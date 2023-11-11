<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DHutangController extends Controller
{
    public function data(Request $request)
    {
        $datangBarang = DB::table('ramwater_d_hutang as a')
            ->where('sts', '!=', '4');
        if ($request['nik']) {
            $datangBarang->where('nik', $request['nik']);
        }
        $datangBarang->latest();

        return datatables()
            ->of($datangBarang)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = [
            'id'          => $request->input('id'),
            'id_parent'   => $request->input('id_parent'),
            'tanggal'     => $request->input('tanggal'),
            'nik'         => $request->input('nik'),
            'nama'        => $request->input('nama'),
            'jumlah'      => $request->input('jumlah') ?? 0,
            'alamat'      => $request->input('alamat'),
            'hp'          => $request->input('hp'),
            'bayar'       => $request->input('bayar') ?? 0,
            'tgl_kembali' => $request->input('tgl_kembali'),
        ];

        $data['jumlah'] = str_replace('.', '', $data['jumlah']);
        $data['bayar'] = str_replace('.', '', $data['bayar']);
        $data['jumlah'] = $data['jumlah'] - $data['bayar'];
        $data['sts'] = 1;

        if ($data['jumlah'] < 1) {
            $data['sts'] = 4;
            try {
                DB::table('ramwater_d_hutang')
                    ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => $data['sts']]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // dd($data);
        try {
            DB::table('ramwater_d_hutang')->upsert($data, ['id']);
            $save = DB::table('ramwater_d_hutang')->latest()->first();
            if (!$data['id_parent']) {
                DB::table('ramwater_d_hutang')->where('id', $save->id)->update(['id_parent' => $save->id]);
            }
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('ramwater_d_hutang')->where('id_parent', $id)->delete();
            DB::table('ramwater_d_hutang')->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return 'delete success';
    }
}
