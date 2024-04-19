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
            ->select('a.*', 'b.nama', 'c.nama_ops');

        return $ops;
    }

    public function getLaporanDataOps($input)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $query = DB::table('d_ops as a')
            ->join('d_karyawan as b', 'a.nik', '=', 'b.nik')
            ->join('t_ops as c', 'a.kd_ops', '=', 'c.kd_ops')
            ->orderBy('a.created_at', 'desc')
            ->select('a.*', 'b.nama', 'c.nama_ops');

        if (isset($input['nik'])) {
            $query->where('a.nik', '=', $input['nik']);
        }
        if (isset($input['kd_ops'])) {
            $query->where('a.kd_ops', 'like', '%' . $input['kd_ops'] . '%');
        }
        if (isset($input['rTanggal'])) {
            $query->whereBetween('a.tanggal', [$tanggal_awal, $tanggal_akhir]);
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
