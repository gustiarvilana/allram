<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

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

        // dd($pembelianData);

        return $this->pembelianService->storePembelian($pembelianData, $dataArrayDetail);
    }
}
