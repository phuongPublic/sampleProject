@extends('layouts.supply_user' )

@section('title')
    ホーム
@stop

@section('header')
    @include('layouts.supply_side_header_guest')
@stop

@section('content')
    <!-- Full Width Column -->
    <div class="content-wrapper login-content" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <!-- Messsage flash -->
                @include('inc.messages')
                <!-- Messsage Error -->
                @include('inc.messages_right')
                <!-- form start -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3 class="box-title bold text-center">{{$sample}}</h3>
                                <p><a href="/mypage">マイページへ</a></p>
                                <p><a href="{{route('supply.user.password')}}">パスワードを変更する</a></p>
                                <p><a href="{{route('supply.user.reset-password')}}">reset password</a></p>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
@stop

@section('footer')
    @include('layouts.supply_side_footer')
@stop
