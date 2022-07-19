<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderCheckController extends Controller
{
    public function index()
    {
        return view('frontend.order_checking');
    }

    public function check()
    {
        $order = Order::where('order_no', request('order_no'))->first();
        return view('frontend.order_checking', compact('order'));
    }
}
