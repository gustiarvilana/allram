<?php

namespace App\Helpers;

use App\Models\UserMenu;
use Illuminate\Support\Facades\DB;

class MenuHelper
{
    public static function getMenusByRole($role, $kd_parent)
    {
        if ($role) {
            $query = DB::table('users_role as a')
                ->join('users_role_menu as b', 'a.kd_role', 'b.kd_role')
                ->join('users as c', 'a.kd_role', 'c.kd_role')
                ->join('users_menu as d', 'b.kd_menu', 'd.kd_menu')
                ->where('d.kd_parent', $kd_parent)
                ->where('d.is_active', '1')
                ->where('b.tahun', 2023)
                ->where('c.kd_role', $role)
                ->orderBy('d.order')
                ->get();

            return $query;
        }
    }

    public static function printChildren($kd_parent, $currentUrl)
    {
        $children = UserMenu::where('kd_parent', $kd_parent)->get();
        if (count($children) > 0) {
            foreach ($children as $child) {
                echo "<ul class='nav nav-treeview'>";
                echo "<li class='nav-item'>";
                echo "<a href='" . url('/') . $child->link_menu . "' class='nav-link'>";
                echo "<i class='far fa-circle nav-icon'></i>";
                echo "<p>" . $child->ur_menu_title . "</p>";
                echo "</a>";
                echo "</li>";
                echo "</ul>";
            }
        }
    }

    public static function countChildren($kd_parent)
    {
        $children = UserMenu::where('kd_parent', $kd_parent)->get();
        return $children;
    }

    public static function getKdByPath($path)
    {
        $menu = UserMenu::where('link_menu', '/' . $path)->first()->kd_menu;
        return $menu;
    }
}
