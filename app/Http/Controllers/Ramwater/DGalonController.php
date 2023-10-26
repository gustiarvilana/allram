<?php

namespace App\Http\Controllers\Ramwater;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DGalonController extends Controller
{
    public function data($id_penjualan)
    {
        $datangBarang = DB::table('ramwater_d_galon as a')->where('id_penjualan', $id_penjualan);

        return datatables()
            ->of($datangBarang)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = [
            'id'           => $request->input('id'),
            'id_penjualan' => $request->input('id_penjualan'),
            'nama'         => $request->input('nama'),
            'jumlah'       => $request->input('jumlah'),
            'tgl_kembali'  => $request->input('tgl_kembali'),
        ];
        try {
            DB::table('ramwater_d_galon')->upsert($data, ['id']);
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('ramwater_d_galon')->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
