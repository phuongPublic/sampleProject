@extends('admin.supply_admin' )

@section('title')
    {{__('supply.job.setting')}}
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
                                <h3 class="box-title bold">{{__('supply.job.setting')}}</h3>
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

                                    <form class="form-horizontal demand_form" method="POST" href="{{route('admin.job.setting')}}" name="" id="setting-admin" >
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <h2 class="detail-title">Setting</h2>
                                            <br>
                                            @foreach($keys as $item)
                                                <div class="form-group row ">
                                                    <label for="" class="col-lg-2 control-label ">{{__('supply.keys.'.$item)}}</label>
                                                    <div class="col-lg-4">
                                                        @if ($item == 'max_job' || $item == 'max_salary')
                                                            <input type="number" min="0" required name="{{$item}}" value="{{$settings[$item]}}" class="form-control type-number" id="{{$item}}" >
                                                        @else
                                                            <input type="text" name="{{$item}}" value="{{$settings[$item]}}" class="form-control type-string" id="{{$item}}" >
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row-bottom text-center close-btn">
                                            <button type="submit" class="btn btn-primary mgt-20 bold"> 保存</button>
                                        </div>
                                    </form>

                                <script>
                                    $('#setting-admin').validate();
                                    $( 'input.type-number' ).rules( 'add', {
                                        required: true,
                                        min: 0,
                                        messages: {
                                            min: '0以上の値を入力してください。',
                                        }

                                    });
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

