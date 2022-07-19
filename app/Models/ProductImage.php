<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = [];

    public static function storeItem($attributes)
    {
        //upload hình ảnh theo product_attribute, mỗi product_attribute có thể có nhiều hình ảnh
        foreach ($attributes as $index=>$attribute) {
            foreach (request('images'.$index, []) as $image) {
                $path = store_file($image, 'product');
                $attribute->images()->create(['path' => $path]);
            }
        }
    }
    
    public static function deleteItem($attribute)
    {
        foreach ($attribute->images as $image) {
            delete_file($image->path);
        }
    }

    public static function updateItem($attributes)
    {
        foreach ($attributes as $index=>$attribute) {
            $old_images = request('old_images'.$index, []);
            if (!request('images'.$index)) {
                foreach ($old_images as $image) {
                    $attribute->images()->create(['path' => $image]);
                }
                continue;
            }

            foreach ($old_images as $image) {
                delete_file($image);
            }
            
            foreach (request('images'.$index, []) as $image) {
                $path = store_file($image, 'product');
                $attribute->images()->create(['path' => $path]);
            }
        }
    }
}
