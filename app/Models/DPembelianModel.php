<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DPembelianModel extends Model
{
    use HasFactory;

    protected $table = 'd_pembelian';
    protected $guarded = [];

    public function getpembelian()
    {
        $pembelian = DB::table('d_pembelian as a')
            ->join('d_supplier as b', 'a.kd_supplier', '=', 'b.kd_supplier')
            ->orderBy('a.tgl_input', 'desc')
            ->select('a.*', 'b.nama', 'a.tgl_input as detail_tgl_input');

        return $pembelian;
    }
}
