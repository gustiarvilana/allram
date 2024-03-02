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

    protected $nota_pembelian;

    public function getpembelian()
    {
        $pembelian = DB::table('d_pembelian as a')
            ->join('d_supplier as b', 'a.kd_supplier', '=', 'b.kd_supplier')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama');

        return $pembelian;
    }

    public function getpembelianByNota()
    {
        $pembelian = DB::table('d_pembelian as a')
            ->join('d_supplier as b', 'a.kd_supplier', '=', 'b.kd_supplier')
            ->where('a.nota_pembelian', '=', $this->getNota_pembelian())
            ->select('a.*', 'b.nama')
            ->first();

        return $pembelian;
    }



    /**
     * Get the value of nota_pembelian
     */
    public function getNota_pembelian()
    {
        return $this->nota_pembelian;
    }

    /**
     * Set the value of nota_pembelian
     *
     * @return  self
     */
    public function setNota_pembelian($nota_pembelian)
    {
        $this->nota_pembelian = $nota_pembelian;

        return $this;
    }
}
