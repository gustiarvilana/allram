<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 't_master_produk';
    protected $guarded = [];

    private $satker;

    public function getProduk($nota_pembelian = null)
    {
        $produk = DB::table('t_master_produk as a');

        if ($nota_pembelian) {
            $produk->leftJoin('d_pembelian_detail as b', function ($join) use ($nota_pembelian) {
                $join->on('a.kd_produk', '=', 'b.kd_produk')
                    ->where('b.nota_pembelian', '=', $nota_pembelian);
            });
        }

        $produk->leftJoin('t_harga_jual as c', 'a.kd_produk', '=', 'c.kd_produk');

        if ($this->satker != null) {
            $produk->where('a.satker', '=', $this->satker);
        }

        return $produk;
    }


    function setSatker($satker)
    {
        $this->satker = $satker;
    }
    function getSatker()
    {
        return $this->satker;
    }
}
