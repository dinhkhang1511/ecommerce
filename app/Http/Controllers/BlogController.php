<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('blogs',request()->all());
        if(!isset($data->blogs))
            abort(404);
        return view('backend.blog.index', compact('data'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('backend.blog.create', compact('tags'));
    }

    public function store(BlogStoreRequest $request)
    {
        $blog = Blog::create($request->validated());
        $blog->tags()->attach($request->tags);
        return success('blogs.index');
    }

    public function edit(Blog $blog)
    {
        $tags = Tag::all();
        $blog->load('tags');
        return view('backend.blog.edit', compact('blog', 'tags'));
    }

    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        if (request()->has('image_path')) {
            delete_file($blog->image_path);
        }

        $blog->update($request->validated());
        $blog->tags()->sync($request->tags);
        return success('blogs.index');
    }

    public function destroy(Blog $blog)
    {
        delete_file($blog->image_path);
        $blog->delete();
        return success('blogs.index');
    }
}
