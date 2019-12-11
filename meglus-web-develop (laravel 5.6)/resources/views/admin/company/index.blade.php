@extends('admin.supply_admin' )

@section('title')
    {{__('supply.company.index')}}
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
                                <h3 class="box-title bold">{{__('supply.company.index')}}</h3>
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
                                <div class="col-sm-9 form-inline">
                                    <form method="GET" action="/admin/company">
                                        <input class="form-control w180 m-r-15" id="filter_name" type="text" name="filter[company_name]" @if(isset($filter['company_name'])) value="{{$filter['company_name']}}" @endif placeholder="会社名">
                                        <input class="form-control w180 m-r-15" id="filter_login_id" type="text" name="filter[company_id]" @if(isset($filter['company_id'])) value="{{$filter['company_id']}}" @endif placeholder="会社ID">

                                        @if(isset($sort))
                                            @foreach($sort as $key => $item)
                                                <input type="hidden" name="sort[{{$key}}]" value="{{$item}}">
                                            @endforeach
                                        @endif
                                        <button type="submit" id="filter_submit" class="btn btn-primary">検索</button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive ">
                                <table class="table admin-table table-bordered table-striped" id="table-company">
                                    <thead>
                                        <tr class="text-center grid-b-b p-l-0 p-r-0 p-b-10 bold">
                                            <th style="width:50px;min-width: 50px;"  class="text-center  p-l-5 p-r-5 text-center color-blue">#</th>
                                            <th style="width:50px;min-width: 50px;" class="text-center w p-l-5 p-r-5 name"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'company_id')}} >ID</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-5 p-r-5 name"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'company_name')}} >会社名</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-5 p-r-5 name"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'company_name_en')}} >会社名</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 mail"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'job_category_cd')}}>職種</a></th>
                                            <th style="width:250px;min-width: 250px;" class="text-center w p-l-6 p-r-5 tel_"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'tel')}}>電話</a></th>
                                            <th style="width:250px;min-width: 250px;" class="text-center w p-l-6 p-r-5 post_cd_"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'post_cd')}}>郵便</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 created_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'prefecture')}}>都道府県</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 created_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'city1')}}>市区町村1</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'city2')}}>市区町村2</a></th>
                                            <th style="width:200px;min-width: 200px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'detail_address')}}>丁目・番地</a></th>
                                            <th style="width:200px;min-width: 200px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'building_name')}}>建物名</a></th>
                                            <th style="width:200px;min-width: 200px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'building_name_en')}}>建物名（半角英数）</a></th>
                                            <th style="width:100px;min-width: 100px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'max_job_num')}}>記事上限数</a></th>
                                            <th style="width:100px;min-width: 100px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-company" {{Supply::makeDataAttr($sort,'status')}}>ステータス</a></th>
                                            <th class="text-center p-l-6 p-r-5 action color-blue">アクション</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($companies as $key => $item)
                                        <tr class="table-row row-{{$item->company_id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->company_id}}"  data-id="{{$item->company_id}}">
                                            <td class="text-left   p-l-5 p-r-5 text-center">{{$key +1}}</td>
                                            <td class="text-left   p-l-5 p-r-5 text-center">{{$item->company_id}}</td>
                                            <td class="text-left   p-l-5 p-r-5 break-all name">{{$item->company_name}}</td>
                                            <td class="text-left   p-l-5 p-r-5 break-all name">{{$item->company_name_en}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 break-all">{{$item->job_category_name}}</td>
                                            <td class="text-left border-left  p-l-5 p-r-5 break-all">{{$item->tel}}</td>
                                            <td class="text-left border-left  p-l-5 p-r-5 break-all">{{$item->post_cd}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 break-all">{{$item->getPrefecture->name}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 break-all">{{$item->city1}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 break-all">{{$item->city2}}</td>
                                            <td class="text-left border-left  p-l-5 p-r-5 break-all">{{$item->detail_address}}</td>
                                            <td class="text-left border-left  p-l-5 p-r-5 break-all">{{$item->building_name}}</td>
                                            <td class="text-left border-left  p-l-5 p-r-5 break-all">{{$item->building_name_en}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 break-all">{{$item->max_job_num}}</td>
                                            <td class="text-center border-left  p-l-5 p-r-5 status">@if($item->status == 0) 新規 @elseif($item->status == 1) 有効 @else 無効 @endif</td>
                                            <td class="text-center border-left p-l-5 p-r-5 action color-blue">
                                                <button class="btn btn-info dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選択してください </button>

                                                <div class="dropdown-menu" id="action-{{$item->id}}" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route('admin.company.edit', ['companyId' => $item->company_id])}}" >編集</a>
                                                    <a class="dropdown-item" href="{{route('admin.job.index', ['companyId' => $item->company_id])}}" >仕事一覧</a>
                                                    <a class="dropdown-item action-change-max-job" data-id="{{$item->company_id}}" data-num="{{$item->max_job_num}}" href="javascript:void(0)" data-toggle="modal" data-target="#modal-job-num">掲載上限数変更</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center navigation">
                            {{ $companies->appends(['sort' => $sort,'filter' => $filter])->links('partials.pagination') }}
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-job-num" tabindex="-1" role="dialog" aria-labelledby="#modal-job-num">
                            <div class="modal-dialog modal-sm" role="document" style="width: 400px">
                                <div class="modal-content">
                                    <form id="change_max_num_job" action="{{route('admin.company.changeMaxJobNum')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-header" style="display: block">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="modal-job-num">掲載上限数変更</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input id="max_job_num_current" type="number" class="form-control" placeholder="数字を入力してください。" name="max_job_num">
                                            <input id="company_id_change_max_job" name="company_id" type="hidden" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">保存</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
