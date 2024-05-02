<?php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DOpsModel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class LaporanService
{
    public function getLaporanByTgl($tanggal_awal, $tanggal_akhir)
    {
        $data = [
            'penjualan' => DB::table('view_penjualan_by_produk as a')
                ->select('a.*', 'b.*', 'c.*', 'b.nama as nama_pelanggan', 'd.nama as nama_sales')
                ->join('d_pelanggan as b', 'a.kd_pelanggan', 'b.kd_pelanggan')
                ->join('t_master_produk as c', 'a.kd_pelanggan', 'c.kd_produk')
                ->join('d_karyawan as d', 'a.kd_sales', 'd.nik')
                ->whereBetween('tgl_penjualan', [$tanggal_awal, $tanggal_akhir])
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

            'pengeluaran' => DB::table('d_ops as a')
                ->join('t_ops as b', 'a.kd_ops', 'b.kd_ops')
                ->leftJoin('d_karyawan as c', 'a.nik', 'c.nik')
                ->whereBetween('a.tanggal', [$tanggal_awal, $tanggal_akhir])
                ->where('a.satker', '=', 'ramwater')
                ->where('b.tipe', '=', 'B')
                ->get(),
        ];

        return $data;
    }
}
