<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DHutangController extends Controller
{
    public function data(Request $request)
    {
        $tanggal = $request['tanggal'] ? date('Ymd', strtotime($request['tanggal'])) : date('Ymd');

        if ($request['riwayat'] != 1) {
            $kasbon = DB::table('ramwater_d_hutang as a')
                ->select(
                    'a.*',
                    'b.nama as nama_karyawan',
                    DB::raw('(SELECT jumlah FROM ramwater_d_hutang as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as sisa'),
                    DB::raw('(SELECT SUM(bayar) FROM ramwater_d_hutang as c WHERE c.id_parent = a.id) as byr_akhir'),
                    DB::raw('(SELECT tanggal FROM ramwater_d_hutang as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as tgl_byr'),
                )
                ->join('t_karyawan as b', 'a.nik', 'b.nik')
                ->where('a.sts', '!=', 4)
                ->whereRaw('a.id_parent = a.id');
            } else {
                $kasbon = DB::table('ramwater_d_hutang as a')
                ->select(
                    'a.*',
                    'b.nama as nama_karyawan',
                    'a.bayar as sisa',
                    'a.bayar as byr_akhir',
                    'a.tanggal as tgl_byr'
                    )
                ->join('t_karyawan as b', 'a.nik', 'b.nik')
                ->where('a.sts', '!=', 4);
        }
        if ($request['nik']) {
            $kasbon->where('a.nik', $request['nik']);
        }

        return datatables()
            ->of($kasbon)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        return view('ramwater.pinjam_uang.index');
    }

    public function store(Request $request)
    {
        $data = [
            // 'id'          => $request->input('id'),
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

        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));
        $data['jumlah'] = str_replace('.', '', $data['jumlah']);
        $data['bayar'] = str_replace('.', '', $data['bayar']);
        // $data['jumlah'] = $data['jumlah'] - $data['bayar'];
        $data['sts'] = 1;

        // dd($data);
        try {
            DB::table('ramwater_d_hutang')->upsert($data, ['id']);
            $save = DB::table('ramwater_d_hutang')->latest()->first();
            if ($data['id_parent'] == null) {
                DB::table('ramwater_d_hutang')->where('id', $save->id)->update(['id_parent' => $save->id]);
            }
            $save = DB::table('ramwater_d_hutang')->latest()->first();
            $all_bayar = DB::table('ramwater_d_hutang')->where('id_parent', $save->id_parent)->sum('bayar');
            $jml_awal = DB::table('ramwater_d_hutang')->where('id', $save->id_parent)->first();
            $jml_awal = DB::table('ramwater_d_hutang')->where('id', $save->id_parent)->first()->jumlah;
            if ($jml_awal == $all_bayar || $jml_awal < $all_bayar) {
                DB::table('ramwater_d_hutang')
                ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => '4']);
            }
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
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

        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));
        $data['jumlah'] = str_replace('.', '', $data['jumlah']);
        $data['bayar'] = str_replace('.', '', $data['bayar']);
        // $data['jumlah'] = $data['jumlah'] - $data['bayar'];
        $data['sts'] = 1;

        try {
            DB::table('ramwater_d_hutang')->upsert($data, ['id']);
            $save = DB::table('ramwater_d_hutang')->latest()->first();
            if (!$data['id_parent']) {
                DB::table('ramwater_d_hutang')->where('id', $save->id)->update(['id_parent' => $save->id]);
            }
            $all_bayar = DB::table('ramwater_d_hutang')->where('id_parent', $save->id_parent)->sum('bayar');
            $jml_awal = DB::table('ramwater_d_hutang')->where('id', $save->id_parent)->first()->jumlah;
            if ($jml_awal == $all_bayar || $jml_awal < $all_bayar) {
                DB::table('ramwater_d_hutang')
                ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => '4']);
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
