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

    public function getKasbonByDate($input)
    {
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $result = DB::table('d_kasbon as a')
            ->whereBetween('tgl_kasbon', [$tanggal_awal, $tanggal_akhir])
            ->select('a.*', DB::raw('SUM(a.nominal) as sum_nominal'))
            ->groupBy('a.id');


        try {
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getKasbonByNik($input)
    {
        // dd('2');
        $rTanggal = $input['rTanggal'];
        list($tanggal_awal, $tanggal_akhir) = explode(' - ', $rTanggal);

        $tanggal_awal = date('Ymd', strtotime($tanggal_awal));
        $tanggal_akhir = date('Ymd', strtotime($tanggal_akhir));

        $result = DB::table('d_kasbon as a')
            ->whereBetween('tgl_kasbon', [$tanggal_awal, $tanggal_akhir])
            ->select('a.*', DB::raw('SUM(a.nominal) as sum_nominal'))
            ->groupBy('a.nik', 'a.jns_kasbon');

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
