<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class CartService
{
    private $total = 0;
    private $api_url;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->api_url = config('app.api_url');
    }

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

    public function checkCart($products = null)
    {
        $cart = session('cart', []);
        $products = $this->getProductsInCart(array_keys($cart));
        foreach($products as $product){
            foreach ($cart[$product->id] as $index => $item)
            {
                $attribute = $product->attributes[$index];
                if (!$attribute)
                {
                    session()->forget('cart.'.$product->id);
                }
            }
        }
        return session('cart', []);
    }

    public function total($cart = null, $products = null)
    {
        if ($products == null) {
            $cart = session('cart', []);
            $products = $this->getProductsInCart(array_keys($cart));
        }

        foreach ($cart as $product) {
            foreach ($product as $index=>$item) {
                $this->total += $item['quantity'] * $this->getPriceAfterDiscount($item);
            }
        }
        return $this->total;
    }

    private function getPriceAfterDiscount($item)
    {
        return $item['price'] * (float)((100 - $item['discount']) / 100);
    }

    public function getProductsInCart($arrID)
    {
        if(!$arrID)
            return [];
        $response = Http::get("$this->api_url/products/find",['product_id' => $arrID]);
        if($response->successful())
        {
            $products = json_decode($response->getBody()->getContents())->products;
            return $products;
        }
        else
            $response->throw();
    }
}
