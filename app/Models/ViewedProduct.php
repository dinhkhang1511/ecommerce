<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewedProduct extends Model
{
    protected $table = 'viewed_products';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public static function view($product)
    {
        if (auth()->check()) {
            ViewedProduct::updateOrCreate(['user_id' =>  auth()->id(), 'product_id' => $product->id])->increment('view_numbers');
        }
        else
        {
            ViewedProduct::updateOrCreate(['user_id' =>  null, 'product_id' => $product->id])->increment('view_numbers');
        }
    }
}
