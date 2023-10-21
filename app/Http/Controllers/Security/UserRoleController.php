<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\UserMenu;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    public function data(Request $request)
    {
        $menu = DB::table('users_role as a');

        return datatables()
            ->of($menu)
            ->addIndexColumn()
            ->make(true);
    }

    public function index()
    {
        $data = [
            'UserMenu' => UserMenu::all(),
        ];
        return view('security.user_role.index', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'kd_role' => $request->input('kd_role'),
            'ur_role' => $request->input('ur_role'),
        ];
        try {
            UserRole::upsert($data, ['id']); // Memanggil metode upsert dari model User
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $data = [
            'id'            => $request->input('id'),
            'kd_role'       => $request->input('kd_role'),
            'ur_role'       => $request->input('ur_role'),
        ];
        try {
            UserRole::upsert($data, ['id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            UserRole::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
