<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function isExists()
    {
        return WishList::whereUserId(auth()->id())
                ->whereProductId(request('product_id'))->first() ? true : false;
    }
}
