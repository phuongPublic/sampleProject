@if(!isset($notTr))
<tr class="text-center"  id="apply-{{$item->id}}">
@endif
    <td style="width:50px;min-width: 50px;" class="text-left" width="" >
        <img width="50" src="{{route('supply.user.avatar', ['id' => $item->demand_user_id])}}">
    </td>
    <td class="text-left">
        <a href="javascript:void(0)" onclick="showUserInfo('{{$item->demand_user_id}}','{{isset($item->job->job_id) ? $item->job->job_id : ''}}');">
            @if (isset($item->demandUser->name)){{$item->demandUser->name}} @endif
        </a>
    </td>
    <td class=""><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-sequence-history" onclick="showSequenceHistory('{{$item->id}}');">{{$item->seq}}</a></td>
    <td class="">{{date('Y/m/d', strtotime($item->seq_update_dt))}}</td>
    <td class="">
        @if(isset($item->job->workplace_name))
            {{$item->job->workplace_name }}
        @endif
    </td>
    <td class="text-center" >
        @if(isset($item->job->jobCategory) && isset($item->job->jobCategory->icon_filepath))
            <img width="30" src="{{$item->job->jobCategory->icon_filepath}}">
        @endif
    </td>
    <td class="text-center">
        @if(isset($item->job->jobCategoryDescription->name))
            {{ $item->job->jobCategoryDescription->name }}
        @endif
    </td>
    <td class="align-middle text-center">
        <div class="action">
            @php($status = Supply::generateSelectableProgress($item, $jobFlow, $progressStatus))
            @if(strlen($status) > 0)
                {!! $status !!}
            @endif
        </div>
    </td>
@if(!isset($notTr))
</tr>
@endif
