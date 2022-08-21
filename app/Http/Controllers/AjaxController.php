<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Promo;
use App\Models\District;
use App\Models\Province;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AjaxController extends Controller
{
    public function findPromos($code)
    {
        $promo = GetData()->getDataWithParam('find-promo', ['code' => $code], []);
        return response()->json($promo);
    }

    public function getColor($product, $size)
    {
        // loại bỏ color trùng id để sửa lỗi hiện thị color trùng
        $attributes = ProductAttribute::where('product_quantity', '>', 0)
                    ->where('product_id', $product)
                    ->where('size_id', $size)
                    ->get()
                    ->unique('color_id');

        $attributes->load('color');
        return $attributes;

        // $attributes = GetData()->getDataFromType("get-colors/$product/$size");
        // return $attributes;
    }

    public function getAttribute()
    {
        return ProductAttribute::where('product_id', request('product'))
                    ->where('size_id', request('size'))
                    ->where('color_id', request('color'))
                    ->first();
    }

    public function getDistrict($id)
    {
        $data = GetData()->getDataFromType("districts/$id");
        return $data;
    }

    public function getWards($id)
    {
        $data = GetData()->getDataFromType("wards/$id");
        return $data;
    }

    public function getAllAttributes()
    {
        $attributes = [
            'sizes' => Size::all(),
            'colors' => Color::all(),
        ];
        return $attributes;
    }

    public function paypalPaid()
    {
        //dùng để check là user đã thanh toán qua paypal rồi
        session()->put('paypal_paid', true);
        return true;
    }

    public function updateOrder(Request $request,$id)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        if($request->has('status'))
        {
            $response = HttpService()->updateDataWithBody('orders', $id, ['status' => $request->status], $headers);
            return response()->json($response);
        }
        return;
    }
}
