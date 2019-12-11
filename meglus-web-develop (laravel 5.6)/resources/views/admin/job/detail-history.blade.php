@extends('admin.supply_admin' )

@section('title')
    {{__('supply.job.detailHistory')}}
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
                                <h3 class="box-title bold">{{__('supply.job.detailHistory')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- Messsage Error -->
                @include('inc.messages')
                    <div class="admin-content ">
                        <table width="100%" border="1px" class="table-job-compare">
                            <tr class="text-center">
                                <th width="10%">日時</th>
                                <th width="20%">大項目</th>
                                <th width="20%">中項目</th>
                                <th width="25%">小項目（変更前）</th>
                                <th width="25%">小項目（変更後）</th>
                            </tr>
                            <!-- 勤務先住所の入力 -->
                            <tr>
                                <td rowspan="40">
                                    <p class="p-l-15">編集された日時 <br/>
                                        {{date('Y/m/d h:i',strtotime($history->created_at))}}</p>

                                </td>
                                <td rowspan="2" class="text-center">{{__('supply.job.localtion')}}</td>
                                <td class="text-center">{{__('supply.job.workplace_name')}}</td>
                                <td class="p-l-15">{{$compare->workplace_name}}</td>
                                <td class="p-l-15">{{$job->workplace_name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_name_en')}}</td>
                                <td class="p-l-15">{{$compare->workplace_name_en}}</td>
                                <td class="p-l-15">{{$job->workplace_name_en}}</td>
                            </tr>
                            <!--勤務先住所の入力 -->
                            <tr>
                                <td rowspan="9" class="text-center">{{__('supply.job.work_localtion')}}</td>
                                <td class="text-center">{{__('supply.job.workplace_post_cd')}}</td>
                                <td class="p-l-15">{{$compare->workplace_post_cd}}</td>
                                <td class="p-l-15">{{$job->workplace_post_cd}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_prefecture')}}</td>
                                <td class="p-l-15">{{$compare->jobPrefectures->name}}</td>
                                <td class="p-l-15">{{$job->jobPrefectures->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_city1')}}</td>
                                <td class="p-l-15">{{$compare->workplace_city1}}</td>
                                <td class="p-l-15">{{$job->workplace_city1}}</td>
                            </tr>
                            <tr>
                                
                                <td class="text-center">{{__('supply.job.workplace_city2')}}</td>
                                <td class="p-l-15">{{$compare->workplace_city2}}</td>
                                <td class="p-l-15">{{$job->workplace_city2}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_address')}}</td>
                                <td class="p-l-15">{{$compare->workplace_detail_address}}</td>
                                <td class="p-l-15">{{$job->workplace_detail_address}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_building_name')}}</td>
                                <td class="p-l-15">{{$compare->workplace_building_name}}</td>
                                <td class="p-l-15">{{$job->workplace_building_name}}</td>
                            </tr>
                            <tr>
                                
                                <td class="text-center">{{__('supply.job.workplace_building_name_en')}}</td>
                                <td class="p-l-15">{{$compare->workplace_building_name_en}}</td>
                                <td class="p-l-15">{{$job->workplace_building_name_en}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_nearest_station_name')}}</td>
                                <td class="p-l-15">{{$compare->is_workplace_station}}</td>
                                <td class="p-l-15">{{$job->is_workplace_station}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.workplace_nearest_station_move_type')}}</td>
                                <td class="p-l-15">
                                    @if($compare->workplace_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="workplace_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$compare->workplace_nearest_station_move_time}} {{__('supply.job.workplace_nearest_station_move_time')}}</label>
                                </td>
                                <td class="p-l-15">
                                    @if($job->workplace_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="workplace_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$job->workplace_nearest_station_move_time}} {{__('supply.job.workplace_nearest_station_move_time')}}</label>
                                </td>
                            </tr>

                            <!-- 面接場所の入力 -->
                            <tr>
                                <td rowspan="9" class="text-center">{{__('supply.job.location_interview')}}</td>
                                <td class="text-center">{{__('supply.job.interview_place_post_cd')}}</td>
                                <td class="p-l-15">{{$compare->interview_place_post_cd}}</td>
                                <td class="p-l-15">{{$job->interview_place_post_cd}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_prefecture')}}</td>
                                <td class="p-l-15">{{$compare->jobInterViewPrefectures->name}}</td>
                                <td class="p-l-15">{{$job->jobInterViewPrefectures->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_city1')}}</td>
                                <td class="p-l-15">{{$compare->interview_city1}}</td>
                                <td class="p-l-15">{{$job->interview_city1}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_city2')}}</td>
                                <td class="p-l-15">{{$compare->interview_city2}}</td>
                                <td class="p-l-15">{{$job->interview_city2}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_detail_address')}}</td>
                                <td class="p-l-15">{{$compare->interview_detail_address}}</td>
                                <td class="p-l-15">{{$job->interview_detail_address}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_building_name')}}</td>
                                <td class="p-l-15">{{$compare->interview_building_name}}</td>
                                <td class="p-l-15">{{$job->interview_building_name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_building_name_en')}}</td>
                                <td class="p-l-15">{{$compare->interview_building_name_en}}</td>
                                <td class="p-l-15">{{$job->interview_building_name_en}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_nearest_station_name')}}</td>
                                <td class="p-l-15">{{$compare->is_interview_station}}</td>
                                <td class="p-l-15">{{$job->is_interview_station}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.interview_nearest_station_move_type')}}</td>
                                <td class="p-l-15">
                                    @if($compare->interview_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="interview_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$compare->interview_nearest_station_move_time}} {{__('supply.job.interview_nearest_station_move_time')}}</label>
                                </td>
                                <td class="p-l-15">
                                    @if($job->interview_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="interview_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$job->interview_nearest_station_move_time}} {{__('supply.job.interview_nearest_station_move_time')}}</label>
                                </td>
                            </tr>

                            <!-- 業務内容の入力 -->
                            <tr>
                                <td rowspan="4" class="text-center">{{__('supply.job.job_detail')}}</td>
                                <td class="text-center">{{__('supply.job.job_category_cd')}}</td>
                                <td class="p-l-15">{{$compare->jobCategory->name}}</td>
                                <td class="p-l-15">{{$job->jobCategory->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.job_discription_cd')}}</td>
                                <td class="p-l-15">{{$compare->jobCategoryDescription->name}}</td>
                                <td class="p-l-15">{{$job->jobCategoryDescription->name}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.min_salary')}}</td>
                                <td class="p-l-15">{{$compare->min_salary}}{{__('supply.job.unit')}}</td>
                                <td class="p-l-15">{{$job->min_salary}}{{__('supply.job.unit')}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.max_salary')}}</td>
                                <td class="p-l-15">{{$compare->max_salary}}{{__('supply.job.unit')}}</td>
                                <td class="p-l-15">{{$job->max_salary}}{{__('supply.job.unit')}}</td>
                            </tr>
                            <!-- 勤務時間の入力 -->
                            <tr>
                                <td rowspan="3" class="text-center">{{__('supply.job.job_time')}}</td>
                                <td class="text-center">{{__('supply.job.job_time_detail')}}</td>
                                <td class="p-l-15">
                                    @if($compareWorkingTime && isset($compareWorkingTime[1]))
                                        @php
                                            $unit_day = (isset($compareWorkingTime[1]) && isset($compareWorkingTime[1]['day'])) ? $compareWorkingTime[1]['day']:[];
                                            $unit_time_start = (isset($compareWorkingTime[1]) && $compareWorkingTime[1]['start_time'])?$compareWorkingTime[1]['start_time']:'';
                                            $unit_time_end = (isset($compareWorkingTime[1]) && isset($compareWorkingTime[1]['end_time']))? $compareWorkingTime[1]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if($jobWorkingTime && isset($jobWorkingTime[1]))
                                        @php
                                            $unit_day = (isset($jobWorkingTime[1]) && isset($jobWorkingTime[1]['day'])) ? $jobWorkingTime[1]['day']:[];
                                            $unit_time_start = (isset($jobWorkingTime[1]) && $jobWorkingTime[1]['start_time'])?$jobWorkingTime[1]['start_time']:'';
                                            $unit_time_end = (isset($jobWorkingTime[1]) && isset($jobWorkingTime[1]['end_time']))? $jobWorkingTime[1]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center">{{__('supply.job.job_time_detail_2')}}</td>
                                <td class="p-l-15">
                                    @if($compareWorkingTime && isset($compareWorkingTime[2]))
                                        @php
                                            $unit_day = (isset($compareWorkingTime[2]) && isset($compareWorkingTime[2]['day'])) ? $compareWorkingTime[2]['day']:[];
                                            $unit_time_start = (isset($compareWorkingTime[2]) && $compareWorkingTime[2]['start_time'])?$compareWorkingTime[2]['start_time']:'';
                                            $unit_time_end = (isset($compareWorkingTime[2]) && isset($compareWorkingTime[2]['end_time']))? $compareWorkingTime[2]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if($jobWorkingTime && isset($jobWorkingTime[2]))
                                        @php
                                            $unit_day = (isset($jobWorkingTime[2]) && isset($jobWorkingTime[2]['day'])) ? $jobWorkingTime[2]['day']:[];
                                            $unit_time_start = (isset($jobWorkingTime[2]) && $jobWorkingTime[2]['start_time'])?$jobWorkingTime[2]['start_time']:'';
                                            $unit_time_end = (isset($jobWorkingTime[2]) && isset($jobWorkingTime[2]['end_time']))? $jobWorkingTime[2]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center">{{__('supply.job.job_time_detail_3')}}</td>
                                <td class="p-l-15">
                                    @if($compareWorkingTime && isset($compareWorkingTime[2]))
                                        @php
                                            $unit_day = (isset($compareWorkingTime[2]) && isset($compareWorkingTime[2]['day'])) ? $compareWorkingTime[2]['day']:[];
                                            $unit_time_start = (isset($compareWorkingTime[2]) && $compareWorkingTime[2]['start_time'])?$compareWorkingTime[2]['start_time']:'';
                                            $unit_time_end = (isset($compareWorkingTime[2]) && isset($compareWorkingTime[2]['end_time']))? $compareWorkingTime[2]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if($jobWorkingTime && isset($jobWorkingTime[3]))
                                        @php
                                            $unit_day = (isset($jobWorkingTime[3]) && isset($jobWorkingTime[3]['day'])) ? $jobWorkingTime[3]['day']:[];
                                            $unit_time_start = (isset($jobWorkingTime[3]) && $jobWorkingTime[3]['start_time'])?$jobWorkingTime[3]['start_time']:'';
                                            $unit_time_end = (isset($jobWorkingTime[3]) && isset($jobWorkingTime[3]['end_time']))? $jobWorkingTime[3]['end_time']:'';
                                        @endphp
                                        @if(in_array(1, $unit_day)) {{__('supply.job.monday')}} &nbsp; @endif
                                        @if(in_array(2, $unit_day)) {{__('supply.job.tuesday')}} &nbsp; @endif
                                        @if(in_array(3, $unit_day)) {{__('supply.job.wednesday')}} &nbsp; @endif
                                        @if(in_array(4, $unit_day)) {{__('supply.job.thursday')}} &nbsp; @endif
                                        @if(in_array(5, $unit_day)) {{__('supply.job.friday')}} &nbsp; @endif
                                        @if(in_array(6, $unit_day)) {{__('supply.job.saturday')}} &nbsp; @endif
                                        @if(in_array(0, $unit_day)) {{__('supply.job.sunday')}} &nbsp; @endif
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <!-- 勤務時間の入力 -->
                            <tr>
                                <td rowspan="4" class="text-center">{{__('supply.job.job_skill')}}</td>
                                <td class="text-center">{{__('supply.job.japanese_level')}}</td>
                                <td class="p-l-15">{{$compare->jobJapaneseLevel->label}}</td>
                                <td class="p-l-15">{{$job->jobJapaneseLevel->label}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.job_skill_1')}}</td>
                                <td class="p-l-15">
                                    @if(isset($compare->experience1_category_cd) && isset($category[$compare->experience1_category_cd]))
                                        {{$category[$job->experience1_category_cd]}}
                                    @endif
                                        &nbsp;&nbsp;
                                    @if(isset($compare->experience1_description_cd) && isset($category[$compare->experience1_description_cd]))
                                        {{$category[$compare->experience1_description_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if(isset($job->experience1_category_cd) && isset($category[$job->experience1_category_cd]))
                                        {{$category[$job->experience1_category_cd]}}
                                    @endif
                                        &nbsp;&nbsp;
                                    @if(isset($job->experience1_description_cd) && isset($category[$job->experience1_description_cd]))
                                        {{$category[$job->experience1_description_cd]}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.job_skill_2')}}</td>
                                <td class="p-l-15">
                                    @if(isset($compare->experience2_category_cd) && isset($category[$compare->experience2_category_cd]))
                                        {{$category[$compare->experience2_category_cd]}}
                                    @endif
                                    &nbsp;&nbsp;
                                    @if(isset($compare->experience2_description_cd) && isset($category[$compare->experience2_description_cd]))
                                        {{$category[$compare->experience2_description_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if(isset($job->experience2_category_cd) && isset($category[$job->experience2_category_cd]))
                                        {{$category[$job->experience2_category_cd]}}
                                    @endif
                                        &nbsp;&nbsp;
                                    @if(isset($job->experience2_description_cd) && isset($category[$job->experience2_description_cd]))
                                        {{$category[$job->experience2_description_cd]}}
                                    @endif
                                </td>
                            </tr>
                                <td class="text-center">{{__('supply.job.job_skill_3')}}</td>
                                <td class="p-l-15">
                                    @if(isset($compare->experience3_category_cd) && isset($category[$compare->experience3_category_cd]))
                                        {{$category[$compare->experience3_category_cd]}}
                                    @endif
                                    &nbsp;&nbsp;
                                    @if(isset($compare->experience3_description_cd) && isset($category[$compare->experience3_description_cd]))
                                        {{$category[$compare->experience3_description_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if(isset($job->experience3_category_cd) && isset($category[$job->experience3_category_cd]))
                                        {{$category[$job->experience3_category_cd]}}
                                    @endif
                                        &nbsp;&nbsp;
                                    @if(isset($job->experience3_description_cd) && isset($category[$job->experience3_description_cd]))
                                        {{$category[$job->experience3_description_cd]}}
                                    @endif
                                </td>
                            </tr>
                            <!-- 仕事で大事なこと -->
                            <tr>
                                <td rowspan="3" class="text-center">{{__('supply.job.job_important')}}</td>
                                <td class="text-center">{{__('supply.job.job_important_1')}}</td>
                                <td class="p-l-15">
                                    @if( isset($compare->important1_cd) && isset($importantThing[$compare->important1_cd]))
                                        {{$importantThing[$job->important1_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if( isset($job->important1_cd) && isset($importantThing[$job->important1_cd]))
                                        {{$importantThing[$job->important1_cd]}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.job_important_2')}}</td>
                                <td class="p-l-15">
                                    @if( isset($compare->important2_cd) && isset($importantThing[$compare->important2_cd]))
                                        {{$importantThing[$job->important2_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if( isset($job->important2_cd) && isset($importantThing[$job->important2_cd]))
                                        {{$importantThing[$job->important2_cd]}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('supply.job.job_important_3')}}</td>
                                <td class="p-l-15">
                                    @if( isset($compare->important3_cd) && isset($importantThing[$compare->important3_cd]))
                                        {{$importantThing[$job->important3_cd]}}
                                    @endif
                                </td>
                                <td class="p-l-15">
                                    @if( isset($job->important3_cd) && isset($importantThing[$job->important3_cd]))
                                        {{$importantThing[$job->important3_cd]}}
                                    @endif
                                </td>
                            </tr>
                            <!-- 応募者への連絡方法の選択 -->
                            <tr>
                                <td rowspan="2" class="text-center">{{__('supply.job.application_method')}}</td>
                                <td class="text-center">{{__('電話のみ')}}</td>
                                <td>
                                    <div class="col-sm-1 text-left form-inline">
                                        <div class="text-right float-left w-100"><input type="radio" id="application_method_1" name="application_method_1" value="0"  onclick="return false;" @if($compare->application_method == 0) checked @endif class="mg-r15 pointer"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-1 text-left form-inline">
                                        <div class="text-right float-left w-100"><input type="radio" id="application_method_1" name="application_method_2" value="0"  onclick="return false;" @if($job->application_method == 0) checked @endif class="mg-r15 pointer"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">{{__('電話とメッセージ')}}</td>
                                <td>
                                    <div class="col-sm-1 text-left form-inline">
                                        <div class="text-right float-left w-100"><input type="radio" id="application_method_1" name="application_method_3" value="1"  onclick="return false;" @if($compare->application_method == 1) checked @endif class="mg-r15 pointer"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-1 text-left form-inline">
                                        <div class="text-right float-left w-100"><input type="radio" id="application_method_1" name="application_method_4" value="1"  onclick="return false;" @if($job->application_method == 1) checked @endif class="mg-r15 pointer"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>

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
