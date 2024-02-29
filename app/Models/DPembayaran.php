<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DPembayaran extends Model
{
    use HasFactory;

    protected $table = 'd_pembayaran';
    protected $guarded = [];

    protected $nota_pembelian;

    public function getPembelianDetail()
    {
        $pembelian = DB::table('d_pembayaran')
            ->where('nota_pembelian', '=', $this->getNotaPemebelian());
        return $pembelian;
    }

    public function decrementStok($pembayaran)
    {
        $produk->decrement('angs_ke', $pembayaran['angs_ke']);
    }

    public function incrementStok($pembayaran)
    {
        $produk->increment('angs_ke', $pembayaran['angs_ke']);
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
