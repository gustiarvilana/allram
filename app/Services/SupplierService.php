<?php

// app/Services/PembelianService.php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierService
{
    private $model;
    public function __construct()
    {
        $this->model = new SupplierModel();
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

        $input_fix['kd_supplier']   = $input['kd_supplier'];
        $input_fix['nama']          = $input['nama'];
        $input_fix['merek']         = $input['merek'];
        $input_fix['alamat']        = $input['alamat'];
        $input_fix['norek']         = $input['norek'];
        $input_fix['nama_bank']     = $input['nama_bank'];
        $input_fix['nama_pemilik']  = $input['nama_pemilik'];
        $input_fix['nama_personal'] = $input['nama_personal'];

        $input_fix['opr_input']   = Auth::user()->nik;
        $input_fix['tgl_input']   = date('Ymd');

        return $input_fix;
    }

    public function validateData($input)
    {
        $errors = [];

        if (empty($input['kd_supplier'])) $errors[]   = 'Kd Supplier';
        if (empty($input['nama'])) $errors[]          = 'Nama';
        if (empty($input['merek'])) $errors[]         = 'Merek';
        if (empty($input['alamat'])) $errors[]        = 'Alamat';
        if (empty($input['norek'])) $errors[]         = 'No Rekening';
        if (empty($input['nama_bank'])) $errors[]     = 'Nama Bank';
        if (empty($input['nama_pemilik'])) $errors[]  = 'Nama Pemilik';
        if (empty($input['nama_personal'])) $errors[] = 'Nama Personal';
        if (empty($input['no_tlp'])) $errors[]        = 'No Hp';
        if (empty($input['kd_ops'])) $errors[]        = 'Kd Ops';

        if (!empty($errors)) {
            throw new \Exception('Field berikut harus terisi: ' . implode(', ', $errors));
        }
    }
}
