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
        $tgl = date('Ymd', strtotime($request['tanggal']));

        if ($tgl) {
            $laporan = DB::table('ramwater_d_penjualan as a')
                ->select(
                    'c.nama as nama_sales',
                    'a.nik',
                    'a.tgl_penjualan',
                    DB::raw('SUM(b.jumlah) as sum_jumlah'),
                    DB::raw('SUM(b.total) as sum_total'),
                    DB::raw('SUM(a.cash) as t_cash'),
                    DB::raw('SUM(a.transfer) as t_transfer'),
                    DB::raw('(SELECT COALESCE(SUM(bayar), 0) FROM ramwater_d_hutang as d WHERE d.nik = a.nik and d.tanggal = a.tgl_penjualan) as bayar_total'),
                    DB::raw('(SELECT COALESCE(SUM(jumlah), 0) FROM ramwater_d_hutang as e WHERE e.nik = a.nik and e.tanggal = a.tgl_penjualan) as hutang_total'),
                    DB::raw('SUM(b.total) + COALESCE((SELECT SUM(bayar) FROM ramwater_d_hutang as c WHERE c.nik = a.nik and c.tanggal = a.tgl_penjualan), 0) - COALESCE((SELECT SUM(jumlah) FROM ramwater_d_hutang as d WHERE d.nik = a.nik and d.tanggal = a.tgl_penjualan), 0) as cash'),
                    DB::raw("(SELECT COALESCE(SUM(jumlah), 0) FROM d_kasbon as e WHERE e.satker='ramwater' and e.nik = a.nik and e.tanggal = a.tgl_penjualan) as kasbon_sales"),
                )

                ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
                ->join('t_karyawan as c', 'a.nik', 'c.nik')
                ->where('a.tgl_penjualan', $tgl)
                ->groupBy(
                    'c.nama',
                    'c.nik',
                    'a.tgl_penjualan',
                    'a.nik',
                );
        }


        return datatables()
            ->of($laporan)
            ->addIndexColumn()
            ->make(true);
    }

    public function perProduk(Request $request)
    {
        $tgl = date('Ymd', strtotime($request['tanggal']));

        $laporan = DB::table('ramwater_d_penjualan as a')
            ->select(
                'c.nama as nama_sales',
                'd.nama as nama_produk',
                DB::raw('SUM(b.jumlah) as sum_jumlah'),
                DB::raw('SUM(b.total) as sum_total'),
                DB::raw('SUM(a.cash) as t_cash'),
                DB::raw('SUM(a.transfer) as t_transfer'),
            )
            ->join('ramwater_d_penjualan_detail as b', 'a.id', 'b.id_penjualan')
            ->join('t_karyawan as c', 'a.nik', 'c.nik')
            ->join('t_master_produk as d', 'a.kd_produk', 'd.kd_produk')
            ->where('a.tgl_penjualan', $tgl)
            ->groupBy(
                'c.nama',
                'd.nama',
            );
        // ->havingRaw('SUM(b.jumlah) > 5');


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
