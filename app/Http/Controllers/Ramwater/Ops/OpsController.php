<?php

namespace App\Http\Controllers\Ramwater\Ops;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\TOps;
use App\Models\UserMenu;
use App\Models\UserRole;
use App\Services\OpsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OpsController extends Controller
{
    private $opsService;
    private $tOps;
    private $dOps;
    private $dKaryawan;
    public function __construct()
    {
        $this->opsService = new OpsService();
        $this->dOps = new DOpsModel();
        $this->tOps = new TOps();
        $this->dKaryawan = new Karyawan();
    }

    public function data(Request $request)
    {
        $requestData = $request->input();
        if (isset($requestData['rTanggal'])) {
            $menu = $this->dOps->getLaporanDataOps($requestData);
        } else {
            $menu = $this->dOps->getDataOps();
        }

        return datatables()
            ->of($menu)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'opss' => $this->tOps->whereRaw("SUBSTR(kd_ops, -2) != '00'")->orderBy('kd_ops', 'asc')->get(),
            'pegawais' => $this->dKaryawan->get(),
        ];

        return view('ramwater.ops.index', $data);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $file = $request->file('path_file');

        return $this->opsService->store($data, $file);
    }


    public function destroy($id)
    {
        $ops = DOpsModel::where('id', $id)->first();
        if ($ops->path_file) {
            $pathToDelete = $ops->path_file;
            $publicPath = storage_path('app/public/');

            // Pastikan path_file dimulai dengan "storage/"
            if (Str::startsWith($pathToDelete, 'storage/')) {
                $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
            }

            // delete
            FormatHelper::deleteFile($pathToDelete);
        }
        try {
            DOpsModel::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
