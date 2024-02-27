<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
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

    public static function uploadFile(UploadedFile $file, $folder, $prefix = null)
    {
        try {
            $filename = ($prefix ? $prefix . '_' : '') . $file->getClientOriginalName();
            $file->storeAs($folder, $filename, 'public');

            $pathFile = "storage/{$folder}/{$filename}";

            return $pathFile;
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            return null;
        }
    }
}
