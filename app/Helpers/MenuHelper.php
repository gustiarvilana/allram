<?php

namespace App\Helpers;

use App\Models\UserMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuHelper
{
    public static function getMenusByRole($role, $kd_parent = 0)
    {
        if ($role) {
            $query = DB::table('users_role as a')
                ->join('users_role_menu as b', 'a.kd_role', 'b.kd_role')
                ->join('users as c', 'a.kd_role', 'c.kd_role')
                ->join('users_menu as d', 'b.kd_menu', 'd.kd_menu')

                ->where('d.kd_parent', $kd_parent)
                ->where('d.is_active', '1')
                ->where('b.tahun', date('Y'))
                ->where('c.kd_role', $role)
                ->orderBy('d.order', 'asc')
                ->get();

            return $query;
        }
    }

    public static function printChildren($kd_parent, $currentUrl, $parentUrl)
    {
        $children = DB::table('users_menu as a')
            ->join('users_role_menu as b', 'a.kd_menu', 'b.kd_menu')
            ->where('a.kd_parent', $kd_parent)
            ->where('b.tahun', date('Y'))
            ->where('b.kd_role', Auth::user()->kd_role)
            ->orderBy('a.order', 'asc')
            ->get();

        if (count($children) > 0) {
            foreach ($children as $child) {
                echo "<ul class='nav nav-treeview ml-3'>";
                echo "<li class='nav-item ";
                if ($child->link_menu == '/' . $currentUrl) {
                    echo "menu-open";
                }
                echo "'>";
                echo "<a href='" . url('/') . $child->link_menu . "' class='nav-link ";
                if ($child->link_menu == '/' . $currentUrl) {
                    echo "active";
                }
                echo "'>";
                echo "<i class='" . ($child->icon == '#' ? $child->icon : 'far fa-circle') . " nav-icon'></i>";
                echo "<p>" . $child->ur_menu_title . "</p>";
                if (count(self::countChildren($child->kd_menu)->where('kd_parent', '!=', null)) > 0) {
                    echo '<i class="right fas fa-angle-left"></i>';
                }
                echo "</a>";

                if (count(self::countChildren($child->kd_menu)->where('kd_parent', '!=', null)) > 0) {
                    self::printChildren($child->kd_menu, $currentUrl, $parentUrl);
                }
                echo "</li>";
                echo "</ul>";
            }
            // open
            // print_r($child->link_menu);
            // print_r('<br>=> /' . $parentUrl);

            if (dirname($child->link_menu) == '/' . $parentUrl || $child->link_menu == '/' . $parentUrl) {
                echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
                echo "<script>";
                echo "$(document).ready(function() {";
                echo "$('#item_menu-" . $child->kd_parent . "').toggleClass('menu-is-opening menu-open');";
                echo "});";
                echo "</script>";
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

    function format_uang($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}
