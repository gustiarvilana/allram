<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    private $supplierModel;

    public function __construct(SupplierModel $supplierModel)
    {
        $this->supplierModel = $supplierModel;
    }

    public function data()
    {
        $supplier = $this->supplierModel->getSupplier();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        return view('ramwater.pembelian.index');
    }
}
