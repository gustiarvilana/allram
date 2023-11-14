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

        if ($request['riwayat'] != 1) {
            $kasbon = DB::table('d_kasbon as a')
                ->select(
                    'a.*',
                    'b.nama',
                    DB::raw('(SELECT jumlah FROM d_kasbon as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as sisa'),
                    DB::raw('(SELECT SUM(bayar) FROM d_kasbon as c WHERE c.id_parent = a.id) as byr_akhir'),
                    DB::raw('(SELECT catatan FROM d_kasbon as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as catatan_akhir'),
                    DB::raw('(SELECT tanggal FROM d_kasbon as c WHERE c.id_parent = a.id ORDER BY created_at DESC LIMIT 1) as tgl_byr')
                )
                ->join('t_karyawan as b', 'a.nik', 'b.nik')
                ->where('a.satker', 'ramwater')
                ->where('a.sts', '!=', 4)
                ->whereRaw('a.id_parent = a.id')
                ->where('tanggal', $tanggal);
        } else {
            $kasbon = DB::table('d_kasbon as a')
                ->select(
                    'a.*',
                    'b.nama',
                    'a.bayar as sisa',
                    'a.bayar as byr_akhir',
                    'a.catatan as catatan_akhir',
                    'a.tanggal as tgl_byr'
                )
                ->join('t_karyawan as b', 'a.nik', 'b.nik')
                ->where('a.satker', 'ramwater')
                ->where('a.sts', '!=', 4);
            // ->where('tanggal', $tanggal);
        }

        return datatables()
            ->of($kasbon)
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
        $data['jumlah']  = $data['jumlah'] ? str_replace('.', '', $data['jumlah']) : 0;
        $data['bayar']   = $data['bayar'] ? str_replace('.', '', $data['bayar']) : 0;

        $data['jumlah'] = $data['jumlah'] - $data['bayar'];
        $data['sts']     = '1';

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
        $data['bayar']   = $data['bayar'] ? str_replace('.', '', $data['bayar']) : 0;

        $data['jumlah'] = $data['jumlah'] - $data['bayar'];
        $data['sts']     = '1';

        if ($data['jumlah'] < 1) {
            $data['sts'] = 4;
            try {
                DB::table('d_kasbon')
                    ->where('id_parent', $data['id_parent'])
                    ->update(['sts' => $data['sts']]);
            } catch (\Throwable $th) {
                throw $th;
            }
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
