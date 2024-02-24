<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\SupplierModel;
use App\Services\PembelianService;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    protected  $supplier;
    protected $pembelianService;

    public function __construct(SupplierModel $supplierModel, PembelianService $pembelianService)
    {
        $this->supplier = $supplierModel;
        $this->pembelianService = $pembelianService;
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
        return view('ramwater.pembelian.index');
    }

    public function store(Request $request)
    {
        $pembelianData = json_decode($request->input('pembelianData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);
        $jns = $request->input('jns');

        return $this->pembelianService->storePembelian($pembelianData, $dataArrayDetail, $jns);
    }

    public function destroy($id)
    {
        $id = $this->integrationHelper->decrypt(base64_decode($id), $this->integrationHelper->getKey());
        return $this->pembelianService->destroyPembelian($id);
    }
}
