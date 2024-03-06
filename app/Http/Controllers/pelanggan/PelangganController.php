<?php

namespace App\Http\Controllers\pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\Produk;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private $model;
    private $const;

    public function __construct()
    {
        $this->model = new DPelangganModel();
        $this->const = config('constants.ramwater');
    }

    public function data(Request $request)
    {
        $pelanggan = $this->model->get();

        return datatables()
            ->of($pelanggan)
            ->addIndexColumn()
            ->make(true);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
