@extends('layouts.frontend.app')
@section('content')
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <i class="fa fa-caret-right mx-2" aria-hidden="true"></i>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" value="{{ auth()->id() }}" name="user_id">
                    <input type="hidden" value="{{ $total }}" id="old_price">
                    <input type="hidden" value="{{ $total }}" name="price" id="price">
                    <input type="hidden" value="0" name="discount" id="discount">
                    <div class="row edit-input-btn">
                        <div class="col-lg-8 col-md-6 mb-5">
                            @guest
                                <h6 class="coupon__code">
                                    <i class="fa fa-tag"></i>
                                    Have an account?
                                    <a href="{{ route('login') }}">Click here to login</a>
                                </h6>
                            @endguest

                            <h6 class="checkout__title">Billing Details</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Full Name<span>*</span></p>

                                        <input type="text" placeholder="Full Name" name="customer_name" required
                                            autocomplete="off" value="{{ old('customer_name', $user->name ?? '') }}">

                                        @error('customer_name')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>

                                        <input type="text" placeholder="Phone number" required name="customer_phone"
                                            autocomplete="off" value="{{ old('customer_phone', $user->phone ?? '') }}">

                                        @error('customer_phone')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>

                                        <input type="text" placeholder="Email" name="customer_email" autocomplete="off"
                                            value="{{ old('customer_email', $user->email ?? '') }}">

                                        @error('customer_email')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Order notes</p>
                                        <input type="text" name="notes" value="{{ old('notes') }}"
                                            placeholder="Notes about your order, e.g. special notes for delivery.">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Address<span>*</span></p>

                                        <input type="text" placeholder="Your Address" class="checkout__input__add"
                                            autocomplete="off" name="customer_address"
                                            value="{{ old('customer_address', $user->address ?? '') }}">

                                        @error('customer_address')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 custom-nice-select mb-5 province">
                                    <div class="checkout__input">
                                        <p>Province<span>*</span></p>
                                        <select id="province" name="province_id">
                                            <option selected value="">Select province</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    {{ $province->id == old('province_id', $user->province_id ?? '') ? 'selected' : '' }}>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                            <div class="error error-nice-select">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 custom-nice-select district">
                                    <div class="checkout__input">
                                        <p>District<span>*</span></p>
                                        <select id="district" name="district_id">
                                            @foreach ($user->province->districts ?? [] as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ $district->id == $user->district_id ?? '' ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach

                                            @if (!($user->province_id ?? null))
                                                <option selected value="">Select District</option>
                                            @endif
                                        </select>
                                        @error('district_id')
                                            <div class="error error-nice-select">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 custom-nice-select ward">
                                    <div class="checkout__input">
                                        <p>Ward<span>*</span></p>
                                        <select id="ward" name="ward_id">
                                            @foreach ($user->district->wards ?? [] as $ward)
                                                <option value="{{ $ward->id }}"
                                                    {{ $ward->id == $user->ward_id ?? '' ? 'selected' : '' }}>
                                                    {{ $ward->name }}
                                                </option>
                                            @endforeach

                                            @if (!($user->district_id ?? null))
                                                <option selected value="">Select Ward</option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('ward_id')
                                        <div class="error error-nice-select">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="cart__discount">
                                <h6>Discount codes</h6>
                                <div>
                                    <input type="text" placeholder="Promos code" id="promos_code">
                                    <button type="button" id="apply_promos">Apply</button>
                                </div>
                            </div>
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products font-weight-bold">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach ($products as $product)
                                        @foreach ($cart[$product->id] as $index => $item)
                                            @php
                                                $attribute = $product->firstAttribute($item);
                                            @endphp

                                            <input type="hidden" name="size_id[]" value="{{ $item['size'] }}">
                                            <input type="hidden" name="color_id[]" value="{{ $item['color'] }}">
                                            <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}">
                                            <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                                            <input type="hidden" name="total[]"
                                                value="{{ $product->after_discount * $item['quantity'] }}">

                                            <li>
                                                <div>{{ $product->name }} - {{ $attribute->color->name }}<br>
                                                    Size: {{ $attribute->size->name }}
                                                </div>
                                                Quantity: {{ $item['quantity'] }}
                                                <span>{{ money($product->after_discount * $item['quantity']) }}</span>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Sub Total <span>{{ money($total) }}</span></li>
                                    <li>Discount <span id="order_discount">0%</span></li>
                                    <li>Total <span id="order_total">{{ money($total) }}</span></li>
                                </ul>
                                @if (!session()->has('paypal_paid') && $products->count() > 0)
                                    <p><b>PAYMENT METHODS</b></p>
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="cod" name="customRadio" class="custom-control-input"
                                                checked>
                                            <label class="custom-control-label fw-600 fs-15" for="cod">COD</label>

                                            <button type="button" class="info-paypal-btn" data-toggle="tooltip" data-placement="top" title="Pay on delivery">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="paypal" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label fw-600 fs-15" for="paypal">PAYPAL</label>

                                            <button type="button" class="info-paypal-btn" data-toggle="modal"
                                                data-target="#info_paypal_modal">
                                                <i class="fas fa-info-circle"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="info_paypal_modal" data-backdrop="static"
                                                data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                                PAYPAL ACCOUNT TEST
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Username : sb-47duhe6013914@personal.example.com</p>
                                                            <p>Password : 12345678</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="paypal-button" style="display: none"></div>
                                @elseif(session()->has('paypal_paid'))
                                    <p><b>You're paid by PAYPAL</b></p>
                                @endif
                                @if ($products->count() > 0)
                                    <button type="submit" class="site-btn" id="site-btn">
                                        PLACE ORDER
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
@endsection
