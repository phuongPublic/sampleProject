<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', \Config::get('site.name', '')) | Supply Side Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-language" content="ja">
    <!-- App csrf_token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Assets -->
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery/jquery-ui.theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layout.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/admin.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />
    <!-- Page css -->
    @yield('css')


    <!-- Language -->
    <script type="text/javascript" src="{{asset('js/lang.js')}}"></script>
    <!-- Page javascript -->
@yield('js')

    <!-- Main JS File -->
    <script type="text/javascript" src="{{ asset('js/jquery/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery.inputmask.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery/jquery.validate.js') }}"></script>
{{--    <script type="text/javascript" src="{{ asset('js/app.js')}}"></script>--}}
    <script src="{{ asset('js/common.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
    <script src="{{ asset('admin_assets/js/admin.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>


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


</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav is-admin">
<div class="wrapper admin-wrapper">
    @include('admin.supply_admin_header')
    @yield('content')
    @include('admin.supply_admin_footer')
    <div class="loader_gb">
        <div class="loader"></div>
    </div>
</div>
<!-- ./wrapper -->
</body>
</html>
