<?php

namespace App\Http\Controllers\Ramwater\Kasbon;

use App\Helpers\IntegrationHelper;
use App\Http\Controllers\Controller;
use App\Models\DKasbonModel;
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

class LaporanKasbonController extends Controller
{
    protected $integrationHelper;
    protected $dPembayaranModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    public function __construct(
        DPembayaranModel $dPembayaranModel,
        DKasbonModel $dKasbonModel,
        PenjualanDetail $penjualanDetailModel
    ) {
        $this->integrationHelper = new IntegrationHelper();
        $this->dPembayaranModel = $dPembayaranModel;
        $this->dKasbonModel = $dKasbonModel;
        $this->penjualanDetailModel = $penjualanDetailModel;
    }

    public function data(Request $request)
    {
        $input = $request->input();

        if (isset($input['jns'])) {
            $kasbon = $this->dKasbonModel->getKasbonByDate($input['data']);
        } else {
            $kasbon = $this->dKasbonModel->getKasbonByNik($input);
        }

        return datatables()
            ->of($kasbon)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return base64_encode($this->integrationHelper->encrypt($row->id, $this->integrationHelper->getKey()));
            })
            ->make(true);
    }

    public function index(Request $request)
    {
        $data = [
            'pelanggans' => DPelangganModel::get(),
            'karyawans' => Karyawan::get(),
            'gudang' => TGudang::get(),
            'channels' => TChannelModel::get(),
        ];

        return view('ramwater.kasbon.laporan', $data);
    }
}
