<?php

namespace App\Http\Controllers\Ramwater;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualandetailController extends Controller
{
    public function data($id_penjualan)
    {
        $detail = DB::table('ramwater_d_penjualan_detail as a')->where('id_penjualan', $id_penjualan);

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = [
            'id'           => $request->input('id'),
            'id_penjualan' => $request->input('id_penjualan'),
            'nama'         => $request->input('nama'),
            'jumlah'       => $request->input('jumlah'),
            'harga'        => $request->input('harga'),
            'ket'        => $request->input('ket'),
        ];
        $data['jumlah'] = str_replace('.', '', $data['jumlah']);
        $data['harga']  = str_replace('.', '', $data['harga']);
        $data['total']  =  $data['jumlah'] * $data['harga'];

        try {
            DB::table('ramwater_d_penjualan_detail')->upsert($data, ['id']);
            return 'berhasil disimpan';
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('ramwater_d_penjualan_detail')->where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
