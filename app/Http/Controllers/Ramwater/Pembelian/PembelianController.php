<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function data()
    {
        dd('data');
    }

    public function index()
    {
        return view('ramwater.pembelian.index');
    }
}
