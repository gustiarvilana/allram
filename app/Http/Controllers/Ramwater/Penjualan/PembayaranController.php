<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\FormatHelper;
use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\TChannelModel;
use App\Services\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    protected $dPembelianDetailModel;
    protected $pembayaranService;
    protected $dPembayaranModel;
    public function __construct(
        DPembelianModel $dPembelianModel,
        DPembayaranModel $dPembayaranModel,
        PembayaranService $pembayaranService
    ) {
        $this->dPembelianModel   = $dPembelianModel;
        $this->dPembayaranModel       = $dPembayaranModel;
        $this->pembayaranService       = $pembayaranService;
        $this->integrationHelper = new IntegrationHelper();
    }

    public function data(Request $request)
    {
        $req = $request->input();

        $bayar = $this->dPembayaranModel->setNotaPembelian($req['nota_pembelian']);
        $bayar = $this->dPembayaranModel->getPembayaran();

        // $bayar = $bayar->map(function ($row) {
        //     return [
        //         'id' => base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey())),
        //         // 'nota_pembelian' => $row->nota_pembelian,
        //         'tgl_pembayaran' => $row->tgl_pembayaran,
        //         'angs_ke' => $row->angs_ke,
        //         'nominal_bayar' => $row->nominal_bayar,
        //         'channel_bayar' => $row->channel_bayar,
        //         'ket_bayar' => $row->ket_bayar,
        //         'path_file' => $row->path_file,
        //         'opr_input' => $row->opr_input,
        //         'tgl_input' => $row->tgl_input,
        //         'created_at' => $row->created_at,
        //         'updated_at' => $row->updated_at,
        //     ];
        // });
        return response()->json($bayar);
    }

    public function index()
    {
        $data = [
            'channels' => TChannelModel::all(),
        ];
        return view('ramwater.pembelian.pembayaran', $data);
    }

    public function store(Request $request)
    {

        $pembelianData = json_decode($request->input('pembelianData'), true);
        $dataArrayDetail = json_decode($request->input('dataArrayDetail'), true);
        $file = $request->file('path_file');

        if ($request->input('jns')) {
            $pembelianData['jns'] = $request->input('jns');
        }

        return $this->pembayaranService->storePembayaran($pembelianData, $dataArrayDetail, $file);
    }

    public function destroy($id)
    {
        $pembayaran = $this->dPembayaranModel->where('id', '=', $id)->first();
        $pembelian = $this->dPembelianModel->where('nota_pembelian', '=', $pembayaran->nota_pembelian)->first();
        $bayarDetails = $this->dPembayaranModel->where('nota_pembelian', '=', $pembayaran->nota_pembelian)->get();

        if ($pembayaran->path_file) {
            // hapus d_pembelian & child
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


        $pembelianModel = new DPembelianModel(); // Gantilah Pembelian dengan nama model yang sesuai
        $pembelian = $pembelianModel->find($pembelian->id);

        $totalNominalBayar = new DPembayaranModel();
        $totalNominalBayar = $totalNominalBayar->where('nota_pembelian', '=', $pembelian->nota_pembelian)->get();
        $totalNominalBayar = $totalNominalBayar->sum('nominal_bayar');

        if ($totalNominalBayar == $pembelian->harga_total) {
            $pembelian->sts_angsuran = 4;
            $pembelian->nominal_bayar = $totalNominalBayar;
            $pembelian->sisa_bayar = $pembelian->harga_total - $totalNominalBayar;
            $pembelian->save();
        } elseif ($totalNominalBayar < $pembelian->harga_total) {
            $pembelian->sts_angsuran = 1;
            $pembelian->nominal_bayar = $totalNominalBayar;
            $pembelian->sisa_bayar = $pembelian->harga_total - $totalNominalBayar;
            $pembelian->save();
        } elseif ($totalNominalBayar > $pembelian->harga_total) {
            throw new \Exception("Pembayaran Terlalu banyak!");
        };


        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
