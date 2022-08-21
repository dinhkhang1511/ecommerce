@extends('layouts.backend.app')
@section('content')
@php
 $page = $data->meta->current_page;
@endphp
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Products</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Products Table</h4>
                <div class="table-responsive">
                    <a href="{{ $api_url . '/excel/products' }}">
                        <button type="button" class="btn btn-primary mb-3">EXCEL</button>
                    </a>
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" placeholder="Type to search" autofocus>
                    </div>
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Group Category</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->index + 1 + ($page - 1)*10}}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ money($product->price) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->parent_category }}</td>
                                <td>
                                    <a href="{{ route('products.show', ['product' => $product->id ]) }}"
                                        data-toggle="tooltip" data-original-title="View">
                                        <i class="fa fa-eye m-r-15" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('products.edit', ['product' => $product->id ]) }}"
                                        data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-pencil text-inverse m-r-10"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', ['product' => $product->id ]) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn-none" type="submit" onclick="return confirm('Are you really want to delete')" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fa fa-close text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item {{$page == '1' ? 'disabled' : ''}} ">
                        <a class="page-link" href="{{route('products.index')}}?page={{$page-1}}{{request('limit') ? '&limit='.request('limit') : ''}}" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item {{$page == $data->meta->last_page ? 'disabled' : ''}}" >
                        <a class="page-link" href="{{route('products.index')}}?page={{$page+1}}{{request('limit') ? '&limit='.request('limit') : ''}}" >Next</a>
                      </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
