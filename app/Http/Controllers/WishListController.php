<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishListController extends Controller
{


    public function index()
    {
        $user = session('user',[]);
        if($user && !empty($user))
        {
            // $wishlist = GetData()->getDataWithParam("users/wishlist",['id' => $user->id])->wishlist;
            $wishlist = GetData()->getDataFromType("users/wishlist/$user->id")->wishlist;
            return view('frontend.wishlist', compact('wishlist'));
        }
        else
            return error();
    }

    public function store(Request $request)
    {
        $user = session('user',[]);
        $user = User::find($user->id);
        $headers = ['access_token' => Cookie::get('access_token', null)];
        if($user)
        {
            $request['user_id'] = $user->id;
            $response = HttpService()->postDataWithBody('wishlists', $request->all(), $headers);
        }
        else
            return redirect('login');

        return success('wishlist.index', $response->data);
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return success('wishlist.index');
    }
}
