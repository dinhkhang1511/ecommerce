<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $params = request()->all();
        $data = GetData()->getDataWithParam('orders', $params);
        $orders = $data->orders;
        $status = request('status', 'status');
        $allStatus = ['Pending', 'Shipping', 'Delivered', 'Canceled'];
        // $orders = Order::latest()->paginate(10);
        return view('backend.order.index', compact('orders','data', 'status', 'allStatus'));
    }

    public function show($id)
    {
        // $order->load('details');

        $order = GetData()->getDataFromId('orders', $id)->orders;
        return view('backend.order.show', compact('order'));
    }

    public function update(Order $order)
    {
        $order->update(['status' => request('status')]);
        return response()->json('success');
    }
    public function groupOrder()
    {
        $groupOrder = getData()->getDataWithParam('orders-range',request()->all()) ?? [];

        return view('backend.order.statistics', compact('groupOrder'));
    }
}
