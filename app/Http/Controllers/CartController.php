<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        try {
            $cart = cart()->checkCart();
            $products = cart()->getProductsInCart(array_keys($cart));
            $total = cart()->total($cart,$products);

            return view('frontend.cart', compact('cart', 'products', 'total'));
        }catch (\Exception $th) {
            session()->flush();
            return error();
        }
    }

    public function store(CartRequest $request)
    {
        cart()->store($request->validated());
        return success('cart.index', 'Added to cart');
    }

    public function update()
    {
        cart()->update(request()->all());
        $total = cart()->total();
        return response()->json($total);
    }

    public function destroy($id)
    {
        cart()->delete($id, request('index'));
        return response()->json(['success'=> 'Success']);
    }
}
