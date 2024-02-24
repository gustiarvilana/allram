<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DStokProduk extends Model
{
    use HasFactory;

    protected $table = 'd_stok_produk';
    protected $guarded = [];

    public function decrementStok($dataDetail)
    {
        $this->where('kd_produk', $dataDetail['kd_produk'])
            ->decrement('qty', $dataDetail['qty_bersih']);
    }

    public function incrementStok($dataDetail)
    {
        dd($dataDetail['qty_bersih']);
        $this->where('kd_produk', $dataDetail['kd_produk'])
            ->increment('stok', $dataDetail['qty_bersih']);
    }
}
