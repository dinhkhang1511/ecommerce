<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $guarded = [];

    public static function storeItem($review, $images)
    {
        foreach ($images as $image) {
            $path = store_file($image, 'review');
            $review->images()->create(['path' => $path]);
        }
    }
    
    public static function deleteItem($review)
    {
        foreach ($review->images as $image) {
            delete_file($image->path);
            $image->delete();
        }
    }
}
