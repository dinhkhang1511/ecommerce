<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Services\ImageServices;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(10);
        return view('backend.size.index', compact('sizes'));
    }

    public function create()
    {
        return view('backend.size.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required']);
        Size::create($data);
        return success('sizes.index');
    }

    public function edit(Size $size)
    {
        return view('backend.size.edit', compact('size'));
    }

    public function update(Size $size)
    {
        $data = request()->validate(['name' => 'required']);
        $size->update($data);
        return success('sizes.index');
    }

    public function destroy(Size $size)
    {
        ImageServices::deleteImages($size);
        $size->delete();
        return success('sizes.index');
    }
}
