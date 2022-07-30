<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class NewsController extends Controller
{
    public function index()
    {
        $param = request()->all();
        $param['limit'] = '6';
        $data = GetData()->getDataWithParam('blogs',$param);
        $blogs = $data->blogs;
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $data = GetData()->getDataFromId('blogs',$id);
        $blog = $data->blogs;

        $relatedPost =  GetData()->getDataFromType("blogs/related/$id")->blogs;

        return view('frontend.blog.show', compact('blog', 'relatedPost'));
    }
}
