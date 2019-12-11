@extends('admin.supply_admin' )

@section('title')
    {{__('supply.demand.title_index')}}
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
                                <h3 class="box-title bold">{{__('supply.demand.title_index')}}</h3>
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
                                <form method="GET" action="/admin/demand">
                                    <div class="col-sm-12 form-inline">
                                        <input class="form-control w180 m-r-15" id="filter_name" type="text" name="filter[name_mail]" @if(isset($filter['name_mail'])) value="{{$filter['name_mail']}}" @endif placeholder="氏名、メール">
                                        <input class="form-control w150 m-r-15" id="filter_tel" type="text" name="filter[tel]" @if(isset($filter['tel'])) value="{{$filter['tel']}}" @endif placeholder="電話番号">
                                            <select class="form-control m-r-15 w150" id="filter_nationality_cd" name="filter[nationality_cd]">
                                                <option value="">国籍</option>
                                                @foreach($country as $key => $item)
                                                    <option value="{{$key}}" @if(isset($filter['nationality_cd']) && $filter['nationality_cd'] == $key) selected @endif>{{$item}}</option>
                                                @endforeach
                                            </select>

                                            <select class="form-control m-r-15" id="filter_gender" name="filter[gender]">
                                                <option value="">性別</option>
                                                <option value="1" @if(isset($filter['gender']) && $filter['gender'] == 1) selected @endif>男</option>
                                                <option value="0" @if(isset($filter['gender']) && $filter['gender'] == 0 && $filter['gender'] != '') selected @endif>女</option>
                                            </select>
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
                                <table class="table admin-table table-bordered table-striped" id="table-demand">
                                    <thead>
                                        <tr>
                                            <th style="width:180px;min-width: 180px;" class="text-center w p-l-5 p-r-5 name"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'name')}} >氏名</a></th>
                                            <th style="width:170px;min-width: 170px;" class="text-center w p-l-6 p-r-5 mail"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'mail')}}>メール</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 tel_"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'tel')}}>電話番号</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 post_cd_"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'post_cd')}}>郵便番号</a></th>
                                            <th style="width:180px;min-width: 180px;" class="text-center w p-l-6 p-r-5 detail_address"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'detail_address')}}>住所</a></th>
                                            <th style="width:80px;min-width: 80px;" class="text-center w p-l-6 p-r-5 gender"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'gender')}}>性別</a></th>
                                            <th style="width:180px;min-width: 180px;" class="text-center w p-l-6 p-r-5 nationality_cd"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'nationality_cd')}}>国籍</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 created_at"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'created_at')}}>登録日時</a></th>
                                            <th style="width:150px;min-width: 150px;" class="text-center w p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'updated_at')}}>更新日時</a></th>
                                            <th style="min-width: 180px;" class="text-center   p-l-6 p-r-5 action color-blue">アクション</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($demands as $item)
                                            <tr class="text-center col-sm-12 table-row row-{{$item->id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->id}}"  data-id="{{$item->id}}">
                                                <td class="-left text-left  w180 p-l-5 p-r-5 name ">
                                                    {{--<img width="50" class="m-r-10" src="{{route('supply.user.avatar', ['id' => $item->id])}}">--}}
                                                    {{$item->name}}
                                                </td>
                                                <td class="-left text-left border-left w170 p-l-5 p-r-5 mail ">{{$item->mail}}</td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 tel_">{{$item->tel}}</td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 post_cd_">{{$item->post_cd}}</td>
                                                <td class="text-center border-left w180 p-l-5 p-r-5 detail_address">
                                                    @if(isset($prefectures[$item->prefecture])) {{$prefectures[$item->prefecture]}}@endif
                                                    {{$item->city1}} {{$item->city2}}  {{$item->detail_address}}
                                                </td>
                                                <td class="text-center border-left w80 p-l-5 p-r-5 gender">@if($item->gender == 1 ) 男 @else 女 @endif</td>
                                                <td class="text-center border-left w180 p-l-5 p-r-5 nationality_cd">@if(isset($country[$item->nationality_cd])) {{$country[$item->nationality_cd]}} @endif</td>
                                                <td class="- text-center border-left w150 p-l-5 p-r-5 created_at">{{date('Y/m/d H:i',strtotime($item->created_at))}}</td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 updated_at">{{date('Y/m/d H:i',strtotime($item->updated_at))}}</td>
                                                <td class="-sdsd text-center border-left   p-l-5 p-r-5 action color-blue">
                                                    <button class="btn btn-info dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選択してください </button>
                                                    <div class="dropdown-menu" id="action-{{$item->id}}" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" href="{{route('admin.demand.view',['id' => $item->id])}}" >閲覧</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('編集', 'ユーザーを更新。','{{route('admin.demand.update',['id' => $item->id])}}')">編集</a>
                                                        @if($item->status != \App\Model\DemandUserInfo::BLOCKED_STATUS )
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('停止', 'アカウント停止。','{{route('admin.demand.block',['id' => $item->id])}}')">アカウント停止</a>

                                                            @if($item->status != \App\Model\DemandUserInfo::BLOCKED_APPLY )
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('停止', '応募停止。','{{route('admin.demand.blockApply',['id' => $item->id])}}')">応募停止</a>
                                                            @else
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('再開', 'アカウント再開。','{{route('admin.demand.unblockApply',['id' => $item->id])}}')">応募再開</a>
                                                            @endif

                                                        @else
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('再開', 'アカウント再開。','{{route('admin.demand.unblock',['id' => $item->id])}}')">アカウント再開</a>
                                                        @endif

                                                        {{--<a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('PWの変更', 'PWの変更。','{{route('admin.demand.password',['id' => $item->id])}}')">PWの変更</a>--}}
                                                        @if(strlen($item->profile_path) > 0)
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('写真削除', '写真削除。','{{route('admin.demand.remove-img',['id' => $item->id])}}')">写真削除</a>
                                                        @endif

                                                        <a class="dropdown-item" href="{{route('admin.demand.history',['id' => $item->id])}}" >応募履歴</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="text-center navigation">
                            {{ $demands->appends(['sort' => $sort,'filter' => $filter])->links('partials.pagination') }}
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

