<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DOps;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    protected $dPembayaran;
    protected $dOps;
    protected $jns;
    public function __construct(
        DStokProduk $dStokProduk,
        DPembelianModel $dPembelianModel,
        DPembayaranModel $dPembayaran,
        DPembelianDetailModel $dPembelianDetailModel,
        DOps $dOps
    ) {
        $this->dStokProduk = $dStokProduk;
        $this->dPembelianModel = $dPembelianModel;
        $this->dPembayaran = $dPembayaran;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
    }

    public function storePembayaran($pembelianData, $dataArrayDetail, $file)
    {
        if (isset($pembelianData['jns'])) {
            $this->setJns($pembelianData['jns']);
        }
        try {
            $this->validateData($pembelianData, $dataArrayDetail);

            return DB::transaction(function () use ($pembelianData, $dataArrayDetail, $file) { //rollback if error
                $pembelianData = $this->preparePembelianData($pembelianData);

                // save: d_penjualan_detail + stok
                $this->upsertPembayaranDetail($pembelianData, $dataArrayDetail, $file);
                // dd($pembelianData, $dataArrayDetail, $file);

                // // save: d_penjualan
                // $pembelian = $this->upsertPembelian($pembelianData);

                // // pembayaran
                // if ($pembelianData['nominal_bayar']) {
                //     $pembayaran = $this->preparePembayaranData($pembelianData);
                //     $pembayaran = $this->upsertPembayaran($pembayaran);
                // }

                // $pembelian['nota_pembelian'] = $pembelianData['nota_pembelian'];

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

                // hapus d_pembelian&child
                $pembelian->delete();
                Log::info('hapus: pembelian hapus');

                // hapus: d_pembayaran
                // hapus: d_ops
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //..

    public function validateData($pembelianData, $dataArrayDetail)
    {
        if (
            empty($pembelianData['nota_pembelian']) ||
            empty($pembelianData['tgl_pembelian']) ||
            empty($pembelianData['kd_supplier']) ||
            empty($pembelianData['jns_pembelian']) ||
            empty($pembelianData['harga_total']) ||
            empty($pembelianData['sisa_bayar'])
        ) {
            throw new \Exception('Semua kolom pada Tabel Pembelian harus terisi.');
        }

        foreach ($dataArrayDetail as $dataDetail) {
            if (
                empty($dataDetail['tgl_pembayaran']) ||
                empty($dataDetail['nominal_bayar']) ||
                empty($dataDetail['channel_bayar'])
            ) {
                throw new \Exception('Semua kolom pada Tabel Pembelian Detail harus terisi.');
            }
        }
    }

    public function preparePembelianData($pembelianData)
    {
        $pembelianData = [
            'opr_input'      => Auth::user()->nik,
            'tgl_input'      => date('Ymd'),
            'sts_angsuran'   => $pembelianData['sts_angsuran'] ?? '4',
            'harga_total'    => $pembelianData['harga_total'] ? FormatHelper::removeDots($pembelianData['harga_total']) : 0,
            'nominal_bayar'  => $pembelianData['nominal_bayar'] ? FormatHelper::removeDots($pembelianData['nominal_bayar']) : 0,
            'sisa_bayar'     => $pembelianData['sisa_bayar'] ? FormatHelper::removeDots($pembelianData['sisa_bayar']) : 0,
            'nota_pembelian' => $pembelianData['nota_pembelian'],
            'tgl_pembelian'  => $pembelianData['tgl_pembelian'],
            'kd_supplier'    => $pembelianData['kd_supplier'],
            'jns_pembelian'  => $pembelianData['jns_pembelian'],
        ];

        return $pembelianData;
    }

    public function preparePembayaranData($pembayaran)
    {
        $pembayaran['nota_pembelian'] = $pembayaran['nota_pembelian'];
        $pembayaran['tgl_pembayaran'] = $pembayaran['tgl_pembayaran'];
        $pembayaran['nominal_bayar']  = $pembayaran['nominal_bayar'] ? FormatHelper::removeDots($pembayaran['nominal_bayar']) : 0;
        $pembayaran['opr_input']      = Auth::user()->nik;
        $pembayaran['tgl_input']      = date('Ymd');

        $pembayaran['ket_bayar']      = $pembayaran['ket_bayar'];
        $pembayaran['angs_ke']        = $pembayaran['angs_ke'];
        $pembayaran['channel_bayar']  = $pembayaran['channel_bayar'];
        $pembayaran['path_file']      = $pembayaran['path_file'] ?? '';

        return $pembayaran;
    }

    public function upsertPembayaranDetail($pembelian, $dataArrayDetail, $file)
    {
        try {
            foreach ($dataArrayDetail as $key => $dataDetail) {
                $dataDetail['angs_ke'] = $key + 1;
                $dataDetail = $this->preparePembayaranData($dataDetail);

                //save: file
                // if ($file) {
                //     $filename = FormatHelper::uploadFile($file, 'pemeblian/' . $pembelian['tgl_pembelian'] . '/' . $pembelian['kd_supplier'], $pembelian['nota_pembelian']);
                //     $dataDetail['path_file'] = $filename;

                //     $pembelian->path_file = $filename;
                //     $pembelian->save();
                // }
                if (!isset($dataDetail['id'])) {
                    if ($file) {
                        $filename = FormatHelper::uploadFile($file, 'pembayaran/' . $pembelian['nota_pembelian'] . '/' . $pembelian['tgl_pembelian'] . '/' . date('his') . '/' . $pembelian['kd_supplier'], $pembelian['nota_pembelian']);

                        $dataDetail['path_file'] = $filename;
                    }
                }

                $dataDetail['id']             = $dataDetail['id'] ?? null;
                $dataDetail['nota_pembelian'] = $pembelian['nota_pembelian'] ?? null;
                $dataDetail['path_file']      = $dataDetail['path_file'] ?? '';

                $dataDetail = $this->dPembayaran->updateOrCreate([
                    'id' => $dataDetail['id'],
                    'nota_pembelian' => $dataDetail['nota_pembelian'],
                ], $dataDetail);
            }
            return $dataDetail;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // public function prepareDetailData($dataDetail)
    // {
    //     $dataDetail['qty_pesan']    = $dataDetail['qty_pesan'] ? FormatHelper::removeDots($dataDetail['qty_pesan']) : 0;
    //     $dataDetail['qty_retur']    = $dataDetail['qty_retur'] ? FormatHelper::removeDots($dataDetail['qty_retur']) : 0;
    //     $dataDetail['qty_bersih']   = $dataDetail['qty_bersih'] ? FormatHelper::removeDots($dataDetail['qty_bersih']) : 0;
    //     $dataDetail['harga_satuan'] = $dataDetail['harga_satuan'] ? FormatHelper::removeDots($dataDetail['harga_satuan']) : 0;
    //     $dataDetail['harga_total']  = $dataDetail['harga_total'] ? FormatHelper::removeDots($dataDetail['harga_total']) : 0;
    //     $dataDetail['kd_produk']    = $dataDetail['kd_produk'];
    //     $dataDetail['kd_gudang']    = $dataDetail['kd_gudang'];
    //     $dataDetail['nota_pembelian'] = null;

    //     return $dataDetail;
    // }

    // public function upsertPembelian($pembelianData)
    // {
    //     $jns = $this->getJns();
    //     $data = $this->dPembelianModel->where('nota_pembelian', '=', $pembelianData['nota_pembelian'])->first();
    //     if (!$data) {
    //         return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
    //     } elseif ($jns == 'update') {
    //         return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
    //     } else {
    //         if (config('constants.ramwater.VALIDASI_UPSERT')) {
    //             throw new \Exception('Nota Pembelian pernah diinput!');
    //         } else {
    //             return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
    //         }
    //     }
    // }

    // public function upsertPembayaran($pembayaran)
    // {
    //     // $pembelian = $this->dPembelianModel->setNota_pembelian($pembayaran['nota_pembelian']);
    //     // $pembelian = $this->dPembelianModel->getpembelianByNota();
    //     // dd($pembelian);
    //     // upsert sts_angsuran

    //     try {
    //         return $this->dPembayaran->updateOrCreate(
    //             [
    //                 'nota_pembelian' => $pembayaran['nota_pembelian'],
    //                 'angs_ke' => $pembayaran['angs_ke'],
    //             ],
    //             $pembayaran
    //         );
    //     } catch (\Exception $e) {
    //         throw new \Exception($e->getMessage());
    //     }
    // }

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
