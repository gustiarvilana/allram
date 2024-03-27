<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DPembayaranModel extends Model
{
    use HasFactory;

    protected $table = 'd_pembayaran';
    protected $guarded = [];

    protected $nota;

    public function getPembayaran()
    {
        $pembayaran = DB::table('d_pembayaran')
            ->where('nota', '=', $this->getNota())
            ->get();

        return $pembayaran;
    }

    public function decrementAng($pembayaran)
    {
        $produk->decrement('angs_ke', $pembayaran['angs_ke']);
    }

    public function incrementAngs($pembayaran)
    {
        $produk->increment('angs_ke', $pembayaran['angs_ke']);
    }




    /**
     * Get the value of nota_pembelian
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set the value of nota
     *
     * @return  self
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }
}
