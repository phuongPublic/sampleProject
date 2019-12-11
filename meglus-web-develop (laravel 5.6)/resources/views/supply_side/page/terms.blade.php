@extends('layouts.supply_front' )

@section('title')
    利用規約
@stop

@section('layouts.supply_side_header')
    Outlet / Edit
@stop

@section('header')
    @include('layouts.supply_side_header_guest')
@stop

@section('content')
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="text-center">利用規約</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box box-default">
                    <div class="box-body">
                        <p>第1条　総則</p>
                        <p>第2条 定義</p>
                        <p>第3条 本利用規約の改定</p>
                        <p>第4条 会員登録</p>
                        <p>第5条 会員資格の取り消し等</p>
                        <p>第6条 本サイトの役割と責任について</p>
                        <p>第7条 本サイトの利用について</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
@stop

@section('footer')
    @include('layouts.supply_side_footer_guest')
@stop
