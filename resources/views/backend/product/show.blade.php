@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="p-2">{{ $product->name }}</h3>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="white-box text-center"> <img src="/{{ $product->first_image }}" class="img-responsive">
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-6">
                            <h4 class="box-title">Product description</h4>
                            <p>{!! $product->description !!}</p>
                            <h2 class="m-t-40">{{ money($product->price) }}<small
                                    class="text-success"> ({{ $product->discount }}% off)</small></h2>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h3 class="box-title m-t-40">General Info</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td width="390">Name</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quantity</td>
                                            <td>{{ $product->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>{{ money($product->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount (%)</td>
                                            <td>{{ $product->discount }} %</td>
                                        </tr>
                                        <tr>
                                            <td>After Discount</td>
                                            <td>{{ money($product->after_discount) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sizes</td>
                                            <td>{{ $product->sizes->implode('name', ', ') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Colors</td>
                                            <td>{{ $product->colors->implode('name', ', ') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Category</td>
                                            <td>{{ $product->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sub Category</td>
                                            <td>{{ $product->subCategory->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ordered</td>
                                            <td>{{ $product->orders->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Reviews</td>
                                            <td>
                                                <a href="{{ route('product-details', ['product' => $product->id]) }}">View</a>
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
@endsection
