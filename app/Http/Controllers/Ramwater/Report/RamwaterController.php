<?php

namespace App\Http\Controllers\Ramwater\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RamwaterController extends Controller
{
    public function dashboard()
    {
        return view('ramwater.report.monitoring');
    }

    public function monitoring_data(Request $request)
    {
        $tgl_ = $request['tanggal'];
        $tgl_awal =  $tgl_ ? date('Ymd', strtotime(substr($tgl_, 0, 10))) : date('Ymd');
        $tgl_akhir = $tgl_ ? date('Ymd', strtotime(substr($tgl_, 13, 10))) : date('Ymd');

        $gaji = DB::table('t_karyawan as a')
            ->select(
                'a.nik',
                'a.nama',
                'a.jabatan',
                DB::raw('SUM(d.jumlah) as jml_penjualan'),
                DB::raw('SUM(d.jumlah * ' . config('constants.insentif.LEVEL-1') . ') as ins_penjualan'),
                DB::raw('(SELECT SUM(g.jumlah) FROM ramwater_d_penjualan AS f
                        JOIN ramwater_d_penjualan_detail AS g ON f.id = g.id_penjualan
                        WHERE f.tgl_penjualan BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'
                        AND f.nik IN
                        (SELECT nik
                        FROM t_karyawan AS e
                        WHERE e.reference = a.nik)) as jml_member'),

                DB::raw('(SELECT SUM(g.jumlah) FROM ramwater_d_penjualan AS f
                        JOIN ramwater_d_penjualan_detail AS g ON f.id = g.id_penjualan
                        WHERE f.tgl_penjualan BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'
                        AND f.nik IN
                        (SELECT nik
                        FROM t_karyawan AS e
                        WHERE e.reference = a.nik)) * ' . config('constants.insentif.MEMBER') . ' as ins_member'),
                DB::raw('(SELECT SUM(bayar) FROM d_kasbon WHERE nik = a.nik AND tanggal BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\') as pot_kasbon'),
                DB::raw('(SELECT SUM(bayar) FROM d_pinjaman WHERE nik = a.nik AND tanggal BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\') as pot_pinjaman'),
                DB::raw('(SELECT SUM(a.jumlah) FROM ramwater_d_penjualan_detail AS a JOIN ramwater_d_penjualan AS b ON a.id_penjualan = b.id WHERE b.tgl_penjualan BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\') as glb_penjualan'),
                DB::raw('(SELECT SUM(a.jumlah) FROM ramwater_d_penjualan_detail AS a JOIN ramwater_d_penjualan AS b ON a.id_penjualan = b.id WHERE b.tgl_penjualan BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\') * ' . config('constants.insentif.MANAGER') . ' as glb_ins_penjualan'),

                DB::raw('(
                    (
                        (SELECT COALESCE(SUM(g.jumlah), 0) FROM ramwater_d_penjualan AS f
                            JOIN ramwater_d_penjualan_detail AS g ON f.id = g.id_penjualan
                            WHERE f.tgl_penjualan BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'
                            AND f.nik IN
                            (SELECT nik FROM t_karyawan AS e WHERE e.reference = a.nik)
                        ) * ' . config('constants.insentif.LEVEL-1') . '
                    ) +
                    COALESCE(SUM(d.jumlah * ' . config('constants.insentif.LEVEL-1') . '), 0) -
                    COALESCE((SELECT SUM(bayar) FROM d_kasbon WHERE nik = a.nik AND tanggal BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'), 0) -
                    COALESCE((SELECT SUM(bayar) FROM d_pinjaman WHERE nik = a.nik AND tanggal BETWEEN \'' . $tgl_awal . '\' AND \'' . $tgl_akhir . '\'), 0) +
                    COALESCE((SELECT total FROM d_gaji WHERE nik = a.nik and satker=a.satker ORDER BY id DESC LIMIT 1), 0)
                ) as total_pendapatan')
            )
            ->leftJoin('users as b', 'a.nik', 'b.nik')
            ->leftJoin('ramwater_d_penjualan as c', 'a.nik', 'c.nik')
            ->leftJoin('ramwater_d_penjualan_detail as d', 'c.id', 'd.id_penjualan')
            ->where('a.satker', 'ramwater')
            ->whereBetween('c.tgl_penjualan', [$tgl_awal, $tgl_akhir])
            ->where('a.nik', '!=', config('constants.nik.CAMPURAN'));

        $gaji->orderBy('b.kd_role', 'asc')
            ->groupBy(
                'a.nik',
                'a.nama',
                'a.jabatan',
                'a.satker',
            );

        return datatables()
            ->of($gaji)
            ->addIndexColumn()
            ->make(true);
    }

    public function monitoring()
    {
        return view('ramwater.report.monitoring');
    }
}
