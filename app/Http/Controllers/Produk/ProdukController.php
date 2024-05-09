<?php

namespace App\Http\Controllers\Produk;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\SupplierModel;
use App\Models\TOps;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    private $model;
    private $tOps;
    private $supplier;
    private $productService;

    public function __construct()
    {
        $this->model = new Produk();
        $this->tOps = new TOps();
        $this->supplier = new SupplierModel();
        $this->productService = new ProductService();
    }

    public function data(Request $request)
    {
        $input = $request->input();

        $produk = $this->model->where('satker', '=', 'ramwater')->orderBy('created_at', 'DESC');

        if (isset($input['kd_supplier'])) $produk->where('kd_supplier', $input['kd_supplier']);

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'tOpss' => $this->tOps->where('tipe', '=', 'P')->get(),
            'suppliers' => $this->supplier->get(),
        ];
        return view('ramwater.produk.index', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all(); // Mengambil semua data dari form

        return $this->productService->storeData($input);
    }

    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }
}
