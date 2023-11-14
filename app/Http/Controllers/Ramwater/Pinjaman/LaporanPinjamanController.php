<?php

namespace App\Http\Controllers\Ramwater\Pinjaman;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPinjamanController extends Controller
{
    public function data(Request $request)
    {
        $tgl_ = $request['tanggal'];
        $tgl_awal =  $tgl_ ? date('Ymd', strtotime(substr($tgl_, 0, 10))) : date('Ymd');
        $tgl_akhir = $tgl_ ? date('Ymd', strtotime(substr($tgl_, 13, 10))) : date('Ymd');

        $laporan = DB::table('d_pinjam as a')
            ->select(
                'a.tanggal',
                'b.nama',
                DB::raw('(SELECT SUM(jumlah) FROM d_pinjam where nik = a.nik) as total'),
            )
            ->join('t_karyawan as b', 'a.nik', 'b.nik')
            ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
            ->where('a.satker', 'ramwater')
            ->where('a.sts', '1')
            ->groupBy(
                'b.nama',
                'a.tanggal',
                'a.nik',
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
        return view('ramwater.pinjam.laporan', $data);
    }
}
