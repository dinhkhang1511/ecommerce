<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;

class WishListController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->wishlist;
        return view('frontend.wishlist', compact('wishlist'));
    }

    public function store(Wishlist $wishlist)
    {
        if (!$wishlist->isExists()) {
            auth()->user()->wishlist()->create(['product_id' => request('product_id')]);
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
