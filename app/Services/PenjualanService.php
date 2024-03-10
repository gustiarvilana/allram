<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DOps;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use App\Models\DTransaksiOps;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PenjualanService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    protected $dPembayaran;
    protected $supplierModel;
    protected $dtransaksiOps;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    protected $jns;
    public function __construct(
        DStokProduk $dStokProduk,
        DPembelianDetailModel $dPembelianDetailModel,
        SupplierModel $supplierModel,
        Penjualan $penjualanModel,
        PenjualanDetail $penjualanDetailModel,
        DTransaksiOps $dtransaksiOps
    ) {
        $this->dStokProduk           = $dStokProduk;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
        $this->supplierModel         = $supplierModel;
        $this->dtransaksiOps         = $dtransaksiOps;
        $this->penjualanModel        = $penjualanModel;
        $this->penjualanDetailModel  = $penjualanDetailModel;
        $this->dPembayaran           = new DPembayaranModel();
    }

    public function storePenjualan($penjualanData, $dataArrayDetail)
    {

        if (isset($penjualanData['jns'])) {
            $this->setJns($penjualanData['jns']);
        }
        try {

            $this->validateData($penjualanData, $dataArrayDetail);

            $penjualanData_fix = $this->preparepenjualanData($penjualanData);

            return DB::transaction(function () use ($penjualanData_fix, $dataArrayDetail) { //rollback if error

                // save: d_penjualan
                $penjualan = $this->upsertpenjualan($penjualanData_fix);

                // save: d_penjualan_detail + stok
                $this->upsertpenjualanDetail($penjualan, $dataArrayDetail);

                // pembayaran
                if ($penjualanData_fix['nominal_bayar']) {
                    $pembayaran = $this->preparePembayaranData($penjualanData_fix);
                    dd(['done' => $pembayaran]);
                    $pembayaran = $this->upsertPembayaran($pembayaran);
                }

                $penjualan['nota_penjualan'] = $penjualanData_fix['nota_penjualan'];

                // save: ops
                $this->upsertOps($penjualan);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyPembelian($id)
    {
        Log::info("hapus: mulai");
        $pembelian = $this->dPembelianModel->find($id);

        $pembelianDetail = $this->dPembelianDetailModel
            ->where('nota_pembelian', '=', $pembelian->nota_pembelian)
            ->get();

        try {
            return DB::transaction(function () use ($pembelian, $pembelianDetail) {
                // update d_stok_produk
                foreach ($pembelianDetail as $detail) {
                    Log::info('hapus: validateStok stok');
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->validateStok($detail);
                    Log::info('hapus: decrementStok stok');
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->decrementStok($detail);
                }


                // hapus d_pembelian & child
                $pathToDelete = $pembelian->path_file;
                $publicPath = storage_path('app/public/');

                // Pastikan path_file dimulai dengan "storage/"
                if (Str::startsWith($pathToDelete, 'storage/')) {
                    // Ubah "storage/" menjadi direktori penyimpanan
                    $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
                }

                FormatHelper::deleteFile($pathToDelete);

                $pembelian->delete();
                Log::info('hapus: pembelian hapus');

                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //..

    public function validateData($penjualanData, $dataArrayDetail)
    {
        if (
            empty($penjualanData['tgl_penjualan']) ||
            empty($penjualanData['kd_pelanggan']) ||
            empty($penjualanData['kd_channel']) ||
            empty($penjualanData['harga_total']) ||
            empty($penjualanData['nominal_bayar']) ||
            empty($penjualanData['sisa_bayar']) ||
            empty($penjualanData['kd_sales']) ||
            empty($penjualanData['opr_input']) ||
            empty($penjualanData['tgl_input'])
        ) {
            throw new \Exception('Semua kolom pada Tabel Penjualan harus terisi.');
        }

        foreach ($dataArrayDetail as $dataDetail) {
            if (
                empty($dataDetail['kd_produk']) ||
                empty($dataDetail['qty_pesan']) ||
                empty($dataDetail['qty_bersih']) ||
                empty($dataDetail['harga_satuan']) ||
                empty($dataDetail['harga_total'])
            ) {
                throw new \Exception('Semua kolom pada Tabel Penjualan Detail harus terisi.');
            }
        }
    }

    public function preparepenjualanData($penjualanData)
    {
        $penjualanData_fix = [
            'nota_penjualan' => $penjualanData['nota_penjualan'] ?? FormatHelper::generateCode('d_penjualan', 'RJ', 5),
            'tgl_penjualan'  => $penjualanData['tgl_penjualan'],
            'kd_pelanggan'   => $penjualanData['kd_pelanggan'],
            'kd_channel'     => $penjualanData['kd_channel'],
            'harga_total'    => $penjualanData['harga_total'] ? FormatHelper::removeDots($penjualanData['harga_total']) : 0,
            'nominal_bayar'  => $penjualanData['nominal_bayar'] ? FormatHelper::removeDots($penjualanData['nominal_bayar']) : 0,
            'sisa_bayar'     => $penjualanData['sisa_bayar'] ? FormatHelper::removeDots($penjualanData['sisa_bayar']) : 0,
            'sts_angsuran'   => $penjualanData['sts_angsuran'],
            'total_galon'    => $penjualanData['total_galon'],
            'galon_kembali'  => $penjualanData['galon_kembali'],
            'sisa_galon'     => $penjualanData['sisa_galon'],
            'sts_galon'      => $penjualanData['sts_galon'],
            'kd_sales'       => $penjualanData['kd_sales'],
            'opr_input'      => Auth::user()->nik,
            'tgl_input'      => date('Ymd'),
        ];

        return $penjualanData_fix;
    }

    public function prepareDetailData($dataDetail)
    {
        $dataDetail_fix['qty_pesan']    = $dataDetail['qty_pesan'] ? FormatHelper::removeDots($dataDetail['qty_pesan']) : 0;
        $dataDetail_fix['qty_retur']    = $dataDetail['qty_retur'] ? FormatHelper::removeDots($dataDetail['qty_retur']) : 0;
        $dataDetail_fix['qty_bersih']   = $dataDetail['qty_bersih'] ? FormatHelper::removeDots($dataDetail['qty_bersih']) : 0;
        $dataDetail_fix['harga_satuan'] = $dataDetail['harga_satuan'] ? FormatHelper::removeDots($dataDetail['harga_satuan']) : 0;
        $dataDetail_fix['harga_total']  = $dataDetail['harga_total'] ? FormatHelper::removeDots($dataDetail['harga_total']) : 0;
        $dataDetail_fix['kd_produk']    = $dataDetail['kd_produk'];

        return $dataDetail_fix;
    }

    public function preparePembayaranData($pembelian)
    {
        if (isset($pembelian['nota_penjualan'])) {
            $angs_ke = $this->dPembayaran->where('nota_penjualan', $pembelian['nota_penjualan'])->get()->max('angs_ke') + 1;
        } elseif (isset($pembelian['nota_pembelian'])) {
            $angs_ke = $this->dPembayaran->where('nota_pembelian', $pembelian['nota_pembelian'])->get()->max('angs_ke') + 1;
        }

        $pembayaran['nota_penjualan'] = $pembelian['nota_penjualan'];
        $pembayaran['tgl']            = $pembelian['tgl_penjualan'];
        $pembayaran['nominal_bayar']  = $pembelian['nominal_bayar'];
        $pembayaran['opr_input']      = Auth::user()->nik;
        $pembayaran['tgl_input']      = date('Ymd');

        $pembayaran['jns_pembayaran'] = 2;

        $pembayaran['ket_bayar']      = '';
        $pembayaran['angs_ke']        = $angs_ke;
        $pembayaran['channel_bayar']  = $pembelian['kd_channel'];
        $pembayaran['path_file']      = '';

        return $pembayaran;
    }

    public function prepareOpsnData($pembelian)
    {
        $supplier = $this->supplierModel->where('kd_supplier', '=', $pembelian['kd_supplier'])->first();

        $ops['nota_pembelian'] = $pembelian['nota_pembelian'];
        $ops['tgl_transaksi']  = $pembelian['tgl_pembelian'];
        $ops['kd_ops']         = $supplier->kd_ops;
        $ops['jns_trs']        = config('constants.ramwater.KD_TRANSAKSI_BIAYA');
        $ops['nominal']        = $pembelian['harga_total'];
        $ops['ket_transaksi']  = '';

        return $ops;
    }

    public function upsertpenjualan($penjaualanData)
    {
        $jns = $this->getJns();
        $data = $this->penjualanModel->where('nota_penjualan', '=', $penjaualanData['nota_penjualan'])->first();

        if (!$data) {
            return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjaualanData['nota_penjualan']], $penjaualanData);
        } elseif ($jns == 'update') {
            return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjaualanData['nota_penjualan']], $penjaualanData);
        } else {
            if (config('constants.ramwater.VALIDASI_UPSERT')) {
                throw new \Exception('Nota Pembelian pernah diinput!');
            } else {
                return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjaualanData['nota_penjualan']], $penjaualanData);
            }
        }
    }

    public function upsertpenjualanDetail($penjualan, $dataArrayDetail)
    {
        $detail = $this->penjualanDetailModel->where('nota_penjualan', $penjualan->nota_penjualan)->get();
        if ($detail->count() > 0) {
            foreach ($detail as $row) {
                if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->incrementStok($row);
            }
            $this->penjualanDetailModel->where('nota_penjualan', $penjualan->nota_penjualan)->delete();
        }
        foreach ($dataArrayDetail as $dataDetail) {
            $dataDetail_fix = $this->prepareDetailData($dataDetail);
            // unset($dataDetail["nama"]);

            $dataDetail_fix['nota_penjualan'] = $penjualan->nota_penjualan;

            $dataDetail_fix = $this->penjualanDetailModel->create($dataDetail_fix);
            if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->decrementStok($dataDetail_fix);
        }
    }


    public function upsertOps($pembelianData)
    {
        $data = $this->prepareOpsnData($pembelianData);

        try {
            return $this->dtransaksiOps->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsertPembayaran($pembayaran)
    {
        // $pembelian = $this->dPembelianModel->setNota_pembelian($pembayaran['nota_pembelian']);
        // $pembelian = $this->dPembelianModel->getpembelianByNota();
        // dd($pembelian);
        // upsert sts_angsuran

        try {
            return $this->dPembayaran->updateOrCreate(
                [
                    'nota_pembelian' => $pembayaran['nota_pembelian'],
                    'angs_ke' => $pembayaran['angs_ke'],
                ],
                $pembayaran
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // ..

    protected function setJns($jns)
    {
        $this->jns = $jns;
    }
    protected function getJns()
    {
        return $this->jns;
    }
}
