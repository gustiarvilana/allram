<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Services\PenjualanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    protected $tGudang;
    protected $produkMOdel;
    protected $tChannelModel;
    protected $karyawan;
    protected $penjualanService;

    public function __construct(PenjualanService $penjualanService)
    {
        $this->integrationHelper = new IntegrationHelper;
        $this->tGudang = new TGudang;
        $this->produkMOdel = new Produk;
        $this->tChannelModel = new TChannelModel();
        $this->karyawan = new Karyawan();
        $this->penjualanService = $penjualanService;
    }

    public function data()
    {
        $supplier = $this->produkMOdel->getProduk();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'gudang' => $this->tGudang->get(),
            'channels' => $this->tChannelModel->get(),
            'saless' => $this->karyawan->where('jabatan', '=', 'sales')->get(),
        ];
        return view('ramwater.penjualan.index', $data);
    }

    public function store(Request $request)
    {
        $penjualanData = json_decode($request->input('penjualanData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);

        if ($request->input('jns')) {
            $penjualanData['jns'] = $request->input('jns');
        }

        return $this->penjualanService->storepenjualan($penjualanData, $dataArrayDetail);
    }

    public function destroy($id)
    {
        $id = $this->integrationHelper->decrypt(base64_decode($id), $this->integrationHelper->getKey());
        return $this->penjualanService->destroypenjualan($id);
    }

    public function penyerahan()
    {
        $data = [
            'pelanggans' => DPelangganModel::get(),
            'saless'     => Karyawan::where('jabatan', '=', 'sales')->get(),
            'gudang'     => TGudang::get(),
            'channels'   => TChannelModel::get(),
        ];
        return view('ramwater.penjualan.penyerahan', $data);
    }

    public function penyerahanUpdate(Request $request)
    {
        $nota_penjualan = $request->input('nota_penjualan');

        try {
            return DB::transaction(function () use ($nota_penjualan) { //rollback if error
                $this->penjualanService->penyerahanUpdate($nota_penjualan);
                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
