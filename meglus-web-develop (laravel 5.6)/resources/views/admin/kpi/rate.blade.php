@extends('admin.supply_admin' )

@section('title')
    {{__('supply.kpi.title_rate')}}
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
                                <h3 class="box-title bold">{{__('supply.kpi.title_rate')}}</h3>
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
                                            <table class="table m-b-0" style="border: none" >
                                                <tbody>
                                                <tr>
                                                    <th width="400" style="text-align: center">
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
                                                    @foreach($days as $item)
                                                        <td width="100" style="border-top: 0px solid #ccc;border-left: 1px solid #ccc;text-align: center">
                                                            {{date('d', strtotime($item))}}
                                                        </td>

                                                    @endforeach
                                                </tr>

                                                @foreach($keys as $key)
                                                    <tr>
                                                        <th width="300" style="border-left: 0px solid #ccc;border-right: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;text-align: left">{{__('supply.kpi.'.$key)}}</th>
                                                        @foreach($days as $item)
                                                            <td style="border: 1px solid #ccc; text-align: center">
                                                                @if(isset($kpis[$key]) && isset($kpis[$key][$item]))
                                                                    {{$kpis[$key][$item]}}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>

                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @if(count($keys) == 0)
                                                <p class="text-center p-t-15" style="border-top: 1px solid #ccc;">No records</p>
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
