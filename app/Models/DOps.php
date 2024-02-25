<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOps extends Model
{
    use HasFactory;

    protected $table = 'd_ops';
    protected $guarded = [];

    protected function upsertOps($pembelianData)
    {
        // $ops = $this->dOps->create([
        //     'nota_pembelian' => $pembelianData['nota_pembelian'] ?? '',
        //     'tgl_pembayaran' => $pembelianData['tgl_pembayaran'] ?? '',
        //     'angs_ke'        => $pembelianData['angs_ke'] ?? '',
        //     'nominal_bayar'  => $pembelianData['nominal_bayar'] ?? '',
        //     'channel_bayar'  => $pembelianData['channel_bayar'] ?? '',
        //     'ket_bayar'      => $pembelianData['ket_bayar'] ?? '',
        //     'path_file'      => $pembelianData['path_file'] ?? '',
        //     'opr_input'      => $pembelianData['opr_input'] ?? '',
        //     'tgl_input'      => $pembelianData['tgl_input'] ?? '',
        // ]);
    }
}
