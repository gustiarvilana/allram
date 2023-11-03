<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DHutangController extends Controller
{
    public function data()
    {
        $datangBarang = DB::table('ramwater_d_hutang as a');

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
                'tanggal'     => $request->input('tanggal'),
                'nik'         => $request->input('nik'),
                'nama'        => $request->input('nama'),
                'jumlah'      => $request->input('jumlah'),
                'alamat'      => $request->input('alamat'),
                'hp'          => $request->input('hp'),
                'tgl_kembali' => $request->input('tgl_kembali'),
            ];
        }

        $data['jumlah'] = str_replace('.', '', $data['jumlah']);

        // dd($data);
        try {
            DB::table('ramwater_d_hutang')->upsert($data, ['id']);
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('ramwater_d_hutang')->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
