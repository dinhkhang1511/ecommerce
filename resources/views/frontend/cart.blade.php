@extends('layouts.frontend.app')
@section('content')
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    foreach ($products as $product)
                                    {
                                        $attributes = collect($product->attributes);
                                        foreach ($cart[$product->id] as $index => $item)
                                        {
                                            $filtered = $attributes->filter(function($value,$key) use($item)
                                            {
                                                if($value->size_id == $item['size'] && $value->color_id == $item['color'])
                                                    return $value;
                                            });
                                            $attribute = $filtered->first();

                                @endphp
                                        <tr>
                                            <input type="hidden" value="{{ $index }}" id="indexValue">
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic mb-3">
                                                    <img src="{{$attribute->images[0] ? $api_asset_url . $attribute->images[0]->path : '' }}" alt="">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>
                                                        <a
                                                            href="{{ route('product-details', ['product' => $product->id]) }}">
                                                            {{$product->name}}
                                                        </a>
                                                    </h6>
                                                    <input type="hidden" id="price_after_discount"
                                                        value="{{ $product->after_discount }}">
                                                    <h5>{{ money($product->after_discount) }}</h5>
                                                    <div class="mt-2">
                                                        <span class="font-weight-bold">Size: </span>
                                                        {{ $attribute->size->name }}
                                                    </div>
                                                    <div class="mt-2 div-color"  >
                                                        <span class="font-weight-bold">Color: </span>
                                                        <div class="color-circle" style="background: {{ $attribute->color->code }};"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <div class="pro-qty-2">
                                                        <input type="hidden" value="{{ $product->id }}"
                                                            name="product_id[]" id="product_id">
                                                        <input type="hidden" value="{{ $attribute->product_quantity }}"
                                                            id="max_qty">
                                                        <span class="fa fa-angle-left dec qtybtn decrease"></span>
                                                        <input type="text" value="{{ $item['quantity'] }}"
                                                            name="quantity{{ $product->id }}[]" class="quantityValue">
                                                        <span class="fa fa-angle-right inc qtybtn increase"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                {{ money($product->after_discount * $item['quantity']) }}
                                            </td>
                                            <td class="cart__close">
                                                <button type="button" class="btn deleteBtn">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                @php
                                    }};
                                @endphp
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
                <div class="col-lg-4">
                    <div class="cart__total mt-5">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Total <span id="total_price">{{ money($total) }}</span></li>
                        </ul>
                        <a href="{{ route('checkout.create') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
