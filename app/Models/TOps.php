<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOps extends Model
{
    use HasFactory;

    protected $table = 't_ops';
    protected $guarded = [];

    public function getPenjualanOps($kd_produk = null)
    {
        if ($kd_produk) {
            $produk = Produk::where('kd_produk', '=', $kd_produk)->first();
            return $produk;
        }
    }
}
