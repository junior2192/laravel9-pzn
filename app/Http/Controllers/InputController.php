<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request)
    {
        $name = $request->input('name');
        return "Hello $name";
    }

    public function helloFirstName(Request $request)
    {
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }

    //mengambil semua input langsung
    public function helloInput(Request $request)
    {
        $input = $request->input();
        return json_encode($input);
    }

    public function inputArray(Request $request)
    {
        $name = $request->input('product.*.name');
        return json_encode($name);
    }
}
