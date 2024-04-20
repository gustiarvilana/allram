<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TOps extends Model
{
    use HasFactory;

    protected $table = 't_ops';
    protected $guarded = [];

    public function findOpsByProduct($kd_produk)
    {
        $produk = DB::table('t_master_produk as a')
            ->join('d_supplier as b', 'a.kd_supplier', 'b.kd_supplier')
            ->where('a.kd_produk', '=', $kd_produk);

        return $produk;
    }
}
