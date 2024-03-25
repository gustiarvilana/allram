<?php

namespace App\Http\Controllers\Produk;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    private $model;
    private $const;

    public function __construct(Produk $produkModel)
    {
        $this->model = $produkModel;
        $this->const = config('constants.ramwater');
    }

    public function data(Request $request)
    {
        $input = [
            'nota_pembelian' => $request->query('nota_pembelian'),
            'nota_penjualan' => $request->query('nota_penjualan'),
            'kd_supplier' => $request->query('kd_supplier'),
        ];

        $this->model->setSatker($this->const['SATKER'] ?? null);
        if ($input) {
            $produk = $this->model->getProduk($input);
        } else {
            $produk = $this->model->getProduk();
        }

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->make(true);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
