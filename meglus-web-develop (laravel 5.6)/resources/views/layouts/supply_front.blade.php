<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', \Config::get('site.name', '') . ' | Supply Side Dashboard')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-language" content="ja">


    <!-- App csrf_token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Assets -->
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layout.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery/jquery-ui.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery/jquery-ui.theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery/jquery-ui.structure.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery/jquery.timepicker.css') }}" />
    <!-- Page css -->
    @yield('css')

<!-- Main JS File -->
    {{--    <script type="text/javascript" src="{{ asset('js/app.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/jquery/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery.inputmask.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery.timepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/common.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
    <!-- Language -->
    <script type="text/javascript" src="{{asset('js/lang.js')}}"></script>
    <!-- Page javascript -->
    @yield('js')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <!-- Setup Headers -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var pageUrl = '{!! url()->current() !!}';
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133195785-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-133195785-1');
    </script>


</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav user-page">
<div class="wrapper">
    @include('layouts.supply_side_header')
    @yield('content')
    @include('layouts.supply_side_footer')
    <div class="loader_gb">
        <div class="loader"></div>
    </div>
    <div class="move_top">

    </div>
</div>
<!-- ./wrapper -->
</body>
</html>
