<?php

namespace App\Services;

use App\User;
use App\Models\Order;
use App\Mail\CheckoutMail;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Notifications\NewOrder;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function store()
    {
        $order = $this->storeInDb();
        $this->sendNotification($order);
        $this->forgetSession();
    }

    private function storeInDb()
    {
        $order = Order::create($this->data);
        //tạo ra id đơn hàng để dùng cho việc check đơn hàng
        $order->update(['order_no' => str_pad($order->id, 10, Str::random(100))]);
        OrderDetail::storeItem($order);
        return $order;
    }

    private function sendNotification($order)
    {
        User::find(1)->notify(new NewOrder($order));
        Mail::to($this->data['customer_email'])->queue(new CheckoutMail($order));
    }

    private function forgetSession()
    {
        session()->forget(['cart', 'paypal_paid']);
    }

    public function checkQuantity($data)
    {
        foreach ($data['product_id'] as $index => $value) {
            $attribute = ProductAttribute::where('product_quantity', '>=', $data['quantity'][$index])
                            ->where('product_id', $value)
                            ->where('size_id', $data['size_id'][$index])
                            ->where('color_id', $data['color_id'][$index])
                            ->first();
            
            if (!$attribute) {
                session()->forget('cart.'.$value.'.'.$index);
                return false;
            }
        }
        return true;
    }
}
