<!-- p03 -->
<div class="modal application_modal" id="apply_default_popup" tabindex="-1" role="dialog" style="">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 1000px;">
            <div class="modal-header text-right">
                <div class="title bold text-center w-100">{{$demandUser->name}}様に内定通知を送信します</div>
                <a href="javascript:void(0)" class="close " >
                    <span aria-hidden="true" onclick="$(function () {$('.application_modal').modal('toggle');});">&times;</span>
                </a>
            </div>
            <form id="job_apply_popup_form" method="POST" action="/job/applicant/update/{{$encrypt}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row form-group-list">
                        <div class="col-sm-12">
                            <h2 class="detail-title">選考結果</h2>
                            <div class="col-sm-12 p-t-15 p-b-15 m-b-15 border-part">
                                <p class="m-b-0">応募者：{{$demandUser->name}}</p>
                                <p class="m-b-0">企業名：{{$job->company_name}}</p>
                                <p class="m-b-0">勤務先：{{$job->workplace_name}}</p>
                                <p class="m-b-0">応募日：{{date('Y/m/d', strtotime($applicant->created_at))}}</p>
                                <p class="m-b-0">選考結果：{{$jobProgressStatus[$param['status']]}}</p>
                            </div>
                            <h2 class="detail-title">注意事項</h2>
                            <div class="col-sm-12 p-t-15 p-b-15 m-b-15 border-part"  id="error-sys-are">
                                <p class="m-b-0">・「ステータスを内定に変更する」を押下すると応募者に内定通知が届きます。</p>
                                <p class="m-b-0">・内定通知送信後、初勤務日を送信してください。</p>
                            </div>
                        </div>
                    </div>
                    <div class="row-bottom text-center close-btn">
                        <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold " >
                            <span aria-hidden="true" onclick="$(function () {$('.application_modal').modal('toggle');});">{{__('ステータスを変更しない')}}</span>
                        </a>
                        <button type="button" class="btn btn-primary mgt-20 bold popup-submit-form-ajax" submit-ajax="true" data-form-id="job_apply_popup_form">{{__('ステータスを内定に変更して、内定通知を送信する')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
