<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('backend.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('details');
        return view('backend.order.show', compact('order'));
    }

    public function update(Order $order)
    {
        $order->update(['status' => request('status')]);
        return response()->json('success');
    }
}
