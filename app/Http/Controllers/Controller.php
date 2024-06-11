<?php

namespace App\Http\Controllers;
use App\Models\Portofolio;
use Illuminate\Http\Request;

abstract class Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'foto' => 'required',
        ]);

        Portfolio::create([
            'content' => $request->content,
            'foto' => $request->foto,
        ]);

        return redirect('/');
    }
}

