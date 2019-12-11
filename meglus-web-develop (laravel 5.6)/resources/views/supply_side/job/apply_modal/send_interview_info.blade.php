<!-- Modal -->
<div class="modal apply-modal job-apply-modal" tabindex="-1" role="dialog" style="" id="job-apply-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <div class="title bold text-center w-100">{{ $data['demand']['name'].__('supply.apply_popup_title.'.$data['action']).(($data['applicant']['send_interview_info_num'] > 1) ? ' #'.$data['applicant']['send_interview_info_num'] : '')}}</div>
                <a href="javascript:void(0)" class="close company-close" >
                    <span aria-hidden="true" onclick="$(function () {
                    @if( isset($data['custom']) && $data['custom'] == 'customM03')
                        $('.apply-modal.customM03').modal('toggle');
                    @else
                        $('.apply-modal').not('.customM03').modal('toggle');
                    @endif
                    });">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <!-- send_interview_info -->
                <form method="POST" href="" name="register_form" id="apply-modal-form" class="apply-modal-form" method="POST" action="/job/apply/{{$data['action']}}/{{$data['applicant']['id']}}">
                    {{ csrf_field() }}
                    <div class="content-box">
                        <h2 class="detail-title">面接日時</h2>
                        <div class="border-part text-center">
                            <div class="row">
                                <div class="col-md-6 show-time-box">
                                    <div class="row p-t-15">
                                        <div class="col-md-4">
                                            <span class="fs-700 fs-16" id="">日にち</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control date-choose text-center time-edit datepicker" name="interview_date" id="interview_date" value="{{ !empty($data['applicant']['interview_dt']) ? date('Y/m/d', strtotime($data['applicant']['interview_dt'])) : date('Y/m/d') }}" {{ !empty($data['applicant']['send_interview_info_num']) ? 'disabled' : '' }}>
                                            <i class="fa fa-calendar fa-6" style="right: 22px;position:absolute;font-size: 22px;top: 7px;z-index: 9"></i>
                                            <p id="error_for_interview_date"  class="color-red text-left"></p>
                                            <script>
                                                $(function() {
                                                    var option = {
                                                        twentyFour: true,
                                                        title: '時間',
                                                        showSeconds: false,
                                                        now: "{{ !empty($data['applicant']['interview_dt']) ? date('H:i', strtotime($data['applicant']['interview_dt'])) : date('H:i') }}",
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
                                            <input type="text" class="form-control time-choose text-center time-edit timepicker-24-hr" name="interview_time" id="interview_time" value="{{ !empty($data['applicant']['interview_dt']) ? date('H:i', strtotime($data['applicant']['interview_dt'])) : date('H:i') }}" {{ !empty($data['applicant']['send_interview_info_num']) ? 'disabled' : '' }}>
                                            <p id="error_for_interview_time" class="color-red text-left"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="detail-title">面接場所</h2>
                        <div class="border-part">
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="height: 100%"><iframe width="100%" height="100%" src="https://www.google.com/maps/embed/v1/place?q={{ urlencode($data['interview_address']) }}&key=AIzaSyA4F1x5K8CSqu-uneecw4hDwkDEJqsi7_w" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><br />
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['jobs']['workplace_name_en'] . ' (' . $data['jobs']['workplace_name'] . ') ' }}</p>
                                    <p>〒{{ $data['jobs']['interview_place_post_cd'] }}</p>
                                    <p>{{ $data['interview_address'] }}</p>
                                    <p>{{ $data['company']['tel'] }}</p>
                                    <p>{{ $data['stationInfo'] }}</p>
                                </div>
                            </div>
                        </div>
                        <h2 class="detail-title">注意事項</h2>
                        <div class="border-part">
                            <div class="row">
                                <div class="col-md-10 m-l-15">
                                    <li>面接日時は、応募者と電話で調整した日程を入力してください。</li>
                                    <li>面接候補日を送信すると、面接日程が最終確定します。</li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="companyId" value="{{$data['company']['company_id']}}">
                    <div class="content-box text-center close-btn">
                        @if($data['applicant']['seq'] == 'm03')
                            <a data-toggle="modal" href="#m03-dialog" class="btn btn-primary mgt-20 bold" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('面接日程を再調整する')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('面接案内を送信して面接日を確定する')}}</span>
                            </a>
                        @elseif(empty($data['applicant']['send_interview_info_num']))
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('面接案内を送信して面接日を確定する')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-edit dis-none">
                                <span aria-hidden="true" >{{__('面接時間を変更する')}}</span>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-submit dis-none" data-form-id="apply-modal-form" submit-ajax="true">
                                <span aria-hidden="true" >{{__('面接案内を送信して面接日を確定する')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold apply-modal-edit">
                                <span aria-hidden="true" >{{__('面接時間を変更する')}}</span>
                            </a>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- custom for M03 -->
<div class="modal fade " id="m03-dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-left: calc(50% - 300px);width: 500px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                確定後の面接日を再調整すると、応募者は他求人で採用される確率が高まります。本当に面接日程の再調整を行いますか？
            </div>
            <div class="modal-footer">
                {{--<a data-toggle="modal" href="#show2" class="btn btn-primary">面接日程を再調整する</a>--}}
                <a href="#" data-dismiss="modal" class="btn btn-primary">再調整しない</a>
                <button type="button" com-id="{{$data['company']['company_id']}}" data-apply-id="{{$data['applicant']['id']}}" data-sec="2ASsAS" data-action="apply" custom-action="customM03" class="btn center-block btn-primary float-r text-light job-apply-action">面接日程を再調整する</button>
            </div>
        </div>
    </div>
</div>
<!-- END custom for M03 -->

