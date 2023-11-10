<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserHelper
{
    public static function getUser()
    {
        $user = DB::table('users as a')
            ->leftJoin('t_karyawan as b', 'a.nik', 'b.nik')
            ->where('a.id', Auth::user()->id)
            ->first();
        return $user;
    }

    public static function getKaryawanWater()
    {
        $ramwater = DB::table('t_karyawan as a')
            ->leftJoin('users as b', 'a.nik', 'b.nik')
            ->leftJoin('users_role as c', 'b.kd_role', 'c.kd_role')
            // ->whereNotIn('b.kd_role', ['1', '2', '99'])
            ->where('a.satker', 'ramwater')
            ->where('b.active', '1')
            ->get();
        return $ramwater;
    }
}
