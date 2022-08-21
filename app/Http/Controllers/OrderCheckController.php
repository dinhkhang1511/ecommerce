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
        // $order = Order::where('order_no', request('order_no'))->first();
        $order = getData()->getDataWithParam('orders',['order_no' => request('order_no')]);
        $order = $order->orders ?? null;
        if(empty($order))
            return back()->with('error','Order not found');
        return view('frontend.order_checking', compact('order'));
    }
}
