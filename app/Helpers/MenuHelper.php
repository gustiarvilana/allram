<?php

namespace App\Helpers;

use App\Models\UserMenu;
use Illuminate\Support\Facades\DB;

class MenuHelper
{
    public static function getMenusByRole($role)
    {
        if ($role) {
            $query = DB::table('users_role as a')
                ->join('users_role_menu as b', 'a.kd_role', 'b.kd_role')
                ->join('users as c', 'a.kd_role', 'c.kd_role')
                ->join('users_menu as d', 'b.kd_menu', 'd.kd_menu')
                ->where('d.is_active', '1')
                ->where('c.kd_role', $role)
                ->orderBy('d.order')
                ->get();

            return $query;
        }
    }

    public static function printChildren($kd_parent)
    {
        $children = UserMenu::where('kd_parent', $kd_parent)->get();
        if (count($children) > 0) {
            echo "<ul>";
            foreach ($children as $child) {
                echo "<li>" . $child->ur_menu_title;
                self::printChildren($child->id);
                echo "</li>";
            }
            echo "</ul>";
        }
    }
}
