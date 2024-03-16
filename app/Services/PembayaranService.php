<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Helpers\IntegrationHelper;
use App\Models\DOps;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        DPembelianDetailModel $dPembelianDetailModel
    ) {
        $this->integrationHelper = new IntegrationHelper();
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
            empty($pembelianData['jns_pembelian'])
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
            'id'             => $this->integrationHelper->decrypt(base64_decode($pembelianData['id']), $this->integrationHelper->getKey()),
        ];

        return $pembelianData;
    }

    public function preparePembayaranData($pembayaran)
    {
        $pembayaran_fix['nota_pembelian'] = $pembayaran['nota_pembelian'];
        $pembayaran_fix['tgl']            = $pembayaran['tgl_pembayaran'];
        $pembayaran_fix['nominal_bayar']  = $pembayaran['nominal_bayar'] ? FormatHelper::removeDots($pembayaran['nominal_bayar']) : 0;
        $pembayaran_fix['opr_input']      = Auth::user()->nik;
        $pembayaran_fix['tgl_input']      = date('Ymd');

        $pembayaran_fix['update'] = $pembayaran['update'] ?? '';

        $pembayaran_fix['ket_bayar']     = $pembayaran['ket_bayar'];
        $pembayaran_fix['angs_ke']       = $pembayaran['angs_ke'];
        $pembayaran_fix['channel_bayar'] = $pembayaran['channel_bayar'];
        $pembayaran_fix['path_file']     = $pembayaran['path_file'] ?? '';
        $pembayaran_fix['id']            = $pembayaran['id'] ?? '';

        return $pembayaran_fix;
    }

    public function upsertPembayaranDetail($pembelian, $dataArrayDetail, $file)
    {
        try {
            if ($dataArrayDetail) {
                $totalNominalBayar = 0;

                foreach ($dataArrayDetail as $key => $dataDetail) {
                    $dataDetail['angs_ke'] = $key + 1;

                    $dataDetail_fix = $this->preparePembayaranData($dataDetail);

                    if (!isset($dataDetail_fix['id']) || $dataDetail_fix['update'] == $dataDetail_fix['id']) {
                        if ($file) {
                            $filename = FormatHelper::uploadFile($file, 'pembayaran/' . $pembelian['nota_pembelian'] . '/' . $pembelian['tgl_pembelian'] . '/' . $pembelian['kd_supplier'], $pembelian['nota_pembelian'] . '_' . $dataDetail_fix['angs_ke']);
                            $dataDetail_fix['path_file'] = $filename;
                        }
                    }

                    $dataDetail_fix['id']             = $dataDetail['id'] ?? null;
                    $dataDetail_fix['nota_pembelian'] = $pembelian['nota_pembelian'] ?? null;
                    $dataDetail_fix['path_file']      = $dataDetail_fix['path_file'] ?? '';
                    unset($dataDetail_fix["update"]);

                    $totalNominalBayar += $dataDetail_fix['nominal_bayar'];

                    $dataDetail = $this->dPembayaran->updateOrCreate([
                        'id' => $dataDetail_fix['id'],
                        'nota_pembelian' => $dataDetail_fix['nota_pembelian'],
                    ], $dataDetail_fix);
                }

                $this->updateStatus($pembelian, $totalNominalBayar, $pembelian['harga_total']);

                return $dataDetail;
            } else {
                $this->dPembayaran->where('nota_pembelian', '=', $pembelian['nota_pembelian'])->delete();
                return;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateStatus($pembelian, $totalNominalBayar, $harga_total)
    {
        // dd($pembelian, $totalNominalBayar, $harga_total);
        $pembelianModel = new DPembelianModel(); // Gantilah Pembelian dengan nama model yang sesuai
        $pembelian = $pembelianModel->find($pembelian['id']); // Sesuaikan dengan cara Anda mendapatkan model
        if ($totalNominalBayar == $harga_total) {
            $pembelian->sts_angsuran = 4;
            $pembelian->nominal_bayar = $totalNominalBayar;
            $pembelian->sisa_bayar = $harga_total - $totalNominalBayar;
            $pembelian->save();
        } elseif ($totalNominalBayar < $harga_total) {
            $pembelian->sts_angsuran = 1;
            $pembelian->nominal_bayar = $totalNominalBayar;
            $pembelian->sisa_bayar = $harga_total - $totalNominalBayar;
            $pembelian->save();
        } elseif ($totalNominalBayar > $harga_total) {
            throw new \Exception("Pembayaran Terlalu banyak!");
        };
    }

    public function destroyPembayaran($arrayRow)
    {
        foreach ($arrayRow as $key => $row) {
            if ($row->path_file) {
                $pathToDelete = $row->path_file;
                $publicPath = storage_path('app/public/');

                // Pastikan path_file dimulai dengan "storage/"
                if (Str::startsWith($pathToDelete, 'storage/')) {
                    $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
                }

                // delete
                FormatHelper::deleteFile($pathToDelete);
            }

            $row = $this->dPembayaran->find($row['id']); // Sesuaikan dengan cara Anda mendapatkan model
            $row->delete();
            Log::info('hapus: pembayaran hapus');
        }
    }

    protected function setJns($jns)
    {
        $this->jns = $jns;
    }
    protected function getJns()
    {
        return $this->jns;
    }
}
