<?php

namespace App\Helpers;

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
}
