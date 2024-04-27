<?php

namespace App\Http\Controllers\Ramwater\Kasbon;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use App\Models\DKasbonModel;
use App\Models\DOpsModel;
use App\Models\Karyawan;
use App\Models\TOps;
use App\Models\UserMenu;
use App\Models\UserRole;
use App\Services\OpsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    private $tOps;
    private $kasbon;
    private $dKaryawan;
    public function __construct()
    {
        $this->opsService = new OpsService();
        $this->dOps = new DOpsModel();
        $this->tOps = new TOps();
        $this->kasbon = new DKasbonModel();
        $this->dKaryawan = new Karyawan();
    }

    public function data(Request $request)
    {
        $requestData = $request->input();

        $kasbon =  $this->kasbon->getKasbon();

        return datatables()
            ->of($kasbon)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'opss' => $this->tOps->get(),
            'pegawais' => $this->dKaryawan->get(),
        ];
        return view('ramwater.kasbon.index', $data);
    }

    public function store(Request $request)
    {
        $input = $request->input('data');
        $this->kasbon->upsert($input);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
    }


    public function destroy($id)
    {
        $kasbon = $this->kasbon->where('id', $id)->first();
        try {
            $kasbon->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
