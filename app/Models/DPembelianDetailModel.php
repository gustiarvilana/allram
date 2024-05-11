<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DPembelianDetailModel extends Model
{
    use HasFactory;

    protected $table = 'd_pembelian_detail';
    protected $guarded = [];

    protected $nota_pemebelian;
    public function getPembelianDetail()
    {
        $pembelian = DB::table('d_pembelian_detail as a')
            ->join('t_master_produk as b', 'a.kd_produk', '=', 'b.kd_produk')
            ->where('nota_pembelian', '=', $this->getNotaPemebelian())
            ->orderBy('sts_angsuran', 'desc');
        return $pembelian;
    }



    /**
     * Get the value of nota_pemebelian
     */
    public function getNotaPemebelian()
    {
        return $this->nota_pemebelian;
    }

    /**
     * Set the value of nota_pemebelian
     *
     * @return  self
     */
    public function setNotaPemebelian($nota_pemebelian)
    {
        $this->nota_pemebelian = $nota_pemebelian;

        return $this;
    }
}
