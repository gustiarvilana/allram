<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

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
use Illuminate\Support\Facades\DB;
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

        if (isset($req['nota_pembelian'])) $nota = $req['nota_pembelian'];
        if (isset($req['nota_penjualan'])) $nota = $req['nota_penjualan'];

        $bayar = $this->dPembayaranModel->setNota($nota);
        $bayar = $this->dPembayaranModel->getPembayaran();

        if (isset($req['grid'])) return datatables()
            ->of($bayar)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
            ->make(true);

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
        return DB::transaction(function () use ($id) {
            $pembayaran = $this->dPembayaranModel->where('id', '=', $id)->first();
            $pembelian = $this->dPembelianModel->where('nota_pembelian', '=', $pembayaran->nota)->first();

            if ($pembayaran->path_file) {
                $pathToDelete = $pembayaran->path_file;
                $publicPath = storage_path('app/public/');

                if (Str::startsWith($pathToDelete, 'storage/')) {
                    $pathToDelete = $publicPath . Str::after($pathToDelete, 'storage/');
                }

                FormatHelper::deleteFile($pathToDelete);
            }

            $pembelianModel = new DPembelianModel();
            $pembelian = $pembelianModel->find($pembelian->id);

            $new_nominal_bayar = $pembelian->nominal_bayar - $pembayaran->nominal_bayar;

            if ($new_nominal_bayar == $pembelian->harga_total) {
                $pembelian->sts_angsuran = 4;
                $pembelian->nominal_bayar = $new_nominal_bayar;
                $pembelian->sisa_bayar = $pembelian->harga_total - $new_nominal_bayar;
                $pembelian->save();
            } elseif ($new_nominal_bayar < $pembelian->harga_total) {
                $pembelian->sts_angsuran = 1;
                $pembelian->nominal_bayar = $new_nominal_bayar;
                $pembelian->sisa_bayar = $pembelian->harga_total - $new_nominal_bayar;
                $pembelian->save();
            } elseif ($new_nominal_bayar > $pembelian->harga_total) {
                throw new \Exception("Pembayaran Terlalu banyak!");
            };

            $pembayaran->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        });
    }

    public function laporan()
    {
        dd('laporan');
    }
}
