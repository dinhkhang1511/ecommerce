<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.svg') }}">
    <title>500</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/error-pages.css') }}" rel="stylesheet">
</head>

<body class="skin-default-dark fixed-layout">
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>500</h1>
                <h3 class="text-uppercase">INTERNAL SERVER ERROR !</h3>
                <p class="text-muted m-t-30 m-b-30">PLEASE TRY AFTER SOME TIME</p>
                <a href="{{ route('home') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>
</html>