<?php

namespace App\Http\Controllers\Ramwater\Penjualan;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPelangganModel;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\TChannelModel;
use App\Models\TGudang;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    protected $integrationHelper;
    protected $dPembayaranModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    public function __construct(
        DPembayaranModel $dPembayaranModel,
        Penjualan $penjualanModel,
        PenjualanDetail $penjualanDetailModel
    ) {
        $this->integrationHelper = new IntegrationHelper();
        $this->dPembayaranModel = $dPembayaranModel;
        $this->penjualanModel = $penjualanModel;
        $this->penjualanDetailModel = $penjualanDetailModel;
    }

    public function data(Request $request)
    {
        $requestData = $request->input();

        if (isset($requestData['rTanggal'])) {
            $penjualan = $this->penjualanModel->getLaporanPenjualan($requestData);
        } elseif (isset($requestData['jns'])) {
            if ($requestData['jns'] == 'hutangNominal') $penjualan = $this->penjualanModel->getHutangPenjualanNominal();
            if ($requestData['jns'] == 'hutangGalon') $penjualan = $this->penjualanModel->getHutangPenjualanGalon();
        } else {
            $penjualan = $this->penjualanModel->getPenjualan();
        }

        if (isset($requestData['jns'])) if ($requestData['jns'] == 'penyerahan') $penjualan = $this->penjualanModel->getPenjualanPenyerahan();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
            ->make(true);
    }

    public function detailData(Request $request)
    {
        $nota_penjualan = $request->input('nota_penjualan');
        $penjualanDetail = $this->penjualanDetailModel->setNotaPenjualan($nota_penjualan);
        $penjualanDetail = $this->penjualanDetailModel->getpenjualanDetail();

        return datatables()
            ->of($penjualanDetail)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
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
        return view('ramwater.penjualan.detail', $data);
    }

    public function laporan()
    {
        dd('laporan');
    }
}
