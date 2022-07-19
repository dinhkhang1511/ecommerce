<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Services\ImageServices;
use App\Models\ProductAttribute;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('backend.product.index', compact('products'));
    }

    public function create()
    {
        $subCategories = SubCategory::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('backend.product.create', compact('subCategories', 'sizes', 'colors'));
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        $attributes = $product->attributes()->createMany(ProductAttribute::getData());
        ProductImage::storeItem($attributes);
        return success('products.index');
    }

    public function show(Product $product)
    {
        $product->load(['orders', 'sizes', 'colors']);
        return view('backend.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $subCategories = SubCategory::all();
        $sizes = Size::all();
        $colors = Color::all();
        $product->load(['allattributes']);
        return view('backend.product.edit', compact('product', 'subCategories', 'sizes', 'colors'));
    }

    public function update(ProductStoreRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->sizes()->detach();
        $product->attributes()->createMany(ProductAttribute::getData());
        ProductImage::updateItem($product->attributes);
        return success('products.index');
    }

    public function destroy(Product $product)
    {
        ImageServices::deleteImages($product);
        $product->delete();
        return success('products.index');
    }
}
