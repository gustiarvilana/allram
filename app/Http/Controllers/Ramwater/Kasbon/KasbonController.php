<?php

namespace App\Http\Controllers\Ramwater\Kasbon;

use App\Http\Controllers\Controller;
use App\Models\DKasbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    public function data(Request $request)
    {
        $tanggal = $request['tanggal'] ? date('Ymd', strtotime($request['tanggal'])) : date('Ymd');

        $ops = DB::table('d_kasbon as a')
            ->select(
                'a.*',
                'b.nama',
                DB::raw('(SELECT SUM(bayar) FROM d_kasbon as c WHERE c.id_parent = a.id) as byr_akhir'),
                DB::raw('(SELECT catatan FROM d_kasbon as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as catatan_akhir')
            )
            ->join('t_karyawan as b', 'a.nik', 'b.nik')
            ->where('a.satker', 'ramwater')
            ->where('a.sts', '!=', 4)
            ->whereRaw('a.id_parent = a.id')
            ->where('tanggal', $tanggal);

        return datatables()
            ->of($ops)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        return view('ramwater.kasbon.index');
    }

    public function store(Request $request)
    {
        $data = [
            'id'        => $request->input('id'),
            'id_parent' => $request->input('id_parent'),
            'satker'    => $request->input('satker'),
            'tanggal'   => $request->input('tanggal'),
            'nik'       => $request->input('nik'),
            'jumlah'    => $request->input('jumlah'),
            'bayar'     => $request->input('bayar'),
            'catatan'   => $request->input('catatan'),
        ];
        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));
        $data['jumlah'] = str_replace('.', '', $data['jumlah']);
        $data['sts'] = '1';

        if (isset($data['harga'])) {
            $data['harga'] = str_replace('.', '', $data['harga']);
            $data['total'] = $data['harga'] * $data['jumlah'];
        }

        try {
            DKasbon::upsert($data, ['id']); // Memanggil metode upsert dari model User
            $save = DKasbon::latest()->first();
            if (!$data['id_parent']) {
                DKasbon::where('id', $save->id)->update(['id_parent' => $save->id]);
            }
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'      => $request->input('id'),
            'satker'  => $request->input('satker'),
            'tanggal' => $request->input('tanggal'),
            'nik'     => $request->input('nik'),
            'jumlah'  => $request->input('jumlah'),
            'bayar'   => $request->input('bayar'),
            'catatan' => $request->input('catatan'),
        ];
        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));
        $data['jumlah'] = str_replace('.', '', $data['jumlah']);

        if (isset($data['harga'])) {
            $data['harga']      = str_replace('.', '', $data['harga']);
            $data['total'] = $data['harga'] * $data['jumlah'];
        }

        try {
            DKasbon::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DKasbon::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
