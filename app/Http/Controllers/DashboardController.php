<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        $month = request('m', date('m'));
        $newCustomers = getData()->getDataWithParam('users-month',request()->all())->users ?? [];

        $newOrders = getData()->getDataWithParam('orders-month',['m' => $month])->orders ?? [];
        $totalIncome = collect($newOrders)->where('status', 'Delivered')->sum('price');
        $newReviews = getData()->getDataWithParam('reviews',['m' => $month, 'limit' => 8])->reviews ?? [];
        $response = getData()->getDataWithParam('products-filters',['filters' => ['bestSellers', 'topFavourite']]);
        $products = collect($response->data);
        $bestSellers = $products['bestSellers'];
        $topFavourite = $products['topFavourite'];
        $orders = getData()->getDataWithParam('orders',['limit' => 'all'])->orders ?? [];
        $pendingOrders = collect($orders)->where('status','Pending');
        return view('backend.index', compact('month', 'newCustomers', 'newOrders', 'totalIncome', 'newReviews', 'bestSellers', 'topFavourite', 'pendingOrders'));
    }
}
