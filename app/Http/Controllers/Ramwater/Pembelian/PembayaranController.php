<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembayaran;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    protected $dPembelianDetailModel;
    protected $dPembayaran;
    public function __construct(
        DPembelianModel $dPembelianModel,
        DPembayaran $dPembayaran
    ) {
        $this->dPembelianModel   = $dPembelianModel;
        $this->dPembayaran       = $dPembayaran;
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data()
    {
        $supplier = $this->dPembayaran->getpembelian();

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
