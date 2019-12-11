@extends('admin.supply_admin' )

@section('title')
    {{__('supply.celebration_money.title_index')}}
@stop

@section('admin.supply_admin_header')
@stop

<style>
    .btn-export-celebration {
        float: right;
        margin-bottom: 15px;
    }
    .hiden-text {
        width: 180px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        display: inline-block;
        cursor: pointer;
    }
</style>

@section('content')
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/moment-with-locales.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bs-material/bootstrap-material-datetimepicker.css') }}" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left">
                                <h3 class="box-title bold">{{__('supply.celebration_money.title_index')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                <!-- Messsage Error -->
                @include('inc.messages')
                    <div class="admin-content ">
                        <div class="box-body m-b-15">
                            <div class="row">
                                <div class="col-2">
                                </div>
                                <div class="col-4" style="display: inherit">
                                    <span class="preview p-t-8 dtp-select-month-before cursor-pointer" id="datepicker-month-before"><i class="material-icons">chevron_left</i></span>
                                    <input class="datepicker form-control w150" id="datepicker" data-date-format="yyyy/mm">
                                    <span class="next  p-t-8  cursor-pointer" id="datepicker-month-after"><i class="material-icons">chevron_right</i></span>
                                    <script>
                                        $( function() {
                                            var datePicker = $('.datepicker').bootstrapMaterialDatePicker({
                                                time: false,
                                                format: 'YYYY/MM',
                                                lang: 'ja',
                                                okText : '同意',
                                                cancelText : 'キャンセル'
                                            });
                                            datePicker.bootstrapMaterialDatePicker('setDate', '{!!$monthFilter!!}');
                                        } );

                                        $('.datepicker').change(function(){
                                            window.location = pageUrl+'?month_filter='+$(this).val();
                                        });
                                    </script>
                                </div>
                                <div class="col-6">
                                    @if (Request::is('admin/celebration/no-adoption'))
                                        <a class="pull-right btn btn-primary btn-export-celebration" href="{{route('admin.celebration.export2')}}">CSV出力</a>
                                    @elseif (Request::is('admin/celebration/other'))
                                        <a class="pull-right btn btn-primary btn-export-celebration" href="{{route('admin.celebration.export3')}}">CSV出力</a>
                                    @else
                                        <a class="pull-right btn btn-primary btn-export-celebration" href="{{route('admin.celebration.export1')}}">CSV出力</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link {{ Request::is('admin/celebration') ? 'active show' : '' }}" href="{{ Request::is('admin/celebration') ? '#' : route('admin.celebration.index')  }}">採用</a>
                                        <a class="nav-link {{ Request::is('admin/celebration/no-adoption') ? 'active show' : '' }}" href="{{ Request::is('admin/celebration/no-adoption') ? '#' : route('admin.celebration.index', ['type' => 'no-adoption'])  }}">不採用・内定取消</a>
                                        <a class="nav-link {{ Request::is('admin/celebration/other') ? 'active show' : '' }}" href="{{ Request::is('admin/celebration/other') ? '#' : route('admin.celebration.index', ['type' => 'other'])  }}">その他</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="table-responsive">

                                            <table id="dtHorizontalExample" class="table" cellspacing="0" style="width: 3000px">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="50">#</th>
                                                        <th width="200">申請者名</th>
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
                                                    <td width="50">{{$index + 1}}</td>
                                                    <td width="200">{{$item->name}}</td>
                                                    <td width="200">
                                                        <a href="{{route('supply.job.detail', ['id' => $item->job_id])}}">
                                                            {{$item->workplace_name}}
                                                        </a>
                                                    </td>
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
                                                    <td width="250">
                                                        <span title="{{$item->questionnaire_text}}" data-toggle="tooltip" data-html="true" data-placement="top" class="hiden-text show-tooltip">
                                                            {{$item->questionnaire_text}}
                                                        </span>
                                                    </td>
                                                    <td width="200">{{$item->bank_cd}}</td>
                                                    <td width="200">{{$item->bank_name}}</td>
                                                    <td width="200">{{$item->bank_branch_cd}}</td>
                                                    <td width="200">{{$item->bank_branch_name}}</td>
                                                    <td width="200">{{$item->bank_account_num}}</td>
                                                    <td width="200">@if ($item->bank_account_type == 0) 普通 @else {{$item->bank_account_type}} @endif</td>
                                                    <td width="200">{{$item->bank_account_name}}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
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
    @include('admin.supply_admin_footer')
@stop
