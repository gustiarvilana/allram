<?php

namespace App\Http\Controllers\pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    private $model;
    private $const;

    public function __construct()
    {
        $this->model = new DPelangganModel();
        $this->const = config('constants.ramwater');
    }

    public function data(Request $request)
    {
        $pelanggan = $this->model->get();

        return datatables()
            ->of($pelanggan)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $req = $request->input();
        return DB::transaction(function () use ($req) {
            $this->model->simpan($req);

            return back()->with(['success' => 'Pelanggan berhasil disimpan!']);
        });
        return back()->with('error', 'Operasi gagal dilakukan!');
    }

    public function destroy($id)
    {
        // $id = $this->integrationHelper->decrypt(base64_decode($id), $this->integrationHelper->getKey());

        $pelanggan = $this->model->find($id);

        try {
            $pelanggan->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' =>  $e->getMessage()]);
        }
    }


    public function laporan()
    {
        dd('laporan');
    }
}
