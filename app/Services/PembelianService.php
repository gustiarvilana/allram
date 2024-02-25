<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembelianService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    protected $jns;
    public function __construct(DStokProduk $dStokProduk, DPembelianModel $dPembelianModel, DPembelianDetailModel $dPembelianDetailModel)
    {
        $this->dStokProduk = $dStokProduk;
        $this->dPembelianModel = $dPembelianModel;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
    }

    public function storePembelian($pembelianData, $dataArrayDetail, $jns = null)
    {
        if ($jns) {
            $this->setJns($jns);
        }
        try {
            $this->validateData($pembelianData, $dataArrayDetail);

            $pembelianData_fix = $this->preparePembelianData($pembelianData);

            return DB::transaction(function () use ($pembelianData_fix, $dataArrayDetail) {

                $pembelian = $this->upsertPembelian($pembelianData_fix);

                $pembelian['nota_pembelian'] = $pembelianData_fix['nota_pembelian'];
                $pembelian['kd_gudang']      = $pembelianData_fix['kd_gudang'];

                $this->upsertPembelianDetail($pembelian, $dataArrayDetail);

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
            ->where('kd_gudang', '=', $pembelian->kd_gudang)
            ->get();

        try {
            return DB::transaction(function () use ($pembelian, $pembelianDetail) {
                foreach ($pembelianDetail as $detail) {
                    Log::info('hapus: validateStok stok');
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->validateStok($detail);
                    Log::info('hapus: decrementStok stok');
                    if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->decrementStok($detail);
                }
                Log::info('hapus: pembelian hapus');
                $pembelian->delete();
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //..

    protected function validateData($pembelianData, $dataArrayDetail)
    {
        if (
            empty($pembelianData['nota_pembelian']) ||
            empty($pembelianData['tgl_pembelian']) ||
            empty($pembelianData['kd_supplier']) ||
            empty($pembelianData['jns_pembelian']) ||
            empty($pembelianData['harga_total']) ||
            empty($pembelianData['nominal_bayar']) ||
            empty($pembelianData['sisa_bayar']) ||
            empty($pembelianData['kd_gudang'])
        ) {
            throw new \Exception('Semua kolom pada Tabel Pembelian harus terisi.');
        }

        foreach ($dataArrayDetail as $dataDetail) {
            if (
                empty($dataDetail['kd_produk']) ||
                empty($dataDetail['qty_pesan']) ||
                empty($dataDetail['qty_bersih']) ||
                empty($dataDetail['harga_satuan']) ||
                empty($dataDetail['harga_total'])
            ) {
                throw new \Exception('Semua kolom pada Tabel Pembelian Detail harus terisi.');
            }
        }
    }

    protected function preparePembelianData($pembelianData)
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
            'kd_gudang'      => $pembelianData['kd_gudang'],
        ];

        return $pembelianData;
    }

    protected function prepareDetailData($dataDetail)
    {
        $dataDetail['qty_pesan']    = $dataDetail['qty_pesan'] ? FormatHelper::removeDots($dataDetail['qty_pesan']) : 0;
        $dataDetail['qty_retur']    = $dataDetail['qty_retur'] ? FormatHelper::removeDots($dataDetail['qty_retur']) : 0;
        $dataDetail['qty_bersih']   = $dataDetail['qty_bersih'] ? FormatHelper::removeDots($dataDetail['qty_bersih']) : 0;
        $dataDetail['harga_satuan'] = $dataDetail['harga_satuan'] ? FormatHelper::removeDots($dataDetail['harga_satuan']) : 0;
        $dataDetail['harga_total']  = $dataDetail['harga_total'] ? FormatHelper::removeDots($dataDetail['harga_total']) : 0;
        $dataDetail['kd_produk']    = $dataDetail['kd_produk'];

        $dataDetail['nota_pembelian'] = null;
        $dataDetail['kd_gudang']      = null;

        return $dataDetail;
    }

    protected function upsertPembelian($pembelianData)
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
            $dataDetail = $this->prepareDetailData($dataDetail);

            $dataDetail['nota_pembelian'] = $pembelian->nota_pembelian;
            $dataDetail['kd_gudang'] = $pembelian->kd_gudang;

            $dataDetail = $this->dPembelianDetailModel->create($dataDetail);
            if (config('constants.ramwater.VALIDASI_STOCK')) $this->dStokProduk->incrementStok($dataDetail);
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
