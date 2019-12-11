@extends('admin.supply_admin' )

@section('title')
    {{__('supply.demand.password')}}
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
                                <h3 class="box-title bold">{{__('supply.demand.password')}}</h3>
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

                                    <form class="form-horizontal demand_form" method="POST" href="{{route('admin.demand.password',['id' => $demand->id])}}" name="demand_form" id="demand_form" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <h2 class="detail-title">update password for {{$demand->name}}</h2>
                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">password</label>
                                                <div class="col-lg-4">
                                                    <input type="password" name="password" value="{{old('password')}}" class="form-control " id="password" >
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">password_confirm</label>
                                                <div class="col-lg-4">
                                                    <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control password_confirmation" id="password_confirmation" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-bottom text-center close-btn">
                                            <button type="submit" class="btn btn-primary mgt-20 bold"> 保存</button>
                                            <a href="{{ url()->previous() }}" class="btn btn-primary mgt-20 bold " >以前に </a>
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

