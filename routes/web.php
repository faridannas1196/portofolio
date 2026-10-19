<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\Home;
use App\Http\Controllers\PortofolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [Home::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'about'])->name('about');

Route::get('/blog', [BlogController::class, 'blog'])->name('blog');

Route::get('/contact', function () {
    return view('contact', ['header' => 'Contact Page']);
});

Route::get('/portofolio', [PortofolioController::class, 'portofolio'])->name('portofolio');

Route::get('/portofolio/add', [PortofolioController::class, 'addPortofolio'])->name('portofolio.add');

Route::get('/manage', [ContentManagementController::class, 'index'])->name('manage');

Route::post('/manage/home', [ContentManagementController::class, 'storeHome'])->name('manage.home.store');
Route::put('/manage/home/{home}', [ContentManagementController::class, 'updateHome'])->name('manage.home.update');
Route::delete('/manage/home/{home}', [ContentManagementController::class, 'destroyHome'])->name('manage.home.destroy');

Route::post('/manage/about', [ContentManagementController::class, 'storeAbout'])->name('manage.about.store');
Route::put('/manage/about/{about}', [ContentManagementController::class, 'updateAbout'])->name('manage.about.update');
Route::delete('/manage/about/{about}', [ContentManagementController::class, 'destroyAbout'])->name('manage.about.destroy');

Route::post('/manage/portfolio', [ContentManagementController::class, 'storePortfolio'])->name('manage.portfolio.store');
Route::put('/manage/portfolio/{portfolio}', [ContentManagementController::class, 'updatePortfolio'])->name('manage.portfolio.update');
Route::delete('/manage/portfolio/{portfolio}', [ContentManagementController::class, 'destroyPortfolio'])->name('manage.portfolio.destroy');

Route::post('/manage/blog', [ContentManagementController::class, 'storeBlog'])->name('manage.blog.store');
Route::put('/manage/blog/{blog}', [ContentManagementController::class, 'updateBlog'])->name('manage.blog.update');
Route::delete('/manage/blog/{blog}', [ContentManagementController::class, 'destroyBlog'])->name('manage.blog.destroy');
