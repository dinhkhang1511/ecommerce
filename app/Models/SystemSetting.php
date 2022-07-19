<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $guarded = [];
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

    public function setLogoAttribute()
    {
        $this->storeImage('logo');
    }

    public function setFaviconAttribute()
    {
        $this->storeImage('favicon');
    }

    private function storeImage($key)
    {
        if (request()->has($key)) {
            $path = store_file(request($key), 'setting');
            $this->attributes[$key] = $path;
        }
    }
}
