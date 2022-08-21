<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

use function PHPUnit\Framework\isInstanceOf;

class CustomerController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('users',request()->all(),[]);
        $customers = collect($data->users)->where('role_id', '!=', 1);
        return view('backend.customer.index', compact('customers','data'));
    }

    public function show($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $response = GetData()->getDataWithParam('getUser'
                , ['fields' => 'reviews.images,wishlist.product,viewed_products.product', 'user_id' => $id]
                , $headers);
        if(($response->status ?? 200) == 401)
            return error('logout');

        $customer = $response;
        $reviews = $customer->reviews;
        $wishlist = $customer->wishlist;
        $viewed_products = $customer->viewed_products;
        return view('backend.customer.show', compact('customer', 'reviews', 'wishlist', 'viewed_products'));
    }

    public function setAdmin(Request $request)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $response = HttpService()->updateDataWithBody('users/set-admin',$request->customer_id, [], $headers);
        return back()->with('success', 'Operation Success');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $response =  HttpService()->deletedData('users', $id, [], $headers);
        return success('customers.index');
    }
}
