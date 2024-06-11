<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogModel;

class BlogController extends Controller
{
    public function Blog()
    {
       $blog = BlogModel::select('*')
                 ->get();
       return view('blog', ['blog' => $blog],['header' => 'Blog Pengalaman']);
    }
}
