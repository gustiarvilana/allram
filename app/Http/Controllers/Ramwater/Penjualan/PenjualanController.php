<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\SupplierModel;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Services\PembelianService;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    protected $tGudang;
    protected $produkMOdel;
    protected $tChannelModel;
    protected $karyawan;

    public function __construct()
    {
        $this->integrationHelper = new IntegrationHelper;
        $this->tGudang = new TGudang;
        $this->produkMOdel = new Produk;
        $this->tChannelModel = new TChannelModel();
        $this->karyawan = new Karyawan();
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
            'channels' => $this->tChannelModel->get(),
            'saless' => $this->karyawan->where('jabatan', '=', 'sales')->get(),
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
