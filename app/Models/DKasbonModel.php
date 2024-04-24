<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DKasbonModel extends Model
{
    use HasFactory;

    protected $table = 'd_kasbon';
    protected $guarded = [];

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
