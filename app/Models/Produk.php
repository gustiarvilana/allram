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

    public function getProduk()
    {
        $produk = DB::table('t_master_produk');

        if ($this->satker != null) {
            $produk->where('satker', '=', $this->satker);
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
