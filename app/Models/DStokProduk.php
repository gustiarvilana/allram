<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DStokProduk extends Model
{
    use HasFactory;

    protected $table = 'd_stok_produk';
    protected $guarded = [];

    public function validateStok($dataDetail)
    {
        $stok = $this->where([
            'kd_produk' => $dataDetail['kd_produk'],
            'kd_gudang' => $dataDetail['kd_gudang']
        ])->first();

        if (!$stok || $stok->stok < $dataDetail['qty_bersih']) {
            throw new \Exception('Stok tidak mencukupi.');
        }
    }

    public function decrementStok($dataDetail)
    {
        $produk = $this->where([
            'kd_produk' => $dataDetail['kd_produk'],
            'kd_gudang' => $dataDetail['kd_gudang']
        ])->first();
        $produk->decrement('stok', $dataDetail['qty_bersih']);
    }

    public function incrementStok($dataDetail)
    {
        $produk = $this->where([
            'kd_produk' => $dataDetail['kd_produk'],
            'kd_gudang' => $dataDetail['kd_gudang']
        ]);
        $exist = $produk->first();
        if (!$exist) {
            $this->create([
                'kd_produk' =>  $dataDetail['kd_produk'],
                'kd_gudang' =>  $dataDetail['kd_gudang'],
                'stok'      =>  0,
                'opr_input' =>  Auth::user()->nik,
                'tgl_input' =>  date('Ymd'),
            ]);
        }
        $produk->increment('stok', $dataDetail['qty_bersih']);
    }
}
