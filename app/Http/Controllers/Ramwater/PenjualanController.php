<?php

namespace App\Http\Controllers\Ramwater;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function data(Request $request)
    {
        $datangBarang = DB::table('d_penjualan as a')
            ->select('a.*', 'b.*', 'c.*', 'a.id as id_penjualan', 'b.nama as nama_produk', 'c.nama as nama_sales')
            ->join('t_master_produk as b', 'a.kd_produk', 'b.kd_produk')
            ->join('t_karyawan as c', 'a.nik', 'c.nik');

        return datatables()
            ->of($datangBarang)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'sales' => DB::table('users as a')
                ->join('t_karyawan as b', 'a.nik', 'b.nik')
                ->where('a.kd_role', 3)
                ->get(),
            'produks' => Produk::where('satker', 'ramwater')->get(),
        ];
        return view('ramwater.penjualan.index', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'tgl_penjualan' => $request->input('tgl_penjualan'),
            'nik'           => $request->input('nik'),
            'kd_produk'     => $request->input('kd_produk'),
            'jumlah'        => $request->input('jumlah'),
            'galon_kembali' => $request->input('galon_kembali'),
        ];
        $data['tgl_penjualan'] = date('Ymd', strtotime($data['tgl_penjualan']));
        try {
            Penjualan::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
    {
        $data = [
            'id'            => $request->input('id'),
            'tgl_penjualan' => $request->input('tgl_penjualan'),
            'nik'           => $request->input('nik'),
            'kd_produk'     => $request->input('kd_produk'),
            'jumlah'        => $request->input('jumlah'),
            'galon_kembali' => $request->input('galon_kembali'),
        ];
        $data['tgl_penjualan'] = date('Ymd', strtotime($data['tgl_penjualan']));
        $data['jumlah'] = $data['jumlah'] - $request->input('sisa');

        try {
            Penjualan::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            Penjualan::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
