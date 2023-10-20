<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\UserMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMenuController extends Controller
{
    public function data(Request $request)
    {
        $menu = DB::table('users_menu');

        return datatables()
            ->of($menu)
            ->addIndexColumn()
            // ->addColumn('user_level', function ($user) {
            //     return $user->UserLevel->nama_level;
            // })
            // ->rawcolumns(['aksi'])
            ->make(true);
    }

    public function index()
    {
        return view('security.user_menu.index');
    }

    public function store(Request $request)
    {
        $data = [
            'kd_menu'       => $request->input('kd_menu'),
            'kd_parent'     => $request->input('kd_parent'),
            'type'          => $request->input('type'),
            'ur_menu_title' => $request->input('ur_menu_title'),
            'ur_menu_desc'  => $request->input('ur_menu_desc'),
            'link_menu'     => $request->input('link_menu'),
            'bg_color'      => $request->input('bg_color'),
            'icon'          => $request->input('icon'),
            'order'         => $request->input('order'),
            'is_active'     => $request->input('is_active'),
        ];
        try {
            UserMenu::upsert($data, ['kd_menu', 'kd_parent']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'            => $request->input('id'),
            'kd_menu'       => $request->input('kd_menu'),
            'kd_parent'     => $request->input('kd_parent'),
            'type'          => $request->input('type'),
            'ur_menu_title' => $request->input('ur_menu_title'),
            'ur_menu_desc'  => $request->input('ur_menu_desc'),
            'link_menu'     => $request->input('link_menu'),
            'bg_color'      => $request->input('bg_color'),
            'icon'          => $request->input('icon'),
            'order'         => $request->input('order'),
            'is_active'     => $request->input('is_active'),
        ];
        try {
            UserMenu::upsert($data, ['id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            UserMenu::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
