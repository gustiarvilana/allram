<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPembelianDetailModel extends Model
{
    use HasFactory;

    protected $table = 'd_pembelian_detail';
    protected $guarded = [];
    protected $formatNumberAttributes = [
        'qty_pesan',
        'qty_retur',
        'qty_bersih',
        'harga_satuan',
        'harga_total',
    ];
}
