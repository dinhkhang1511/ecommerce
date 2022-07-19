<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Services\ImageServices;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->paginate(10);
        return view('backend.color.index', compact('colors'));
    }

    public function create()
    {
        return view('backend.color.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required', 'code' => 'required']);
        Color::create($data);
        return success('colors.index');
    }

    public function edit(Color $color)
    {
        return view('backend.color.edit', compact('color'));
    }

    public function update(Color $color)
    {
        $data = request()->validate(['name' => 'required', 'code' => 'required']);
        $color->update($data);
        return success('colors.index');
    }

    public function destroy(Color $color)
    {
        ImageServices::deleteImages($color);
        $color->delete();
        return success('colors.index');
    }
}
