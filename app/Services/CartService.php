<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private $total = 0;

    public function store($data)
    {
        $sessionKey = 'cart.'.$data['product_id'];
        $collect = collect(session($sessionKey, []));

        //nếu sản phẩm đã có trong session thì chỉ tăng số lượng, ngược lại thì thêm vào session
        $key = $collect->where('size', $data['size'])->where('color', $data['color'])->keys();
        if ($key->count() == 0) {
            session()->push($sessionKey, $data);
        } else {
            session()->increment($sessionKey.'.'.$key[0].'.quantity', $data['quantity']);
        }
    }

    public function update($data)
    {
        $sessionKey = 'cart.'.$data['product'].'.'.$data['key'].'.quantity';
        session()->put($sessionKey, $data['quantity']);
    }

    public function delete($product_id, $key)
    {
        $sessionKey = 'cart.'.$product_id;
        session()->forget($sessionKey.'.'.$key);
        if (count(session($sessionKey)) == 0) {
            session()->forget($sessionKey);
        }
    }

    public function checkCart()
    {
        $cart = session('cart', []);
        $products = Product::find(array_keys($cart));
        $products->each(function ($product) use ($cart) {
            foreach ($cart[$product->id] as $index => $item) {
                $attribute = $product->firstAttribute($item);
                if (!$attribute) {
                    session()->forget('cart.'.$product->id);
                }
            }
        });
        return session('cart', []);
    }

    public function total($cart = null, $products = null)
    {
        if ($products == null) {
            $cart = session('cart', []);
            $products = Product::find(array_keys($cart));
        }

        foreach ($products as $product) {
            foreach ($cart[$product->id] as $index=>$item) {
                $this->total += $cart[$product->id][$index]['quantity'] * $product->after_discount;
            }
        }
        return $this->total;
    }
}
