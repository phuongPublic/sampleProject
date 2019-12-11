@extends('layouts.supply_job' )

@section('title')
    {{__('supply.common.title_result')}}
@stop

@section('layouts.supply_side_header')
@stop

@section('header')
    @include('layouts.supply_side_header')
@stop

@section('content')
    @php($attentionText = [])
    <!-- Full Width Column -->
    <div class="content-wrapper login-content" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box-2">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left form-inline">
                                <div class="col-sm-2">
                                    <span class="mg-r15">{{__('supply.common.title_result')}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <form action="{{route('supply.job.resultConfirm')}}" method="get">
                                        <input id="datepicker_confirm" type="month" name="month_filter" value="{{$monthFilter}}" width="312" />
                                        <input type="submit" id="set-month" style="display: none">
                                    </form>
                                </div>
                                <div class="col-sm-3 text-right">
                                    <a href="{{route('mypage')}}" class="btn btn-primary">
                                        マイページに戻る
                                    </a>
                                </div>
                                <div class="col-sm-3 text-right">
                                    @if(isset($user->companyInfo))
                                        {{$user->companyInfo->company_name}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- Messsage area -->
                @include('inc.messages')
                <!-- Content -->
                    <input type="hidden" id="job-apply-url" value="{{route('supply.job.resultConfirm')}}">
                    <script>
                        var sortingData = {};
                        @if(isset($sort))
                            sortingData = {!! json_encode($sort) !!};
                        @endif
                    </script>
                    <table class="table " >
                        <thead>
                        <tr class="text-center">
                            <th scope="col"></th>
                            <th scope="col" class="text-left"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'name')}}>名前</a></th>
                            <th scope="col" class="" width="125"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'seq_update_dt')}}>採用日時</a></th>
                            <th scope="col" class="" width="200"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'workplace_name')}}>勤務先名</a></th>
                            <th scope="col" class="" colspan="2"><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'job_category_cd')}}>職種</a></th>
                            <th scope="col" class=""><a href="javascript:void(0)" class="multiple-sort-apply" {{Supply::makeDataAttr($sort,'job_discription_cd')}}>職務内容</a></th>
                            <th scope="col" class="color-blue" colspan="2">採用報酬</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicant as $item)

                            <tr class="text-center">
                                <td scope="col" class="text-left" width="80">
                                    <img width="50" src="{{route('supply.user.avatar', ['id' => $item->demand_user_id])}}">
                                </td>
                                <td scope="col" class="text-left">
                                    <a href="javascript:void(0)" onclick="showUserInfo('{{$item->demand_user_id}}','{{$item->job->job_id}}');">{{$item->demandUser->name}}</a>
                                </td>
                                <td scope="col" width="125" class="">{{date('Y/m/d', strtotime($item->seq_update_dt))}}</td>
                                <td scope="col" width="200" class="">
                                    <a href="{{route('supply.job.detail', ['id' => $item->job->job_id])}}">
                                        {{ $item->job->workplace_name }}
                                    </a>
                                </td>
                                <td scope="col" class="text-center" >
                                    @if(isset($item->job->jobCategory) && isset($item->job->jobCategory->icon_filepath))
                                        <img width="30" src="{{$item->job->jobCategory->icon_filepath}}">
                                    @endif
                                </td>
                                <td scope="col" colspan="2" class="text-center">
                                    @if(isset($item->job->jobCategoryDescription->name))
                                        {{ $item->job->jobCategoryDescription->name }}
                                    @endif
                                </td>
                                <td scope="col" colspan="2" class="">
                                    <span>50,000円</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(request()->sort)
                        {{ $applicant->appends(['sort' => $sort,'month_filter' => $monthFilter])->links('partials.pagination') }}
                    @else
                        {{ $applicant->appends(['month_filter' => $monthFilter])->links('partials.pagination') }}
                    @endif
                </div>
            </section>
            <script>
                $(document).ready(function () {
                    $('#datepicker_confirm').val('{!! $monthFilter !!}');
                    $('#datepicker_confirm').change(function () {
                        $('#set-month').trigger( "click" );
                    });
                })
            </script>
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
