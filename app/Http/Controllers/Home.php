<?php

namespace App\Http\Controllers;

use App\Models\HomeModel;

class Home extends Controller
{
    public function index()
    {
        $home = HomeModel::select('*')->get();

        return view('home', [
            'home' => $home,
            'header' => 'Home Page',
        ]);
    }
}

