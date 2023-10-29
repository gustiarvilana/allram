<?php

namespace App\Http\Controllers\Ramwater\DatangBarang;

use App\Http\Controllers\Controller;
use App\Models\DatangBarang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatangBarangControler extends Controller
{
    public function data(Request $request)
    {
        $datangBarang = DB::table('ramwater_d_datang_barang as a')
            ->select('a.*', 'b.nama as nama_produk')
            ->join('t_master_produk as b', 'a.kd_produk', 'b.kd_produk');

        return datatables()
            ->of($datangBarang)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'produks' => Produk::where('satker', 'ramwater')->get(),
        ];
        return view('ramwater.datang_barang.index', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'tgl_datang' => $request->input('tgl_datang'),
            'nama' => $request->input('nama'),
            'kd_produk' => $request->input('kd_produk'),
            'jumlah' => $request->input('jumlah'),
            'rb' => $request->input('rb'),
            'harga' => $request->input('harga'),
        ];
        $data['tgl_datang'] = date('Ymd', strtotime($data['tgl_datang']));
        if (isset($data['harga'])) {
            $data['harga']        = str_replace('.', '', $data['harga']);
        }

        try {
            DatangBarang::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'         => $request->input('id'),
            'tgl_datang' => $request->input('tgl_datang'),
            'nama'       => $request->input('nama'),
            'kd_produk'  => $request->input('kd_produk'),
            'jumlah'     => $request->input('jumlah'),
            'rb'         => $request->input('rb'),
            'harga'      => $request->input('harga'),
        ];
        if (isset($data['harga'])) {
            $data['harga']        = str_replace('.', '', $data['harga']);
        }

        $data['tgl_datang'] = date('Ymd', strtotime($data['tgl_datang']));
        try {
            DatangBarang::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DatangBarang::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
