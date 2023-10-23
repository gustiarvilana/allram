<?php

namespace App\Http\Controllers\Ramwater;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RamwaterController extends Controller
{
    public function index()
    {
        return view('ramwater.index');
    }
}
