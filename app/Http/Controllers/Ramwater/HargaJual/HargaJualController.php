<?php

namespace App\Http\Controllers\Ramwater\HargaJual;

use App\Http\Controllers\Controller;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\SupplierModel;
use App\Models\TChannelModel;
use App\Models\THargaJual;
use App\Models\TOps;
use App\Services\OpsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HargaJualController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new THargaJual();
    }

    public function data(Request $request)
    {
        $input = $request->all();

        $hargaJual = DB::table('t_harga_jual as a')
            ->join('t_master_produk as b', 'a.kd_produk', 'b.kd_produk')
            ->where('a.kd_produk', '=', $input['kd_produk'])
            ->select('a.*', 'b.nama');

        return datatables()
            ->of($hargaJual)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validation($input);

        try {
            $this->model->updateOrCreate([
                'id' => $input['id']
            ], $input);
            return response()->json(['success' => true, 'message' => 'Data berhasil Disimpan']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $this->model->where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil Dihapus']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validation($data)
    {
        $errors = [];

        if (empty($data['kd_produk'])) {
            $errors[] = 'kd_produk';
        }
        if (empty($data['ket_harga'])) {
            $errors[] = 'ket_harga';
        }
        if (empty($data['harga'])) {
            $errors[] = 'harga';
        }
        if (empty($data['satuan'])) {
            $errors[] = 'satuan';
        }

        if (!empty($errors)) {
            throw new \Exception("Terjadi kesalahan: " . json_encode($errors));
        }
    }

    public function prepareData($input)
    {
        $kode = $this->generate();

        $input_fix['kd_produk'] = $input['kd_produk'];
        $input_fix['ket_harga'] = $input['ket_harga'];
        $input_fix['harga']     = $input['harga'];
        $input_fix['satuan']    = $input['satuan'];
        $input_fix['kd_harga']   = $input_fix['kd_harga'] ?? $kode;

        return $input_fix;
    }

    public function generate()
    {
        $latest = $this->model->latest()->first();
        $kode = $latest ? $latest->id + 1 : 1;
        while ($this->model->where('id', $kode)->exists()) {
            $kode++;
        }

        return $kode;
    }
}
