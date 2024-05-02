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

    public function getProduk($input = null)
    {
        $produk = DB::table('t_master_produk as a');

        if ($input) {
            if (!empty($input['nota_pembelian'])) {
                $field = 'nota_pembelian';
                $table = 'd_pembelian_detail';
            } elseif (!empty($input['nota_penjualan'])) {
                $field = 'nota_penjualan';
                $table = 'd_penjualan_detail';
            } elseif (!empty($input['kd_supplier'])) {
                $where = [
                    'kd_supplier' => $input['kd_supplier'],
                ];
            }

            if (isset($field) && isset($table)) {
                $produk->join($table . ' as b', function ($join) use ($input, $field) {
                    $join->on('a.kd_produk', '=', 'b.kd_produk')->where('b.' . $field, '=', $input[$field]);
                });
            } else if (!empty($input['kd_supplier'])) {
                $produk->where($where);
            } elseif (!empty($input['jns'])) {
                $produk->where('a.stok_all', '>', 0);
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
