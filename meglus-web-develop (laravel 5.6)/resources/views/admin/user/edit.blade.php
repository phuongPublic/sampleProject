@extends('admin.supply_admin' )

@section('title')
    {{__('supply.user.edit')}}
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
                                <h3 class="box-title bold">{{__('supply.user.edit')}}</h3>
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

                                    <form class="form-horizontal demand_form" method="POST" href="{{route('admin.user.edit',['id' => $user->id])}}" name="" id="" >
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <h2 class="detail-title">ユーザ名：{{$user->last_name}} {{$user->first_name}}</h2>
                                            <br>
                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">ログインID</label>
                                                <div class="col-lg-4">
                                                    <input type="text" value="{{$user->login_id}}" class="form-control " id="login_id" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">会社名</label>
                                                <div class="col-lg-4">
                                                    <input type="text" value="@if(isset($user->companyInfo->company_name)){{$user->companyInfo->company_name}}@endif" class="form-control " id="company_name" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">氏</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="first_name" value="{{$user->last_name}}" class="form-control " id="last_name">
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">名</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="last_name" value="{{$user->first_name}}" class="form-control " id="first_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-bottom text-center close-btn">
                                            <button type="submit" class="btn btn-primary mgt-20 bold" id="save-user-info"> 保存</button>
                                            <a href="{{ route('admin.user.index') }}" class="btn btn-primary mgt-20 bold " >戻る</a>
                                        </div>
                                    </form>
                                    <script>
                                        $('#save-user-info').click(function () {
                                            if (confirm("本当に保存しますか。")) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        })
                                    </script>

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

