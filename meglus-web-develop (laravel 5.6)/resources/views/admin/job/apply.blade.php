@extends('admin.supply_admin' )

@section('title')
    {{__('supply.job.history')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')
@php($attentionText = [])
{{--    @include('supply_side.auth.active_code_modal')--}}

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bs-material/bootstrap-material-datetimepicker.css') }}" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/moment-with-locales.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bs-material/bootstrap-material-datetimepicker.css') }}" />

    <script language="JavaScript" type="text/javascript" src="{{ asset('js/job_apply.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/locate-all.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/job.js') }}"></script>

    <link href='{{ asset('css/fullcalendar.min.css') }}' rel='stylesheet' type='text/css'>
    <link href='{{ asset('css/fullcalendar.custom.css') }}' rel='stylesheet' type='text/css'>

    <!-- Full Width Column -->
    <div class="content-wrapper login-content" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box-2">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left form-inline">
                                <div class="col-sm-7">
                                    <span class="mg-r15 bold">{{__('supply.common.title_apply')}}</span>
                                    {{$job->workplace_name}}
                                    @if(isset($job->job_category))
                                        {{$job->job_category->name}}
                                    @endif
                                    @if(isset($job->job_description))
                                        ・{{$job->job_description->name}}
                                    @endif
                                </div>
                                <div class="col-sm-5 text-right">
                                    @if(isset($user->companyInfo) && isset($user->companyInfo->company_name))
                                    <span class="bold">{{$user->companyInfo->company_name}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- Messsage area -->
                    @include('inc.messages')
                    <!-- Content -->
                    <script>
                        var sortingData = {};
                        @if(isset($sort))
                            sortingData = {!! json_encode($sort) !!};
                        @endif
                    </script>
                    <div class="row table-header">
                        <div class="text-center col-sm-12 grid-b-b p-l-0 p-r-0 p-b-10 bold">
                            <div class="float-left text-center w-22 name"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'name')}}>応募者</a></div>
                            <div class="float-left text-center w-10 progress_status"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'progress_status')}}>進行状況</a></div>
                            <div class="float-left text-center w-10 updated_at"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'updated_at')}}>最終更新日</a></div>
                            <div class="float-left text-center w-40 seq"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'seq')}}>応募者とのコミュニケーション</a></div>
                            <div class="float-left text-center w-18 action color-blue">採用ステータス</div>
                        </div>
                    </div>
                    <div class="row table-body">
                        @foreach($applicant as $item)
                            @php($text =  Supply::generateAttentionText($jobFlow[$item->seq], $item) )
                            @if($text != null)
                                @php($attentionText[] = $text  )
                            @endif
                            @include('admin.job.apply_row')
                        @endforeach
                    </div>
                    <div class="p-t-15">
                        {{$applicant->appends(['sort' => $sort])->links('partials.pagination')}}
                    </div>
                </div>
            </section>
            @include('supply_side.job.apply_modal.default_popup')
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
@stop

@section('footer')
    @include('layouts.supply_side_footer')
@stop
