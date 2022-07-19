<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_details');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function ward()
    {
        return $this->belongsTo('App\Models\Ward');
    }

    public function getStatusColorAttribute()
    {
        $classes = [
            'Pending' => 'label-warning',
            'Shipping' => 'label-danger',
            'Delivered' => 'label-success'
        ];
        return $classes[$this->status];
    }
}
