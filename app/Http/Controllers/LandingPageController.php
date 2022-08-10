<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class LandingPageController extends Controller
{

    public function index()
    {
        $api_url = $this->api_url;
        $response = Http::get("$api_url/home");
        if($response->successful())
        {
            $data = $this->respondToData($response);
            $bestSellers = $data->bestSellers;
            $newArrivals = $data->newArrivals;
            $hotSales = $data->hotSales;
            $blogs = $data->blogs;
            $hotSales = $data->hotSales;
            $blogs = $data->blogs;
            $categories = $data->categories;
            return view('frontend.index', compact('bestSellers', 'newArrivals', 'hotSales', 'blogs', 'categories'));
        }
        else
            $response->throw();
    }
}
