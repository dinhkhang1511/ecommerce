<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16"
    href="{{ asset('images/favicon.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->site_title }}</title>
    <link href="{{ asset('backend/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body class="skin-purple fixed-layout">
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header d-flex justify-content-center">
                    <a class="navbar-brand" href="/">
                        <b>
                            adike
                        </b>
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark"
                                href="javascript:void(0)">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                                href="javascript:void(0)">
                                <i class="icon-menu"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-bell"></i>
                                @if (count($current_user->unread_notifications) > 0)
                                <div class="notify">
                                    <span class="heartbit"></span>
                                    <span class="point"></span>
                                </div>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            @foreach ($current_user->unread_notifications as $item)
                                            <a href="{{ $item->data->url }}?notification={{ $item->id }}">
                                                <div class="btn btn-danger btn-circle">
                                                    <i class="{{ $item->data->icon ?? 'fas fa-wallet' }}"></i>
                                                </div>
                                                <div class="mail-contnet">
                                                    <h5>{{ $item->data->title }}</h5>
                                                    <span class="mail-desc">{{ $item->data->body }}</span>
                                                    <span class="time">{{ date('d-m H:i', strtotime($item->created_at))}}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link"
                                        href="{{ count($current_user->unread_notifications) > 0 ? route('mark-all-as-read') : '#'}}">
                                            <strong>Mark all notifications as read</strong> <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </li>

                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="/{{ $current_user->avatar ?? '' }}">
                                <span class="hidden-md-down">{{ $current_user->name ?? '' }} &nbsp;
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="{{ url('edit-profile') }}" class="dropdown-item">
                                    <i class="ti-user"></i> My Profile
                                </a>
                                <a href="javascript:void(0)" class="dropdown-item">
                                    <i class="ti-wallet"></i> My balance
                                </a>
                                {{-- <a href="{{ route('send-email.create') }}" class="dropdown-item">
                                    <i class="ti-email"></i> Inbox
                                </a> --}}
                                <a href="{{ url('logout') }}" class="dropdown-item">
                                    <i class="fa fa-power-off"></i> Logout
                                </a>
                            </div>
                        </li>

                        <li class="nav-item right-side-toggle">
                            <a class="nav-link  waves-effect waves-light" href="javascript:void(0)">
                                <i class="ti-settings"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        @include('layouts.backend.left_sidebar')

        <div class="page-wrapper">
            <div class="container-fluid">

                @yield('content')

                @include('layouts.backend.right_sidebar')
            </div>
        </div>

        <footer class="footer">
            {{ $setting->copyright_text }}
        </footer>

    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('backend/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/summernote.js') }}"></script>
    <script src="{{ asset('js/fontawesome.js') }}"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    @yield('script')
    @isset($success)
        <script>
            $.toast({
                heading: "Success",
                text: @json($success),
                position: "top-right",
                loaderBg: "#ff6849",
                icon: "success",
                hideAfter: 3500,
                stack: 6
            });
        </script>
    @endisset

    @isset($error)
        <script>
            $.toast({
                heading: "Failed",
                text: @json($error),
                position: "top-right",
                loaderBg: "#ff6849",
                icon: "error",
                hideAfter: 3500,
                stack: 6
            });
        </script>
    @endisset
</body>
</html>
