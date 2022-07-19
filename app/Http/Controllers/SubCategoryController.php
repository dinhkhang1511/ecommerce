<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Services\ImageServices;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::latest()->paginate(10);
        return view('backend.sub-category.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.sub-category.create', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        SubCategory::create($request->validated());
        return success('sub-categories.index');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('backend.sub-category.edit', compact('subCategory', 'categories'));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->validated());
        return success('sub-categories.index');
    }

    public function destroy(SubCategory $subCategory)
    {
        ImageServices::deleteImages($subCategory);
        $subCategory->delete();
        return success('sub-categories.index');
    }
}
