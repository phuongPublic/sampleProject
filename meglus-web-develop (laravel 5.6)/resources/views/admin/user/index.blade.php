@extends('admin.supply_admin' )

@section('title')
    {{__('supply.user.title_index')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')
    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left">
                                <h3 class="box-title bold">{{__('supply.user.title_index')}} </h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- Messsage Error -->
                    @include('inc.messages')
                    <script>
                        var sortingData = {};
                        @if(isset($sort))
                            sortingData = {!! json_encode($sort) !!};
                                @endif
                        var filterData = {};
                        @if(isset($filter))
                            filterData = {!! json_encode($filter) !!};
                        @endif


                    </script>

                    <div class="admin-content ">
                        <div class="box-body m-b-15">
                            <div class="row table-filter m-b-15">
                                <form method="GET" action="/admin/user">
                                    <div class="col-sm-12 form-inline">
                                        <input class="form-control w180 m-r-15" id="filter_name" type="text" name="filter[name]" @if(isset($filter['name'])) value="{{$filter['name']}}" @endif placeholder="氏名">
                                        <input class="form-control w180 m-r-15" id="filter_login_id" type="text" name="filter[login_id]" @if(isset($filter['login_id'])) value="{{$filter['login_id']}}" @endif placeholder="ログインID">
                                        <input class="form-control w180 m-r-15" id="filter_company_name" type="text" name="filter[company_name]" @if(isset($filter['company_name'])) value="{{$filter['company_name']}}" @endif placeholder="会社名">

                                        @if(isset($sort))
                                            @foreach($sort as $key => $item)
                                                <input type="hidden" name="sort[{{$key}}]" value="{{$item}}">
                                            @endforeach
                                        @endif
                                        <button type="submit" id="filter_submit" class="btn btn-primary">検索</button>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive ">
                                <table class="table admin-table table-bordered table-striped" id="table-supply">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;min-width: 50px;" class="text-center color-blue">#</th>
                                            <th style="width:200px;min-width: 200px;" class="text-center name"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'first_name')}} >氏名</a></th>
                                            <th style="width:250px;min-width: 250px;" class="text-center mail"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'login_id')}}>ログインID</a></th>
                                            <th style="width:250px;min-width: 250px;" class="text-center tel_"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'company_name')}}>会社名</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center post_cd_"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'status')}}>ステータス</a></th>
                                            <th style="width:200px;min-width: 200px;" class="text-center created_at"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'created_at')}}>登録日時</a></th>
                                            <th style="width:200px;min-width: 200px;" class="text-center updated_at"><a href="javascript:void(0)" class="multiple-sort-user" {{Supply::makeDataAttr($sort,'updated_at')}}>更新日時</a></th>
                                            <th style="min-width: 200px;" class="text-center color-blue">アクション</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $item)
                                            <tr class="text-center table-row row-{{$item->id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->id}}"  data-id="{{$item->id}}">
                                                <td class="text-left  w50 p-l-5 p-r-5 text-center">{{$key +1}}</td>
                                                <td class="text-left  w200 p-l-5 p-r-5 break-all name">{{$item->last_name}} {{$item->first_name}}</td>
                                                <td class="text-left border-left w250 p-l-5 p-r-5 break-all login_id ">{{$item->login_id}}</td>
                                                <td class="text-center border-left w250 p-l-5 p-r-5 break-all company_name">@if(isset($item->companyInfo->company_name)){{$item->companyInfo->company_name}}@endif</td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 status">@if($item->status == 0) 新規 @elseif($item->status == 1) 有効 @else 無効 @endif</td>
                                                <td class="text-center border-left w200 p-l-5 p-r-5 created_at">{{$item->created_at}}</td>
                                                <td class="text-center border-left w200 p-l-5 p-r-5 updated_at">{{$item->updated_at}}</td>
                                                <td class="text-center border-left p-l-5 p-r-5 action color-blue">
                                                    <button class="btn btn-info dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選択してください </button>
                                                    <div class="dropdown-menu" id="action-{{$item->id}}" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" href="{{route('admin.user.password', ['id' => $item->id])}}" >パスワードを変更する</a>
                                                        @if($item->status == 1)
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('編集', 'ユーザーを更新。','{{route('admin.user.block',['id' => $item->id])}}')">やめる</a>
                                                        @elseif($item->status == 9)
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('編集', 'ユーザーを更新。','{{route('admin.user.unblock',['id' => $item->id])}}')">ブロック解除</a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{route('admin.user.edit', ['id' => $item->id])}}" >編集する</a>

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center navigation">
                            {{ $users->appends(['sort' => $sort,'filter' => $filter])->links('partials.pagination') }}
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirm-modal">
                            <div class="modal-dialog modal-sm" style="width: 400px">
                                <div class="modal-content" >
                                    <div class="modal-header text-right">
                                        <div class="" ><b id="title-modal-confirm"></b></div>
                                        <a href="javascript:void(0)" class="close " >
                                            <span aria-hidden="true" onclick="$(function () {$('#confirm-modal').modal('toggle');});">&times;</span>
                                        </a>
                                    </div>
                                    <div class="modal-body p-l-15 p-r-15 p-t-0 p-b-0" id="modal-body-confirm"></div>
                                    <div class="modal-footer" style="border-top: 0px;">
                                        <a class="btn btn-secondary" href="javascript:void(0);" onclick="$(function () {$('#confirm-modal').modal('toggle');});" >キャンセル</a>
                                        <a href="" class="btn btn-primary" id="link-modal">同意</a>
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
