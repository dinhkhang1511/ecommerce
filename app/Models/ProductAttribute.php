<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = [];

    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public static function getData()
    {
        foreach (request('sizes') as $index => $size) {
            $data[] = [
                'size_id' => $size,
                'product_quantity' => request('quantity')[$index],
                'color_id' => request('colors')[$index],
            ];
        }
        $data = collect($data)->unique(function ($item) {
            return $item['size_id'].$item['color_id'];
        });
        return $data;
    }
}
