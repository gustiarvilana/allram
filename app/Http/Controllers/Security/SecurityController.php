<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SecurityController extends Controller
{
    public function index()
    {
        return view('security.index');
    }
}
