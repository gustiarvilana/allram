<?php

namespace App\Http\Controllers\Ramwater\Operasional;

use App\Http\Controllers\Controller;
use App\Models\DOperasional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperasionalController extends Controller
{
    public function data(Request $request)
    {
        $tanggal = date('Ymd', strtotime($request['tanggal']));

        $ops = DB::table('d_operasional as a')
            // ->where('satker', 'ramwater', $tanggal)
            ->where('tanggal', $tanggal);

        return datatables()
            ->of($ops)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'ops' => DB::table('t_operasional')->get()
        ];
        return view('ramwater.operasional.index', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'id'        => $request->input('id'),
            'tanggal'        => $request->input('tanggal'),
            'satker'         => $request->input('satker'),
            'nik'            => $request->input('nik'),
            'kd_operasional' => $request->input('kd_operasional'),
            'jumlah'         => $request->input('jumlah'),
            'harga'          => $request->input('harga'),
            'keterangan'     => $request->input('keterangan'),
        ];
        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));

        if (isset($data['harga'])) {
            $data['harga']      = str_replace('.', '', $data['harga']);
            $data['total'] = $data['harga'] * $data['jumlah'];
        }

        try {
            DOperasional::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'             => $request->input('id'),
            'tanggal'        => $request->input('tanggal'),
            'satker'         => $request->input('satker'),
            'nik'            => $request->input('nik'),
            'kd_operasional' => $request->input('kd_operasional'),
            'jumlah'         => $request->input('jumlah'),
            'harga'          => $request->input('harga'),
            'keterangan'     => $request->input('keterangan'),
        ];
        $data['tanggal'] = date('Ymd', strtotime($data['tanggal']));

        if (isset($data['harga'])) {
            $data['harga'] = str_replace('.', '', $data['harga']);
            $data['total'] = $data['harga'] * $data['jumlah'];
        }

        try {
            DOperasional::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            DOperasional::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
