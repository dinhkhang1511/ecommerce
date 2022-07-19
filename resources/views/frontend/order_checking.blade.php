@extends('layouts.frontend.app')
@section('content')
    <section class="checkout">
        <div class="container">
            <div class="checkout__form">
                <form action="{{ route('checking-order') }}" method="POST">
                    @csrf
                    <div class="row edit-input-btn">
                        <div class="col-12">
                            <h6 class="checkout__title">ORDER CHECK</h6>
                            <div class="row justify-content-md-center align-items-center">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Order No <span>*</span></p>
                                        <input type="text" name="order_no" placeholder="Order No"
                                            value="{{ old('order_no') }}" autocomplete="off">
                                        @error('order_no') 
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="site-btn mt-3 mb-5">CHECK</button>
                </form>
            </div>
        </div>
    </section>

    @isset($order)
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Products</th>
                                    <th>Order Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->order_no }}</td>
                                    <td>
                                        <button type="submit" class="site-btn mt-3 mb-5" data-toggle="modal" data-target="#modelId">VIEW</button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Products</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                    </div>
                                                    <div class="modal-body">
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
                                    </td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>{{ money($order->price) }}</td>
                                    <td>
                                        <span class="status {{ $order->status_color }}">{{ $order->status }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="{{ route('shop') }}">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endisset
@endsection
