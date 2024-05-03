<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DKasbonModel;
use App\Models\DOpsModel;
use App\Models\DPembayaranGalonModel;
use App\Models\DPembayaranModel;
use App\Models\DPembelianDetailModel;
use App\Models\DStokProduk;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\SupplierModel;
use App\Models\TOps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    private $model;
    public function __construct()
    {
        $this->model = new Produk();
    }

    public function storeData($input)
    {
        try {
            $this->validateData($input);

            return DB::transaction(function () use ($input) {

                $data_input = $this->prepareData($input);
                $this->upsertData($data_input);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                try {
                    return $this->model->destroy($id);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function upsertData($data)
    {
        try {
            return $this->model->updateOrCreate([
                'id' => $data['id']
            ], $data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //..

    public function prepareData($input)
    {
        $input_fix['id']          = isset($input['id']) ? $input['id'] : '';
        $input_fix['kd_produk']   = $input['kd_produk'];
        $input_fix['satker']      = 'ramwater';
        $input_fix['nama']        = $input['nama'];
        $input_fix['merek']       = $input['merek'];
        $input_fix['type']        = $input['type'];
        $input_fix['kd_supplier'] = $input['kd_supplier'];
        $input_fix['stok_all']    = isset($input['stok_all']) ? $input['stok_all'] : 0;
        $input_fix['kd_ops']      = $input['kd_ops'];
        $input_fix['opr_input']   = Auth::user()->nik;
        $input_fix['tgl_input']   = date('Ymd');
        $input_fix['harga_beli']  = $input['harga_beli'];

        return $input_fix;
    }

    public function validateData($input)
    {
        $errors = [];

        if (empty($input['kd_produk'])) $errors[]   = 'Kode Produk';
        if (empty($input['nama'])) $errors[]        = 'Nama';
        if (empty($input['merek'])) $errors[]       = 'Merek';
        if (empty($input['type'])) $errors[]        = 'Type';
        if (empty($input['kd_supplier'])) $errors[] = 'Kode Supplier';
        if (empty($input['kd_ops'])) $errors[]      = 'Kode OPS';
        if (empty($input['harga_beli'])) $errors[]  = 'Harga Beli';

        if (!empty($errors)) {
            throw new \Exception('Field berikut harus terisi: ' . implode(', ', $errors));
        }
    }
}
