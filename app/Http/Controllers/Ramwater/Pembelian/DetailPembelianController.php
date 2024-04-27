<?php

namespace App\Http\Controllers\Ramwater\Pembelian;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DPembayaran;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DPembelianModel;
use App\Models\TChannelModel;
use Illuminate\Http\Request;

class DetailPembelianController extends Controller
{
    protected $dPembelianModel;
    protected $integrationHelper;
    protected $dPembelianDetailModel;
    protected $dPembayaranModel;
    public function __construct(
        DPembelianModel $dPembelianModel,
        DPembelianDetailModel $dPembelianDetailModel,
        DPembayaranModel $dPembayaranModel
    ) {
        $this->integrationHelper = new IntegrationHelper();
        $this->dPembelianModel = $dPembelianModel;
        $this->dPembelianDetailModel = $dPembelianDetailModel;
        $this->dPembayaranModel = $dPembayaranModel;
    }

    public function data(Request $request)
    {
        $requestData = $request->input();
        if (isset($requestData['rTanggal'])) {
            $supplier = $this->dPembelianModel->getLaporanPembelian($requestData);
        } elseif (isset($requestData['jns'])) {
            if ($requestData['jns'] == 'hutang') $supplier = $this->dPembelianModel->getHutang($requestData);
        } else {
            $supplier = $this->dPembelianModel->getpembelian();
        }

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
            ->make(true);
    }

    public function detailData(Request $request)
    {
        $nota_pembelian = $request->input('nota_pembelian');
        $penjualanDetail = $this->dPembelianDetailModel->setNotaPemebelian($nota_pembelian);
        $penjualanDetail = $this->dPembelianDetailModel->getPembelianDetail();

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
        return view('ramwater.pembelian.detail');
    }

    public function laporan()
    {
        dd('laporan');
    }
}
