<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ImageServices;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('backend.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());
        return success('categories.index');
    }

    public function edit(Category $category)
    {
        return view('backend.category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if (request()->has('image_path')) {
            delete_file($category->image_path);
        }
        $category->update($request->validated());
        return success('categories.index');
    }

    public function destroy(Category $category)
    {
        ImageServices::deleteImages($category);
        $category->delete();
        return success('categories.index');
    }
}
