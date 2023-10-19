<?php

namespace App\Helpers;


class MenuHelper
{
    public static function getMenusByRole($role)
    {
        if ($role) {
            $query = DB:
        } 
    }
    
    public static function printChildren($parentId)
    {
        $children = Menu::where('parent_id', $parentId)->get();
        if (count($children) > 0) {
            echo "<ul>";
            foreach ($children as $child) {
                echo "<li>" . $child->nama_menu;
                self::printChildren($child->id);
                echo "</li>";
            }
            echo "</ul>";
        }
    }
}
