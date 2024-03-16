<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\FormatHelper;
use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPenjualanDetailModel;
use App\Models\DPenjualanModel;
use App\Models\Karyawan;
use App\Models\TChannelModel;
use App\Models\TGudang;
use App\Services\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{

    protected $integrationHelper;

    public function __construct()
    {
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $bayar = $this->dPembayaranModel->setNotaPenjualan($req['nota_penjualan']);
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
        $pembayaran = $this->dPembayaranModel->where('id', '=', $id)->first();
        $penjualan = $this->dPenjualanModel->where('nota_penjualan', '=', $pembayaran->nota_penjualan)->first();
        $bayarDetails = $this->dPembayaranModel->where('nota_penjualan', '=', $pembayaran->nota_penjualan)->get();

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

        $penjualanModel = new DPenjualanModel(); // Gantilah Penjualan dengan nama model yang sesuai
        $penjualan = $penjualanModel->find($penjualan->id);

        $totalNominalBayar = new DPembayaranModel();
        $totalNominalBayar = $totalNominalBayar->where('nota_penjualan', '=', $penjualan->nota_penjualan)->get();
        $totalNominalBayar = $totalNominalBayar->sum('nominal_bayar');

        if ($totalNominalBayar == $penjualan->harga_total) {
            $penjualan->sts_angsuran = 4;
            $penjualan->nominal_bayar = $totalNominalBayar;
            $penjualan->sisa_bayar = $penjualan->harga_total - $totalNominalBayar;
            $penjualan->save();
        } elseif ($totalNominalBayar < $penjualan->harga_total) {
            $penjualan->sts_angsuran = 1;
            $penjualan->nominal_bayar = $totalNominalBayar;
            $penjualan->sisa_bayar = $penjualan->harga_total - $totalNominalBayar;
            $penjualan->save();
        } elseif ($totalNominalBayar > $penjualan->harga_total) {
            throw new \Exception("Pembayaran Terlalu banyak!");
        };


        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
