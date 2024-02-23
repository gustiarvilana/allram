<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\DStokProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianService
{
    protected $dStokProduk;
    protected $dPembelianModel;
    protected $dPembelianDetailModel;
    public function __construct(DStokProduk $dStokProduk, DPembelianModel $dPembelianModel, DPembelianDetailModel $dPembelianDetailModel)
    {
        $this->dStokProduk = $dStokProduk;
        $this->dPembelianModel = $dPembelianModel;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
    }

    public function storePembelian($pembelianData, $dataArrayDetail)
    {
        try {
            $this->validateData($pembelianData, $dataArrayDetail);

            $pembelianData = $this->preparePembelianData($pembelianData);

            return DB::transaction(function () use ($pembelianData, $dataArrayDetail) {

                $pembelian = $this->upsertPembelian($pembelianData);
                $this->storePembelianDetail($pembelian, $dataArrayDetail);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storePembelianDetail($pembelian, $dataArrayDetail)
    {
        $detail = $this->dPembelianDetailModel->where('nota_pembelian', $pembelian->nota_pembelian)->get();
        if ($detail->count() > 0) {
            foreach ($detail as $row) {
                // $this->dStokProduk->incrementStok($row);
            }
            $this->dPembelianDetailModel->where('nota_pembelian', $pembelian->nota_pembelian)->delete();
        }
        foreach ($dataArrayDetail as $dataDetail) {
            $dataDetail['nota_pembelian'] = $pembelian->nota_pembelian;
            $dataDetail = $this->prepareDetailData($dataDetail);

            $dataDetail = $this->dPembelianDetailModel->create($dataDetail);
        }
    }

    protected function validateData($pembelianData, $dataArrayDetail)
    {
        if (
            empty($pembelianData['nota_pembelian']) ||
            empty($pembelianData['tgl_pembelian']) ||
            empty($pembelianData['kd_supplier']) ||
            empty($pembelianData['jns_pembelian']) ||
            empty($pembelianData['harga_total']) ||
            empty($pembelianData['nominal_bayar']) ||
            empty($pembelianData['sisa_bayar'])
        ) {
            throw new \Exception('Semua kolom pada Tabel Pembelian harus terisi.');
        }

        foreach ($dataArrayDetail as $dataDetail) {
            if (
                empty($dataDetail['nota_pembelian']) ||
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

    protected function validateStok($dataDetail)
    {
        $stok = $this->dStokProduk->where('kd_produk', $dataDetail['kd_produk'])->first();

        if (!$stok || $stok->qty < $dataDetail['qty_pesan']) {
            throw new \Exception('Stok tidak mencukupi.');
        }
    }

    protected function preparePembelianData($pembelianData)
    {
        $pembelianData['opr_input'] = Auth::user()->nik;
        $pembelianData['tgl_input'] = date('Ymd');
        $pembelianData['sts_angsuran'] = $pembelianData['sts_angsuran'] ?? '4';
        $pembelianData['harga_total'] = $pembelianData['harga_total'] ? FormatHelper::removeDots($pembelianData['harga_total']) : 0;
        $pembelianData['nominal_bayar'] = $pembelianData['nominal_bayar'] ? FormatHelper::removeDots($pembelianData['nominal_bayar']) : 0;
        $pembelianData['sisa_bayar'] = $pembelianData['sisa_bayar'] ? FormatHelper::removeDots($pembelianData['sisa_bayar']) : 0;

        return $pembelianData;
    }

    protected function prepareDetailData($dataDetail)
    {
        $dataDetail['qty_pesan'] = $dataDetail['qty_pesan'] ? FormatHelper::removeDots($dataDetail['qty_pesan']) : 0;
        $dataDetail['qty_retur'] = $dataDetail['qty_retur'] ? FormatHelper::removeDots($dataDetail['qty_retur']) : 0;
        $dataDetail['qty_bersih'] = $dataDetail['qty_bersih'] ? FormatHelper::removeDots($dataDetail['qty_bersih']) : 0;
        $dataDetail['harga_satuan'] = $dataDetail['harga_satuan'] ? FormatHelper::removeDots($dataDetail['harga_satuan']) : 0;
        $dataDetail['harga_total'] = $dataDetail['harga_total'] ? FormatHelper::removeDots($dataDetail['harga_total']) : 0;

        return $dataDetail;
    }

    protected function upsertPembelian($pembelianData)
    {
        return DPembelianModel::updateOrCreate(['nota_pembelian' => $pembelianData['nota_pembelian']], $pembelianData);
    }
}
