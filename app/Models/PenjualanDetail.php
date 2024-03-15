<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'd_penjualan_detail';
    protected $guarded = [];

    protected $notaPenjualan;
    function getPenjualanDetail()
    {
        $penjualan = DB::table('d_penjualan_detail as a')
            ->leftJoin('t_master_produk as b', 'a.kd_produk', '=', 'b.kd_produk')
            ->where('a.nota_penjualan', '=', $this->getNotaPenjualan())
            ->select('a.*', 'b.nama');

        return $penjualan;
    }

    function setNotaPenjualan($notaPenjualan)
    {
        $this->notaPenjualan = $notaPenjualan;
    }

    function getNotaPenjualan()
    {
        return $this->notaPenjualan;
    }
}
