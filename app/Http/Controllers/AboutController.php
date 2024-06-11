<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutModel;

class AboutController extends Controller
{
    public function about(){
        $about = AboutModel::select('*')
                 ->get();
       return view('about', ['about' => $about],['header' => 'Tentang Saya']);
    }
}
