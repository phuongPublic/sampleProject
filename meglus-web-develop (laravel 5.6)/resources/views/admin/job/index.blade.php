@extends('admin.supply_admin' )

@section('title')
    {{__('supply.job.title_index')}}
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
                                <h3 class="box-title bold">{{__('supply.job.title_index')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                <!-- Messsage Error -->
                @include('inc.messages')

                    <script>
                        var jobCategory = {};
                        @if(isset($sort))
                            jobCategory = {!! json_encode($category) !!};
                        @endif
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
                                <div class="col-sm-12 form-inline">
                                    <form method="GET" >
                                        <input class="form-control w180 m-r-15" id="filter_name_address" type="text" name="filter[name_address]" @if(isset($filter['name_address'])) value="{{$filter['name_address']}}" @endif placeholder="勤務先名, 会社名, 住所">
                                        <select class="form-control m-r-15 w150" id="filter_job_category_cd" name="filter[job_category_cd]">
                                            <option value="">職種</option>
                                            @foreach($category as $key => $item)
                                                <option value="{{$item['id']}}" @if(isset($filter['job_category_cd']) && $filter['job_category_cd'] == $item['id']) selected @endif>&nbsp;&nbsp;{{$item['name']}}</option>
                                            @endforeach
                                        </select>

                                        <select class="form-control m-r-15 w150" id="filter_job_discription_cd" name="filter[job_discription_cd]"  @if(!isset($filter['job_category_cd']) || $filter['job_category_cd'] == '') disabled @endif>
                                            <option value="">職務内容</option>
                                            @if(isset($filter['job_category_cd']) && $filter['job_category_cd'] != '' && isset($category[$filter['job_category_cd']]['items']) )
                                                @foreach($category[$filter['job_category_cd']]['items'] as $key => $item)
                                                    <option value="{{$item['id']}}" @if(isset($filter['job_discription_cd']) && $filter['job_discription_cd'] == $item['id']) selected @endif>&nbsp;&nbsp;{{$item['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <select class="form-control m-r-15 w150" id="filter_japanese_level" name="filter[japanese_level]">
                                            <option value="">日本語レーベル</option>
                                            @foreach($japanese as $key => $item)
                                                <option value="{{$key}}" @if(isset($filter['japanese_level']) && $filter['japanese_level'] == $key) selected @endif>&nbsp;&nbsp;{{$item}}</option>
                                            @endforeach
                                        </select>

                                        <select class="form-control m-r-15 w150" id="filter_status" name="filter[status]">
                                            <option value="">ステータス</option>
                                            @foreach($statusCd as $key => $item)
                                                <option value="{{$key}}" @if(isset($filter['status']) && $filter['status'] == $key) selected @endif>&nbsp;&nbsp;{{$item}}</option>
                                            @endforeach
                                        </select>

                                        @if(isset($sort))
                                            @foreach($sort as $key => $item)
                                                <input type="hidden" name="sort[{{$key}}]" value="{{$item}}">
                                            @endforeach
                                        @endif
                                        <button type="submit" id="filter_submit" class="btn btn-primary">検索</button>
                                    </form>
                                </div>
                            </div>
                            @if (!empty($cid))
                                <div class="row form-group">
                                    <div class="col-sm-12 text-left">
                                            <a href="javascript:;" onclick="linkConfirm('掲載再開', 'すべて公開を続ける','{{route('admin.job.reOpenAll', ['companyId' => $cid])}}')" class="btn btn-primary unblock-job w180 m-r-15" id="reopen-job">すべて公開を続ける</a>
                                            <a href="javascript:;" onclick="linkConfirm('掲載の停止', 'すべての公開を停止','{{route('admin.job.stopAll', ['companyId' => $cid])}}')" class="btn btn-primary block-job m-r-15" id="stop-job">すべての公開を停止</a>
                                            <a href="{{ route('admin.company.index') }}" class="btn btn-primary m-r-15" >以前に </a>
                                    </div>
                                </div>
                            @endif
                            <div class="table-responsive ">
                                <table class="table admin-table table-bordered table-striped">
                                    <thead class="text-center col-sm-12 grid-b-b p-l-0 p-r-0 p-b-10 bold">
                                        <tr>
                                            <th class="text-center w250 p-l-5 p-r-5 workplace_name"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'workplace_name')}} >勤務先名</a></th>
                                            <th class="text-center w250 p-l-6 p-r-5 address"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'address')}}>住所</a></th>
                                            <th class="text-center w200 p-l-6 p-r-5 job_category_cd"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'job_category_cd')}}>職種</a></th>
                                            <th class="text-center w150 p-l-6 p-r-5 salary"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'salary')}}>時給</a></th>
                                            <th class="text-center w150 p-l-6 p-r-5 japanese_level"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'japanese_level')}}>日本語</a></th>
                                            <th class="text-center w150 p-l-6 p-r-5 status"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'status')}}>ステータス</a></th>
                                            <th class="text-center w150 p-l-6 p-r-5 created_at"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'created_at')}}>登録日時</a></th>
                                            <th class="text-center w150 p-l-6 p-r-5 updated_at"><a href="javascript:void(0)" class="multiple-sort-admin-list" {{Supply::makeDataAttr($sort,'updated_at')}}>更新日時</a></th>
                                            <th class="float-sdsd text-center w150 p-l-6 p-r-5 action color-blue">アクション</th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-body" id="table-job-list">
                                        @php
                                            $itemStop = 0;
                                            $itemReOpen = 0;
                                        @endphp
                                        @foreach ($jobs as $key => $item)
                                            @if ($item->status == \App\Model\Jobs::STOP_STATUS)
                                                @php ($itemStop++)
                                            @elseif ($item->status == \App\Model\Jobs::REOPEN_STATUS)
                                                @php($itemReOpen++)
                                            @endif
                                            <tr class="text-center col-sm-12 table-row row-{{$item->job_id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->job_id}}"  data-id="{{$item->job_id}}">
                                                <td class="text-left w250 p-l-5 p-r-5 workplace_name">
                                                    <p class="m-b-0">{{$item->workplace_name}} <br/><span class="fs-13">{{$item->company_name}}</span></p>
                                                </td>
                                                <td class="text-center border-left w250 p-l-6 p-r-5 address">
                                                    {{$item->prefectures_name}}
                                                    {{$item->workplace_city1}}
                                                    {{$item->workplace_city2}}
                                                    {{$item->workplace_detail_address}}
                                                </td>
                                                <td class="text-center border-left w200 p-l-6 p-r-5 job_category_cd">
                                                    <p>
                                                    @if(isset($category[$item->job_category_cd]))
                                                        {{$category[$item->job_category_cd]['name']}}
                                                        @if(isset($category[$item->job_category_cd]['items']) && isset($category[$item->job_category_cd]['items'][$item->job_discription_cd]))
                                                            <br>{{$category[$item->job_category_cd]['items'][$item->job_discription_cd]['name']}}
                                                        @endif
                                                    @endif
                                                    </p>
                                                </td>
                                                <td class="text-center border-left w150 p-l-6 p-r-5 salary">
                                                    {{$item->min_salary}}~{{$item->max_salary}}
                                                </td>
                                                <td class="text-center border-left w150 p-l-6 p-r-5 salary">
                                                    @if(isset($japanese[$item->japanese_level]))
                                                        {{$japanese[$item->japanese_level]}}
                                                    @endif
                                                </td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 status">
                                                    @if(isset($statusCd[$item->status]))
                                                        {{$statusCd[$item->status]}}
                                                    @endif
                                                </td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 created_at">{{date('Y/m/d H:i',strtotime($item->created_at))}}</td>
                                                <td class="text-center border-left w150 p-l-5 p-r-5 updated_at">{{date('Y/m/d H:i',strtotime($item->updated_at))}}</td>
                                                <td class="float-sdsd text-center border-left   p-l-5 p-r-5 action color-blue">
                                                    <button class="btn btn-info dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選択してください </button>
                                                    <div class="dropdown-menu" id="action-{{$item->id}}" aria-labelledby="dropdownMenuButton">
                                                        @if (empty($cid))
                                                            <a class="dropdown-item" href="{{route('supply.job.detail',['id' => $item->job_id])}}" >閲覧</a>
                                                            <a class="dropdown-item" href="{{route('admin.job.history',['id' => $item->job_id])}}" >記事ステータスのログ</a>
            {{--                                                <a class="dropdown-item" href="{{route('admin.job.history',['id' => $item->job_id])}}" >編集ログの閲覧</a>--}}
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('編集', '編集。','{{route('supply.job.edit',['id' => $item->job_id])}}')">編集</a>
                                                            @if($item->status == \App\Model\Jobs::STOP_STATUS)
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('掲載再開', '記事を再開してもよろしでしょうか。','{{route('supply.job.reopen',['id' => $item->job_id])}}')">掲載再開</a>
                                                            @else
                                                                {{--@if(--}}
                                                                {{--$item->status == \App\Model\Jobs::ACTIVATED_STATUS--}}
                                                                {{--||$item->status == \App\Model\Jobs::DEACTIVATED_STATUS--}}
                                                                {{--|| $item->status == \App\Model\Jobs::REOPEN_STATUS--}}
                                                                {{--)--}}
                                                                    {{--<a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('記事停止', '記事を停止してもよろしでしょうか。','{{route('supply.job.stop',['id' => $item->job_id])}}')">掲載停止</a>--}}
                                                                {{--@endif--}}
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('掲載の停止', '掲載の停止。','{{route('supply.job.stop',['id' => $item->job_id])}}')">掲載の停止</a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{route('admin.job.apply',['id' => $item->job_id])}}" >応募者リストの表示</a>
                                                        @else
                                                            @if($item->status == \App\Model\Jobs::STOP_STATUS)
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('掲載再開', '記事を再開してもよろしでしょうか。','{{route('supply.job.reopen',['id' => $item->job_id])}}')">掲載再開</a>
                                                            @else
                                                                {{--@if(--}}
                                                                {{--$item->status == \App\Model\Jobs::ACTIVATED_STATUS--}}
                                                                {{--||$item->status == \App\Model\Jobs::DEACTIVATED_STATUS--}}
                                                                {{--|| $item->status == \App\Model\Jobs::REOPEN_STATUS--}}
                                                                {{--)--}}
                                                                    {{--<a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('記事停止', '記事を停止してもよろしでしょうか。','{{route('supply.job.stop',['id' => $item->job_id])}}')">掲載停止</a>--}}
                                                                {{--@endif--}}
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="linkConfirm('掲載の停止', '掲載の停止。','{{route('supply.job.stop',['id' => $item->job_id])}}')">掲載の停止</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                            </div>

                            @if (!empty($cid))
                                <script>
                                    if ({{$itemStop}} == {{count($jobs)}}) {
                                        $('#stop-job').css({'pointer-events': 'none', 'cursor': 'not-allowed', 'background': '#ccc', 'border': '1px solid #ccc'});
                                    } else if ({{$itemReOpen}} == {{count($jobs)}}) {
                                        $('#reopen-job').css({'pointer-events': 'none', 'cursor': 'not-allowed', 'background': '#ccc', 'border': '1px solid #ccc'});
                                    }
                                </script>
                            @endif
                        </div>
                        <div class="text-center navigation">
                            {{ $jobs->appends(['sort' => $sort,'filter' => $filter])->links('partials.pagination') }}
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
