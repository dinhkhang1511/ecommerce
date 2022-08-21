<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Province;
use App\Services\CheckoutService;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = session('cart', []);
        // $products = Product::find(array_keys($cart));
        $data = getData()->getDataWithParam('products/find',['product_id' => array_keys($cart)]);
        $products = $data->products ?? [];

        $total = cart()->total($cart, $products);
        // $provinces = Province::all();
        $provinces = getData()->getDataFromType('locations/provinces')->data;
        $user = session('user','');
        return view('frontend.checkout', compact('products', 'cart', 'total', 'provinces', 'user'));
    }

    public function store(CheckoutRequest $request)
    {
        $response = HttpService()->postDataWithBody('checkout', $request->all(), []);
        if (($response->status ?? 200) == 400) {
            return error('checkout.create', 'Your product is out of stock');
        }

        session()->forget(['cart', 'paypal_paid']);
        return success('home', 'Checkout successful');
    }
}
