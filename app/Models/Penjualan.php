<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'd_penjualan';
    protected $guarded = [];

    function getPenjualan()
    {
        $penjualan = DB::table('d_penjualan as a')
            ->join('d_pelanggan as b', 'a.kd_pelanggan', '=', 'b.kd_pelanggan')
            ->leftJoin('t_channel_bayar as c', 'a.kd_channel', '=', 'c.kd_channel')
            ->leftJoin('d_karyawan as d', 'a.kd_sales', '=', 'd.nik')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales');

        return $penjualan;
    }

    function getPenjualanPenyerahan()
    {
        $penjualan = DB::table('d_penjualan as a')
            ->join('d_pelanggan as b', 'a.kd_pelanggan', '=', 'b.kd_pelanggan')
            ->leftJoin('t_channel_bayar as c', 'a.kd_channel', '=', 'c.kd_channel')
            ->leftJoin('d_karyawan as d', 'a.kd_sales', '=', 'd.nik')
            ->where('a.sts_penyerahan', '!=', '4')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales');

        return $penjualan;
    }
}
