<?php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Models\DOpsModel;
use Illuminate\Support\Facades\DB;

class OpsService
{
    private $opsModel;
    public function __construct()
    {
        $this->opsModel = new DOpsModel();
    }

    public function store($input)
    {
        try {
            $this->validateData($input);
            return DB::transaction(function () use ($input) {

                $data_fix = $this->prepareData($input);
                $this->opsModel->upsertData($data_fix);

                return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function prepareData($input)
    {
        $input_fix = [
            'tanggal'    => $input['tanggal'],
            'satker'     => $input['satker'],
            'nik'        => $input['nik'],
            'kd_ops'     => $input['kd_ops'],
            'jumlah'     => $input['jumlah'] ? FormatHelper::removeDots($input['jumlah']) : 0,
            'harga'      => $input['harga'] ? FormatHelper::removeDots($input['harga']) : 0,
            'total'      => $input['total'] ? FormatHelper::removeDots($input['total']) : 0,
            'keterangan' => $input['keterangan'] ?? '',
            // 'id'             => $this->integrationHelper->decrypt(base64_decode($pembelianData['id']), $this->integrationHelper->getKey()),
        ];
        if (isset($input['id'])) if ($input['id'] > 0) $input_fix['id'] = $input['id'];

        return $input_fix;
    }

    public function validateData($input)
    {
        if (
            empty($input['tanggal']) ||
            empty($input['satker']) ||
            empty($input['nik']) ||
            empty($input['kd_ops']) ||
            empty($input['jumlah']) ||
            empty($input['harga']) ||
            empty($input['total'])
        ) {
            throw new \Exception('Semua kolom pada Tabel OPS harus terisi.');
        }
    }
}
