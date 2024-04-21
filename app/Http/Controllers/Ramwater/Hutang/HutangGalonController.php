<?php

namespace App\Http\Controllers\Ramwater\Hutang;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\TOps;

class HutangGalonController extends Controller
{
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
        ];
        return view('ramwater.hutang.galon', $data);
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
