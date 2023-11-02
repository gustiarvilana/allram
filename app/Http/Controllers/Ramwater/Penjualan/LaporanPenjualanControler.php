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

                DB::raw('(SELECT SUM(jumlah) FROM ramwater_d_penjualan where kd_produk = a.kd_produk and nik = c.nik) as sum_jumlah'),
                DB::raw('(SELECT SUM(total) FROM ramwater_d_penjualan_detail where id_penjualan = a.id) as sum_total'),
            )
            ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
            ->join('t_karyawan as c', 'a.nik', 'c.nik')
            ->join('t_master_produk as d', 'a.kd_produk', 'd.kd_produk')
            ->groupBy(
                'a.id',
                'a.nik',
                'a.kd_produk',
                'd.nama',
                'c.nama',
                'c.nik',
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
        return view('ramwater.penjualan.laporan', $data);
    }
}
