@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="box-title m-t-40">General Info</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td width="390">Customer Name</td>
                                            <td>{{ $order->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Phone</td>
                                            <td>{{ $order->customer_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Email</td>
                                            <td>{{ $order->customer_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $order->customer_address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Province</td>
                                            <td>{{ $order->province->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>District</td>
                                            <td>{{ $order->district->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ward</td>
                                            <td>{{ $order->ward->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Notes</td>
                                            <td>{{ $order->notes }}</td>
                                        </tr>
                                        <tr>
                                            <td>Price (after discount)</td>
                                            <td>{{ money($order->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td>{{ $order->discount }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                                                <select class="form-control" id="order_status">
                                                    <option {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option {{ $order->status == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                                                    <option {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->size->name }}</td>
                                    <td>{{ $item->color->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
