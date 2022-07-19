@extends('layouts.backend.app')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Orders</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Orders Table</h4>
                <div class="table-responsive">
                    <a href="{{ url('excel/orders') }}">
                        <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                    </a>
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Customer Email</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ $order->customer_email }}</td>
                                <td>
                                    <span class="label {{ $order->status_color }}">{{ $order->status }}</span>
                                </td>
                                <td>{{ $order->price }}</td>
                                <td>
                                    <a href="{{ route('orders.show', ['order' => $order->id ]) }}" 
                                        data-toggle="tooltip" data-original-title="View"> 
                                        <i class="fa fa-eye m-r-15" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
