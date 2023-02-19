<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutingController extends Controller
{
    public function provinces()
    {
        return view('interfaces.province.all');
    }
    public function cities()
    {
        return view('interfaces.city.all');
    }
    public function networks()
    {
        return view('interfaces.network.all');
    }
    public function phones()
    {
        return view('interfaces.phone.all');
    }
    public function message()
    {
        return view('interfaces.message.all');
    }
}
