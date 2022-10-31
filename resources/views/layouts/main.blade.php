<!doctype html>
<html lang="en">
<head>
    <title>@yield('title','Payroll')</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="A Financial Dashboard Panel for XARA CBS"/>
    <meta name="keywords" content="Xara, matatu sacco software, core banking system">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/logo/logo.png')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">

    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/font-awesome-n.min.css')}}">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/icon/feather/css/feather.css')}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/icon/icofont/css/icofont.css')}}">
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/assets/pages/advance-elements/css/bootstrap-datetimepicker.css')}}">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/bower_components/bootstrap-daterangepicker/css/daterangepicker.css')}}"/>
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/bower_components/datedropper/css/datedropper.min.css')}}"/>
    <!-- swiper css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/bower_components/swiper/css/swiper.min.css')}}">
    <!-- Form wizard css -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/bower_components/jquery.steps/css/jquery.steps.css')}}">
    <!-- list css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/pages/list-scroll/list.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bower_components/stroll/css/stroll.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/icon/themify-icons/themify-icons.css')}}">
    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/chartist/css/chartist.css')}}" type="text/css"
          media="all">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assets/css/widget.css')}}">
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/pages.css')}}">
    <style>
        #imagePreview {
            width: 180px;
            height: 180px;
            background-position: center center;
            background-size: cover;
            background-image: url("{{asset('/images/default_photo.png') }}");
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            display: inline-block;
        }

        #signPreview {
            width: 180px;
            height: 100px;
            background-position: center center;
            background-size: cover;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            background-image: url("{{asset('/images/sign_av.jpg') }}");
            display: inline-block;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('layouts.top_nav')
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('layouts.sidebar')
                    <div class="pcoded-content">
                        @yield('content')
                    </div>
                    <div id="styleSelector">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
@include('sweetalert::alert')
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/waves.min.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>

<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/modernizr.js')}}"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/css-scrollbars.js')}}"></script>

<script src="{{asset('assets/js/jquery.cookie.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/jquery.steps.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/jquery.validate.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>

<script src="{{asset('assets/js/underscore-min.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/moment.min.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/validate.js')}}"></script>

<script src="{{asset('assets/js/form-wizard.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/vertical-layout.min.js')}}" type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/jquery.mcustomscrollbar.concat.min.js')}}"
        type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script type="ce2668daaac54a74e9f6cdff-text/javascript" src="{{asset('assets/js/script.js')}}"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"
        type="ce2668daaac54a74e9f6cdff-text/javascript"></script>
<script src="{{asset('assets/js/rocket-loader.min.js')}}" data-cf-settings="ce2668daaac54a74e9f6cdff-|49"
        defer=""></script>

</html>
