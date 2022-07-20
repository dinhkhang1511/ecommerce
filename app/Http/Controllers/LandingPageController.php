<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Album;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LandingPageController extends Controller
{

    public function index(Product $product)
    {
        $api_url = $this->api_url;
        $response = Http::get("$api_url/home");
        if($response->successful())
        {
            $data = json_decode($response->getBody()->getContents());
            $bestSellers = $data->bestSellers;
            $newArrivals = $data->newArrivals;
            $hotSales = $data->hotSales;
            $blogs = $data->blogs;
            $hotSales = $data->hotSales;
            $blogs = $data->blogs;
            $categories = $data->categories;
            $album = $data->album;
            return view('frontend.index', compact('bestSellers', 'newArrivals', 'hotSales', 'blogs', 'categories', 'album'));
        }
        else
            $response->throw();
    }
}
