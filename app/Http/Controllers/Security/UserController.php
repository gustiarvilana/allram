<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('security.karyawan.index');
    }

    public function store(Request $request)
    {
        $data = [
            'name'              => $request->input('name'),
            'nik'               => $request->input('nik'),
            'username'          => $request->input('username'),
            'phone'             => $request->input('phone'),
            'pwd'               => $request->input('password'),
            'kd_role'           => $request->input('kd_role'),
            'active'            => $request->input('active'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
        ];
        // dd($data);
        try {
            User::upsert($data, ['id']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
