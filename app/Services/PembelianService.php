<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DOps;
use App\Models\DOpsModel;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use App\Models\DTransaksiOps;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembelianService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    protected $dPembayaran;
    protected $supplierModel;
    protected $dtransaksiOps;
    protected $jns;
    public function __construct() {
        $this->dStokProduk = new DStokProduk();
        $this->dPembelianModel = new DPembelianModel();
        $this->dPembayaran = new DPembayaranModel();
        $this->dPembelianDetailModel = new DPembelianDetailModel();
        $this->supplierModel = new SupplierModel();
        $this->dtransaksiOps = new DOpsModel();
    }

    public function storePembelian($pembelianData, $dataArrayDetail, $file)
    {
        if (isset($pembelianData['jns'])) {
            $this->setJns($pembelianData['jns']);
        }
        try {
            $this->validateData($pembelianData, $dataArrayDetail);
            $pembelianData_fix = $this->preparePembelianData($pembelianData);

            return DB::transaction(function () use ($pembelianData, $pembelianData_fix, $dataArrayDetail, $file) { //rollback if error
                // save: d_penjualan
                $pembelian = $this->upsertPembelian($pembelianData_fix);

                //save: file
                if ($file) {
                    $filename = FormatHelper::uploadFile($file, 'pembelian/' . $pembelian['nota_pembelian'] . '/' . $pembelian['tgl_pembelian'] . '/' . $pembelian['kd_supplier'], $pembelian['nota_pembelian']);
                    $pembelian->path_file = $filename;
                    $pembelian->save();
                }
                // pembayaran
                if ($pembelianData_fix['nominal_bayar']) {
                    $pembayaran = $this->preparePembayaranData($pembelianData_fix);
                    $angs_ke = $pembayaran['angs_ke'];
                    if (isset($pembelianData['jns'])) unset($pembayaran['angs_ke']);
                    $pembayaran = $this->upsertPembayaran($pembayaran);

                    if ($file) {
                        $filename = FormatHelper::uploadFile($file, 'pembayaran/' . $pembelianData_fix['nota_pembelian'] . '/' . $pembelianData_fix['tgl_pembelian'] . '/' . $pembelianData_fix['kd_supplier'], $pembelianData_fix['nota_pembelian'] . '_' . $angs_ke);
                        $pembayaran['path_file'] = $filename;
                        $pembayaran->save();
                    }
                }

                $pembelian['nota_pembelian'] = $pembelianData_fix['nota_pembelian'];

                // save: d_penjualan_detail + stok
                $this->upsertPembelianDetail($pembelian, $dataArrayDetail);

                // save: ops
                $this->upsertOps($pembelian,$file);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyPembelian($id)
    {
        $pembelian = $this->dPembelianModel->find($id);

        $pembelianDetail = $this->dPembelianDetailModel
            ->where('nota_pembelian', '=', $pembelian->nota_pembelian)
            ->get();

        try {
            return DB::transaction(function () use ($pembelian, $pembelianDetail) {
                // update d_stok_produk
                foreach ($pembelianDetail as $detail) {
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->validateStok($detail);
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

                $this->dtransaksiOps->where('nota', '=', $pembelian->nota_pembelian)->delete();
                $this->dPembayaran->where('nota', '=', $pembelian->nota_pembelian)->delete();
                $pembelian->delete();

                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //..

    public function validateData($pembelianData, $dataArrayDetail)
    {
        $requiredColumns = [
            'nota_pembelian' => 'Nota Pembelian',
            'tgl_pembelian'  => 'Tanggal Pembelian',
            'kd_supplier'    => 'Kode Supplier',
            'harga_total'    => 'Harga Total'
        ];
        $errorColumns = [];

        foreach ($requiredColumns as $column => $columnName) {
            if (empty($pembelianData[$column])) {
                $errorColumns[] = $columnName;
            }
        }

        if (!empty($errorColumns)) {
            throw new \Exception('Kolom-kolom berikut pada Tabel Pembelian harus terisi: ' . implode(', ', $errorColumns) . '.');
        }

        foreach ($dataArrayDetail as $index => $dataDetail) {
            $requiredColumnsDetail = [
                'kd_produk',
                'qty_pesan',
                'qty_bersih',
                'harga_satuan',
                'kd_gudang',
                'harga_total'
            ];

            foreach ($requiredColumnsDetail as $column) {
                if (empty($dataDetail[$column])) {
                    throw new \Exception("Semua kolom pada Tabel Pembelian Detail pada baris " . ($index + 1) . " harus terisi.");
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
        ];

        return $pembelianData;
    }

    public function prepareDetailData($dataDetail)
    {
        $dataDetail['qty_pesan']    = $dataDetail['qty_pesan'] ? FormatHelper::removeDots($dataDetail['qty_pesan']) : 0;
        $dataDetail['qty_retur']    = $dataDetail['qty_retur'] ? FormatHelper::removeDots($dataDetail['qty_retur']) : 0;
        $dataDetail['qty_bersih']   = $dataDetail['qty_bersih'] ? FormatHelper::removeDots($dataDetail['qty_bersih']) : 0;
        $dataDetail['harga_satuan'] = $dataDetail['harga_satuan'] ? FormatHelper::removeDots($dataDetail['harga_satuan']) : 0;
        $dataDetail['harga_total']  = $dataDetail['harga_total'] ? FormatHelper::removeDots($dataDetail['harga_total']) : 0;
        $dataDetail['kd_produk']    = $dataDetail['kd_produk'];
        $dataDetail['kd_gudang']    = $dataDetail['kd_gudang'];
        $dataDetail['nota_pembelian'] = null;

        return $dataDetail;
    }

    public function preparePembayaranData($pembelian)
    {
        $pembayaran['nota']          = $pembelian['nota_pembelian'];
        $pembayaran['jns_nota']      = 'pembelian';
        $pembayaran['tgl']           = $pembelian['tgl_pembelian'];
        $pembayaran['nominal_bayar'] = $pembelian['nominal_bayar'];
        $pembayaran['opr_input']     = Auth::user()->nik;
        $pembayaran['tgl_input']     = date('Ymd');

        $pembayaran['ket_bayar']      = '';
        $pembayaran['angs_ke']        = 1;
        $pembayaran['channel_bayar']  = 1;
        $pembayaran['path_file']      = '';

        return $pembayaran;
    }

    public function prepareOpsnData($pembelian)
    {
        $supplier = $this->supplierModel->where('kd_supplier', '=', $pembelian['kd_supplier'])->first();

        $ops['nota']    = $pembelian['nota_pembelian'];
        $ops['tanggal']    = $pembelian['tgl_pembelian'];
        $ops['satker']     = 'ramwater';
        $ops['nik']        = '000';
        $ops['kd_ops']     = $supplier->kd_ops;
        $ops['jumlah']     = '000';
        $ops['harga']      = '000';
        $ops['total']      = $pembelian['harga_total'];
        $ops['keterangan'] = '000';

        return $ops;
    }

    public function upsertPembelian($pembelianData)
    {
        $jns = $this->getJns();
        $data = $this->dPembelianModel->where('nota_pembelian', '=', $pembelianData['nota_pembelian'])->first();

        if (!$data) {
            return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
        } elseif ($jns == 'update') {
            return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
        } else {
            if (config('constants.ramwater.VALIDASI_UPSERT')) {
                throw new \Exception('Nota Pembelian pernah diinput!');
            } else {
                return $this->dPembelianModel->updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
            }
        }
    }

    public function upsertOps($pembelianData,$file)
    {
        $data = $this->prepareOpsnData($pembelianData);

        try {
            $ops = $this->dtransaksiOps->updateOrCreate(['nota' => $data['nota']], $data);

            if ($file) {
                $filename = FormatHelper::uploadFile($file, 'ops/' . $data['tanggal'] . '/' . $data['nik'] . '/' . $data['kd_ops'], $data['nota']);
                $ops->path_file = $filename;
                $ops->save();
            }

            return $ops;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsertPembelianDetail($pembelian, $dataArrayDetail)
    {
        $detail = $this->dPembelianDetailModel->where('nota_pembelian', $pembelian->nota_pembelian)->get();
        if ($detail->count() > 0) {
            foreach ($detail as $row) {
                if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->decrementStok($row);
            }
            $this->dPembelianDetailModel->where('nota_pembelian', $pembelian->nota_pembelian)->delete();
        }

        foreach ($dataArrayDetail as $dataDetail) {
            Log::info('service');
            if ($dataDetail['harga_satuan'] > 0) {
                $dataDetail = $this->prepareDetailData($dataDetail);
                unset($dataDetail["nama"]);

                $dataDetail['nota_pembelian'] = $pembelian->nota_pembelian;

                $dataDetail = $this->dPembelianDetailModel->create($dataDetail);
                if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->incrementStok($dataDetail);
            }
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
