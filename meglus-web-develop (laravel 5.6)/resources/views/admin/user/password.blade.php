@extends('admin.supply_admin' )

@section('title')
    {{__('supply.user.password')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')
    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left">
                                <h3 class="box-title bold">{{__('supply.user.password')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- Messsage Error -->
                @include('admin.inc.messages')
                    <div class="admin-content ">
                        <div class="box-body">
                            <div class="modal-body">
                                <div class="row-bottom">

                                    <form class="form-horizontal demand_form" method="POST" href="{{route('admin.user.password',['id' => $user->id])}}" name="" id="" >
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <h2 class="detail-title">ユーザ名: {{$user->last_name}} {{$user->first_name}}</h2>
                                            <br>
                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">パスワード</label>
                                                <div class="col-lg-4">
                                                    <input type="password" name="password" value="{{old('password')}}" class="form-control " id="password" >
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">パスワード（確認）</label>
                                                <div class="col-lg-4">
                                                    <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control password_confirmation" id="password_confirmation" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-bottom text-center close-btn">
                                            <button type="submit" class="btn btn-primary mgt-20 bold"> 保存</button>
                                            <a href="{{ route('admin.user.index') }}" class="btn btn-primary mgt-20 bold " >戻る </a>
                                        </div>
                                    </form>


                                </div>


                            </div>

                        </div>


                    </div>
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

