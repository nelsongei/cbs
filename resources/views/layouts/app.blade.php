<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'CBS')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/font-awesome-n.min.css') }}">
    <!-- Vegas CSS -->
    <link rel="stylesheet" href="{{ asset('css/vegas.min.css') }}">
    <!-- Flaticon CSS -->
    {{-- <link rel="stylesheet" href="https://affixtheme.com/html/xmee/demo/font/flaticon.css"> --}}
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
    <section class="fxt-template-animation fxt-template-layout29">
        <div class="container-fluid">
            <div class="row">
                <div class="vegas-container col-md-6 col-12 fxt-bg-img" id="vegas-slide"
                    data-vegas-options='{"delay":5000, "timer":true,"animation":"kenburnsUp", "transition":"swirlRight", "slides":[{"src": "images/research-growth.gif"}, {"src": "images/cloud-financials-infinite.gif"}, {"src": "images/56.gif"}]}'>
                    <div class="fxt-page-switcher">
                        <a href="{{ url('login') }}" class="switcher-text1 active">Login</a>
                        <a href="{{ url('register') }}" class="switcher-text1">Register</a>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </section>
    <!-- jquery-->
    <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Imagesloaded js -->
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Vegas js -->
    <script src="{{ asset('js/vegas.min.js') }}"></script>
    <!-- Validator js -->
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
