<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\DPembelianModel;
use Illuminate\Http\Request;

class LaporanPembelianController extends Controller
{
    protected $dPembelianModel;
    public function __construct(DPembelianModel $dPembelianModel)
    {
        $this->dPembelianModel = $dPembelianModel;
    }

    public function data()
    {
        $supplier = $this->dPembelianModel->getpembelian();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        return view('ramwater.pembelian.laporan');
    }

    public function laporan()
    {
        dd('laporan');
    }
}
