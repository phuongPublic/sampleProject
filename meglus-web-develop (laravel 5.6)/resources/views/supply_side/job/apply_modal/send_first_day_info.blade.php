<!-- Modal -->
<div class="modal apply-modal job-apply-modal" tabindex="-1" role="dialog" style="" id="job-apply-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <div class="title bold text-center w-100">{{$data['demand']['name'].__('supply.apply_popup_title.'.$data['action']).(($data['applicant']['send_first_day_info_num'] > 1) ? ' #'.$data['applicant']['send_first_day_info_num'] : '')}}</div>
                <a href="javascript:void(0)" class="close company-close" >
                    <span aria-hidden="true" onclick="$(function () {$('.apply-modal').modal('toggle');});">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <!-- send_interview_info -->
                <form method="POST" href="" name="register_form" id="apply-modal-form" class="apply-modal-form" method="POST" action="/job/apply/{{$data['action']}}/{{$data['applicant']['id']}}">
                    {{ csrf_field() }}
                    <div class="content-box">
                        <h2 class="detail-title">初出社日</h2>
                        <div class="border-part text-center">
                            <div class="row">
                                <div class="col-md-6 show-time-box">
                                    <div class="row p-t-15">
                                        <div class="col-md-4"><span class="fs-700 fs-16" id="">日にち</span></div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control date-choose text-center time-edit datepicker" name="first_day_date" id="first_day_date" value="{{ !empty($data['applicant']['first_day_dt']) ? date('Y/m/d', strtotime($data['applicant']['first_day_dt'])) : date('Y/m/d') }}" {{ !empty($data['applicant']['send_first_day_info_num']) ? 'disabled' : '' }}>
                                            <i class="fa fa-calendar fa-6" style="right: 22px;position:absolute;font-size: 22px;top: 7px;z-index: 9"></i>
                                            <p id="error_for_interview_date"  class="color-red text-left"></p>
                                            <script>
                                                $(function() {
                                                    var option = {
                                                        twentyFour: true,
                                                        title: '時間',
                                                        showSeconds: false,
                                                        now: "{{ !empty($data['applicant']['first_day_dt']) ? date('H:i', strtotime($data['applicant']['first_day_dt'])) : date('H:i') }}"
                                                    };
                                                    $('.timepicker-24-hr').wickedpicker(option);
                                                    $('.datepicker').datepicker({ format: "yyyy/mm/dd",
                                                        language: "ja",minDate: 0, maxDate: "+1M" ,viewMode: "years",minViewMode: "years"});
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 show-time-box">
                                    <div class="row p-t-15">
                                        <div class="col-md-4">
                                            <span class="input-group-text fs-700 fs-16" id="">開始時間</span>
                                        </div>
                                        <div class="col-md-8 input-group">
                                            <input type="text" class="form-control time-choose text-center time-edit timepicker-24-hr" name="first_day_time" id="first_day_time" value="" {{ !empty($data['applicant']['send_first_day_info_num']) ? 'disabled' : '' }}>
                                            <p id="error_for_interview_time" class="color-red text-left"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="detail-title">勤務場所</h2>
                        <div class="border-part">
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="height: 100%"><iframe width="100%" height="100%" src="https://www.google.com/maps/embed/v1/place?q={{ urlencode($data['workplace_address']) }}&key=AIzaSyA4F1x5K8CSqu-uneecw4hDwkDEJqsi7_w" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><br />
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['jobs']['workplace_name_en'] . ' (' . $data['jobs']['workplace_name'] . ') ' }}</p>
                                    <p>〒{{ $data['jobs']['workplace_post_cd'] }}</p>
                                    <p>{{ $data['workplace_address'] }}</p>
                                    <p>{{ $data['company']['tel'] }}</p>
                                    <p>{{ $data['stationInfo'] }}</p>
                                </div>
                            </div>
                        </div>
                        <h2 class="detail-title">注意事項</h2>
                        <div class="border-part">
                            <div class="row">
                                <div class="col-md-10 m-l-15">
                                    <li>初出社に関する不明点は勤務先まで直接お問い合わせください</li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="companyId" value="{{$data['company']['company_id']}}">
                    <div class="content-box text-center close-btn">
                        @if(empty($data['applicant']['send_first_day_info_num']))
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('初勤務日を送信する')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-edit dis-none">
                                <span aria-hidden="true" >{{__('初勤務日を変更する')}}</span>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit dis-none" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('初勤務日を送信する')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-edit">
                                <span aria-hidden="true" >{{__('初勤務日を変更する')}}</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
