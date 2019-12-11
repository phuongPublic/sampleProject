<!-- header -->
<header class="masthead text-white text-center fixed-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand js-scroll-trigger" href="{{ route('admin.index') }}">
                <img class="logo" src="{{ asset('img/top-logo.png') }}">
            </a>

            <!-- Admin menu  -->
            @if(Auth::user() && Auth::user()->is_admin ==1)
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->last_name}} {{Auth::user()->first_name}}{{__('でログインしています。')}}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.job.category') }}">職種・職務内容マスター</a>
                        {{--<a class="dropdown-item" href="{{ route('admin.job.index',['sort[updated_at]' => 'DESC']) }}">Jobs list</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('supply.job.create') }}">Create job</a>--}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.otp.index') }}">認証コード管理</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.user.index') }}">サプライユーザリスト</a>
                        <a class="dropdown-item" href="{{ route('admin.demand.index') }}">求職者リスト</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.applicant.index') }}">応募者リスト</a>
                        <a class="dropdown-item" href="{{ route('admin.company.index') }}">企業リスト</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.kpi.index') }}">KPI情報</a>
                        <a class="dropdown-item" href="{{ route('admin.celebration.index') }}">お祝い金管理</a>
                        <div class="dropdown-divider"></div>

                        {{--TODO--}}
                        @php
                            $listGroup = \App\Model\CodeMst::LIST_GROUP;
                        @endphp
                        @foreach($listGroup as $group)
                            <a class="dropdown-item" href="{{ route('admin.setting.group', ['group' => $group]) }}">{{__('supply.menu.'.$group)}}</a>
                        @endforeach

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.job.setting') }}">ジョブをインストールする</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('supply_logout') }}">{{__('ログアウト')}}</a>
                    </div>
                </div>
            @endif
        </div>
    </nav>
</header>

