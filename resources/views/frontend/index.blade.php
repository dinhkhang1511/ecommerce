@extends('layouts.frontend.app')
@section('content')
    <section class="hero">
        <div class="hero__slider owl-carousel" id="background">
            <div class="hero__items set-bg" data-setbg="{{ asset('images/background_1.jpeg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.
                                </p>
                                <a href="{{ route('shop') }}" class="primary-btn">Shop now <span
                                        class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('images/background_2.jpeg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.
                                </p>
                                <a href="{{ route('shop') }}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="carouselExampleIndicators" class="carousel slide mt-3 mb-5" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ $api_asset_url . 'images/background_1.jpeg' }}" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="{{ $api_asset_url . 'images/background_2.jpeg' }}" class="d-block w-100">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <section class="banner spad">
        <div class="container">
            <div class="row">
                @php
                    $classes = ['', 'banner__item--middle', 'banner__item--last'];
                @endphp
                @foreach ($categories as $index => $item)
                    <div class="col-lg-{{ $index == 1 ? 5 : 7 }} @if ($index==0) offset-lg-4 @endif">
                        <div class="banner__item {{ $classes[$index] }}">
                            <div class="banner__item__pic">
                                <img width="450" height="450" src="{{ $api_asset_url . $item->image_path }}" />
                            </div>
                            <div class="banner__item__text">
                                <h2>{{ $item->name }}</h2>
                                <a href="{{ route('shop', ['category' => $item->id]) }}">Shop now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="product spad">
        @if (count($bestSellers) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Best Sellers</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="best-seller" class="owl-carousel">
                        @foreach ($bestSellers as $product)
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
                                        <a href="{{ route('product-details', ['product' => $product->id]) }}" class="add-cart">+ Add To Cart</a>
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
        @endif

        @if (count($newArrivals) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>New Arrivals</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="new-arrivals" class="owl-carousel">
                        @foreach ($newArrivals as $product)
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
                                                <span>{{ money($product->price) }}</span> @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if (count($hotSales) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Hot Sales</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="hot-sales" class="owl-carousel">
                        @foreach ($hotSales as $product)
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
                                                <span>{{ money($product->price) }}</span> @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </section>
    {{-- @if (isset($album) && $album)
        <section class="instagram spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Our gallery</span>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="instagram__pic">
                            @foreach ($album->images as $item)
                                <div class="instagram__pic__item set-bg" data-setbg="{{$api_asset_url . $item->path }}"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="instagram__text text-center">
                            <h2>{{ $album->title }}</h2>
                            <p>{{ $album->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}
    @if (count($blogs) > 0)
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="blog">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="{{$api_asset_url . $blog->image_path }}"></div>
                            <div class="blog__item__text">
                                <span><i class="far fa-calendar"></i> {{ date("d-m-Y",strtotime($blog->created_at))}}</span>
                                <h5>{{ $blog->title }}</h5>
                                <a href="{{ route('blog-details', ['blog' => $blog->id]) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <a href="{{ url('all-blogs') }}">
                    <button type="button" class="site-btn mt-5 loadmore">
                        Load more
                    </button>
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection
