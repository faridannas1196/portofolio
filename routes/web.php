<?php

use App\Models\post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;

Route::get('/', [Home::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'about'])->name('about');

Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

Route::get('/contact', function () {
    return view('contact', ['header' => 'Contact Page']);
});

Route::get('/portofolio', [PortofolioController::class, 'portofolio'])->name('portofolio');



