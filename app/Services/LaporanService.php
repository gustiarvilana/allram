<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class LaporanService
{
    public function getLaporanByTgl($tanggal_awal, $tanggal_akhir)
    {
        $data = [
            // 'penjualan' => DB::table('view_penjualan_by_produk as a')
            //     // ->select('a.*', 'b.*', 'c.*', 'b.nama as nama_pelanggan', 'd.nama as nama_sales')
            //     ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
            //     // ->join('t_master_produk as c', 'a.kd_pelanggan', 'c.kd_produk')
            //     ->join('d_karyawan as d', 'a.kd_sales', 'd.nik')
            //     ->whereBetween('a.tgl_penjualan', [$tanggal_awal, $tanggal_akhir])
            //     ->get(),

            'penjualan' => DB::table('view_penjualan_by_produk as a')
                ->select(
                    'd.nama as sales',
                    'c.nama',
                    'a.harga_satuan',
                    DB::raw('SUM(a.harga_total) as total_nominal'),
                    DB::raw('SUM(a.qty_bersih) as total_qty')
                )
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_master_produk as c', 'a.kd_produk', 'c.kd_produk')
                ->join('d_karyawan as d', 'a.kd_sales', 'd.nik')
                ->whereBetween('tgl_penjualan', [$tanggal_awal, $tanggal_akhir])
                ->groupBy('d.nama', 'c.nama', 'a.harga_satuan')
                ->get(),

            'bayarTunai' => DB::table('view_pembayaran_penjualan as a')
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_channel_bayar as c', 'a.channel_bayar', 'c.kd_channel')
                ->whereBetween('a.tgl', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('a.channel_bayar', [1])
                ->get(),

            'bayarOnline' => DB::table('view_pembayaran_penjualan as a')
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_channel_bayar as c', 'a.channel_bayar', 'c.kd_channel')
                ->whereBetween('tgl', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('channel_bayar', [2, 3])
                ->get(),

            'BayarPiutangTunai' => DB::table('view_pembayaran_piutang_nominal as a')
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_channel_bayar as c', 'a.channel_bayar', 'c.kd_channel')
                ->whereBetween('tgl', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('channel_bayar', [1])
                ->get(),

            'BayarPiutangNTunai' => DB::table('view_pembayaran_piutang_nominal as a')
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_channel_bayar as c', 'a.channel_bayar', 'c.kd_channel')
                ->whereBetween('tgl', [$tanggal_awal, $tanggal_akhir])
                ->whereIn('channel_bayar', [2, 3])
                ->get(),

            'pengeluaran' => DB::table('d_kasbon as a')
                ->join('t_jns_kasbon as b', 'a.jns_kasbon', '=', 'b.kd_jns_kasbon')
                ->whereBetween('tgl_kasbon', [$tanggal_awal, $tanggal_akhir])
                ->select('b.nama', DB::raw('SUM(a.nominal) as total_nominal'))
                ->groupBy('b.nama')
                ->union(
                    DB::table('d_ops as a')
                        ->join('t_ops as b', 'a.kd_ops', '=', 'b.kd_ops')
                        ->where('b.tipe', 'B')
                        ->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])
                        ->select('b.nama_ops', DB::raw('SUM(a.total) as total_nominal'))
                        ->groupBy('b.nama_ops')
                )
                ->get(),

        ];

        // dd($data['penjualan']);

        return $data;
    }
}
