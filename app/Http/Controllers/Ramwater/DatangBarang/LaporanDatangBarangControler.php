<?php

namespace App\Http\Controllers\Ramwater\DatangBarang;

use App\Http\Controllers\Controller;
use App\Models\DatangBarang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanDatangBarangControler extends Controller
{
    public function data(Request $request)
    {
        $tgl_ = $request['tanggal'];
        $tgl_awal =  $tgl_ ? date('Ymd', strtotime(substr($tgl_, 0, 10))) : date('Ymd');
        $tgl_akhir = $tgl_ ? date('Ymd', strtotime(substr($tgl_, 13, 10))) : date('Ymd');

        $laporan = DB::table('ramwater_d_datang_barang as a')
            ->select(
                'a.tgl_datang',
                'a.nama',
                'a.kd_produk',
                'b.nama as nama_produk',
                DB::raw('(SELECT SUM(jumlah-rb) FROM ramwater_d_datang_barang where kd_produk = a.kd_produk) as sum_jumlah'),
                DB::raw('(SELECT SUM(total) FROM ramwater_d_datang_barang where kd_produk = a.kd_produk) as sum_total'),
            )
            ->join('t_master_produk as b', 'a.kd_produk', 'b.kd_produk')
            ->whereBetween('tgl_datang', [$tgl_awal, $tgl_akhir])
            ->groupBy(
                'a.tgl_datang',
                'a.nama',
                'a.kd_produk',
                'b.nama',
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
        return view('ramwater.datang_barang.laporan', $data);
    }
}
