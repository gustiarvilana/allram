<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DGalonController extends Controller
{
    public function data()
    {
        $datangBarang = DB::table('ramwater_d_galon as a');

        return datatables()
            ->of($datangBarang)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = [
            'id'          => $request->input('id'),
            // 'nik'         => $request->input('nik'),
            'nama'        => $request->input('nama'),
            'jumlah'      => $request->input('jumlah'),
            'alamat'      => $request->input('alamat'),
            'hp'          => $request->input('hp'),
            'tgl_kembali' => $request->input('tgl_kembali'),
        ];
        if ($data['alamat']) {
            $data = [
                'id'          => $request->input('id'),
                'nik'         => $request->input('nik'),
                'nama'        => $request->input('nama'),
                'jumlah'      => $request->input('jumlah'),
                'alamat'      => $request->input('alamat'),
                'hp'          => $request->input('hp'),
                'tgl_kembali' => $request->input('tgl_kembali'),
            ];
        }

        $data['jumlah'] = str_replace('.', '', $data['jumlah']);

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
