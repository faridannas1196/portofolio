<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PortofolioModel;

class PortofolioController extends Controller
{
    public function Portofolio()
{
   $porto = PortofolioModel::select('*')
             ->get();
   return view('portofolio', ['porto' => $porto],['header' => 'Portofolio Saya']);
}
}
