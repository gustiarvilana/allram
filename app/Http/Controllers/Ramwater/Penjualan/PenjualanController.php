<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\SupplierModel;
use App\Models\TGudang;
use App\Services\PembelianService;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    protected  $supplier;
    protected $pembelianService;
    protected $tGudang;

    public function __construct(SupplierModel $supplierModel, PembelianService $pembelianService, TGudang $tGudang)
    {
        $this->supplier = $supplierModel;
        $this->pembelianService = $pembelianService;
        $this->tGudang = $tGudang;
        $this->integrationHelper = new IntegrationHelper;
    }

    public function data()
    {
        $supplier = $this->supplier->getSupplier();

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
        return view('ramwater.pembelian.index', $data);
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
