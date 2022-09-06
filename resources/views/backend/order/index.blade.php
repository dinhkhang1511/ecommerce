@extends('layouts.backend.app')
@section('content')
@php
 $page = $data->meta->current_page;
@endphp
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
                        <div class="float-left">
                            <a href="http://localhost:8888/api/excel/orders">
                                <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                            </a>
                        </div>

                        <div class="float-right">
                            <select class="form-control " id="sort-order" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="{{route('orders.index')}}" {{$status == 'status' ? 'selected' : ''}}> Status </option>
                                @foreach($allStatus as $index)
                                    <option value="{{route('orders.index')}}?status={{$index}}" {{strtolower($status) == strtolower($index) ? 'selected' : ''}}> {{$index}} </option>
                                @endforeach
                            </select>
                        </div>

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
                                <th>Created at</th>
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
                                <td>{{ $order->created_at }}</td>
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
                <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item {{$page == '1' ? 'disabled' : ''}} ">
                        <a class="page-link" href="{{route('orders.index')}}?page={{$page-1}}{{request('limit') ? '&limit='.request('limit') : ''}}{{request('status') ? '&status='.request('status') : ''}}" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item {{$page == $data->meta->last_page ? 'disabled' : ''}}" >
                        <a class="page-link" href="{{route('orders.index')}}?page={{$page+1}}{{request('limit') ? '&limit='.request('limit') : ''}}{{request('status') ? '&status='.request('status') : ''}}" >Next</a>
                      </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
