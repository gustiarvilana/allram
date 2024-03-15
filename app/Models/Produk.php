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

    public function getProduk($nota = null)
    {
        $produk = DB::table('t_master_produk as a');

        if ($nota) {
            if (!empty($nota['nota_pembelian'])) {
                $produk->join('d_pembelian_detail as b', function ($join) use ($nota) {
                    $join->on('a.kd_produk', '=', 'b.kd_produk')
                        ->where('b.nota_pembelian', '=', $nota['nota_pembelian']);
                });
            } elseif (!empty($nota['nota_penjualan'])) {
                $produk->join('d_penjualan_detail as b', function ($join) use ($nota) {
                    $join->on('a.kd_produk', '=', 'b.kd_produk')
                        ->where('b.nota_penjualan', '=', $nota['nota_penjualan']);
                });
            }
        }

        if (!empty($this->satker)) {
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
