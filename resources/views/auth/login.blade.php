<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.svg') }}">
    <title>{{ $setting->site_title }}</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
</head>
<body class="skin-default card-no-border">
    <section id="wrapper">
        <div class="login-register" style="background-image:url({{ asset('images/login-register.jpeg') }});">
            <div class="login-box card">
                <div class="card-body">
                    @if ($errors->first())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST" class="form-horizontal form-material"
                        id="loginform">
                        @csrf
                        <h3 class="box-title m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" required placeholder="Email Address"
                                    autocomplete="off" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required placeholder="Password"
                                    autocomplete="off" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="login_as_admin">
                                    <label class="custom-control-label" for="login_as_admin">Continue as admin</label>
                                    <a href="/password/reset" id="to-recover" class="text-dark pull-right">
                                        <i class="fa fa-lock m-r-5"></i> Forgot password?
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                <div class="social">
                                    <a href="{{ url('auth/redirect/facebook') }}" class="btn btn-facebook"
                                        data-toggle="tooltip" title="Login with Facebook">
                                        <i aria-hidden="true" class="fa fa-facebook"></i>
                                    </a>
                                    <a href="{{ url('auth/redirect/google') }}" class="btn btn-googleplus"
                                        data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true"
                                            class="fa fa-google-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-info m-l-5">
                                    <b>Sign Up</b>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
