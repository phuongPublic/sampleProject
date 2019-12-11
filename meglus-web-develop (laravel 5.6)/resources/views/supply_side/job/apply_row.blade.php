@if(!isset($notTr))
<div class="text-center col-sm-12 table-row grid-b-b p-l-0 p-r-0" id="apply-{{$item->id}}" data-seq="{{$item->seq}}">
@endif
    <div class="float-left text-left w-20 name">
        <img width="50" class="m-r-10" src="{{route('supply.user.avatar', ['id' => $item->demand_user_id])}}?{{date('His')}}">
        <a href="javascript:void(0)" onclick="showUserInfo('{{$item->demand_user_id}}','{{$item->job_id}}');">{{$item->name}}</a>
        @if($jobFlow[$item->seq]['display_badge_at'] == 'applicant')
            <span class="warning warning-applicant">&nbsp;</span>
        @endif
    </div>

    <div class="float-left text-center w-10 progress_status border-left">
        @if(isset($progressStatus[$item->progress_status]))
            {{$progressStatus[$item->progress_status]}}
        @endif

        @if($jobFlow[$item->seq] && $jobFlow[$item->seq]['help_message'])
            <img data-toggle="tooltip" data-html="true" data-placement="bottom" title= '{{$jobFlow[$item->seq]['help_message']}}' class="show-tooltip" width="15" src="/img/question-icon.png">
        @endif
    </div>

    <div class="float-left text-center w-10 updated_at border-left">
        {{date('Y/m/d', strtotime($item->seq_update_dt))}}
    </div>

    <div class="float-left w-35 seq border-right border-left">
        <div class="job_contact float-l h-100000 text-left m-l-4 p-r-10">
            @if($item->application_method == 0)
                <p class="m-b-0"><img width="25" src="/img/phone.png"></p>
            @else
                <p class="m-b-0"><img width="25" src="/img/email.png"></p>
            @endif
        </div>
        <div class="text-left p-r-2">
            {!! Supply::displayMessage($jobFlow[$item->seq],$item, $reasonCd)  !!}
        </div>
    </div>

    <div class="float-left text-right no-center w-17 action p-t-15 ">
        <div class="button-status">
            @php($strTextButton = Supply::displayButtonText($jobFlow[$item->seq],$item))
            @if(strlen($strTextButton) > 0)
                @if( ($item->seq == 'p05' && (int)$item->send_first_day_info_num >= 2) || ($item->seq == 'm05' && (int)$item->send_first_day_info_num >= 2))
                    <button type="button" disabled class="btn btn-info center-block btn-primary float-r text-light job-apply-action">{!! $strTextButton  !!}</button>
                @else
                    <button type="button" com-id="{{$user->companyInfo->company_id}}" data-apply-id="{{$item->id}}" data-action="{{$jobFlow[$item->seq]['action']}}" class="btn btn-info center-block btn-primary float-r text-light job-apply-action">{!! $strTextButton  !!}</button>
                @endif

                @if($jobFlow[$item->seq]['display_badge_at'] == 'button')
                    <span class="warning warning-button">&nbsp;</span>
                @endif
            @endif
        </div>
    </div>

    <div class="float-left text-right no-center p-t-15 w-8 action">
        @php($status = Supply::generateSelectableProgress($item, $jobFlow, $progressStatus))
        @if(strlen($status) > 0)
            {!! $status !!}
            @if($jobFlow[$item->seq]['display_badge_at'] == 'status')
                <span class="warning warning-status">&nbsp;</span>
            @endif
        @endif
    </div>
@if(!isset($notTr))
</div>
@endif

