<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormatHelper
{
    public static function addDots($value)
    {

        $data = number_format($value, 0, ',', '.');


        return $data;
    }

    public static function removeDots($value)
    {

        $data = str_replace('.', '', $value);


        return $data;
    }

    public static function uploadFile(UploadedFile $file, $folder, $prefix)
    {
        try {
            $filename = $prefix . '.' . $file->getClientOriginalExtension();
            // dd($file);
            $file->storeAs($folder, $filename, 'public');

            $pathFile = "storage/{$folder}/{$filename}";

            return $pathFile;
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            return null;
        }
    }

    public static function deleteFile($filePath)
    {
        try {
            if (file_exists($filePath)) {
                // Menghapus file
                unlink($filePath);

                // Menghapus folder jika kosong setelah menghapus file
                $folderPath = dirname($filePath);
                if (is_dir($folderPath) && count(glob("$folderPath/*")) === 0) {
                    rmdir($folderPath);
                }

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }

    public static function add($a, $b)
    {
        return $a + $b;
    }


    public static function generateCode($table, $prefix = false, $length = 5)
    {
        $lastRecord = DB::table($table)->orderBy('created_at', 'desc')->first();

        if ($lastRecord) {
            if ($lastRecord->kd_pelanggan) {
                $lastCode = $lastRecord->kd_pelanggan;
            } else {
                $lastCode = $lastRecord->nota_penjualan;
            }
            $lastNumber = intval(substr($lastCode, -5));
        } else {
            $lastNumber = 0;
        }

        $nextNumber = $lastNumber + 1;

        $formattedNumber = str_pad($nextNumber, $length, '0', STR_PAD_LEFT);

        if ($prefix) {
            $kode = $prefix . '-' . date('ym')  . $formattedNumber;
        } else {
            $kode = date('ym') . '-' . $formattedNumber;
        }

        if ($lastRecord->kd_pelanggan) {
            if (DB::table($table)->where('kd_pelanggan', $kode)->exists()) {
                return self::generateCode($table, $prefix);
            }
        } else {
            if (DB::table($table)->where('nota_penjualan', $kode)->exists()) {
                return self::generateCode($table, $prefix);
            }
        }

        return $kode;
    }
}
