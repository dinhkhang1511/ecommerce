<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class NewsController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(9);
        return view('frontend.blog.index', compact('blogs'));
    }
    
    public function show(Blog $blog)
    {
        $blog->load('tags');
        $relatedPost = Blog::relatedPost($blog);
        return view('frontend.blog.show', compact('blog', 'relatedPost'));
    }
}
