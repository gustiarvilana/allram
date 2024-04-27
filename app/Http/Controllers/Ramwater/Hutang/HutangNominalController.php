<?php

namespace App\Http\Controllers\Ramwater\Hutang;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\SupplierModel;
use App\Models\TChannelModel;
use App\Models\TOps;
use App\Services\OpsService;

class HutangNominalController extends Controller
{
    private $tOps;
    private $dKaryawan;
    public function __construct()
    {
        $this->tOps = new TOps();
        $this->dKaryawan = new Karyawan();
    }

    public function index()
    {
        $data = [
            'opss' => $this->tOps->get(),
            'pegawais' => $this->dKaryawan->get(),
            'channels' => TChannelModel::all(),
            'suppliers' => SupplierModel::all()
        ];
        return view('ramwater.hutang.nominal', $data);
    }

    public function destroy($id)
    {
        try {
            DOpsModel::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
