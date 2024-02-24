<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembelianModel;
use Illuminate\Http\Request;

class LaporanPembelianController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    public function __construct(DPembelianModel $dPembelianModel)
    {
        $this->dPembelianModel = $dPembelianModel;
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data()
    {
        $supplier = $this->dPembelianModel->getpembelian();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
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
