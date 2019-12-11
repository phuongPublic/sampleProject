<!-- header -->
<header class="masthead text-white text-center fixed-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand js-scroll-trigger" href="/">
                <img class="logo" src="{{ asset('img/top-logo.png') }}">
            </a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                {{__('Menu')}}
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                        @if(Auth::user())
                        <li class="nav-item nav-item-user ">
                            <p><a class="nav-link text-white link-to-mypage" href="{{ route('mypage', ['sort[updated_at]' => 'DESC']) }}"> {{Auth::user()->last_name}} {{Auth::user()->first_name}} {{__('でログインしています。')}}</a></p>
                            <p><a class="text-white bg_blue logout-btn" href="{{ route('supply_logout') }}"> {{__('ログアウト')}}</a></p>
                        </li>
                        @else
                        {{--<li class="nav-item bg_blue mg-r5">--}}
                            {{--<a class="nav-link text-white link-to-top-page " href="/">{{__('トップ')}}</a>--}}
                        {{--</li>--}}
                        <li class="nav-item  bg_blue">
                            <a class="nav-link text-white" href="{{ route('supply_login') }}">

                                {{__('アカウントをお持ちの')}}<br/>
                                企業様はこちら</a>
                        </li>
                        @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
