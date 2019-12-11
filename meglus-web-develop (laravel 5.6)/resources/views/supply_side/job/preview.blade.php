<div class="modal job_preview" id="job_preview" tabindex="-1" role="dialog" style="">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="">
            <div class="modal-header text-right">
                <div class="title-user-info  w-100 text-left">
                    {{--<b>仕事のプレビュー</b>--}}
                </div>
                <a href="javascript:void(0)" class="close " >
                    <span aria-hidden="true" onclick="$(function () {$('#job_preview').modal('toggle');});">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="row-bottom text-center close-btn">
                    <div class="mobile-preview">
                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                <img class="icon-preview" src="/img/d_rc_00.png" width="100%">
                            </div>

                            @if($job->application_method == 1)
                                <div class="col-lg-10 col-xl-10  p-t-30 p-l-5 p-r-5">
                                    {{$job->workplace_name}}
                                </div>
                            @else
                                <div class="col-lg-7 col-xl-7  p-t-30 p-l-5 p-r-5">
                                    {{$job->workplace_name}}
                                </div>
                                <div class="col-lg-3 col-xl-3 p-t-15 p-l-5 p-r-5">
                                    <div class="contact-icon"></div>
                                </div>
                            @endif

                        </div>
                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                <img class="icon-preview" src="/img/d_rc_01.png" width="100%">
                            </div>
                            <div class="col-lg-7 col-xl-7  p-t-30  p-l-5 p-r-5">
                                @if(isset($job->jobCategory))
                                    {{$job->jobCategory->name}}
                                @endif
                            </div>
                            <div class="col-lg-3 col-xl-3 p-t-15  p-l-5 p-r-5">
                                @if(isset($job->jobCategory))
                                    <img src="{{$job->jobCategory->icon_filepath}}" width="50px;">
                                @endif
                            </div>
                        </div>


                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                <img class="icon-preview" src="/img/d_rc_03.png" width="100%">
                            </div>
                            <div class="col-sm-5  p-t-30  p-l-5 p-r-5">
                                ¥{{number_format($job->min_salary)}}～¥{{number_format($job->max_salary)}}
                            </div>
                            <div class="col-sm-5 p-t-15 p-t-15 p-l-5 p-r-0 " style="border-left: 1px solid #dfdddd; margin: 8px 0px">
                                <div class="jlpt_icon">
                                    <div class="jlpt-level jlpt-level-{{$job->jobJapaneseLevel->label}}">
                                        {{$job->jobJapaneseLevel->label}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                <img class="icon-preview" src="/img/d_rc_05.png" width="100%">
                            </div>
                            <div class="col-sm-5  p-t-30 p-l-5 p-r-5">
                                {{$job->workplace_nearest_station_move_time}} {{__('supply.job.workplace_nearest_station_move_time')}}
                            </div>
                            <div class="col-sm-5 p-t-15 p-t-15 p-l-5 p-r-0" style="border-left: 1px solid #dfdddd; margin: 8px 0px">
                                <div class="bus_icon">
                                    <p class="station-number text-center m-b-0"><span>{{$job->is_station_number}}</span></p>
                                    <p class="station-name text-center">{{$job->is_station_name}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                @if($jobWorkingTime && (isset($jobWorkingTime[2]) || isset($jobWorkingTime[3])))
                                    <img class="icon-preview cursor-pointer"  onclick="showWorkingTimeDetail($('#popup-working-time').attr('show-detail'));"  src="/img/d_pr_19.png" width="100%">
                                    <span class="warning warning-status" >&nbsp;</span>
                                @else
                                    <img class="icon-preview" src="/img/d_pr_19.png" width="100%">
                                @endif
                            </div>
                            <div class="col-lg-10 col-xl-10  p-t-10 p-r-0">
                                @if($jobWorkingTime && isset($jobWorkingTime[1]))
                                    @php
                                        $unit_day = $jobWorkingTime[1]['day'];
                                        $unit_time_start = $jobWorkingTime[1]['start_time'];
                                        $unit_time_end = $jobWorkingTime[1]['end_time'];
                                    @endphp
                                @endif
                                    <div class="col-xl-12 form-inline p-l-0 p-r-0">
                                        <div class="day-of-week @if(in_array(1, $unit_day)) active @endif m-r-5">
                                            <p class="m-b-0">MON</p>
                                            <p class="m-b-0">{{__('supply.job.monday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(2, $unit_day)) active @endif m-r-5">
                                            <p class="m-b-0">tue</p>
                                            <p class="m-b-0">{{__('supply.job.tuesday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(3, $unit_day)) active @endif  m-r-5">
                                            <p class="m-b-0">thu</p>
                                            <p class="m-b-0">{{__('supply.job.thursday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(4, $unit_day)) active @endif  m-r-5">
                                            <p class="m-b-0">wed</p>
                                            <p class="m-b-0">{{__('supply.job.wednesday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(5, $unit_day)) active @endif  m-r-5">
                                            <p class="m-b-0">fri</p>
                                            <p class="m-b-0">{{__('supply.job.friday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(6, $unit_day)) active @endif  m-r-5">
                                            <p class="m-b-0">sat</p>
                                            <p class="m-b-0">{{__('supply.job.saturday')}}</p>
                                        </div>
                                        <div class="day-of-week @if(in_array(0, $unit_day)) active @endif ">
                                            <p class="m-b-0">sun</p>
                                            <p class="m-b-0">{{__('supply.job.sunday')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 text-center  p-l-0 p-r-0 p-t-5">
                                        <span class=" icon-clock">{{$unit_time_start}}〜{{$unit_time_end}}</span>
                                    </div>

                            </div>


                            @if($jobWorkingTime && (isset($jobWorkingTime[2]) || isset($jobWorkingTime[3])))
                                @if($jobWorkingTime && isset($jobWorkingTime[1]))
                                    @php
                                        $unit_day = $jobWorkingTime[1]['day'];
                                        $unit_time_start = $jobWorkingTime[1]['start_time'];
                                        $unit_time_end = $jobWorkingTime[1]['end_time'];
                                    @endphp
                                @endif

                                <div class="popup-working-time" id = "popup-working-time" show-detail="hidden">
                                    <div class=" working-time-1 ">
                                        <div class="col-xl-12 form-inline p-l-0 p-r-0">
                                            <div class="day-of-week @if(in_array(1, $unit_day)) active @endif m-r-5">
                                                <p class="m-b-0">MON</p>
                                                <p class="m-b-0">{{__('supply.job.monday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(2, $unit_day)) active @endif m-r-5">
                                                <p class="m-b-0">tue</p>
                                                <p class="m-b-0">{{__('supply.job.tuesday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(3, $unit_day)) active @endif  m-r-5">
                                                <p class="m-b-0">thu</p>
                                                <p class="m-b-0">{{__('supply.job.thursday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(4, $unit_day)) active @endif  m-r-5">
                                                <p class="m-b-0">wed</p>
                                                <p class="m-b-0">{{__('supply.job.wednesday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(5, $unit_day)) active @endif  m-r-5">
                                                <p class="m-b-0">fri</p>
                                                <p class="m-b-0">{{__('supply.job.friday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(6, $unit_day)) active @endif  m-r-5">
                                                <p class="m-b-0">sat</p>
                                                <p class="m-b-0">{{__('supply.job.saturday')}}</p>
                                            </div>
                                            <div class="day-of-week @if(in_array(0, $unit_day)) active @endif ">
                                                <p class="m-b-0">sun</p>
                                                <p class="m-b-0">{{__('supply.job.sunday')}}</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 text-center  p-l-0 p-r-0 p-t-10">
                                            {{$unit_time_start}}〜{{$unit_time_end}}
                                        </div>
                                    </div>
                                    @if(isset($jobWorkingTime[2]) && isset($jobWorkingTime[2]['day']) && count($jobWorkingTime[2]['day']) >0)
                                        @php
                                            $unit_day = $jobWorkingTime[2]['day'];
                                            $unit_time_start = $jobWorkingTime[2]['start_time'];
                                            $unit_time_end = $jobWorkingTime[2]['end_time'];
                                        @endphp
                                        <div class=" working-time-2 ">
                                            <div class="col-xl-12 form-inline p-l-0 p-r-0">
                                                <div class="day-of-week @if(in_array(1, $unit_day)) active @endif m-r-5">
                                                    <p class="m-b-0">MON</p>
                                                    <p class="m-b-0">{{__('supply.job.monday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(2, $unit_day)) active @endif m-r-5">
                                                    <p class="m-b-0">tue</p>
                                                    <p class="m-b-0">{{__('supply.job.tuesday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(3, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">thu</p>
                                                    <p class="m-b-0">{{__('supply.job.thursday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(4, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">wed</p>
                                                    <p class="m-b-0">{{__('supply.job.wednesday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(5, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">fri</p>
                                                    <p class="m-b-0">{{__('supply.job.friday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(6, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">sat</p>
                                                    <p class="m-b-0">{{__('supply.job.saturday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(0, $unit_day)) active @endif ">
                                                    <p class="m-b-0">sun</p>
                                                    <p class="m-b-0">{{__('supply.job.sunday')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 text-center  p-l-0 p-r-0 p-t-10">
                                                {{$unit_time_start}}〜{{$unit_time_end}}
                                            </div>
                                        </div>


                                    @endif

                                    @if(isset($jobWorkingTime[3]) && isset($jobWorkingTime[3]['day']) && count($jobWorkingTime[3]['day']) >0)
                                        @php
                                            $unit_day = $jobWorkingTime[3]['day'];
                                            $unit_time_start = $jobWorkingTime[3]['start_time'];
                                            $unit_time_end = $jobWorkingTime[3]['end_time'];
                                        @endphp
                                        <div class="working-time-3">
                                            <div class="col-xl-12 form-inline p-l-0 p-r-0">
                                                <div class="day-of-week @if(in_array(1, $unit_day)) active @endif m-r-5">
                                                    <p class="m-b-0">MON</p>
                                                    <p class="m-b-0">{{__('supply.job.monday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(2, $unit_day)) active @endif m-r-5">
                                                    <p class="m-b-0">tue</p>
                                                    <p class="m-b-0">{{__('supply.job.tuesday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(3, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">thu</p>
                                                    <p class="m-b-0">{{__('supply.job.thursday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(4, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">wed</p>
                                                    <p class="m-b-0">{{__('supply.job.wednesday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(5, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">fri</p>
                                                    <p class="m-b-0">{{__('supply.job.friday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(6, $unit_day)) active @endif  m-r-5">
                                                    <p class="m-b-0">sat</p>
                                                    <p class="m-b-0">{{__('supply.job.saturday')}}</p>
                                                </div>
                                                <div class="day-of-week @if(in_array(0, $unit_day)) active @endif ">
                                                    <p class="m-b-0">sun</p>
                                                    <p class="m-b-0">{{__('supply.job.sunday')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 text-center  p-l-0 p-r-0 p-t-10">
                                                {{$unit_time_start}}〜{{$unit_time_end}}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>



                        <div class="form-group row height-70">
                            <div class="col-lg-2 col-xl-2 no-padding">
                                <img class="icon-preview" src="/img/d_pr_21.png" width="100%">
                            </div>
                            <div class="col-lg-10 col-xl-10  p-t-20">
                                @if( isset($job->important1_cd) && isset($importantThing[$job->important1_cd]))
                                    <img width="30" src="{{$importantThing[$job->important1_cd]['img_path']}}" class="m-r-10">
                                @endif
                                @if( isset($job->important2_cd) && isset($importantThing[$job->important2_cd]))
                                    <img width="30" src="{{$importantThing[$job->important2_cd]['img_path']}}" class="m-r-10">
                                @endif
                                @if( isset($job->important3_cd) && isset($importantThing[$job->important3_cd]))
                                    <img width="30" src="{{$importantThing[$job->important3_cd]['img_path']}}" class="">
                                @endif
                            </div>

                        </div>


                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold" >
                        <span aria-hidden="true" onclick="$(function () {$('#job_preview').modal('toggle');});">{{__('閉じる')}}</span>
                    </a>
                    <a href="{{route('supply.job.edit',['id' => $job->job_id])}}" class="btn btn-primary mgt-20 bold " >掲載中の記事を編集する</a>
                </div>
            </div>
        </div>
    </div>
</div>
