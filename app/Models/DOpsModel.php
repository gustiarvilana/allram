<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DOpsModel extends Model
{
    use HasFactory;

    protected $table = 'd_ops';
    protected $guarded = [];

    public function getDataOps()
    {
        $ops = DB::table('d_ops as a')
            ->join('d_karyawan as b', 'a.nik', '=', 'b.nik')
            ->join('t_ops as c', 'a.kd_ops', '=', 'c.kd_ops')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.nama_ops', 'c.tipe');

        return $ops;
    }

    public function getLaporanDataOps($input)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $query = DB::table('d_ops as a')
            ->leftJoin('d_karyawan as b', 'a.nik', '=', 'b.nik')
            ->leftJoin('t_ops as c', 'a.kd_ops', '=', 'c.kd_ops')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.nama_ops', 'c.tipe');

        if (isset($input['nik'])) {
            $query->where('a.nik', '=', $input['nik']);
        }
        if (isset($input['kd_ops'])) {
            $query->where('a.kd_ops',  $input['kd_ops'])->where('c.kd_ops',  $input['kd_ops']);
            // $query->where('a.kd_ops', 'like', '%' . $input['kd_ops'] . '%');
        }
        if (isset($input['rTanggal'])) {
            $query->whereBetween('a.tanggal', [$tanggal_awal, $tanggal_akhir]);
        }
        if (isset($input['kd_jns_ops'])) {
            $query->where('c.tipe', '=', $input['kd_jns_ops']);
        }

        return $query;
    }


    public function upsertData($req)
    {
        return $this->updateOrCreate(
            ['id' => $req['id'] ?? null],
            $req
        );
    }
}
