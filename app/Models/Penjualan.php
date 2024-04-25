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
            ->leftJoin('d_kasbon as e', 'a.nota_penjualan', '=', 'e.nota_penjualan')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales', 'e.id as id_kasbon');

        return $penjualan;
    }

    function getHutangPenjualanNominal()
    {
        $penjualan = DB::table('d_penjualan as a')
            ->join('d_pelanggan as b', 'a.kd_pelanggan', '=', 'b.kd_pelanggan')
            ->leftJoin('t_channel_bayar as c', 'a.kd_channel', '=', 'c.kd_channel')
            ->leftJoin('d_karyawan as d', 'a.kd_sales', '=', 'd.nik')
            ->where('a.sts_angsuran', '=', '1')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales');

        return $penjualan;
    }

    function getHutangPenjualanGalon()
    {
        $penjualan = DB::table('d_penjualan as a')
            ->join('d_pelanggan as b', 'a.kd_pelanggan', '=', 'b.kd_pelanggan')
            ->leftJoin('t_channel_bayar as c', 'a.kd_channel', '=', 'c.kd_channel')
            ->leftJoin('d_karyawan as d', 'a.kd_sales', '=', 'd.nik')
            ->where('a.sts_galon', '=', '1')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales');

        return $penjualan;
    }

    function getLaporanPenjualan($input)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $query = DB::table('d_penjualan as a')
            ->join('d_pelanggan as b', 'a.kd_pelanggan', '=', 'b.kd_pelanggan')
            ->leftJoin('t_channel_bayar as c', 'a.kd_channel', '=', 'c.kd_channel')
            ->leftJoin('d_karyawan as d', 'a.kd_sales', '=', 'd.nik')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.ur_channel', 'd.nama as nama_sales');

        if (isset($input['kd_pelanggan'])) {
            $query->where('a.kd_pelanggan', '=', $input['kd_pelanggan']);
        }
        if (isset($input['nama'])) {
            $query->where('b.nama', 'like', '%' . $input['nama'] . '%');
        }
        if (isset($input['nik'])) {
            $query->where('a.kd_sales', '=', $input['nik']);
        }
        if (isset($input['nota_penjualan'])) {
            $query->where('a.nota_penjualan', 'like', '%' . $input['nota_penjualan'] . '%');
        }
        if (isset($input['rTanggal'])) {
            $query->whereBetween('a.tgl_penjualan', [$tanggal_awal, $tanggal_akhir]);
        }

        return $query;
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
