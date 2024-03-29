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
                    <form action="{{ route('update-password') }}" class="form-horizontal form-material" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h3 class="box-title m-b-20">Reset Password</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email','') }}" required autocomplete="email"
                                    autofocus placeholder="Email"> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Comfirm password">
                            </div>
                        </div>
                        <div class="form-group text-center p-b-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg text-uppercase waves-effect waves-light"
                                    type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
