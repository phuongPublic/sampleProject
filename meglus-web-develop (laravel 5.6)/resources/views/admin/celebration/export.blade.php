<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <table id="dtHorizontalExample" class="table" cellspacing="0" style="width: 3000px;">
    <thead>
    <tr class="text-center">
        <th width="50">#</th>
        <th width="200"><b>申請者名</b></th>
        <th width="200">求人名</th>
        <th width="200">申請日</th>
        <th width="200">更新日</th>
        <th width="200">残日数</th>
        <th width="200">初勤務日</th>
        <th width="200">アンケート点数</th>
        <th width="200">アンケートコメント</th>
        <th width="200">銀行番号</th>
        <th width="200">銀行名</th>
        <th width="200">支店番号</th>
        <th width="200">支店名</th>
        <th width="200">口座番号</th>
        <th width="200">預金種目</th>
        <th width="200">口座名義</th>
    </tr>
    </thead>
    <tbody>
    @foreach($celebrationMoney as $index => $item)
        <tr class="text-center">
            <td width="50" align="right">{{$index + 1}}</td>
            <td width="200" align="right"><h1>{{$item->name}}</h1></td>
            <td width="200" align="right">{{$item->workplace_name}}</td>
            <td width="200">{{$item->celebration_money_created_at}}</td>
            <td width="200">
                @if ($item->celebration_money_status == 0)
                    -
                @else
                    {{$item->set_employment_dt}}
                @endif
            </td>
            <td width="200">
                @php
                    $now = \Carbon\Carbon::now();
                    $createDate = new \Carbon\Carbon($item->celebration_money_created_at);
                    $dateAdd = $createDate->addDays(30);
                @endphp
                @if ($item->celebration_money_status == 0)
                    -
                @else
                    {{$dateAdd->diffInDays($now)}}
                @endif
            </td>
            <td width="200">{{$item->first_work_day}}</td>
            <td width="200">{{$item->questionnaire_score}}</td>
            <td width="200">{{$item->questionnaire_text}}</td>
            <td width="200">{{$item->bank_cd}}</td>
            <td width="200">{{$item->bank_name}}</td>
            <td width="200">{{$item->bank_branch_cd}}</td>
            <td width="200">{{$item->bank_branch_name}}</td>
            <td width="200">{{(string)$item->bank_account_num}}</td>
            <td width="200">@if ($item->bank_account_type == 0) 普通 @else {{$item->bank_account_type}} @endif</td>
            <td width="200">{{$item->bank_account_name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>