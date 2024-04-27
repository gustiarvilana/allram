<?php

namespace App\Http\Controllers\Ramwater\Piutang;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\DPelangganModel;
use App\Models\Karyawan;
use App\Models\SupplierModel;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Models\TOps;

class PiutangNominalController extends Controller
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
            'pelanggans' => DPelangganModel::get(),
            'saless' => Karyawan::where('jabatan', '=', 'sales')->get(),
            'gudang' => TGudang::get(),
            'channels' => TChannelModel::get(),
        ];
        return view('ramwater.piutang.nominal', $data);
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
