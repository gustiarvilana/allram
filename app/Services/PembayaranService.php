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
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

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
                if (isset($pembelianData['nota_pembelian'])) $data = $this->preparePembelianData($pembelianData);
                if (isset($pembelianData['nota_penjualan'])) $data = $this->preparePenjualanData($pembelianData);

                // save: d_penjualan_detail + stok
                $this->upsertPembayaranDetail($data, $dataArrayDetail, $file);
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
        if (isset(($pembelianData['nota_pembelian']))) {
            if (
                empty($pembelianData['nota_pembelian']) ||
                empty($pembelianData['tgl_pembelian']) ||
                empty($pembelianData['kd_supplier']) ||
                empty($pembelianData['jns_pembelian'])
            ) {
                throw new \Exception('Semua kolom pada Tabel Pembelian harus terisi.');
            }
        } else {
            if (
                empty($pembelianData['nota_penjualan']) ||
                empty($pembelianData['tgl_penjualan']) ||
                empty($pembelianData['kd_pelanggan'])
            ) {
                throw new \Exception('Semua kolom pada Tabel Penjualan harus terisi.');
            }
        }

        if (!isset($pembelianData['jns'])) {

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

    public function preparePenjualanData($pembelianData)
    {
        $penjualanData_fix = [
            'nota_penjualan' => $pembelianData['nota_penjualan'] ?? FormatHelper::generateCode('d_penjualan', 'RJ', 5),
            'tgl_penjualan'  => $pembelianData['tgl_penjualan'],
            'kd_pelanggan'   => $pembelianData['kd_pelanggan'],
            'kd_channel'     => $pembelianData['kd_channel'],
            'harga_total'    => $pembelianData['harga_total'] ? FormatHelper::removeDots($pembelianData['harga_total']) : 0,
            'nominal_bayar'  => $pembelianData['nominal_bayar'] ? FormatHelper::removeDots($pembelianData['nominal_bayar']) : 0,
            'sisa_bayar'     => $pembelianData['sisa_bayar'] ? FormatHelper::removeDots($pembelianData['sisa_bayar']) : 0,
            'sts_angsuran'   => $pembelianData['sts_angsuran'],
            'total_galon'    => $pembelianData['total_galon'],
            'galon_kembali'  => $pembelianData['galon_kembali'],
            'sisa_galon'     => $pembelianData['sisa_galon'],
            'sts_galon'      => $pembelianData['sts_galon'],
            'kd_sales'       => $pembelianData['kd_sales'],
            'opr_input'      => Auth::user()->nik,
            'tgl_input'      => date('Ymd'),
        ];
        return $penjualanData_fix;
    }

    public function preparePembayaranData($pembayaran)
    {
        if (isset($pembayaran['nota_pembelian'])) {
            $pembayaran_fix['jns_nota']      = 'pembelian';
        } else {
            $pembayaran_fix['jns_nota']      = 'penjualan';
        }

        $pembayaran_fix['nota']          = $pembayaran['nota'];
        $pembayaran_fix['tgl']           = $pembayaran['tgl_pembayaran'];
        $pembayaran_fix['nominal_bayar'] = $pembayaran['nominal_bayar'] ? FormatHelper::removeDots($pembayaran['nominal_bayar']) : 0;
        $pembayaran_fix['opr_input']     = Auth::user()->nik;
        $pembayaran_fix['tgl_input']     = date('Ymd');

        $pembayaran_fix['update'] = $pembayaran['update'] ?? '';

        $pembayaran_fix['ket_bayar']     = $pembayaran['ket_bayar'];
        $pembayaran_fix['angs_ke']       = $pembayaran['angs_ke'];
        $pembayaran_fix['channel_bayar'] = $pembayaran['channel_bayar'];
        $pembayaran_fix['path_file']     = $pembayaran['path_file'] ?? '';
        $pembayaran_fix['id']            = $pembayaran['id'] ?? '';

        return $pembayaran_fix;
    }

    public function upsertPembayaranDetail($data, $dataArrayDetail, $file)
    {
        try {
            if ($dataArrayDetail) {
                $totalNominalBayar = 0;

                foreach ($dataArrayDetail as $key => $dataDetail) {
                    $dataDetail['angs_ke'] = $key + 1;
                    if (isset($data['nota_pembelian'])) $dataDetail['nota'] = $data['nota_pembelian'];
                    if (isset($data['nota_penjualan'])) $dataDetail['nota'] = $data['nota_penjualan'];

                    $dataDetail_fix = $this->preparePembayaranData($dataDetail);

                    if (!isset($dataDetail_fix['id']) || $dataDetail_fix['update'] == $dataDetail_fix['id']) {
                        if ($file) {
                            if (isset($data['nota_pembelian'])) $filename = FormatHelper::uploadFile($file, 'pembayaran/' . $data['nota_pembelian'] . '/' . $data['tgl_pembelian'] . '/' . $data['kd_supplier'], $data['nota_pembelian'] . '_' . $dataDetail_fix['angs_ke']);
                            if (isset($data['nota_penjualan'])) $filename = FormatHelper::uploadFile($file, 'penjualan/' . $data['nota_penjualan'] . '/' . $data['tgl_penjualan'] . '/' . $data['kd_pelanggan'], $data['nota_penjualan'] . '_' . $dataDetail_fix['angs_ke']);
                            $dataDetail_fix['path_file'] = $filename;
                        }
                    }

                    $dataDetail_fix['id']             = $dataDetail['id'] ?? null;
                    $dataDetail_fix['path_file']      = $dataDetail_fix['path_file'] ?? '';
                    unset($dataDetail_fix["update"]);

                    $totalNominalBayar += $dataDetail_fix['nominal_bayar'];

                    $dataDetail = $this->dPembayaran->updateOrCreate([
                        'id'             => $dataDetail_fix['id'],
                        'nota' => $dataDetail_fix['nota'],
                    ], $dataDetail_fix);
                }

                $this->updateStatus($data, $totalNominalBayar, $data['harga_total']);

                return $dataDetail;
            } else {
                $this->dPembayaran->where('nota_pembelian', '=', $data['nota_pembelian'])->delete();
                return;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateStatus($data, $totalNominalBayar, $harga_total)
    {
        $pembelianModel = new DPembelianModel();
        $penjualanModel = new Penjualan();

        if (isset($data['nota_pembelian'])) $data_fix = $pembelianModel->find($data['id']);
        if (isset($data['nota_penjualan'])) $data_fix = $penjualanModel->where('nota_penjualan', '=', $data['nota_penjualan'])->first();

        // dd($totalNominalBayar, $harga_total);
        // if ($data['sts_angsuran'] != '4') {
        if ($totalNominalBayar == $harga_total) {
            $data_fix->sts_angsuran = 4;
        } elseif ($totalNominalBayar < $harga_total) {
            $data_fix->sts_angsuran = 1;
        } elseif ($totalNominalBayar > $harga_total) {
            throw new \Exception("Pembayaran Terlalu banyak!");
        };
        // };

        if (isset($data['total_galon'])) {

            $total = $data['total_galon'] - $data['sisa_galon'];
            $kembali = $data['galon_kembali'];
            $sisa = $total - $kembali;
            $data_fix['sisa_galon'] = $sisa;
            $data_fix['galon_kembali'] = $kembali;

            $new_sisa = $data_fix['sisa_galon'] - $data_fix['galon_kembali'];

            if (intVal($total) > 0) {
                if ($new_sisa == 0) {
                    $data_fix->sts_galon = 4;
                } elseif ($new_sisa > 0) {
                    $data_fix->sts_galon = 1;
                } elseif ($new_sisa < 0) {
                    throw new \Exception("Pengembalian Galon Terlalu banyak!");
                };
            }
        }

        $data_fix->nominal_bayar = $totalNominalBayar;
        $data_fix->sisa_bayar = $harga_total - $totalNominalBayar;

        return $data_fix->save();
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
