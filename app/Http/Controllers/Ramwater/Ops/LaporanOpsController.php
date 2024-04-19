<?php

namespace App\Http\Controllers\Ramwater\Ops;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\TOps;
use App\Models\UserMenu;
use App\Models\UserRole;
use App\Services\OpsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanOpsController extends Controller
{
    private $opsService;
    private $tOps;
    private $dKaryawan;
    public function __construct()
    {
        $this->opsService = new OpsService();
        $this->tOps = new TOps();
        $this->dKaryawan = new Karyawan();
    }

    // public function data(Request $request)
    // {
    //     $menu = DB::table('d_ops as a');

    //     return datatables()
    //         ->of($menu)
    //         ->addIndexColumn()
    //         ->make(true);
    // }

    public function index()
    {
        $data = [
            'opss' => $this->tOps->get(),
            'pegawais' => $this->dKaryawan->get(),
        ];
        return view('ramwater.ops.laporan', $data);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->input('data'), true);

        return $this->opsService->store($data);
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
