<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="/" class="navbar-brand"><b>メグ</b>ラスラボ</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li @if(\Request::route()->getName() == 'supply_homepage')class="active"@endif><a href="/">{{__('supply.header.home')}}</a></li>
                    <li @if(\Request::route()->getName() == 'supply_company_profile')class="active"@endif><a href="#">{{__('supply.header.profile')}}</a></li>
                    <li @if(\Request::route()->getName() == 'supply_vision')class="active"@endif><a href="#">{{__('supply.header.vision')}}</a></li>
                    <li @if(\Request::route()->getName() == 'supply_contact')class="active"@endif><a href="#">{{__('supply.header.contact')}}</a></li>
                    <li @if(\Request::route()->getName() == 'supply_login')class="active"@endif><a href="{{route('supply_login')}}">{{__('supply.header.login')}}</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('supply.header.language')}} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{route('set_locale', 'ja')}}">
                                    @if(\App::isLocale('ja'))<i class="fa fa-check text-aqua"></i>@endif {{__('supply.header.language_japanese')}}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{route('set_locale', 'vi')}}">
                                    @if(\App::isLocale('vi'))<i class="fa fa-check text-aqua"></i>@endif {{__('supply.header.language_vietnamese')}}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{route('set_locale', 'en')}}">
                                    @if(\App::isLocale('en'))<i class="fa fa-check text-aqua"></i>@endif {{__('supply.header.language_english')}}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{route('set_locale', 'hi')}}">
                                    @if(\App::isLocale('hi'))<i class="fa fa-check text-aqua"></i>@endif {{__('supply.header.language_hiragana')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
