<?php

namespace App\Http\Controllers;

use App\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::customer()->latest()->paginate(10);
        return view('backend.customer.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['reviews.images', 'wishlist', 'viewed_products']);
        $reviews = $customer->reviews;
        $wishlist = $customer->wishlist;
        $viewed_products = $customer->viewed_products;
        return view('backend.customer.show', compact('customer', 'reviews', 'wishlist', 'viewed_products'));
    }
}
