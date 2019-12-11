@extends('admin.supply_admin' )

@section('title')
    {{__('supply.login.title')}}
@stop

@section('layouts.supply_side_header')
@stop

@section('header')
    @include('layouts.supply_side_header')
@stop

@section('content')
    <!-- Full Width Column -->
    <div class="content-wrapper login-content" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3 class="box-title bold text-center">{{__('supply.login.title')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- form start -->
                    <form class="form-horizontal user-login-form" method="post" href="{{route('supply_submit_login')}}" name="register_form" id="user_register_form">
                        <div class="box-body">

                            <div class="form-group row">
                                <label for="login_id_input" class="col-sm-4 col-md-3 control-label">{{__('supply.login.email')}}</label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="email" name="login_id" class="form-control" id="login_id_input" placeholder="{{__('supply.login.email')}}"
                                           required @if(isset($login_id)) value="{{$login_id}}" @endif>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_id" class="col-sm-4 col-md-3 control-label">{{__('supply.login.password')}}</label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="password" name="password" class="form-control  " id="password_id" placeholder="{{__('supply.login.password')}}" >
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-info center-block bg_blue text-light mgb-10">{{__('supply.login.title')}}</button>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                        {{ csrf_field() }}
                    </form>
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
