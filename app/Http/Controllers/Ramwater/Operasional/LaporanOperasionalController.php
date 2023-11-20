<?php

namespace App\Http\Controllers\Ramwater\Operasional;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanOperasionalController extends Controller
{
    public function data(Request $request)
    {
        $tgl_ = $request['tanggal'];
        $tgl_awal =  $tgl_ ? date('Ymd', strtotime(substr($tgl_, 0, 10))) : date('Ymd');
        $tgl_akhir = $tgl_ ? date('Ymd', strtotime(substr($tgl_, 13, 10))) : date('Ymd');

        $laporan = DB::table('d_operasional as a')
            ->select(
                'a.tanggal',
                'c.nama_operasional as nama',
                DB::raw('(SELECT SUM(total) FROM d_operasional where kd_operasional = a.kd_operasional) as total'),
            )
            ->join('t_karyawan as b', 'a.nik', 'b.nik')
            ->join('t_operasional as c', 'a.kd_operasional', 'c.kd_operasional')
            ->where('tanggal', date('Ymd',strtotime($tgl_)))
            ->where('a.satker', 'ramwater')
            ->groupBy(
                'a.kd_operasional',
                'a.tanggal',
                'c.nama_operasional',
            );

        return datatables()
            ->of($laporan)
            ->addIndexColumn()
            ->make(true);
    }

    public function laporan()
    {
        $data = [
            'produks' => Produk::where('satker', 'ramwater')->get(),
        ];
        return view('ramwater.operasional.laporan', $data);
    }
}
