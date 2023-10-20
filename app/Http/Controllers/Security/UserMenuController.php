<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserMenuController extends Controller
{
    public function index()
    {
        return view('security.user_menu.index');
    }
}
