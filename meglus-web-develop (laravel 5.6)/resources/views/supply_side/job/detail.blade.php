@extends('layouts.supply_job' )

@section('title')
    {{__('記事の詳細')}}
@stop

@section('layouts.supply_side_header_guest')
@stop

@section('header')
    @include('layouts.supply_side_header_guest')
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
                            <div class="col-sm-12">
                                <h3 class="box-title bold text-center">{{__('記事の詳細')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- Messsage flash -->
                    @include('inc.messages')
                    <!-- Messsage Error -->
                    @include('inc.messages_right')
                    <!-- form start -->
                    <div class="form-horizontal register_form" name="register_form" id="job_register_form">
                        {{ csrf_field() }}

                        <!-- 勤務先住所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.localtion')}}</h5></div>
                            <div class="form-group row ">
                                <label for="workplace_name" class="col-lg-4 col-xl-3 control-label ">{{__('supply.job.workplace_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_name_en}}
                                </div>
                            </div>
                        </div>

                        <!--勤務先住所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.work_localtion')}}</h5></div>
                            <div class="form-group row">
                                <label for="workplace_post_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_post_cd')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    {{$job->workplace_post_cd}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_prefecture" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_prefecture')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->jobPrefectures->name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_city1" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_city1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_city1}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_city2" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_city2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_city2}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_address" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_address')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_detail_address}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_building_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_building_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_building_name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_building_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_building_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->workplace_building_name_en}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_nearest_station_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_nearest_station_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->is_workplace_station}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_nearest_station_move_type" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_nearest_station_move_type')}}</label>

                                <div class="col-lg-8 col-xl-9 form-inline">
                                    @if($job->workplace_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="workplace_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$job->workplace_nearest_station_move_time}} {{__('supply.job.workplace_nearest_station_move_time')}}</label>
                                </div>
                            </div>
                        </div>

                        <!-- 面接場所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.location_interview')}}</h5></div>
                            <div class="form-group row">
                                <label for="interview_place_post_cd" class="col-lg-4 col-xl-3 control-label ">{{__('supply.job.interview_place_post_cd')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    {{$job->interview_place_post_cd}}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="interview_prefecture" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_prefecture')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->jobInterViewPrefectures->name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_city1" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_city1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->interview_city1}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_city2" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_city2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->interview_city2}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_detail_address" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_detail_address')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->interview_detail_address}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_building_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_building_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->interview_building_name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_building_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_building_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->interview_building_name_en}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_nearest_station_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_nearest_station_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->is_interview_station}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_nearest_station_move_type" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_nearest_station_move_type')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">

                                    @if($job->interview_nearest_station_move_type == 0)
                                        {{__('supply.job.workplace_nearest_station_move_type_option_0')}}
                                    @else
                                        {{__('supply.job.workplace_nearest_station_move_type_option_1')}}
                                    @endif
                                    <label for="interview_nearest_station_move_time" class="control-label">&nbsp;-&nbsp;{{$job->interview_nearest_station_move_time}} {{__('supply.job.interview_nearest_station_move_time')}}</label>
                                </div>

                            </div>
                        </div>

                        <!-- 業務内容の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_detail')}}</h5></div>
                            <div class="form-group row">
                                <label for="job_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_category_cd')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->jobCategory->name}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="job_discription_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_discription_cd')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    @if (isset($job->jobCategoryDescription->name)){{$job->jobCategoryDescription->name}}@endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="salary" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.salary')}}</label>
                                <div class="col-lg-8 col-xl-9 text-left form-inline">
                                    <div class="form-group">
                                        {{$job->min_salary}}
                                        <label for="min_salary" class="control-label">&nbsp;{{__('supply.job.unit')}}</label>
                                        <label for="max_salary" class="control-label  mg-r15 mg-l15">~</label>
                                        {{$job->max_salary}}
                                        <label for="max_salary" class="control-label">&nbsp;{{__('supply.job.unit')}}</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- 勤務時間の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_time')}}</h5></div>
                            @if($jobWorkingTime && isset($jobWorkingTime[1]))
                                @php
                                    $unit_day = $jobWorkingTime[1]['day'];
                                    $unit_time_start = $jobWorkingTime[1]['start_time'];
                                    $unit_time_end = $jobWorkingTime[1]['end_time'];
                                @endphp
                                <div class="form-group row form-group-title">
                                    <span>{{__('supply.job.job_time_detail')}}</span>
                                </div>
                                <div class="form-group row text-center">
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="job_time_day_1" name="job_time_day_1[]" value="1" onclick="return false;" @if(in_array(1, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="2" onclick="return false;" @if(in_array(2, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="3" onclick="return false;" @if(in_array(3, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="4" onclick="return false;" @if(in_array(4, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="5" onclick="return false;" @if(in_array(5, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="6" onclick="return false;" @if(in_array(6, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="0" onclick="return false;" @if(in_array(0, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 勤務時間帯①（必須） -->
                            @if($jobWorkingTime && isset($jobWorkingTime[2]))
                                @php
                                    $unit_day = $jobWorkingTime[2]['day'];
                                    $unit_time_start = $jobWorkingTime[2]['start_time'];
                                    $unit_time_end = $jobWorkingTime[2]['end_time'];
                                @endphp
                                <div class="form-group row form-group-title">
                                    <span>{{__('supply.job.job_time_detail_2')}}</span>
                                </div>
                                <div class="form-group row text-center">
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="job_time_day_1" name="job_time_day_1[]" value="1" onclick="return false;" @if(in_array(1, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="2" onclick="return false;" @if(in_array(2, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="3" onclick="return false;" @if(in_array(3, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="4" onclick="return false;" @if(in_array(4, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="5" onclick="return false;" @if(in_array(5, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="6" onclick="return false;" @if(in_array(6, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="0" onclick="return false;" @if(in_array(0, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    </div>
                                </div>
                             @endif

                            <!-- 勤務時間帯①（必須） -->
                            @if($jobWorkingTime && isset($jobWorkingTime[3]))
                                @php
                                    $unit_day = $jobWorkingTime[3]['day'];
                                    $unit_time_start = $jobWorkingTime[3]['start_time'];
                                    $unit_time_end = $jobWorkingTime[3]['end_time'];
                                @endphp
                                <div class="form-group row form-group-title">
                                    <span>{{__('supply.job.job_time_detail_3')}}</span>
                                </div>
                                <div class="form-group row text-center">
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="job_time_day_1" name="job_time_day_1[]" value="1" onclick="return false;" @if(in_array(1, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="2" onclick="return false;" @if(in_array(2, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="3" onclick="return false;" @if(in_array(3, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="4" onclick="return false;" @if(in_array(4, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="5" onclick="return false;" @if(in_array(5, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="6" onclick="return false;" @if(in_array(6, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline col-1">
                                            <input class="form-check-input" type="checkbox" id="day" name="job_time_day_1[]" value="0" onclick="return false;" @if(in_array(0, $unit_day)) checked @endif >
                                            <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline">
                                            {{$unit_time_start}}
                                            &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                            {{$unit_time_end}}
                                        </div>
                                    </div>
                                </div>
                            @endif



                        </div>

                        <!-- 勤務時間の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_skill')}}</h5></div>
                            <div class="form-group row">
                                <label for="japanese_level" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.japanese_level')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    {{$job->jobJapaneseLevel->label}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="experience1_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_1')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline text-left">
                                    @if(isset($job->experience1_category_cd) && isset($category[$job->experience1_category_cd]))
                                        {{$category[$job->experience1_category_cd]}}
                                    @endif
                                    <div class="col-sm-2"></div>
                                    @if(isset($job->experience1_description_cd) && isset($category[$job->experience1_description_cd]))
                                        {{$category[$job->experience1_description_cd]}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience2_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_2')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline text-left">
                                    @if(isset($job->experience2_category_cd) && isset($category[$job->experience2_category_cd]))
                                        {{$category[$job->experience2_category_cd]}}
                                    @endif
                                    <div class="col-sm-2"></div>
                                    @if(isset($job->experience2_description_cd) && isset($category[$job->experience2_description_cd]))
                                        {{$category[$job->experience2_description_cd]}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience3_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_3')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline text-left">
                                    @if(isset($job->experience3_category_cd) && isset($category[$job->experience3_category_cd]))
                                        {{$category[$job->experience3_category_cd]}}
                                    @endif
                                    <div class="col-sm-2"></div>
                                    @if(isset($job->experience3_description_cd) && isset($category[$job->experience3_description_cd]))
                                        {{$category[$job->experience3_description_cd]}}
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- 仕事で大事なこと -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_important')}}</h5></div>
                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    @if( isset($job->important1_cd) && isset($importantThing[$job->important1_cd]))
                                        {{$importantThing[$job->important1_cd]}}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    @if( isset($job->important2_cd) && isset($importantThing[$job->important2_cd]))
                                        {{$importantThing[$job->important2_cd]}}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_3')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    @if( isset($job->important3_cd) && isset($importantThing[$job->important3_cd]))
                                        {{$importantThing[$job->important3_cd]}}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- 応募者への連絡方法の選択 -->
                        <div class="box-body application_method">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.application_method')}}</h5></div>
                            <div class="form-group row job-radio-item @if(Input::old('application_method', $job->application_method) == 0 || !Input::old('application_method', $job->application_method) ) selected @endif " id="job-radio-item-0">
                                <div class="col-sm-1 text-left form-inline max-w-30">
                                    <div class="text-right float-left w-100"><input type="checkbox"  onclick="return false;"  id="application_method_0" name="application_method" value="0" @if(Input::old('application_method', $job->application_method) == 0 || !Input::old('application_method', $job->application_method) ) checked @endif  class="mg-r15 pointer application_method"></div>
                                </div>
                                <label for="application_method" class="col-lg-8 col-xl-9 control-label max-w-70">{!! __('supply.job.application_method_label_1') !!}</label>
                            </div>
                            <div class="form-group row job-radio-item @if(Input::old('application_method', $job->application_method) == 1  ) selected @endif" id="job-radio-item-1">
                                <div class="col-sm-1 text-left form-inline max-w-30">
                                    <div class="text-right float-left w-100"><input type="checkbox"  onclick="return false;" id="application_method_1" name="application_method" value="1" @if(Input::old('application_method', $job->application_method) == 1 ) checked @endif class="mg-r15 pointer application_method"></div>
                                </div>
                                <label for="application_method" class="col-lg-8 col-xl-9 control-label max-w-70">{!! __('supply.job.application_method_label_2') !!}</label>
                            </div>
                        </div>

                        <div class="box-footer text-center">
                            <div class="form-group text-center">
                                @if($job->isOwner())
                                <a class="btn btn-info center-block btn-primary bg_blue text-light" href="{{route('supply.job.edit', ['id' =>$job->job_id ] )}}">{{__('編集')}}</a>
                                @endif
                                <a class="btn btn-info center-block btn-primary bg_blue text-light" href="{{route('mypage', ['sort[updated_at]' => 'DESC'])}}">{{__('マイページへ')}}</a>
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
    @include('layouts.supply_side_footer')
@stop
