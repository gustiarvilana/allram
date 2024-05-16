<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function data(Request $request)
    {
        $menu = DB::table('d_karyawan as a')
            ->select('a.*', 'b.*', 'a.nik as nik_karyawan', 'a.id as id_karyawan', 'b.id as id_user')
            ->leftJoin('users as b', 'a.nik', 'b.nik');

        return datatables()
            ->of($menu)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        return view('security.karyawan.index');
    }

    public function store(Request $request)
    {
        $lastNik = Karyawan::max('nik');
        $newNik = $lastNik ? $lastNik + 1 : 1;

        $data = [
            'nik'       => $newNik,
            'nama'      => $request->input('nama'),
            'satker'    => 'ramarmalia',
            'jabatan'   => $request->input('jabatan'),
            'alamat'    => $request->input('alamat'),
            'jk'        => $request->input('jk'),
            'ktp'       => $request->input('ktp'),
            'no_hp'     => $request->input('no_hp'),
            'reference' => $request->input('reference'),
        ];

        try {
            Karyawan::upsert($data, ['kd_menu', 'kd_parent']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'        => $request->input('id'),
            'nik'       => $request->input('nik'),
            'nama'      => $request->input('nama'),
            'jabatan'   => $request->input('jabatan'),
            'satker'    => $request->input('satker'),
            'alamat'    => $request->input('alamat'),
            'jk'        => $request->input('jk'),
            'ktp'       => $request->input('ktp'),
            'no_hp'     => $request->input('no_hp'),
            'reference' => $request->input('reference'),
        ];
        try {
            Karyawan::upsert($data, ['id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            Karyawan::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
