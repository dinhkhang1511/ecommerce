@php
    if(session('user'))
        $user = session('user');
    else
        $user = '';
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{$api_asset_url .'images/favicon.svg' }}">
    <title>{{ $setting->site_title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bundle/frontend/app.css') }}" type="text/css" />
    @yield('css')
</head>

<body>
    <div class="position-fixed p-3 toast-wrapper">
        <div id="liveToastSuccess" class="alert alert-success alert-dismissible" role="alert">
            {{ $success ?? 'Operation successful' }}
            <button type="button" class="close" id="close_success">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <div class="position-fixed p-3 toast-wrapper">
        <div id="liveToastError" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $error ?? 'Operation failed' }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                @if($user)
                    <a href="/logout">Log out</a>
                    @if (strcmp('Admin',$user->roles) == 0)
                        <a href="/dashboard">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="{{route('shop')}}" class="search-switch">
                <i class="fa fa-search"></i>
            </a>
            <a href="{{ route('wishlist.index') }}">
                <i class="far fa-heart"></i>
            </a>
            <a href="{{ route('cart.index') }}">
                <i class="fas fa-shopping-bag"></i>
                <span class="badge rounded-pill bg-warning">{{ $cart_amount }}</span>
            </a>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>

    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="header__top__left">
                            @if(!$user)
                                <p>“Just do it.”</p>
                            @else
                                <p>Hello {{$user->name}}</p>
                            @endif

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="header__top__right">
                            <div class="header__top__links">
                                @if(!$user)
                                    <a href="{{ url('login') }}">Login</a>
                                    <a href="{{ route('register') }}">Register</a>
                                @else
                                    <a href="/logout">Log out</a>
                                    @if (strcmp('Admin',$user->roles) == 0)
                                        <a href="/dashboard">Dashboard</a>
                                    @endif
                                @endauth
                            </div>
                            @if(isset($user) && !empty($user))
                                <div class="header__top__hover my-profile">
                                    <span>My Profile <i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    <ul>
                                        <li>
                                            <a href="{{ url('edit-profile') }}">Update Profile</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('edit-password') }}">Change Password</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 d-flex align-items-center">
                    <div class="header__logo">
                        <a href="/">
                            <div class="main">
                                <span>A</span>
                                <span>D</span>
                                <span>I</span>
                                <span>K</span>
                                <span>E</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li @if (url()->current() == url('/')) class="active" @endif>
                                <a href="/">Home</a>
                            </li>
                            <li @if (url()->current() == url('shop')) class="active" @endif>
                                <a href="{{ route('shop') }}">Shop</a>
                            </li>
                            <li @if (url()->current() == url('all-blogs')) class="active" @endif>
                                <a href="{{ url('all-blogs') }}">Blog</a>
                            </li>
                            <li @if (url()->current() == url('contact/create')) class="active" @endif>
                                <a href="{{ route('contact.create') }}">Contacts</a>
                            </li>
                            <li @if (url()->current() == url('checkout/create')) class="active" @endif>
                                <a href="{{ route('checkout.create') }}">Checkout</a>
                            </li>
                            <li class="mobile-only">
                                <a href="{{ url('edit-profile') }}">Update Profile</a>
                            </li>
                            <li class="mobile-only">
                                <a href="{{ url('edit-password') }}">Change Password</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="{{route('shop')}}" class="search-switch-new">
                            <i class="fa fa-search"></i>
                        </a>
                        <a href="{{ route('wishlist.index') }}">
                            <i class="far fa-heart"></i>
                        </a>
                        <a href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-bag"></i>
                            {{-- $cart_amount in AppServiceProvider --}}
                            <span class="badge rounded-pill bg-warning" id="cart_amount">{{ $cart_amount }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="/">
                                <div class="main">
                                    <span>A</span>
                                    <span>D</span>
                                    <span>I</span>
                                    <span>K</span>
                                    <span>E</span>
                                </div>
                            </a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#">
                            <img src="{{ $api_asset_url. 'images/details-payment.png' }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            @foreach ($sub_categories_footer as $item)
                                <li><a
                                        href="{{ route('shop', ['subcategory' => $item->id]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                            <li><a href="{{ route('shop', ['sale' => 'yes']) }}">Sale off</a></li>
                            <li><a href="{{ url('order-checking') }}">Search Order</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Contact</h6>
                        <ul>
                            <li><a href="{{ route('contact.create') }}">Contact Us</a></li>
                            <li><a href="tel:0932177045">0932177045</a></li>
                            <li><a href="mailto:dinhkhang1511@gmail.com">dinhkhang1511@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget newslatter">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><i class="fa fa-envelope-square"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <p>
                            {{ $setting->copyright_text }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <a id="button"></a>
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form action="{{ route('shop') }}" class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here....." name="name" autocomplete="off">
            </form>
        </div>
    </div>

    <script src="{{ asset('bundle/frontend/app.js') }}"></script>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
        <symbol id="star" viewBox="0 0 26 28">
            <path
                d="M26 10.109c0 .281-.203.547-.406.75l-5.672 5.531 1.344 7.812c.016.109.016.203.016.313 0 .406-.187.781-.641.781a1.27 1.27 0 0 1-.625-.187L13 21.422l-7.016 3.687c-.203.109-.406.187-.625.187-.453 0-.656-.375-.656-.781 0-.109.016-.203.031-.313l1.344-7.812L.39 10.859c-.187-.203-.391-.469-.391-.75 0-.469.484-.656.875-.719l7.844-1.141 3.516-7.109c.141-.297.406-.641.766-.641s.625.344.766.641l3.516 7.109 7.844 1.141c.375.063.875.25.875.719z" />
        </symbol>
    </svg>

    @if(isset($success) || $success = session('success'))
        <script>
            $("#liveToastSuccess").show();
            $("#liveToastSuccess").delay(1500).slideUp(200, function() {
                $(this).hide();
            });

        </script>
    @endif

    @if(isset($error) || $error = session('error'))
        <script>
            $("#liveToastError").show();
            $("#liveToastError").delay(1500).slideUp(200, function() {
                $(this).hide();
            });

        </script>
    @endif

    @yield('script')
</body>

</html>
