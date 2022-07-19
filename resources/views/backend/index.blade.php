@extends('layouts.backend.app')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <p class="font-weight-bold">Overview</p>
        </div>
        <div class="col-3 ml-auto">
            <div class="form-group">
                <select class="form-control" id="month">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i < 10 ? "0$i" : $i }}" @if ($i == $month) selected @endif>
                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div class="card-group">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">NEW CLIENTS</p>
                                <p>({{ $month . date('-Y') }})</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-primary">{{ $newCustomers->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-note"></i></h3>
                                <p class="text-muted">NEW ORDERS</p>
                                <p>({{ $month . date('-Y') }})</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-cyan">{{ $newOrders->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-doc"></i></h3>
                                <p class="text-muted">TOTAL INCOME</p>
                                <p>({{ $month . date('-Y') }})</p>
                            </div>
                            <div class="ml-auto">
                                <h4 class="counter text-purple">{{ money($totalIncome) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-bag"></i></h3>
                                <p class="text-muted">NEW REVIEWS</p>
                                <p>({{ $month . date('-Y') }})</p>
                            </div>
                            <div class="ml-auto">
                                <h2 class="counter text-success">{{ $newReviews->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-6">
                            <h4>Top Selling Product</h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>NAME</th>
                                <th>PRICE</th>
                                <th>DISCOUNT</th>
                                <th>NUMBERS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bestSellers as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="txt-oflo">{{ $item->name }}</td>
                                    <td class="txt-oflo">{{ $item->after_discount }}</td>
                                    <td class="txt-oflo">{{ $item->discount }} %</td>
                                    <td class="txt-oflo">{{ $item->result }}</td>
                                    <td class="txt-oflo">
                                        <a href="{{ route('products.show', ['product' => $item->id]) }}">VIEW</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-6">
                            <h4>Top Favorite Product</h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>NAME</th>
                                <th>PRICE</th>
                                <th>DISCOUNT</th>
                                <th>NUMBERS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topFavourite as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="txt-oflo">{{ $item->name }}</td>
                                    <td class="txt-oflo">{{ $item->after_discount }}</td>
                                    <td class="txt-oflo">{{ $item->discount }} %</td>
                                    <td class="txt-oflo">{{ $item->result }}</td>
                                    <td class="txt-oflo">
                                        <a href="{{ route('products.show', ['product' => $item->id]) }}">VIEW</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-6">
                            <h4>Recent Customer</h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newCustomers->take(8) as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="txt-oflo">{{ $item->name }}</td>
                                    <td class="txt-oflo">{{ $item->email }}</td>
                                    <td class="txt-oflo">{{ $item->phone }}</td>
                                    <td class="txt-oflo">
                                        <a href="{{ route('customers.show', ['customer' => $item->id]) }}">VIEW</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-6">
                            <h4>Pending Orders</h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>CUSTOMER NAME</th>
                                <th>CUSTOMER EMAIL</th>
                                <th>CUSTOMER PHONE</th>
                                <th>PRICE</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingOrders as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="txt-oflo">{{ $item->customer_name }}</td>
                                    <td class="txt-oflo">{{ $item->customer_email }}</td>
                                    <td class="txt-oflo">{{ $item->customer_phone }}</td>
                                    <td class="txt-oflo">{{ $item->price }}</td>
                                    <td>
                                        <input type="hidden" value="{{ $item->id }}" id="order_id">
                                        <select class="form-control" id="order_status">
                                            <option {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option {{ $item->status == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                                            <option {{ $item->status == 'Delivered' ? 'selected' : '' }}>Delivered
                                            </option>
                                        </select>
                                        {{-- <span class="label {{ $item->status_color }}">{{ $item->status }}</span> --}}
                                    </td>
                                    <td class="txt-oflo">
                                        <a href="{{ route('orders.show', ['order' => $item->id]) }}">VIEW</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Reviews</h5>
                </div>
                <div class="comment-widgets">
                    @foreach ($newReviews->take(8) as $item)
                        <a href="{{ route('product-details', ['product' => $item->product->id]) }}">
                            <div class="d-flex no-block comment-row">
                                <div class="p-2">
                                    <span class="round">
                                        <img src="/{{ $item->user->avatar }}" alt="user" width="50" height="50">
                                    </span>
                                </div>
                                <div class="comment-text w-100">
                                    <h5 class="font-medium">{{ $item->user->name }}</h5>
                                    <p class="m-b-10 text-muted">{{ $item->body }}</p>
                                    <div class="comment-footer">
                                        <span
                                            class="text-muted pull-right ml-auto">{{ $item->created_at->format('d F, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
