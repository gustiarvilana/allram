<?php

namespace App\Http\Controllers\Ramwater\Ops;

use App\Helpers\FormatHelper;
use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\DPembayaranModel;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Services\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OpsController extends Controller
{
    protected $integrationHelper;
    protected $dPembayaranModel;
    protected $pembayaranService;

    public function __construct(PembayaranService $pembayaranService)
    {
        $this->integrationHelper = new IntegrationHelper();
        $this->dPembayaranModel = new DPembayaranModel();
        $this->dPenjualanModel = new Penjualan();
        $this->pembayaranService = $pembayaranService;
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $bayar = $this->dPembayaranModel->setNota($req['nota_penjualan']);
        $bayar = $this->dPembayaranModel->getPembayaran();

        return response()->json($bayar);
    }

    public function index()
    {
        $data = [
            'pelanggans' => DPelangganModel::get(),
            'saless' => Karyawan::where('jabatan', '=', 'sales')->get(),
            'gudang' => TGudang::get(),
            'channels' => TChannelModel::get(),
        ];
        return view('ramwater.ops.pembayaran', $data);
    }

    public function store(Request $request)
    {
        $penjualanData = json_decode($request->input('penjualanData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);
        $file = $request->file('path_file');

        if ($request->input('jns')) {
            $penjualanData['jns'] = $request->input('jns');
        }

        return $this->pembayaranService->storePembayaran($penjualanData, $dataArrayDetail, $file);
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $pembayaran = $this->dPembayaranModel->where('id', '=', $id)->first();
            if (!$pembayaran) return response()->json(['success' => false, 'message' => 'pembayaran tidak ditemukan']);

            $penjualan = $this->dPenjualanModel->where('nota_penjualan', '=', $pembayaran->nota_penjualan)->first();

            if ($pembayaran->path_file) {
                // hapus d_penjualan & child
                $pathToDelete = $pembayaran->path_file;
                $publicPath = storage_path('app/public/');

                // Pastikan path_file dimulai dengan "storage/"
                if (Str::startsWith($pathToDelete, 'storage/')) {
                    // Ubah "storage/" menjadi direktori penyimpanan
                    $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
                }

                FormatHelper::deleteFile($pathToDelete);
            }
            $pembayaran->delete();

            $penjualanModel = new Penjualan();
            $penjualan = $penjualanModel->find($penjualan->id);

            $totalNominalBayar = new DPembayaranModel();
            $totalNominalBayar = $totalNominalBayar->where('nota_penjualan', '=', $penjualan->nota_penjualan)->get();
            $totalNominalBayar = $totalNominalBayar->sum('nominal_bayar');
            $this->pembayaranService->updateStatus($penjualan, $totalNominalBayar, $penjualan->harga_total);

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        });
    }

    public function laporan()
    {
        dd('laporan');
    }
}
