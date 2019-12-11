<!-- Modal -->
<div class="modal apply-modal job-apply-modal @if( isset($data['custom'])) {{$data['custom']}} @endif" tabindex="-1" role="dialog" style="" id="job-apply-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <div class="title bold text-center w-100">{{ $data['demand']['name'] }}<span class="title-toggle">{{ empty($data['applicant']['send_interview_date_info_num']) ? '様に面接候補日を送信します' :  '様に提案中の面接候補日'}}</span><span class="dis-none title-toggle">{{ __('様に面接候補日を送信します'.(($data['applicant']['send_interview_date_info_num'] > 1) ? ' #'.$data['applicant']['send_interview_date_info_num'] : '')) }}</span></div>
                <a href="javascript:void(0)" class="close company-close" >
                    <span aria-hidden="true" onclick="$(function () {
                    @if( isset($data['custom']) && $data['custom'] == 'customM03')
                        $('.apply-modal.customM03').modal('toggle');
                    @else
                        $('.apply-modal').not('.customM03').modal('toggle');
                    @endif
                        });
                    ">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <!-- send_interview_info -->
                <form method="POST" href="" name="register_form" id="apply-modal-form" class="apply-modal-form @if( isset($data['custom'])) {{$data['custom']}} @endif  " method="POST" action="/job/apply/{{$data['action']}}/{{$data['applicant']['id']}}">
                    {{ csrf_field() }}
                    <div class="content-box">
                        <h2 class="detail-title">{{ $data['demand']['name'] }}様の都合の良い時間帯</h2>
                        <div class="border-part text-center">
                            <div class="row">
                                <div class="col-sm-12 text-center m-b-15">
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(1, $data['work_days'])) active @endif" for="inlineCheckbox1">{{__('supply.job.monday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(2, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.tuesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(3, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.wednesday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(4, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.thursday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(5, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.friday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(6, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.saturday')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline col-1">
                                        <label class="form-check-label day-of-week @if(in_array(0, $data['work_days'])) active @endif" for="job_interview_day">{{__('supply.job.sunday')}}</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <div class="form-check form-check-inline hour-working">
                                        <label class="control-label">{{ date('H:i', strtotime($data['demand']['work_start_time'])) }}</label>
                                            &nbsp;&nbsp;<label class="control-label">～</label>&nbsp;&nbsp;
                                        <label class="control-label">{{ date('H:i', strtotime($data['demand']['work_end_time'])) }}</label>
                                    </div>
                                </div>
                                @if(isset($data['applicant']) && isset($data['applicant']['interview_date_adjustment_text']) && $data['applicant']['seq'] == 'm04')
                                    <div class="col-sm-12 text-center">
                                        <div class="form-check form-check-inline hour-working">
                                            <label class="control-label">
                                                <span class="color-red bold">{{ date('Y/m/d H:i', strtotime($data['applicant']['interview_date_adjustment_text'])) }} </span>の面接を希望しています。
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h2 class="detail-title">面接候補日</h2>
                        <div class="border-part">
                            <div class="row @if((!$data['date_text'] || !isset($data['date_text']['day1'])) || in_array($data['applicant']['seq'],[ 'm04', 'm06'])) show-input @else show-view  @endif" id="apply-modal-edit-view">
                                <div class="col-md-4 popup-date-select">
                                    <p class="p-0 m-t-10 m-b-5 text-center fw-600">面接候補日①（必須）</p>
                                    <div id="calendar1" data-date="interview_date_1"></div>
                                    <div class="form-inline p-t-15">
                                        <div class="text-left m-b-10">
                                            <span class="w-m-80 float-l">日にち</span>
                                            <div class="input-group date">
                                                @if($data['applicant']['seq'] == 'm06')
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar1 time-edit" name="interview_date_1" id="interview_date_1" value="{{ date('Y/m/d') }}" placeholder="{{date('Y/m/d')}}" >
                                                @else
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar1 time-edit" name="interview_date_1" id="interview_date_1" value="{{ old( 'interview_date_1', isset($data['date_text']['day1']) ? date('Y/m/d', strtotime($data['date_text']['day1'])) : date('Y/m/d')) }}" placeholder="{{date('Y/m/d')}}" {{ (!empty($data['applicant']['send_interview_date_info_num']) && !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                                @endif
                                                <span class="input-group-addon"></span><i class="fa fa-calendar fa-6"></i>
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <span class="w-m-80 float-l">開始時間</span><input type="text" class="time-choose text-center time-edit interview_time float-l timepicker-24-hr"  placeholder="11:11"   name="interview_time_1" id="interview_time_1" value="" {{ (!empty($data['applicant']['send_interview_date_info_num']) &&  !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-0 p-r-0 p-t-10 fs-12">
                                        <p id="error_for_interview_date_1" class="m-b-0 color-red"></p>
                                        <p id="error_for_interview_time_1" class="m-b-0 color-red"></p>
                                    </div>
                                </div>

                                <div class="col-md-4 popup-date-select">
                                    <p class="p-0 m-t-10 m-b-5 text-center fw-600">面接候補日②（必須）</p>
                                    <div id="calendar2" data-date="interview_date_2"></div>
                                    <div class="form-inline p-t-15">
                                        <div class="text-left m-b-10">
                                            <span class="w-m-80 float-l">日にち</span>
                                            <div class="input-group date">
                                                @if($data['applicant']['seq'] == 'm06')
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar2 time-edit" name="interview_date_2" id="interview_date_2" value="{{ date('Y/m/d') }}" placeholder="{{date('Y/m/d')}}" >

                                                @else
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar2 time-edit" name="interview_date_2" id="interview_date_2" value="{{ old( 'interview_date_2', isset($data['date_text']['day2']) ? date('Y/m/d', strtotime($data['date_text']['day2'])) :  date('Y/m/d')) }}" placeholder="{{date('Y/m/d')}}" placeholder="{{date('Y/m/d')}}" {{ (!empty($data['applicant']['send_interview_date_info_num']) && !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                                @endif
                                                <span class="input-group-addon"></span><i class="fa fa-calendar fa-6"></i>
                                            </div>

                                        </div>
                                        <div class="text-left">
                                            <span class="w-m-80 float-l">開始時間</span><input type="text" class="time-choose text-center time-edit interview_time float-l timepicker-24-hr" name="interview_time_2"   placeholder="12:12"   id="interview_time_2" value="" {{ (!empty($data['applicant']['send_interview_date_info_num']) && !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-0 p-r-0 p-t-10 fs-12">
                                        <p id="error_for_interview_date_2" class="m-b-0 color-red"></p>
                                        <p id="error_for_interview_time_2" class="m-b-0 color-red"></p>
                                    </div>
                                </div>

                                <div class="col-md-4 popup-date-select">
                                    <p class="p-0 m-t-10 m-b-5 text-center fw-600">面接候補日③（必須）</p>
                                    <div id="calendar3" data-date="interview_date_3"></div>
                                    <div class="form-inline p-t-15">
                                        <div class="text-left m-b-10">
                                            <span class="w-m-80 float-l">日にち</span>
                                            <div class="input-group date">
                                                @if($data['applicant']['seq'] == 'm06')
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar3 time-edit glyphicon glyphicon-th" name="interview_date_3" id="interview_date_3" value="{{ date('Y/m/d') }}" placeholder="{{date('Y/m/d')}}" >
                                                @else
                                                    <input type="text" readonly class="datepicker interview_date float-l calendar3 time-edit glyphicon glyphicon-th" name="interview_date_3" id="interview_date_3" value="{{ old( 'interview_date_3', isset($data['date_text']['day3']) ? date('Y/m/d', strtotime($data['date_text']['day3'])) :  date('Y/m/d')) }}" placeholder="{{date('Y/m/d')}}" {{ (!empty($data['applicant']['send_interview_date_info_num']) &&  !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                                @endif
                                                <span class="input-group-addon"></span><i class="fa fa-calendar fa-6"></i>
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <span class="w-m-80 float-l">開始時間</span><input type="text" class="time-choose text-center time-edit interview_time float-l timepicker-24-hr" name="interview_time_3" placeholder="13:13" id="interview_time_3" value="" {{ (!empty($data['applicant']['send_interview_date_info_num']) &&  !in_array($data['applicant']['seq'],['m04','m06']) && $data['custom'] != 'customM03') ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-0 p-r-0 p-t-10 fs-12">
                                        <p id="error_for_interview_date_3" class="m-b-0 color-red"></p>
                                        <p id="error_for_interview_time_3" class="m-b-0 color-red"></p>
                                    </div>
                                </div>

                                <div class="col-sm-6 offset-sm-3 popup-date-view">
                                    <p class="m-b-5">面接候補日1<span class="p-l-30">{{isset($data['date_text']['day1']) ? date('Y/m/d', strtotime($data['date_text']['day1'])) : '' }}</span><span class="p-l-20">{{isset($data['date_text']['day1']) ? date('H : i', strtotime($data['date_text']['day1'])) : '' }}</span></p>
                                    <p class="m-b-5">面接候補日2<span class="p-l-30">{{isset($data['date_text']['day2']) ? date('Y/m/d', strtotime($data['date_text']['day2'])) : '' }}</span><span class="p-l-20">{{isset($data['date_text']['day2']) ? date('H : i', strtotime($data['date_text']['day2'])) : '' }}</span></p>
                                    <p class="m-b-5">面接候補日3<span class="p-l-30">{{isset($data['date_text']['day3']) ? date('Y/m/d', strtotime($data['date_text']['day3'])) : '' }}</span><span class="p-l-20">{{isset($data['date_text']['day3']) ? date('H : i', strtotime($data['date_text']['day3'])) : '' }}</span></p>
                                </div>

                                <script>
                                    $(function() {
                                        @if($data['applicant']['seq'] == 'm06')
                                            var time1 = "{{ date('H:i') }}";
                                            var time2 = "{{ date('H:i') }}";
                                            var time3 = "{{ date('H:i') }}";
                                        @else
                                            var time1 = "{{ old( 'interview_time_1', isset($data['date_text']['day1']) ? date('H:i', strtotime($data['date_text']['day1'])) : date('H:i')) }}";
                                            var time2 = "{{ old( 'interview_time_2', isset($data['date_text']['day2']) ? date('H:i', strtotime($data['date_text']['day2'])) : date('H:i')) }}";
                                            var time3 = "{{ old( 'interview_time_3', isset($data['date_text']['day3']) ? date('H:i', strtotime($data['date_text']['day3'])) : date('H:i')) }}";
                                        @endif

                                        var option = {
                                        twentyFour: true,
                                        title: '時間',
                                        showSeconds: false,
                                        now: time1,
                                    };
                                        $('#interview_time_1').wickedpicker(option);
                                        var option2 = {
                                        twentyFour: true,
                                        title: '時間',
                                        showSeconds: false,
                                        now: time2,
                                    };
                                        $('#interview_time_2').wickedpicker(option2);
                                        var option3 = {
                                            twentyFour: true,
                                            title: '時間',
                                            showSeconds: false,
                                            now: time3,
                                        };
                                        $('#interview_time_3').wickedpicker(option3);
                                        $('.datepicker').datepicker({ format: "yyyy/mm/dd",
                                            language: "ja",minDate: 0, maxDate: "+1M" ,viewMode: "years",minViewMode: "years"});
                                    });
                                </script>
                            </div>
                        </div>
                        <h2 class="detail-title">注意事項</h2>
                        <div class="border-part">
                            <div class="row">
                                <div class="col-md-10 m-l-15">
                                    <li>応募者の都合の良い時間帯を考慮し、面接候補日を提案してください。</li>
                                    <li>面接日は本日から30日以内で、開始時間を指定することができます。</li>

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="companyId" value="{{$data['company']['company_id']}}">
                    <div class="content-box text-center close-btn">
                        @if(empty($data['applicant']['send_interview_date_info_num']) || $data['applicant']['seq'] == 'm04')
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit" data-form-id="apply-modal-form"
                               @if( isset($data['custom']))
                               custom-action="{{$data['custom']}}"
                               @endif
                               submit-ajax="true">
                                <span aria-hidden="true" >{{__('面接候補日を送信する')}}</span>
                            </a>
                        @else
                            @if( isset($data['custom']) && $data['custom'] == 'customM03')
                                <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit"
                                   @if( isset($data['custom']))
                                   custom-action="{{$data['custom']}}"
                                   @endif
                                   data-form-id="apply-modal-form" submit-ajax="true">
                                    <span aria-hidden="true" >{{__('面接候補日を送信する')}}</span>
                                </a>
                            @else
                                @if($data['applicant']['seq'] == 'm06')
                                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit" data-form-id="apply-modal-form" submit-ajax="true">
                                        <span aria-hidden="true" >{{__('面接候補日を送信する')}}</span>
                                    </a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-close">
                                    <span aria-hidden="true" onclick="$(function () {
                                        $('.apply-modal').not('.customM03').modal('toggle');
                                        });
                                        " >
{{--                                        {{__('閉じる。応募者からの返事を待つ')}}--}}
                                        {{__(' 閉じる')}}
                                    </span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit dis-none" data-form-id="apply-modal-form" submit-ajax="true">
                                        <span aria-hidden="true" >{{__('面接候補日を送信する')}}</span>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-edit">
                                        <span aria-hidden="true" >
{{--                                            {{__('ボタン内のテキスト調整')}}--}}
                                            {{__('面接候補日を再送信する')}}
                                        </span>
                                    </a>
                                @endif
                            @endif

                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
