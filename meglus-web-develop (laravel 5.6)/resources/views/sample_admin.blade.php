@extends('admin.supply_admin' )

@section('title')
    {{__('supply.login.title')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('header')
    @include('admin.supply_admin_header')
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
    @include('admin.supply_admin_footer')
@stop
