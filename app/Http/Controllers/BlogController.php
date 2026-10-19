<?php

namespace App\Http\Controllers;

use App\Models\BlogModel;

class BlogController extends Controller
{
    public function blog()
    {
        $blog = BlogModel::select('*')->get();

        return view('blog', [
            'blog' => $blog,
            'header' => 'Blog Pengalaman',
        ]);
    }
}
