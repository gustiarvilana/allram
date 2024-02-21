<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    private $supplier;
    public function __construct() {
    $this->supplierModel=new SupplierModel();    
    }

    public function data()
    {
        $supplier=Suppl
    }

    public function index()
    {
        return view('ramwater.pembelian.index');
    }
}
