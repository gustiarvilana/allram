<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\TChannelModel;
use App\Services\PembayaranService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    protected $dPembelianDetailModel;
    protected $pembayaranService;
    protected $dPembayaranModel;
    public function __construct(
        DPembelianModel $dPembelianModel,
        DPembayaranModel $dPembayaranModel,
        PembayaranService $pembayaranService
    ) {
        $this->dPembelianModel   = $dPembelianModel;
        $this->dPembayaranModel       = $dPembayaranModel;
        $this->pembayaranService       = $pembayaranService;
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $bayar = $this->dPembayaranModel->setNotaPembelian($req['nota_pembelian']);
        $bayar = $this->dPembayaranModel->getPembayaran();

        return response()->json($bayar);
    }

    public function index()
    {
        $data = [
            'channels' => TChannelModel::all(),
        ];
        return view('ramwater.pembelian.pembayaran', $data);
    }

    public function store(Request $request)
    {

        $pembelianData = json_decode($request->input('pembelianData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);
        $file = $request->file('path_file');

        if ($request->input('jns')) {
            $pembelianData['jns'] = $request->input('jns');
        }

        return $this->pembayaranService->storePembayaran($pembelianData, $dataArrayDetail, $file);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
