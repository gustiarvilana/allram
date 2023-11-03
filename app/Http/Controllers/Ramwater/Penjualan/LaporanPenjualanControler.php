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
        $tgl_ = $request['tanggal'];
        $tgl_awal =  $tgl_ ? date('Ymd', strtotime(substr($tgl_, 0, 10))) : date('Ymd');
        $tgl_akhir = $tgl_ ? date('Ymd', strtotime(substr($tgl_, 13, 10))) : date('Ymd');

        $laporan = DB::table('ramwater_d_penjualan as a')
            ->select(
                'c.nama as nama_sales',
                DB::raw('SUM(a.jumlah) as sum_jumlah'),
                DB::raw('SUM(b.total) as sum_total'),
                DB::raw('SUM(a.cash) as t_cash'),
                DB::raw('SUM(a.transfer) as t_transfer'),
            )
            ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
            ->join('t_karyawan as c', 'a.nik', 'c.nik')
            ->whereBetween('a.tgl_penjualan', [$tgl_awal, $tgl_akhir])
            ->groupBy(
                'c.nama',
                'c.nik',
                'a.tgl_penjualan',
                // 'b.jumlah',
                // 'a.cash',
                // 'a.transfer',
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
