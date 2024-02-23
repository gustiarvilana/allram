<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPembelianModel extends Model
{
    use HasFactory;

    protected $table = 'd_pembelian';
    protected $guarded = [];
    protected $formatNumberAttributes = [
        'harga_total',
        'nominal_bayar',
        'sisa_bayar',
        'sts_angsuran',
    ];
}
