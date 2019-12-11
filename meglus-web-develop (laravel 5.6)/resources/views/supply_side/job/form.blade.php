@extends('layouts.supply_job' )

@section('content')
    <script>
        var minimumWages = {};
        @if(isset($minimumWages))
            minimumWages = {!! json_encode($minimumWages) !!};
        @endif

        var maximumWages = {};
        @if(isset($maximumWages))
            maximumWages = {!! json_encode($maximumWages) !!};
        @endif

        var jobCategoryCd   = {};
        @if($categories)
            jobCategoryCd = {!! json_encode($categories) !!};
        @endif

        var companyInfo = {};
        @if(isset($company))
            companyInfo   = {!! json_encode($company) !!};
        @endif

    </script>

    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <!-- Messsage area -->
                    @include('inc.messages')

                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3 class="box-title bold text-center">{{__('supply.job.create')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal register_form" method="POST" href="" name="register_form" id="job_register_form">
                        {{ csrf_field() }}

                        <!-- 勤務先住所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.localtion')}}</h5></div>
                            <div class="form-group row ">
                                <label for="workplace_name" class="col-lg-4 col-xl-3 control-label ">{{__('supply.job.workplace_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_name" value="{{old('workplace_name', $job->workplace_name)}}" class="form-control " id="workplace_name" placeholder="{{__('supply.job.workplace_name')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_name_en" value="{{old('workplace_name_en', $job->workplace_name_en)}}"  class="form-control " id="workplace_name_en" placeholder="{{__('supply.job.workplace_name_en')}}" >
                                </div>
                            </div>
                        </div>

                        <!--勤務先住所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.work_localtion')}}</h5></div>
                            <div class="form-group row text-center form-inline">
                                <div class="w-100">
                                    <button type="button" id="workplace-get-company-info" class="btn btn-info center-block bg_blue text-light mg-l15 get-company-info">{{__('企業情報と同じ')}}</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="workplace_post_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_post_cd')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <input type="text"  maxlength="7" name="workplace_post_cd" value="{{old('workplace_post_cd', $job->workplace_post_cd)}}"  class="form-control post_cd" id="workplace_post_cd" placeholder="0000000" >
                                    <button type="button" id="find-address" class="btn btn-info center-block bg_blue text-light mg-l15 find-address">{{__('supply.job.find_address_btn')}}</button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_prefecture" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_prefecture')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control workplace_prefecture" data-old-value="{{Input::old('workplace_prefecture')}}" id="workplace_prefecture" name="workplace_prefecture">
                                        <option value="">選択してください</option>
                                        @foreach($prefectures['prefectures'] as $key => $prefecture)
                                            <option value="{{ $key }}" @if (Input::old('workplace_prefecture', $job->workplace_prefecture) == $key)  selected @endif>{{ $prefecture }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_city1" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_city1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control workplace_city1" id="workplace_city1" name="workplace_city1" @if (!Input::old('workplace_prefecture', $job->workplace_prefecture) && !Input::old('workplace_city1', $job->workplace_city1 ))  disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(isset($prefectures['workplace_city1']))
                                            @foreach($prefectures['workplace_city1'] as $key => $item)
                                                <option value="{{ $item }}" @if (Input::old('workplace_city1', $job->workplace_city1) == $item)  selected @endif>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_city2" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_city2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control" id="workplace_city2" name="workplace_city2" @if (!Input::old('workplace_city2', $job->workplace_city2) && !Input::old('workplace_city1', $job->workplace_city1))  disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(isset($prefectures['workplace_city2']))
                                            @foreach($prefectures['workplace_city2'] as $key => $item)
                                                <option value="{{ $item }}" @if (Input::old('workplace_city2', $job->workplace_city2) == $item)  selected @endif>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_detail_address" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_address')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_detail_address" value="{{old('workplace_detail_address', $job->workplace_detail_address)}}" class="form-control " id="workplace_detail_address" placeholder="{{__('supply.job.workplace_address')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_building_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_building_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_building_name"  value="{{old('workplace_building_name', $job->workplace_building_name)}}"  class="form-control " id="workplace_building_name" placeholder="{{__('supply.job.workplace_building_name')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_building_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_building_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_building_name_en" value="{{old('workplace_building_name_en', $job->workplace_building_name_en)}}" class="form-control " id="workplace_building_name_en" placeholder="{{__('supply.job.workplace_building_name_en')}}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="workplace_nearest_station_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_nearest_station_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="workplace_nearest_station_name" value="{{old('workplace_nearest_station_name', $job->is_workplace_station)}}" class="form-control ajax_find_station_name" id="workplace_nearest_station_cd" placeholder="{{__('supply.job.workplace_nearest_station_name')}}" >
                                    <input type="hidden" name="workplace_nearest_station_name_source" value="{{old('workplace_nearest_station_name_source',$job->is_station_name)}}" id="workplace_nearest_station_name_source" >
                                    <input type="hidden" name="workplace_nearest_station_cd" value="{{old('workplace_nearest_station_cd', $job->workplace_nearest_station_cd)}}" id="workplace_nearest_station_source_cd" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="workplace_nearest_station_move_type" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.workplace_nearest_station_move_type')}}</label>

                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <input type="radio" id="workplace_nearest_station_move_type" name="workplace_nearest_station_move_type" value="0"  @if((Input::old('workplace_nearest_station_move_type', $job->workplace_nearest_station_move_type) == 0) || !Input::old('workplace_nearest_station_move_type', $job->workplace_nearest_station_move_type) ) checked @endif   class="mg-r15"><label class="mg-r15">{{__('supply.job.workplace_nearest_station_move_type_option_0')}}</label>
                                    <input type="radio" name="workplace_nearest_station_move_type" value="1" @if(Input::old('workplace_nearest_station_move_type', $job->workplace_nearest_station_move_type) == 1 ) checked @endif class="mg-r15"><label class="mg-r15">{{__('supply.job.workplace_nearest_station_move_type_option_1')}}</label>
                                    <input type="number" name="workplace_nearest_station_move_time" value="{{old('workplace_nearest_station_move_time', $job->workplace_nearest_station_move_time)}}" class="form-control w100 " id="workplace_nearest_station_move_time" placeholder="{{__('supply.job.workplace_nearest_station_move_time')}}" >
                                    <label for="workplace_nearest_station_move_time" class="control-label"> &nbsp;{{__('supply.job.workplace_nearest_station_move_time')}}</label>
                                </div>
                            </div>
                        </div>

                        <!-- 面接場所の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.location_interview')}}</h5></div>
                            <div class="form-group row text-center form-inline">
                                <div class="col-lg-4 col-xl-3"></div>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <button type="button" id="get-workplace" class="btn btn-info center-block bg_blue text-light get-workplace max-w-45">{{__('勤務先と同じ')}}</button>
                                    <button type="button" id="interview-get-company-info" class="btn btn-info center-block bg_blue text-light mg-l15 get-company-info  max-w-45">{{__('企業情報と同じ')}}</button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_place_post_cd" class="col-lg-4 col-xl-3 control-label ">{{__('supply.job.interview_place_post_cd')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <input type="text" name="interview_place_post_cd" maxlength="7" class="form-control post_cd max-w-45" id="interview_place_post_cd" value="{{old('interview_place_post_cd', $job->interview_place_post_cd)}}" placeholder="0000000">
                                    <button type="button" id="interview-find-address" class="btn btn-info center-block bg_blue text-light mg-l15 find-address max-w-45">{{__('supply.job.find_address_btn')}}</button>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="interview_prefecture" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_prefecture')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control workplace_prefecture" id="interview_prefecture" name="interview_prefecture">
                                        <option value="">選択してください</option>
                                        @foreach($prefectures['prefectures'] as $key => $prefecture)
                                            <option value="{{ $key }}" @if (Input::old('interview_prefecture', $job->interview_prefecture) == $key)  selected @endif>{{ $prefecture }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_city1" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_city1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control workplace_city1" id="interview_city1" name="interview_city1" @if (!Input::old('interview_city1', $job->interview_city1) && !Input::old('interview_prefecture', $job->interview_prefecture))  disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(isset($prefectures['interview_city1']))
                                            @foreach($prefectures['interview_city1'] as $key => $item)
                                                <option value="{{ $item }}" @if (Input::old('interview_city1', $job->interview_city1) == $item)  selected @endif>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_city2" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_city2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control" id="interview_city2" name="interview_city2" @if (!Input::old('interview_city2', $job->interview_city2) && !Input::old('interview_city1', $job->interview_city1))  disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(isset($prefectures['interview_city2']))
                                            @foreach($prefectures['interview_city2'] as $key => $item)
                                                <option value="{{ $item }}" @if (Input::old('interview_city2', $job->interview_city2) == $item)  selected @endif>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_detail_address" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_detail_address')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="interview_detail_address" value="{{(old('interview_detail_address', $job->interview_detail_address))}}" class="form-control " id="interview_detail_address" placeholder="{{__('supply.job.interview_detail_address')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_building_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_building_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="interview_building_name" value="{{old('interview_building_name', $job->interview_building_name)}}" class="form-control " id="interview_building_name" placeholder="{{__('supply.job.interview_building_name')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_building_name_en" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_building_name_en')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="interview_building_name_en" value="{{old('interview_building_name_en', $job->interview_building_name_en)}}" class="form-control " id="interview_building_name_en" placeholder="{{__('supply.job.interview_building_name_en')}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_nearest_station_name" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_nearest_station_name')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <input type="text" name="interview_nearest_station_name" value="{{old('interview_nearest_station_name', $job->is_interview_station)}}" class="form-control ajax_find_station_name" id="interview_nearest_station_cd" placeholder="{{__('supply.job.interview_nearest_station_name')}}" >
                                    <input type="hidden" name="interview_nearest_station_name_source" value="{{old('interview_nearest_station_name_source', $job->is_interview_station_name)}}" id="interview_nearest_station_name_source" >
                                    <input type="hidden" name="interview_nearest_station_cd" value="{{old('interview_nearest_station_cd', $job->interview_nearest_station_cd)}}" id="interview_nearest_station_source_cd" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interview_nearest_station_move_type" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.interview_nearest_station_move_type')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <input type="radio" id="interview_nearest_station_move_type" name="interview_nearest_station_move_type" value="0"  @if(Input::old('interview_nearest_station_move_type',$job->interview_nearest_station_move_type) == 0 || !Input::old('interview_nearest_station_move_type',$job->interview_nearest_station_move_type)) checked @endif class="mg-r15"><label class="mg-r15">{{__('supply.job.interview_nearest_station_move_type_option_0')}}</label>
                                    <input type="radio" name="interview_nearest_station_move_type" value="1" @if(Input::old('interview_nearest_station_move_type',$job->interview_nearest_station_move_type) == 1 ) checked @endif class="mg-r15"><label class="mg-r15">{{__('supply.job.interview_nearest_station_move_type_option_1')}}</label>
                                    <input type="number" name="interview_nearest_station_move_time" value="{{old('interview_nearest_station_move_time', $job->interview_nearest_station_move_time)}}" class="form-control w100 mg-l15" id="interview_nearest_station_move_time" placeholder="{{__('supply.job.interview_nearest_station_move_time')}}" >
                                    <label for="interview_nearest_station_move_time" class="control-label"> &nbsp;{{__('supply.job.interview_nearest_station_move_time')}}</label>
                                </div>

                            </div>
                        </div>

                        <!-- 業務内容の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_detail')}}</h5></div>
                            <div class="form-group row">
                                <label for="job_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_category_cd')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control job_category_cd" id="job_category_cd" name="job_category_cd">
                                        <option value="">選択してください</option>
                                        @foreach($categories as $key => $item)
                                            <option value="{{$item['id']}}" @if(Input::old('job_category_cd', $job->job_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="job_discription_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_discription_cd')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control" id="job_discription_cd" name="job_discription_cd" @if(!Input::old('job_category_cd', $job->job_category_cd)) disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(Input::old('job_category_cd', $job->job_category_cd))
                                            @foreach($categories[Input::old('job_category_cd', $job->job_category_cd)]['items'] as $key => $item)
                                                <option value="{{$item['id']}}" @if(Input::old('job_discription_cd', $job->job_discription_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="salary" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.salary')}}</label>
                                <div class="col-lg-8 col-xl-9 text-left form-inline">
                                        <input type="text" name="min_salary" value="{{old('min_salary', $job->min_salary)}}" class="form-input w100 input_salary" id="min_salary" >
                                        <label for="min_salary" class="control-label">&nbsp;{{__('supply.job.unit')}}</label>
                                        <label for="max_salary" class="control-label  mg-r15 mg-l15">~</label>
                                        <input type="text" name="max_salary" value="{{old('max_salary', $job->max_salary)}}" class="form-input w100 input_salary" id="max_salary" >
                                        <label for="max_salary" class="control-label">&nbsp;{{__('supply.job.unit')}}</label>
                                </div>
                            </div>
                        </div>


                        <!-- 勤務時間の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_time')}}</h5></div>
                            <div class="form-group row form-group-title">
                                <span>{{__('supply.job.job_time_detail')}}</span>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-12 text-center">
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="job_time_day_1" name="job_time_day_1[]" value="1" @if(isset($jobWorkingTime[1]['day'][1])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="2" @if(isset($jobWorkingTime[1]['day'][2])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="3" @if(isset($jobWorkingTime[1]['day'][3])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="4" @if(isset($jobWorkingTime[1]['day'][4])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="5" @if(isset($jobWorkingTime[1]['day'][5])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="6" @if(isset($jobWorkingTime[1]['day'][6])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_1[]" value="0" @if(isset($jobWorkingTime[1]['day'][0])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    @php
                                        $startTime = (isset($jobWorkingTime[1]['start_time']))?$jobWorkingTime[1]['start_time']:'';
                                        $endTime = (isset($jobWorkingTime[1]['end_time']))?$jobWorkingTime[1]['end_time']:'';
                                    @endphp
                                    <input type="text" name="unit_time_start_1" value="{{old('unit_time_start',$startTime )}}" class="form-input w100 col-sm-3 unit_time_start" id="unit_time_start_1" placeholder="{{__('supply.job.unit_time_start')}}" >&nbsp;
                                    &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="unit_time_end_1" value="{{old('unit_time_end', $endTime)}}" class="form-input w100 col-sm-3 unit_time_end" id="unit_time_end_1" placeholder="{{__('supply.job.unit_time_end')}}" >&nbsp;
                                </div>
                            </div>


                            <!-- 勤務時間帯①（必須） -->
                            <div class="form-group row form-group-title">
                                <span>{{__('supply.job.job_time_detail_2')}}</span>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-12 text-center">
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="job_time_day_2" name="job_time_day_2[]" value="1" @if(isset($jobWorkingTime[2]['day'][1])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="2"  @if(isset($jobWorkingTime[2]['day'][2])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="3"  @if(isset($jobWorkingTime[2]['day'][3])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="4"  @if(isset($jobWorkingTime[2]['day'][4])) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="5" @if(isset($jobWorkingTime[2]['day'][5])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="6" @if(isset($jobWorkingTime[2]['day'][6])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_2[]" value="0" @if(isset($jobWorkingTime[2]['day'][0])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    @php
                                        $startTime = (isset($jobWorkingTime[2]['start_time']))?$jobWorkingTime[2]['start_time']:'';
                                        $endTime = (isset($jobWorkingTime[2]['end_time']))?$jobWorkingTime[2]['end_time']:'';
                                    @endphp
                                    <input type="text" name="unit_time_start_2" value="{{old('unit_time_start', $startTime)}}" class="form-input w100 col-sm-3 unit_time_start" id="unit_time_start_2" placeholder="{{__('supply.job.unit_time_start')}}" >&nbsp;
                                    &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="unit_time_end_2" value="{{old('unit_time_end',$endTime )}}" class="form-input w100 col-sm-3 unit_time_end" id="unit_time_end_2" placeholder="{{__('supply.job.unit_time_end')}}" >&nbsp;
                                </div>
                            </div>



                            <!-- 勤務時間帯①（必須） -->
                            <div class="form-group row form-group-title">
                                <span>{{__('supply.job.job_time_detail_3')}}</span>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-sm-12 text-center">
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="job_time_day_3" name="job_time_day_3[]" value="1" @if(isset($jobWorkingTime[3]['day'][1])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="2" @if(isset($jobWorkingTime[3]['day'][2])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.tuesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="3" @if(isset($jobWorkingTime[3]['day'][3])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.wednesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="4" @if(isset($jobWorkingTime[3]['day'][4])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.thursday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="5" @if(isset($jobWorkingTime[3]['day'][5])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.friday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="6" @if(isset($jobWorkingTime[3]['day'][6])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.saturday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <input class="form-check-input large-checkbox" type="checkbox" id="day" name="job_time_day_3[]" value="0" @if(isset($jobWorkingTime[3]['day'][0])) checked @endif >
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('supply.job.sunday')}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    @php
                                        $startTime = (isset($jobWorkingTime[3]['start_time']))?$jobWorkingTime[3]['start_time']:'';
                                        $endTime = (isset($jobWorkingTime[3]['end_time']))?$jobWorkingTime[3]['end_time']:'';
                                    @endphp

                                    <input type="text" name="unit_time_start_3" value="{{old('unit_time_start', $startTime)}}" class="form-input w100 col-sm-3 unit_time_start" id="unit_time_start_3" placeholder="{{__('supply.job.unit_time_start')}}" >&nbsp;
                                    &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="unit_time_end_3" value="{{old('unit_time_end', $endTime)}}" class="form-input w100 col-sm-3 unit_time_end" id="unit_time_end_3" placeholder="{{__('supply.job.unit_time_end')}}" >&nbsp;
                                </div>
                            </div>
                        </div>

                        <!-- 勤務時間の入力 -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_skill')}}</h5></div>
                            <div class="form-group row">
                                <label for="japanese_level" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.japanese_level')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control " id="japanese_level" name="japanese_level">
                                        <option value="">選択してください</option>
                                        @foreach($japaneseLevel as $key => $item)
                                            <option value="{{$item->value}}" @if(Input::old('japanese_level', $job->japanese_level) == $item->value) selected @endif>{{$item->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="experience1_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_1')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <select class="form-control  col-sm-5 job_category_cd" id="experience1_category_cd" name="experience1_category_cd">
                                        <option value="">選択してください</option>
                                        @foreach($categories as $key => $item)
                                            <option value="{{$item['id']}}" @if(Input::old('experience1_category_cd', $job->experience1_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-sm-2"></div>
                                    <select class="form-control  col-sm-5" id="experience1_description_cd" name="experience1_description_cd"  @if(!Input::old('experience1_category_cd', $job->experience1_category_cd)) disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(Input::old('experience1_category_cd', $job->experience1_category_cd))
                                            @foreach($categories[Input::old('experience1_category_cd', $job->experience1_category_cd)]['items'] as $key => $item)
                                                <option value="{{$item['id']}}" @if(Input::old('experience1_description_cd', $job->experience1_description_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience2_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_2')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <select class="form-control col-sm-5 job_category_cd" id="experience2_category_cd" name="experience2_category_cd">
                                        <option value="">選択してください</option>
                                        @foreach($categories as $key => $item)
                                            <option value="{{$item['id']}}" @if(Input::old('experience2_category_cd', $job->experience2_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-sm-2"></div>
                                    <select class="form-control col-sm-5" id="experience2_description_cd" name="experience2_description_cd" @if(!Input::old('experience2_category_cd', $job->experience2_category_cd)) disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(Input::old('experience2_category_cd', $job->experience2_category_cd))
                                            @foreach($categories[Input::old('experience2_category_cd', $job->experience2_category_cd)]['items'] as $key => $item)
                                                <option value="{{$item['id']}}" @if(Input::old('experience2_category_cd', $job->experience2_description_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience3_category_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_skill_3')}}</label>
                                <div class="col-lg-8 col-xl-9 form-inline">
                                    <select class="form-control col-sm-5 job_category_cd" id="experience3_category_cd" name="experience3_category_cd">
                                        <option value="">選択してください</option>
                                        @foreach($categories as $key => $item)
                                            <option value="{{$item['id']}}" @if(Input::old('experience3_category_cd', $job->experience3_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-sm-2"></div>
                                    <select class="form-control col-sm-5" id="experience3_description_cd" name="experience3_description_cd" @if(!Input::old('experience3_category_cd', $job->experience3_category_cd)) disabled @endif>
                                        <option value="">選択してください</option>
                                        @if(Input::old('experience3_category_cd', $job->experience3_category_cd))
                                            @foreach($categories[Input::old('experience3_category_cd', $job->experience3_category_cd)]['items'] as $key => $item)
                                                <option value="{{$item['id']}}" @if(Input::old('experience3_description_cd', $job->experience3_description_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 仕事で大事なこと -->
                        <div class="box-body">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.job_important')}}</h5></div>
                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_1')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control importantCd" id="important1_cd" name="important1_cd">
                                        <option value="">選択してください</option>
                                        @foreach($important as $key => $item)
                                            <option value="{{$item->value}}" @if(Input::old('important1_cd', $job->important1_cd) == $item->value) selected @endif>{{$item->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_2')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control importantCd" id="important2_cd" name="important2_cd">
                                        <option value="">選択してください</option>
                                        @foreach($important as $key => $item)
                                            <option value="{{$item->value}}" @if(Input::old('important2_cd', $job->important2_cd) == $item->value) selected @endif>{{$item->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="important1_cd" class="col-lg-4 col-xl-3 control-label">{{__('supply.job.job_important_3')}}</label>
                                <div class="col-lg-8 col-xl-9">
                                    <select class="form-control importantCd" id="important3_cd" name="important3_cd">
                                        <option value="">選択してください</option>
                                        @foreach($important as $key => $item)
                                            <option value="{{$item->value}}" @if(Input::old('important3_cd', $job->important3_cd) == $item->value) selected @endif>{{$item->label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 応募者への連絡方法の選択 -->
                        <div class="box-body application_method">
                            <div class="form-group row sub-title"><h5>{{__('supply.job.application_method')}}</h5></div>
                            <div class="form-group row job-radio-item @if(Input::old('application_method', $job->application_method) == 0 || !Input::old('application_method', $job->application_method) ) selected @endif " id="job-radio-item-0">
                                <div class="col-sm-1 text-left form-inline max-w-30">
                                    <div class="text-right float-left w-100"><input type="checkbox" id="application_method_0" name="application_method" value="0" @if(Input::old('application_method', $job->application_method) == 0 || !Input::old('application_method', $job->application_method) ) checked @endif  class="mg-r15 pointer application_method"></div>
                                </div>
                                <label for="application_method" class="col-sm-9 control-label max-w-70">{!! __('supply.job.application_method_label_1') !!}</label>
                            </div>
                            <div class="form-group row job-radio-item  @if(Input::old('application_method', $job->application_method) == 1  ) selected @endif" id="job-radio-item-1">
                                <div class="col-sm-1 text-left form-inline max-w-30">
                                    <div class="text-right float-left w-100"><input type="checkbox" id="application_method_1" name="application_method" value="1" @if(Input::old('application_method', $job->application_method) == 1 ) checked @endif class="mg-r15 pointer application_method"></div>
                                </div>
                                <label for="application_method" class="col-sm-9 control-label max-w-70">{!! __('supply.job.application_method_label_2') !!}</label>
                            </div>
                        </div>

                        <div class="box-footer text-center">
                            <div class="form-group text-center">
                                @if(count(Auth::user()->jobs) > 0)
                                    <a class="btn btn-info center-block bg_blue text-light mgb-10 " href="{{route('mypage', ['sort[updated_at]' => 'DESC'])}}">{{__('マイページに戻る')}}</a>
                                @endif
                                <button type="button" @if($job->job_id ) id="copy-job" disabled @endif class="btn btn-info center-block bg_blue text-light mgb-10 submit-form-ajax" submit-form-ajax="true" data-form-id="job_register_form">
                                @if($job->job_id && Request::route()->getName() != 'supply.job.copy')
                                    {{__('記事を編集して上書き保存する')}}
                                @else
                                    {{__('新規記事を掲載する')}}
                                @endif
                                </button>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
@stop
