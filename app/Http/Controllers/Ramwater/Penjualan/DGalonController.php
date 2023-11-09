<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DGalonController extends Controller
{
    public function data()
    {
        $datangBarang = DB::table('ramwater_d_galon as a')
            ->where('sts', '!=', '4')
            ->latest();

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
        $data['created_at'] = now();

        // dd($data);
        if ($data['jumlah'] == 0) {
            $data['sts'] = 4;
            try {
                DB::table('ramwater_d_galon')
                    ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => $data['sts']]);
            } catch (\Throwable $th) {
                throw $th;
            }
        } elseif ($data['jumlah'] < 0) {
            $data['sts'] = 5;
            try {
                DB::table('ramwater_d_galon')
                    ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => $data['sts']]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        try {
            DB::table('ramwater_d_galon')->upsert($data, ['id']);
            $save = DB::table('ramwater_d_galon')->latest()->first();
            if (!$data['id_parent']) {
                DB::table('ramwater_d_galon')->where('id', $save->id)->update(['id_parent' => $save->id]);
            }
            $data['created_at'] = now();
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('ramwater_d_galon')->where('id_parent', $id)->delete();
            DB::table('ramwater_d_galon')->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
