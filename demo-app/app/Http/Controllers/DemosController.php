<?php

namespace App\Http\Controllers;

use App\Http\Controllers;

class DemosController extends Controller
{

    public function dns()
    {
        return view('demos.dns');
    }


    public function api()
    {
        return view('demos.api');
    }


    public function kv()
    {
        return view('demos.kv');
    }
}
