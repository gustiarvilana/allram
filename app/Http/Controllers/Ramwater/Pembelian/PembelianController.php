<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    private $model;
    public function __construct(SupplierModel $supplierModel)
    {
        $this->model = $supplierModel;
    }

    public function data()
    {
        $supplier = $this->model->getSupplier();

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
