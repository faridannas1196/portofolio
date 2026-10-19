<?php

namespace App\Http\Controllers;

use App\Models\PortofolioModel;
use Illuminate\Http\RedirectResponse;

class PortofolioController extends Controller
{
    public function portofolio()
    {
        $porto = PortofolioModel::select('*')->get();

        return view('portofolio', [
            'porto' => $porto,
            'header' => 'Portofolio Saya',
        ]);
    }

    public function addPortofolio(): RedirectResponse
    {
        return redirect()->route('manage')->withFragment('portfolio');
    }
}
