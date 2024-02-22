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

    public function data()
    {
        $this->model->setSatker($this->const['satker'] ?? null);
        $produk = $this->model->getProduk();

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
