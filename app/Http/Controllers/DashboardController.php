<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Product $product)
    {
        $month = request('m', date('m'));
        $newCustomers = User::whereMonth('created_at', $month)
            ->whereYear('created_at', date('Y'))
            ->customer()
            ->latest()
            ->get();

        $newOrders = Order::whereMonth('created_at', $month)->whereYear('created_at', date('Y'))->latest()->get();
        $totalIncome = $newOrders->where('status', 'Delivered')->sum('price');
        $newReviews = Review::whereMonth('created_at', $month)->whereYear('created_at', date('Y'))->latest()->get();
        $bestSellers = $product->best_seller;
        $topFavourite = $product->top_favourite;
        $pendingOrders = Order::where('status', 'pending')->get();
        return view('backend.index', compact('month', 'newCustomers', 'newOrders', 'totalIncome', 'newReviews', 'bestSellers', 'topFavourite', 'pendingOrders'));
    }
}
