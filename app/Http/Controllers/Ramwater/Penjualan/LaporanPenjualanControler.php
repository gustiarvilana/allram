<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\DatangBarang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanControler extends Controller
{

    public function data(Request $request)
    {
        $laporan = DB::table('ramwater_d_penjualan as a')
            ->select(
                'c.nama as nama_sales',
                'd.nama as nama_produk',
                DB::raw('SUM(a.jumlah) as sum_jumlah'),
                DB::raw('SUM(b.total) as sum_total'),
            )
            ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
            ->join('t_karyawan as c', 'a.nik', 'c.nik')
            ->join('t_master_produk as d', 'a.kd_produk', 'd.kd_produk')
            ->groupBy(
                'a.kd_produk',
                'd.nama',
                'c.nama',
                'c.nik',
            )
            ->havingRaw('SUM(b.jumlah) > 5');


        return datatables()
            ->of($laporan)
            ->addIndexColumn()
            ->make(true);
    }

    public function perorangan(Request $request)
    {
        $laporan = DB::table('ramwater_d_penjualan as a')
            ->select(
                'b.nama as nama_sales',
                'd.nama as nama_produk',
                DB::raw('SUM(a.jumlah) as sum_jumlah'),
                DB::raw('SUM(b.total) as sum_total'),
            )
            ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
            ->join('t_karyawan as c', 'a.nik', 'c.nik')
            ->join('t_master_produk as d', 'a.kd_produk', 'd.kd_produk')
            ->where('a.nik', '1239')
            ->groupBy(
                'a.kd_produk',
                'b.nama',
                'd.nama',
                'c.nama',
                'c.nik',
            )
            ->havingRaw('SUM(b.jumlah) > 5');

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
        return view('ramwater.penjualan.laporan', $data);
    }
}
