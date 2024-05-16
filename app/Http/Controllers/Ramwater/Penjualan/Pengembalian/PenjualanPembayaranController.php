<?php

namespace App\Http\Controllers\Ramwater\Penjualan\Pengembalian;

use App\Helpers\FormatHelper;
use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\DPembayaranGalonModel;
use App\Models\DPembayaranModel;
use App\Models\DPenjualanModel;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Services\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanPembayaranController extends Controller
{
    protected $integrationHelper;
    protected $dPembayaranModel;
    protected $dPembayaranGalonModel;
    protected $pembayaranService;
    protected $dPenjualanModel;

    public function __construct()
    {
        $this->integrationHelper     = new IntegrationHelper();
        $this->dPembayaranModel      = new DPembayaranModel();
        $this->dPembayaranGalonModel = new DPembayaranGalonModel();
        $this->dPenjualanModel       = new Penjualan();
        $this->pembayaranService     = new PembayaranService();
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $bayar = $this->dPembayaranModel->setNota($req['nota_penjualan']);
        $bayar = $this->dPembayaranModel->getPembayaran();

        return response()->json($bayar);
    }

    public function dataGalon(Request $request)
    {
        $req = $request->input();
        $bayarGalon = $this->dPembayaranGalonModel->setNota($req['nota_penjualan']);
        $bayarGalon = $this->dPembayaranGalonModel->getPembayaran();

        return datatables()
            ->of($bayarGalon)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'pelanggans' => DPelangganModel::get(),
            'saless' => Karyawan::where('jabatan', '=', 'sales')->get(),
            'gudang' => TGudang::get(),
            'channels' => TChannelModel::get(),
        ];
        return view('ramwater.penjualan.pembayaran', $data);
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

            $penjualan = $this->dPenjualanModel->where('nota_penjualan', '=', $pembayaran->nota)->first();

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
            $totalNominalBayar = $totalNominalBayar->where('nota', '=', $penjualan->nota_penjualan)->get();
            $totalNominalBayar = $totalNominalBayar->sum('nominal_bayar');
            $this->pembayaranService->updateStatus($penjualan, $totalNominalBayar, $penjualan->harga_total);

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        });
    }

    public function destroyGalon($id)
    {
        return DB::transaction(function () use ($id) {

            $galon = $this->dPembayaranGalonModel->where('id', '=', $id)->first();
            $penjualan = Penjualan::where('nota_penjualan', '=', $galon->nota)->first();

            $new_sisa_galon = intVal($penjualan->sisa_galon) + $galon->galon_bayar;

            if ($new_sisa_galon == 0) {
                $new_sts_galon = 4;
            } else {
                $new_sts_galon = 1;
            }

            $penjualan->galon_kembali = $penjualan->total_galon - $new_sisa_galon;
            $penjualan->sisa_galon = $new_sisa_galon;
            $penjualan->sts_galon = $new_sts_galon;

            $penjualan->save();
            $galon->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        });
    }

    public function laporan()
    {
        dd('laporan');
    }
}
