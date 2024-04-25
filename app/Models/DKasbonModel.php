<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DKasbonModel extends Model
{
    use HasFactory;

    protected $table = 'd_kasbon';
    protected $guarded = [];

    public function getKasbonByDate($input, $nik)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $result = DB::table('d_kasbon as a')
            ->where('a.nik', $nik)
            ->join('d_karyawan as b', 'a.nik', 'b.nik')
            ->whereBetween('tgl_kasbon', [$tanggal_awal, $tanggal_akhir])
            ->select('a.*', 'b.nama as nama_karyawan', DB::raw('SUM(a.nominal) as sum_nominal'))
            ->groupBy('a.id');


        try {
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getKasbonByNik($input)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $result = DB::table('d_kasbon as a')
            ->join('d_karyawan as b', 'a.nik', 'b.nik')
            ->whereBetween('tgl_kasbon', [$tanggal_awal, $tanggal_akhir])
            ->select('a.*', 'b.nama as nama_karyawan', DB::raw('SUM(a.nominal) as sum_nominal'));

        if (isset($input['nik'])) {
            $result->where('a.nik', $input['nik']);
        }

        $result->groupBy('a.nik', 'a.jns_kasbon');
        try {
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function upsert($input)
    {
        try {
            return $this->updateOrCreate(
                [
                    'nota_penjualan' => $input['nota_penjualan'],
                ],
                $input
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function hapus($input)
    {
        try {
            return $this->where('nota_penjualan', '=', $input['nota_penjualan'])->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
