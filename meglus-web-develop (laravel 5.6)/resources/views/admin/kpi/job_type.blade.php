@extends('admin.supply_admin' )

@section('title')
    {{__('supply.kpi.job_type')}}
@stop

@section('admin.supply_admin_header')
@stop

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
                                <h3 class="box-title bold">{{__('supply.kpi.job_type')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- Messsage Error -->
                    @include('inc.messages')
                    <div class="admin-content ">
                        <div class="box-body m-b-15">
                            <div class="row">
                                @include('admin.kpi.sidebar')
                                <div class="col-10">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade active show" style="overflow-y: auto">
                                            <style>
                                                .table td, .table th{vertical-align: unset}
                                            </style>
                                            <table class="table m-b-0" style="border: none;table-layout:fixed;" >
                                                <tbody>
                                                @php($index = 0)
                                                @foreach($data as $key => $items)
                                                    @php($index++)
                                                    <tr style="width: auto">
                                                        @foreach($items as $i => $item)
                                                            @if((string)$i == 'label-input')
                                                                <th width="300" style="border-left: 0px solid #ccc;border-right: 1px solid #ccc; @if($index > 1) border-top: 1px solid #ccc; @endif border-bottom: 1px solid #ccc;text-align: left" >
                                                                    <span class="preview float-left p-t-8 cursor-pointer dtp-select-month-before" id="datepicker-month-before"><i class="material-icons">chevron_left</i></span>
                                                                    <input class="datepicker form-control w90 float-left" id="datepicker" data-date-format="yyyy/mm">
                                                                    <span class="next float-left p-t-8 cursor-pointer" id="datepicker-month-after"><i class="material-icons">chevron_right</i></span>
                                                                    <script>
                                                                        $( function() {
                                                                            var datePicker = $('.datepicker').bootstrapMaterialDatePicker({
                                                                                time: false,
                                                                                format: 'YYYY/MM',
                                                                                lang: 'ja',
                                                                                okText : '同意',
                                                                                cancelText : 'キャンセル'
                                                                            });
                                                                            datePicker.bootstrapMaterialDatePicker('setDate', '{!! $monthFilter !!}');
                                                                        } );

                                                                        $('.datepicker').change(function(){
                                                                            window.location = pageUrl+'?month_filter='+$(this).val();
                                                                        });
                                                                    </script>
                                                                </th>
                                                            @elseif((string)$i == 'label')
                                                                <th style="border-left: 0px solid #ccc;border-right: 1px solid #ccc; @if($index > 1) border-top: 1px solid #ccc; @endif border-bottom: 1px solid #ccc;text-align: left" >
                                                                    {{$item}}
                                                                </th>
                                                            @else
                                                                <td width="80" style="@if($index > 1) border-top: 1px solid #ccc; @endif border-left: 1px solid #ccc;text-align: center; ">
                                                                    {{$item}}
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @if(count($data) == 0)
                                                <p class="text-center p-t-15" >No records</p>
                                            @endif

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
