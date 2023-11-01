<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function data(Request $request)
    {
        $tanggal = isset($request['tanggal']) ? date('Ymd', strtotime($request['tanggal'])) : date('Ymd');
        $datangBarang = DB::table('ramwater_d_penjualan as a')
            ->select(
                'a.id as id_penjualan',
                'a.tgl_penjualan',
                'a.nik',
                'a.kd_produk',
                'a.jumlah',
                'a.galon_kembali',
                'a.galon_diluar',
                'a.cash',
                'b.nama as nama_produk',
                'c.nama as nama_sales',
                DB::raw('(SELECT SUM(jumlah) FROM ramwater_d_galon as d WHERE d.id_penjualan = a.id) as sum_galon'),
                DB::raw('(SELECT SUM(total) FROM ramwater_d_penjualan_detail as e WHERE e.id_penjualan = a.id) as sum_detail'),
                DB::raw('(SELECT SUM(jumlah) FROM ramwater_d_penjualan_detail as e WHERE e.id_penjualan = a.id) as sum_jumlah')
            )
            ->leftJoin('t_master_produk as b', 'a.kd_produk', '=', 'b.kd_produk')
            ->leftJoin('t_karyawan as c', 'a.nik', '=', 'c.nik')
            ->where('tgl_penjualan', $tanggal)
            ->groupBy(
                'a.id',
                'a.tgl_penjualan',
                'a.nik',
                'a.kd_produk',
                'a.jumlah',
                'a.galon_kembali',
                'a.galon_diluar',
                'a.cash',
                'b.nama',
                'c.nama'
            )
            ->get();

        return DataTables::of($datangBarang)->addIndexColumn()->make(true);
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
            'galon_diluar'  => $request->input('galon_diluar'),
            'cash'          => $request->input('cash'),
        ];
        $data['tgl_penjualan'] = date('Ymd', strtotime($data['tgl_penjualan']));
        $data['jumlah']        = str_replace('.', '', $data['jumlah']);
        $data['galon_kembali'] = str_replace('.', '', $data['galon_kembali']);
        $data['galon_diluar']  = str_replace('.', '', $data['galon_diluar']);
        $data['cash']          = str_replace('.', '', $data['cash']);

        try {
            Penjualan::upsert($data, ['id']);
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
            'galon_diluar'  => $request->input('galon_diluar'),
            'cash'          => $request->input('cash'),
        ];
        $data['tgl_penjualan'] = date('Ymd', strtotime($data['tgl_penjualan']));
        $data['jumlah'] = $data['jumlah'] - $request->input('sisa');
        $data['jumlah']        = str_replace('.', '', $data['jumlah']);
        $data['galon_kembali'] = str_replace('.', '', $data['galon_kembali']);
        $data['galon_diluar']  = str_replace('.', '', $data['galon_diluar']);
        $data['cash']          = str_replace('.', '', $data['cash']);

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
            DB::table('ramwater_d_galon')->where('id_penjualan', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
