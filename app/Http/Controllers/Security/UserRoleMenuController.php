<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Models\UserRoleMenu;
use Illuminate\Http\Request;

class UserRoleMenuController extends Controller
{
    public function getMenuByRole(Request $request)
    {
        $req = $request->all();

        $menu = UserRoleMenu::where('kd_role', $req['kd_role'])->get();

        return $menu;
    }

    public function store(Request $request)
    {
        $req = $request->all();

        UserRoleMenu::where('kd_role', $req['kd_role'])->delete();

        if ($req['data']) {
            foreach ($req['data'] as $kd) {
                UserRoleMenu::create([
                    'kd_role' => $req['kd_role'],
                    'kd_menu' => $kd,
                    'tahun' => date('Y'),
                ]);
            }
        }
    }
}
