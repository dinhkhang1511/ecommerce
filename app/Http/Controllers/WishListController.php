<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\User;

class WishListController extends Controller
{


    public function index()
    {
        $user = session('user',[]);
        if($user)
        {
            $wishlist = User::find($user->id)->wishlist;
            return view('frontend.wishlist', compact('wishlist'));
        }
        else
            return error();
    }

    public function store(Wishlist $wishlist)
    {
        $user = session('user',[]);
        $user = User::find($user->id);
        if (!$wishlist->isExists()) {
            $user->wishlist()->create(['product_id' => request('product_id')]);
            return success('wishlist.index', 'Added to wishlist');
        }
        return error('wishlist.index', 'Already in wishlist');
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return success('wishlist.index');
    }
}
