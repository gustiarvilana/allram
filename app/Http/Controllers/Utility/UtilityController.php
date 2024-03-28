<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UtilityController extends Controller
{
    public function setSession(Request $request)
    {
        $name = $request->input('name');
        $val = $request->input('val');

        $request->session()->put($name, $val);
        return;
    }

    public function add(Request $request)
    {
        $a = $request->input('a');
        $b = $request->input('b');

        $result = $a + $b;

        return response()->json(['result' => $result]);
    }
}
