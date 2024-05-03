<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\SupplierModel;
use App\Models\TOps;
use App\Services\ProductService;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $model;
    private $tOps;
    private $supplier;
    private $SupplierService;

    public function __construct()
    {
        $this->model = new SupplierModel();
        $this->tOps = new TOps();
        $this->supplier = new SupplierModel();
        $this->SupplierService = new SupplierService();
    }

    public function data(Request $request)
    {
        $supplier = $this->model->orderBy('created_at', 'DESC');
        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'tOpss' => $this->tOps->where('tipe', '=', 'B')->get(),
            'suppliers' => $this->supplier->get(),
        ];
        return view('ramwater.supplier.index', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        return $this->SupplierService->storeData($input);
    }

    public function destroy($id)
    {
        return $this->SupplierService->destroy($id);
    }
}
