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
            ->orderBy('a.sts_angsuran', 'asc')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama');

        return $pembelian;
    }

    public function getHutang($input)
    {
        $input = isset($input['data']) ? $input['data'] : '';
        $pembelian = DB::table('d_pembelian as a')
            ->join('d_supplier as b', 'a.kd_supplier', '=', 'b.kd_supplier')
            ->where('a.sts_angsuran', '=', '1')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama');

        if (isset($input['kd_supplier'])) {
            $pembelian->where('a.kd_supplier', '=', $input['kd_supplier']);
        }
        if (isset($input['nota_pembelian'])) {
            $pembelian->where('a.nota_pembelian', 'like', '%' . $input['nota_pembelian'] . '%');
        }
        if (isset($input['rTanggal'])) {
            $rTanggal = $input['rTanggal'];
            list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);


            $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
            $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));
            $pembelian->whereBetween('a.tgl_pembelian', [$tanggal_awal, $tanggal_akhir]);
        }

        return $pembelian;
    }

    public function getLaporanPembelian($input)
    {
        $query = DB::table('d_pembelian as a')
            ->join('d_supplier as b', 'a.kd_supplier', '=', 'b.kd_supplier')
            ->orderBy('a.created_at', 'desc')
            ->orderBy('sts_angsuran', 'desc')
            ->select('a.*', 'b.nama');

        if (isset($input['kd_supplier'])) {
            $query->where('a.kd_supplier', '=', $input['kd_supplier']);
        }
        if (isset($input['nota_pembelian'])) {
            $query->where('a.nota_pembelian', 'like', '%' . $input['nota_pembelian'] . '%');
        }
        // if (isset($input['rTanggal'])) {
        //     $rTanggal = $input['rTanggal'];
        //     list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        //     $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        //     $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        //     $query->whereBetween('a.tgl_pembelian', [$tanggal_awal, $tanggal_akhir]);
        // }

        return $query;
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
