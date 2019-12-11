@extends('admin.supply_admin' )

@section('title')
    {{$title}}
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
                                <h3 class="box-title bold">{{$title}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- Messsage Error -->
                    @include('inc.messages')
                    <style>
                        .table-scroll {
                            position:relative;
                            max-width:100%;
                            margin:auto;
                            overflow:hidden;
                            border-bottom:1px solid #dee2e6;
                            border-right:1px solid #dee2e6;
                        }
                        .table-wrap {
                            width:100%;
                            overflow:auto;
                        }
                        .table-scroll table {
                            width:100%;
                            margin:auto;
                            border-collapse:separate;
                            border-spacing:0;
                        }
                        .table-scroll th, .table-scroll td {
                            padding:5px !important;
                            border-bottom:1px solid #dee2e6;
                            border-right:1px solid #dee2e6;
                            background:rgba(255,255,255,0.5);
                            white-space:nowrap;
                            vertical-align:center;
                            text-align: center;
                        }

                        .table-scroll th{
                            padding:5px 5px 5px 15px!important;
                            text-align: left;
                        }
                        .table-scroll thead, .table-scroll tfoot {
                            background:#f9f9f9;
                        }
                        .clone {
                            position:absolute;
                            top:0;
                            left:0;
                            pointer-events:none;
                        }
                        .clone th, .clone td {
                            visibility:hidden
                        }
                        .clone td, .clone th {
                            border-color:transparent
                        }
                        .clone tbody th {
                            visibility:visible;
                            color:red;
                        }
                        .clone .fixed-side {
                            border-bottom:1px solid #dee2e6;
                            border-right:1px solid #dee2e6;
                            background:#fff;
                            visibility:visible;
                            color: #000;
                            font-weight: normal;
                        }
                        .clone thead, .clone tfoot{background:transparent;}
                    </style>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
                        });

                    </script>
                    @include('admin.kpi.top')
                    <div class="admin-content ">
                        <div class="box-body m-b-15">
                            <div class="row">
                                @include('admin.kpi.sidebar')
                                <div class="col-10">
                                    <div class="table-scroll" id="table-scroll">
                                        <div class="table-wrap">
                                            <table class="main-table">
                                                <tbody>
                                                @php($index = 0)
                                                @foreach($data as $key => $items)
                                                    @php($index++)
                                                    <tr>
                                                        @foreach($items as $i => $item)
                                                            @if((string)$i == 'label-input')
                                                                <th class="fixed-side"   style="min-width: 180px;">
                                                                    <div class="form-inline">
                                                                        <span class="preview p-t-8 dtp-select-month-before cursor-pointer" id="datepicker-month-before"><i class="material-icons">chevron_left</i></span>
                                                                        <input class="datepicker w90 form-control " id="datepicker" data-date-format="yyyy/mm">
                                                                        <span class="next  p-t-8  cursor-pointer" id="datepicker-month-after"><i class="material-icons">chevron_right</i></span>
                                                                    </div>
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
                                                                <th class="fixed-side"   style="min-width: 180px;">{{$item}}</th>
                                                            @else
                                                                <td>{{$item}}</td>
                                                            @endif
                                                        @endforeach
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
