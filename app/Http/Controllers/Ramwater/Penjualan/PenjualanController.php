<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\SupplierModel;
use App\Models\TGudang;
use App\Services\PembelianService;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    protected $tGudang;
    protected $produkMOdel;

    public function __construct(TGudang $tGudang, Produk $produkMOdel)
    {
        $this->integrationHelper = new IntegrationHelper;
        $this->tGudang = $tGudang;
        $this->produkMOdel = $produkMOdel;
    }

    public function data()
    {
        $supplier = $this->produkMOdel->getProduk();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'gudang' => $this->tGudang->get(),
        ];
        return view('ramwater.penjualan.index', $data);
    }

    public function store(Request $request)
    {
        $pembelianData = json_decode($request->input('pembelianData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);
        $file = $request->file('path_file');

        if ($request->input('jns')) {
            $pembelianData['jns'] = $request->input('jns');
        }

        return $this->pembelianService->storePembelian($pembelianData, $dataArrayDetail, $file);
    }

    public function destroy($id)
    {
        $id = $this->integrationHelper->decrypt(base64_decode($id), $this->integrationHelper->getKey());
        return $this->pembelianService->destroyPembelian($id);
    }
}
