<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('backend.tag.index', compact('tags'));
    }

    public function create()
    {
        return view('backend.tag.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required']);
        
        Tag::create($data);
        
        return success('tags.index');
    }

    public function edit(Tag $tag)
    {
        return view('backend.tag.edit', compact('tag'));
    }

    public function update(Tag $tag)
    {
        $data = request()->validate(['name' => 'required']);
        
        $tag->update($data);
        
        return success('tags.index');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        
        return success('tags.index');
    }
}
