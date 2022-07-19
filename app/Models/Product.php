<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'quantity', 'discount', 'description', 'sub_category_id'
    ];
    protected $appends = ['after_discount', 'first_image'];

    /*  *****************************RELATIONSHIP***************************** */

    public function colors()
    {
        return $this->belongsToMany('App\Models\Color', 'product_attributes')->withPivot('product_quantity');
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size', 'product_attributes')
                    ->withPivot('product_quantity')
                    ->where('product_quantity', '>', 0);
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    //lấy attributes có product_quantity > 0
    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute')->where('product_quantity', '>', 0);
    }

    //lấy tất cả attributes
    public function allattributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    /*  *****************************QUERY SCOPE***************************** */

    public function scopeActive($query)
    {
        return $query->where('products.quantity', '>', 0);
    }

    /*  *****************************MUTATORS***************************** */

    public function setQuantityAttribute()
    {
        $this->attributes['quantity'] = collect(request('quantity'))->sum();
    }

    /*  *****************************ACCESSORS***************************** */

    public function getBestSellerAttribute()
    {
        return $this->select('products.*')
            ->selectRaw('COUNT(*) AS result')
            ->active()
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->groupBy('order_details.product_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(8)
            ->with('attributes.images')
            ->get();
    }

    public function getTopFavouriteAttribute()
    {
        return $this->select('products.*')
            ->selectRaw('COUNT(*) AS result')
            ->active()
            ->join('wishlists', 'products.id', '=', 'wishlists.product_id')
            ->groupBy('wishlists.product_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(8)
            ->get();
    }

    public function getNewArrivalAttribute()
    {
        return $this->latest()->active()->limit(8)->with('attributes.images')->get();
    }

    public function getHotSaleAttribute()
    {
        return $this->where('discount', '>', 0)
            ->active()
            ->orderBy('discount', 'desc')
            ->limit(8)
            ->with('attributes.images')
            ->get();
    }

    public function getRelatedAttribute()
    {
        return $this->where('sub_category_id', $this->sub_category_id)
            ->active()
            ->where('id', '!=', $this->id)
            ->with('attributes.images')
            ->get();
    }

    public function getImagesAttribute()
    {
        return $this->attributes()->first()->images ?? collect([]);
    }

    public function getFirstImageAttribute()
    {
        return $this->images->first()->path ?? '';
    }

    public function getCategoryAttribute()
    {
        return $this->subCategory->category;
    }

    public function getAfterDiscountAttribute()
    {
        return $this->price * ((100 - $this->discount) / 100);
    }

    public function getRatingStarAttribute()
    {
        return round($this->reviews->average('rating'));
    }

    /*  *****************************METHODS***************************** */

    public function firstAttribute($item)
    {
        return $this->attributes()->where('size_id', $item['size'])
                ->where('color_id', $item['color'])
                ->first();
    }
}
