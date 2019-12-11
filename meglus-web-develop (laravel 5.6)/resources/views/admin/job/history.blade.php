@extends('admin.supply_admin' )

@section('title')
    {{__('supply.job.history')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')
    {{--{{dd($statusCd)}}--}}
    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left">
                                <h3 class="box-title bold">{{__('supply.job.history')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- Messsage Error -->
                @include('inc.messages')
                    <div class="admin-content ">
                        <div class="row table-header">
                            <div class="text-center col-sm-12 grid-b-b p-l-0 p-r-0 p-b-10 bold">
                                <div class="float-left text-center w-25 p-l-5 p-r-5 "><a href="javascript:void(0)">日時</a></div>
                                <div class="float-left text-center w-25 p-l-5 p-r-5 "><a href="javascript:void(0)">更新者</a></div>
                                <div class="float-left text-center w-25 p-l-5 p-r-5 "><a href="javascript:void(0)">変更前ステータス</a></div>
                                <div class="float-left text-center w-25 p-l-5 p-r-5 "><a href="javascript:void(0)">変更後のステータス</a></div>
                            </div>
                        </div>
                        <div class="row table-body" id="table-job-list">
                            @foreach ($history as $item)
                                <div class="text-center col-sm-12 table-row row-{{$item->job_id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->job_id}}"  data-id="{{$item->job_id}}">

                                    <div class="float-left text-center w-25 p-l-5 p-r-5 ">
                                        {{date('Y年月m日d h:i', strtotime($item->created_at))}}
                                    </div>

                                    <div class="float-left text-center w-25 p-l-5 p-r-5 border-left">
                                        @if(isset($item->owner))
                                            {{$item->owner->first_name.$item->owner->last_name}}
                                        @endif
                                    </div>

                                    <div class="float-left text-center w-25 p-l-6 p-r-5 border-left">
                                        @if($item->status_before == null)
                                            -
                                        @else
                                            @if($item->status_before == 1)
                                                <a href="{{route('admin.job.detailHistory',['id' => $item->id])}}">{{$statusCd[$item->status_before]}}</a>
                                            @else
                                            {{$statusCd[$item->status_before]}}
                                            @endif
                                        @endif
                                    </div>

                                    <div class="float-left text-center w-25 p-l-6 p-r-5 border-left">
                                        @if($item->status_after == null)
                                            -
                                        @else
                                            @if($item->status_after == 1)
                                                <a href="{{route('admin.job.detailHistory',['id' => $item->id])}}">{{$statusCd[$item->status_after]}}</a>
                                            @else
                                                {{$statusCd[$item->status_after]}}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $history->links('partials.pagination') }}
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
