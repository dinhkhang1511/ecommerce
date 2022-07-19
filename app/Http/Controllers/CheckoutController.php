<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Province;
use App\Services\CheckoutService;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = session('cart', []);
        $products = Product::find(array_keys($cart));
        $total = cart()->total($cart, $products);
        $provinces = Province::all();
        $user = auth()->check() ? auth()->user() : '';
        return view('frontend.checkout', compact('products', 'cart', 'total', 'provinces', 'user'));
    }

    public function store(CheckoutRequest $request)
    {
        $checkoutService = new CheckoutService($request->validated());
        
        //kiểm tra xem số lượng hàng tồn còn đủ so với số lượng mong muốn của user không
        if (!$checkoutService->checkQuantity(request()->all())) {
            return error('checkout.create', 'Your product is out of stock');
        }
        
        $checkoutService->store();
        return success('home', 'Checkout successful');
    }
}
