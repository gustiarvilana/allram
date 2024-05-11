<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DKasbonModel;
use App\Models\DOpsModel;
use App\Models\DPembayaranGalonModel;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DStokProduk;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\SupplierModel;
use App\Models\TOps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PenjualanService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    protected $dPembayaran;
    protected $dPembayaranGalon;
    protected $supplierModel;
    protected $dtransaksiOps;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    protected $tOps;
    protected $jns;
    protected $dKasbon;
    public function __construct(
        DStokProduk $dStokProduk,
        DPembelianDetailModel $dPembelianDetailModel,
        SupplierModel $supplierModel,
        Penjualan $penjualanModel,
        PenjualanDetail $penjualanDetailModel,
        DOpsModel $dtransaksiOps,
        TOps $tOps
    ) {
        $this->dStokProduk           = $dStokProduk;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
        $this->supplierModel         = $supplierModel;
        $this->dtransaksiOps         = $dtransaksiOps;
        $this->penjualanModel        = $penjualanModel;
        $this->penjualanDetailModel  = $penjualanDetailModel;
        $this->tOps                  = $tOps;
        $this->dPembayaran           = new DPembayaranModel();
        $this->dPembayaranGalon      = new DPembayaranGalonModel();
        $this->dKasbon               = new DKasbonModel();
    }

    public function storePenjualan($penjualanData, $dataArrayDetail, $file)
    {
        if (isset($penjualanData['jns'])) {
            $this->setJns($penjualanData['jns']);
        }
        try {
            $this->validateData($penjualanData, $dataArrayDetail);
            $penjualanData_fix = $this->preparepenjualanData($penjualanData);

            return DB::transaction(function () use ($penjualanData, $penjualanData_fix, $dataArrayDetail, $file) {
                // save: d_penjualan
                $penjualan = $this->upsertpenjualan($penjualanData_fix);

                //save: file
                if ($file) {
                    $filename = FormatHelper::uploadFile($file, 'penjualan/' . $penjualan['nota_penjualan'] . '/' . $penjualan['tgl_penjualan'] . '/' . $penjualan['kd_supplier'], $penjualan['nota_penjualan']);
                    $penjualan->path_file = $filename;
                    $penjualan->save();
                }

                // save: d_penjualan_detail + stok
                $this->upsertpenjualanDetail($penjualan, $dataArrayDetail);

                // pembayaran
                if ($penjualanData_fix['nominal_bayar']) {
                    $pembayaran = $this->preparePembayaranData($penjualanData_fix);
                    if (isset($penjualanData['jns'])) unset($pembayaran['angs_ke']);
                    $pembayaran = $this->upsertPembayaran($pembayaran);

                    if ($penjualanData_fix['total_galon']) {
                        $pembayaranGalon = $this->preparePembayaranGalonData($penjualanData_fix);
                        $pembayaranGalon = $this->upsertPembayaranGalon($pembayaranGalon);
                    }

                    if ($penjualanData_fix['harga_total'] > $penjualanData_fix['nominal_bayar'] || $penjualanData['isKasbon'] == '0') {
                        $dataKasbon = $this->prepareKasbon($penjualan);

                        $set_penjualan = $this->penjualanModel->where('nota_penjualan', '=', $dataKasbon['nota_penjualan'])->first();
                        $set_kasbon = $this->dKasbon->where('nota_penjualan', '=', $dataKasbon['nota_penjualan'])->first();

                        if ($penjualanData['isKasbon'] == 1) {
                            $this->dKasbon->upsert($dataKasbon);
                            $set_penjualan->sisa_bayar = 0;
                            $set_penjualan->nominal_bayar =  $set_penjualan->harga_total;
                        } else if ($set_kasbon) {
                            $set_penjualan->sisa_bayar = $set_kasbon->nominal;
                            $set_penjualan->nominal_bayar = intVal($set_penjualan->harga_total) - $set_kasbon->nominal;
                            $set_penjualan->sts_angsuran = 1;
                            $this->dKasbon->hapus($dataKasbon);
                        }
                        $set_penjualan->save();
                    }
                }
                // dd('success');
                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyPenjualan($id)
    {
        $penjualan = $this->penjualanModel->find($id);

        $penjualanDetail = $this->penjualanDetailModel
            ->where('nota_penjualan', '=', $penjualan->nota_penjualan)
            ->get();

        try {
            return DB::transaction(function () use ($penjualan, $penjualanDetail) {
                // update d_stok_produk
                foreach ($penjualanDetail as $detail) {
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->validateStok($detail);
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->incrementStok($detail);
                }

                if ($penjualan->path_file) {
                    $pathToDelete = $penjualan->path_file;
                    $publicPath = storage_path('app/public/');

                    // Pastikan path_file dimulai dengan "storage/"
                    if (Str::startsWith($pathToDelete, 'storage/')) {
                        // Ubah "storage/" menjadi direktori penyimpanan
                        $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
                    }

                    FormatHelper::deleteFile($pathToDelete);
                }

                $this->dPembayaran->where('nota', '=', $penjualan->nota_penjualan)->delete();
                $this->dtransaksiOps->where('nota', '=', $penjualan->nota_penjualan)->delete();

                $penjualan->delete();

                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //..

    public function validateData($penjualanData, $dataArrayDetail)
    {
        $errors = [];

        if (empty($penjualanData['tgl_penjualan'])) {
            $errors[] = 'tgl_penjualan';
        }
        if (empty($penjualanData['kd_pelanggan'])) {
            $errors[] = 'kd_pelanggan';
        }
        if (empty($penjualanData['harga_total'])) {
            $errors[] = 'harga_total';
        }
        if (empty($penjualanData['opr_input'])) {
            $errors[] = 'opr_input';
        }
        if (empty($penjualanData['tgl_input'])) {
            $errors[] = 'tgl_input';
        }

        foreach ($dataArrayDetail as $key => $dataDetail) {
            $detailErrors = [];
            if (empty($dataDetail['kd_produk'])) {
                $detailErrors[] = 'kd_produk';
            }
            if (empty($dataDetail['qty_pesan'])) {
                $detailErrors[] = 'qty_pesan';
            }
            if (empty($dataDetail['qty_bersih'])) {
                $detailErrors[] = 'qty_bersih';
            }
            if (empty($dataDetail['harga_satuan'])) {
                $detailErrors[] = 'harga_satuan';
            }
            if (empty($dataDetail['kd_gudang'])) {
                $detailErrors[] = 'kd_gudang';
            }
            if (empty($dataDetail['harga_total'])) {
                $detailErrors[] = 'harga_total';
            }

            if (!empty($detailErrors)) {
                $errors["detail_$key"] = $detailErrors;
            }
        }

        if (!empty($errors)) {
            throw new \Exception("Terjadi kesalahan: " . json_encode($errors));
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

            'sts_angsuran'   => $penjualanData['isKasbon'] == 1 && $penjualanData['sisa_bayar'] != '0' ? 3 : $penjualanData['sts_angsuran'],

            'total_galon'   => $penjualanData['total_galon'] ? FormatHelper::removeDots($penjualanData['total_galon']) : 0,
            'galon_kembali' => $penjualanData['galon_kembali'] ? FormatHelper::removeDots($penjualanData['galon_kembali']) : 0,
            'sisa_galon'    => $penjualanData['sisa_galon'] ? FormatHelper::removeDots($penjualanData['sisa_galon']) : 0,

            'kd_sales'       => $penjualanData['kd_sales'],
            'opr_input'      => Auth::user()->nik,
            'tgl_input'      => date('Ymd'),
        ];

        // $total_galon = intVal($penjualanData_fix['total_galon']) - intVal($penjualanData_fix['sisa_galon']);
        $total_galon = intVal($penjualanData_fix['total_galon']);
        $galon_kembali = intVal($penjualanData_fix['galon_kembali']);

        $penjualanData_fix['sisa_galon'] = intVal($total_galon) - intVal($galon_kembali);

        if ($total_galon > 0) {
            if ($penjualanData_fix['sisa_galon'] == 0) {
                $penjualanData_fix['sts_galon'] = 4;
            } elseif ($penjualanData_fix['sisa_galon'] > 0) {
                $penjualanData_fix['sts_galon'] = 1;
            } elseif ($penjualanData_fix['sisa_galon'] < 0) {
                throw new \Exception("Pengembalian Galon Terlalu banyak!");
            };
        }

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
        $dataDetail_fix['kd_gudang']    = $dataDetail['kd_gudang'];

        return $dataDetail_fix;
    }

    public function preparePembayaranData($pembelian)
    {
        $angs_ke = $this->dPembayaran->where('nota', $pembelian['nota_penjualan'])->get()->max('angs_ke') + 1;

        $pembayaran['nota']          = $pembelian['nota_penjualan'];
        $pembayaran['jns_nota']      = 'penjualan';
        $pembayaran['tgl']           = $pembelian['tgl_penjualan'];
        $pembayaran['nominal_bayar'] = $pembelian['nominal_bayar'];
        $pembayaran['opr_input']     = Auth::user()->nik;
        $pembayaran['tgl_input']     = date('Ymd');

        $pembayaran['jns_pembayaran'] = 2;

        $pembayaran['ket_bayar']      = '';
        $pembayaran['angs_ke']        = $pembayaran['angs_ke'] ?? $angs_ke;
        $pembayaran['channel_bayar']  = $pembelian['kd_channel'];
        $pembayaran['path_file']      = '';

        return $pembayaran;
    }

    public function preparePembayaranGalonData($penjualan)
    {
        $angs_ke = $this->dPembayaranGalon->where('nota', $penjualan['nota_penjualan'])->get()->max('angs_ke') + 1;

        $pembayaran['nota']          = $penjualan['nota_penjualan'];
        $pembayaran['jns_nota']      = 'penjualan';
        $pembayaran['tgl']           = $penjualan['tgl_penjualan'];
        $pembayaran['angs_ke']        = $angs_ke;
        $pembayaran['galon_bayar'] = $penjualan['galon_kembali'];
        $pembayaran['opr_input']     = Auth::user()->nik;
        $pembayaran['tgl_input']     = date('Ymd');

        $pembayaran['jns_pembayaran'] = 2;

        $pembayaran['ket_bayar']      = '';

        return $pembayaran;
    }

    public function prepareOpsnData($penjualanData)
    {
        $namaOps = $this->tOps->findOpsByProduct($penjualanData['kd_produk'])->first();

        if (!$namaOps->kd_ops) throw new \Exception("kd_ops Belum diatur!");

        $ops['nota']       = $penjualanData['nota_penjualan'];
        $ops['tanggal']    = $penjualanData['tgl_penjualan'];
        $ops['satker']     = 'ramwater';
        $ops['nik']        = $penjualanData['nik'];
        $ops['kd_ops']     = $namaOps->kd_ops;
        $ops['jumlah']     = '000';
        $ops['harga']      = '000';
        $ops['total']      = $penjualanData['harga_total'];
        $ops['keterangan'] = '000';

        return $ops;
    }

    public function prepareKasbon($input)
    {
        $input_fix['nik']            = $input['kd_sales'];
        $input_fix['tgl_kasbon']     = $input['tgl_penjualan'];
        $input_fix['jns_kasbon']     = 3;
        $input_fix['nota_penjualan'] = $input['nota_penjualan'];
        $input_fix['nominal']        = $input['sisa_bayar'];
        $input_fix['ket_kasbon']     = 'Kurang Harga';
        $input_fix['opr_input']      = $input['opr_input'];
        $input_fix['tgl_input']      = $input['tgl_input'];

        return $input_fix;
    }

    public function upsertpenjualan($penjualanData)
    {
        $jns = $this->getJns();
        $data = $this->penjualanModel->where('nota_penjualan', '=', $penjualanData['nota_penjualan'])->first();

        if (!$data) {
            return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjualanData['nota_penjualan']], $penjualanData);
        } elseif ($jns == 'update') {
            return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjualanData['nota_penjualan']], $penjualanData);
        } else {
            if (config('constants.ramwater.VALIDASI_UPSERT')) {
                return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjualanData['nota_penjualan']], $penjualanData);
            } else {
                return $this->penjualanModel->updateOrCreate(['nota_penjualan' => $penjualanData['nota_penjualan']], $penjualanData);
            }
        }
    }

    public function upsertpenjualanDetail($penjualan, $dataArrayDetail)
    {
        $detail = $this->penjualanDetailModel->where('nota_penjualan', $penjualan->nota_penjualan)->get();
        if ($detail->count() > 0) {
            foreach ($detail as $row) {
                $row['kd_gudang'] = 1;
                if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->incrementStok($row);
            }
            $this->penjualanDetailModel->where('nota_penjualan', $penjualan->nota_penjualan)->delete();
        }

        foreach ($dataArrayDetail as $dataDetail) {
            $dataDetail_fix = $this->prepareDetailData($dataDetail);

            $dataDetail_fix['nota_penjualan'] = $penjualan->nota_penjualan;

            if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->decrementStok($dataDetail_fix);
            // unset($dataDetail_fix['kd_gudang']);
            $dataDetail_fix = $this->penjualanDetailModel->create($dataDetail_fix);
            $dataDetail_fix['tgl_penjualan'] = $penjualan->tgl_penjualan;
            $dataDetail_fix['nik'] = $penjualan->kd_sales;
            // save: ops
            $this->upsertOps($dataDetail_fix);
        }
    }


    public function penyerahanUpdate($nota_penjualan)
    {
        try {
            $penjualan = $this->penjualanModel->where('nota_penjualan', '=', $nota_penjualan)->first();
            $penjualan->sts_penyerahan = 4;
            return $penjualan->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsertOps($penjualanData)
    {
        $data = $this->prepareOpsnData($penjualanData);

        try {
            return $this->dtransaksiOps->updateOrCreate([
                'nota'    => $data['nota'],
                'kd_ops' => $data['kd_ops']
            ], $data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsertPembayaran($pembayaran)
    {
        try {
            return $this->dPembayaran->updateOrCreate(
                [
                    'nota' => $pembayaran['nota'],
                ],
                $pembayaran
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsertPembayaranGalon($pembayaran)
    {
        try {
            return $this->dPembayaranGalon->updateOrCreate(
                [
                    'nota' => $pembayaran['nota'],
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
