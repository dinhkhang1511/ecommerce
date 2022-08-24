@extends('layouts.frontend.app')
@section('css')
    <link href="{{ asset('backend/lightbox/css/lightbox.css') }}" rel="stylesheet" />
@endsection
@section('script')
    <script src="{{ asset('js/product_details.js') }}"></script>
    <script src="{{ asset('backend/lightbox/js/lightbox.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 10,
            'wrapAround': true,
            'disableScrolling': true
        })

    </script>
@endsection
@section('content')
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="/">Home</a>
                            <i class="fa fa-caret-right mx-2" aria-hidden="true"></i>
                            <a href="{{ route('shop') }}">Shop</a>
                            <i class="fa fa-caret-right mx-2" aria-hidden="true"></i>
                            <span>{{ $product->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6 col-md-9 mb-5">
                        <div class="tab-content">
                            <div class="product__details__pic__item">
                                <a href="{{$api_asset_url . $product->first_image }}" data-lightbox="main-image" id="main-image-link">
                                    <img src="{{$api_asset_url . $product->first_image }}" class="img-thumbnail" id="main-image">
                                </a>
                            </div>
                        </div>
                        <div id="tab_image" class="owl-carousel mt-3">
                            @foreach ($product->attributes as $attributeKey => $attribute)
                                @foreach ($attribute->images as $imageKey => $image)
                                    <div class="tab-image @if ($attributeKey==0 && $imageKey==0) active @endif">
                                        <a href="#tab{{ $image->id }}">
                                            <input type="hidden" value="{{$api_asset_url . $image->path }}"
                                                id="attribute{{ $attribute->id }}">
                                            <div class="product__thumb__pic set-bg img-thumbnail"
                                                data-setbg="{{$api_asset_url . $image->path }}"></div>
                                        </a>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product__details__text">
                            <h4>{{ $product->name }}</h4>
                            <div class="rating">
                                @for ($i = 0; $i < $product->rating; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor

                                @for ($i = 5; $i > $product->rating; $i--)
                                    <i class="fa fa-star-o"></i>
                                @endfor
                                <span> - {{ count($reviews) }} Reviews</span>
                            </div>
                            <h3>
                                {{ money($product->after_discount) }}
                                @if ($product->discount > 0)
                                    <span>{{ money($product->price) }}</span>
                                @endif
                            </h3>
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <div class="product__details__option">
                                    <div class="product__details__option__size">
                                        <span>Size:</span>
                                        @foreach ($sizes as $item)
                                            <label for="size{{ $item->size_id }}" @if ($loop->first) class="active" @endif>
                                                {{ $item->size->name }}
                                                <input type="radio" id="size{{ $item->size_id }}"
                                                    value="{{ $item->size_id }}" name="size" @if ($loop->first) checked @endif
                                                    class="size">
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="product__details__option__color" id="colorWrapper">
                                        <span>Color:</span>
                                        @foreach ($colors as $item)
                                            <label class="color @if ($loop->first) active @endif" style="background:
                                                {{ $item->color->code }}">
                                                <input type="radio" name="color" value="{{ $item->color_id }}" @if ($loop->first) checked @endif>
                                                <i class="fas fa-check"></i>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="product__details__cart__option">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id"
                                                id="product_id">
                                            <input type="hidden" value="{{$product->price}}" id="price" name="price">
                                            <input type="hidden" value="{{$product->discount}}" id="discount" name="discount">
                                            <input type="hidden"
                                                value="{{ $product->attributes[0]->product_quantity }}"
                                                id="max_qty">
                                            <span class="fa fa-angle-up dec qtybtn" id="increase"></span>
                                            <input type="text" value="0" id="quantity" name="quantity">
                                            <span class="fa fa-angle-down inc qtybtn" id="decrease"></span>
                                        </div>
                                    </div>
                                    <button id="addToCartBtn" type="submit" class="primary-btn" disabled>add to
                                        cart</button>
                                </div>
                            </form>
                            <div class="product__details__btns__option">
                                <form action="{{ route('wishlist.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    <button type="submit" class="wishlist">
                                        <i class="fa fa-heart"></i> add to wishlist
                                    </button>
                                </form>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Guaranteed Safe Checkout</span></h5>
                                <ul>
                                    <li id="in_stock"><span>In stock:</span>
                                        {{ $product->attributes[0]->product_quantity }}</li>
                                    @if($product->category->parent)
                                        <li><span>Category:</span> {{ $product->category->parent->name }} > {{$product->category->name}}</li>
                                    @else
                                    <li><span>Category:</span> {{ $product->category->name }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#tabs-5" role="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                        Reviews</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Additional
                                        Information</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane active" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="row p-3">
                                            <button type="button"
                                                class="btn btn-primary button-reviews col-4">{{ count($reviews) }}
                                                reviews</button>
                                        </div>

                                        @if(isset($user->email))
                                            <div class="row p-3">
                                                <div class="row col-3 align-items-center">
                                                    <img src="{{$api_asset_url . $user->avatar }}" alt="" width="50"
                                                        class="mr-3 avatar">
                                                    <a href="{{ route('login') }}" class="font-weight-bold"
                                                        data-toggle="modal" data-target="#reviews" style="color: #9d9d9d">Click
                                                        to reviews</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row p-3">
                                                <div class="row col-3 align-items-center">
                                                    <img src="{{$api_asset_url}}images/avatar-default.svg" alt="" width="50" class="mr-3">
                                                    <a href="{{ route('login') }}" class="font-weight-bold"
                                                        style="color: #9d9d9d">Login to reviews</a>
                                                </div>
                                            </div>
                                        @endif



                                            <!-- Modal -->
                                            @include('frontend.modals.review')



                                        @foreach ($reviews as $review)
                                            <div class="row p-3 border-bottom">
                                                <div class="row col-3 align-items-start">
                                                    <img src="{{$api_asset_url . $review->user->avatar }}" alt="" width="50"
                                                        class="mr-3 avatar">
                                                    <div>
                                                        <p class="font-weight-bold">{{ $review->user->name }}</p>
                                                        <p>Joined at {{ date('d/m/y',strtotime($review->created_at)) }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="rating mb-2">
                                                        @for ($i = 0; $i < $review->rating; $i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor

                                                        @for ($i = 5; $i > $review->rating; $i--)
                                                            <i class="fa fa-star-o"></i>
                                                        @endfor
                                                        <span class="review_at"> - Reviewed at
                                                            {{ date('d/m/y',strtotime($review->updated_at)) }}</span>
                                                    </div>
                                                    <p>{{ $review->body }}</p>
                                                    <div>
                                                        @foreach ($review->images as $image)
                                                            <a href="{{$api_asset_url . $image->path }}"
                                                                data-lightbox="album{{ $review->id }}">
                                                                <img src="{{$api_asset_url . $image->path }}" class="image-review mr-2"
                                                                    width="120" height="120">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- <div class="mt-3">
                                        {{ $reviews->links() }}
                                    </div> --}}
                                </div>
                                <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                            pharetras loremos.
                                        </p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                                a touchscreen and touchpad.
                                            </p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                                $350.00, a new Pocket PC can now be purchased.
                                            </p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                                worn all year round.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Recent view</h3>
                </div>
            </div>
            <div class="row">
                <div id="recent-products" class="owl-carousel">
                    @foreach ($recentViewProducts as $product)
                        <div class="col-12">
                            <div class="product__item sale">
                                <div class="product__item__pic set-bg" data-setbg="{{$api_asset_url . $product->first_image }}">
                                    @if ($product->discount > 0)
                                        <span class="label">Sale</span>
                                    @endif
                                    <ul class="product__hover">
                                        <li>
                                            <form action="{{ route('wishlist.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                <button type="submit" class="wishlist">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="{{ route('product-details', ['product' => $product->id]) }}">
                                                <button type="submit" class="wishlist">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $product->name }}</h6>
                                    <a href="{{ route('product-details', ['product' => $product->id]) }}"
                                        class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        @for ($i = 0; $i < $product->rating; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor

                                        @for ($i = 5; $i > $product->rating; $i--)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    </div>
                                    <h5 class="discount">
                                        {{ money($product->after_discount) }}
                                        @if ($product->discount > 0)
                                            <span>{{ money($product->price) }}</span>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Product</h3>
                </div>
            </div>
            <div class="row">
                <div id="related-products" class="owl-carousel">
                    @foreach ($relatedProducts as $product)
                        <div class="col-12">
                            <div class="product__item sale">
                                <div class="product__item__pic set-bg" data-setbg="{{$api_asset_url . $product->first_image }}">
                                    @if ($product->discount > 0)
                                        <span class="label">Sale</span>
                                    @endif
                                    <ul class="product__hover">
                                        <li>
                                            <form action="{{ route('wishlist.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                <button type="submit" class="wishlist">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="{{ route('product-details', ['product' => $product->id]) }}">
                                                <button type="submit" class="wishlist">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $product->name }}</h6>
                                    <a href="{{ route('product-details', ['product' => $product->id]) }}"
                                        class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        @for ($i = 0; $i < $product->rating; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor

                                        @for ($i = 5; $i > $product->rating; $i--)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    </div>
                                    <h5 class="discount">
                                        {{ money($product->after_discount) }}
                                        @if ($product->discount > 0)
                                            <span>{{ money($product->price) }}</span>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
