<?php

namespace App\Models;

use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DPelangganModel extends Model
{
    use HasFactory;

    protected $table = 'd_pelanggan';
    protected $guarded = [];

    public function simpan($req)
    {
        $data = $this->prepareSimpan($req);

        return $this->updateOrCreate([
            'id'           => $data['id'],
            'kd_pelanggan' => $data['kd_pelanggan'],
        ], $data);
    }

    public function prepareSimpan($input)
    {
        $kode = FormatHelper::generateCode('d_pelanggan', 'P', 3);

        $data = [
            'id'           => $input['id'] ?? null,
            'kd_pelanggan' => $input['kd_pelanggan'] == 0 ? $kode : $input['kd_pelanggan'],
            'nama'         => $input['nama'],
            'alamat'       => $input['alamat'],
            'kd_kec'       => $input['kd_kec'] ?? 0,
            'kd_kel'       => $input['kd_kel'] ?? 0,
            'kd_kota'      => $input['kd_kota'] ?? 0,
            'kd_pos'       => $input['kd_pos'] ?? 0,
            'no_tlp'       => $input['no_tlp'] ?? '123',

            'opr_input'      => Auth::user()->nik,
            'tgl_input'      => date('Ymd'),
        ];

        return $data;
    }
}
