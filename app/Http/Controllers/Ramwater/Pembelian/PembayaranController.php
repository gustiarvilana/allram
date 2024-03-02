<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\TChannelModel;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    protected $dPembelianDetailModel;
    protected $dPembayaranModel;
    public function __construct(
        DPembelianModel $dPembelianModel,
        DPembayaranModel $dPembayaranModel
    ) {
        $this->dPembelianModel   = $dPembelianModel;
        $this->dPembayaranModel       = $dPembayaranModel;
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $supplier = $this->dPembayaranModel->setNotaPembelian($req['nota_pembelian']);
        $supplier = $this->dPembayaranModel->getPembayaran();

        return response()->json($supplier);
    }

    public function index()
    {
        $data = [
            'channels' => TChannelModel::all(),
        ];
        return view('ramwater.pembelian.pembayaran', $data);
    }

    public function store()
    {
        dd('store');
    }

    public function laporan()
    {
        dd('laporan');
    }
}
