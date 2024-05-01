<?php

namespace App\Http\Controllers\Ramwater\LaporanMaster;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\SupplierModel;
use App\Models\TChannelModel;
use App\Models\TOps;
use App\Services\LaporanService;
use App\Services\OpsService;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    private $laporanService;
    public function __construct()
    {
        $this->laporanService = new LaporanService();
    }

    public function data(Request $request)
    {
        $input = $request->input();

        if (isset($input['rTanggal'])) {
            $rTanggal = $input['rTanggal'];
            list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

            $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
            $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));
        }

        $laporan = $this->laporanService->getLaporanByTgl($tanggal_awal, $tanggal_akhir);

        return response()->json(['success' => true, 'data' => $laporan]);
    }

    public function index(Request $request)
    {
        return view('ramwater.laporan.harian');
    }
}
