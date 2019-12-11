@extends('admin.supply_admin' )

@section('title')
    {{ \Config::get('site.name') }} | 職種・職務内容を管理
@stop

@section('layouts.supply_side_header')
    Outlet / Edit
@stop

@section('header')
    @include('layouts.supply_side_header')
@stop

<style>
    #modal-sequence-history .modal-header {
        display: block;
    }
    #content-wrapper.applicant .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
</style>

@section('content')

    <script type="text/javascript" src="{{ asset('js/job_apply.js') }}"></script>
    @php($attentionText = [])
    <!-- Full Width Column -->
    <div class="content-wrapper login-content applicant" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box-2">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left form-inline">
                                <h3 class="mg-r15">{{__('supply.applicant.index')}}</h3>
                            </div>
                        </div>
                        <div class="row table-filter m-b-15">
                            <form method="GET" action="/admin/applicant">
                                <div class="col-sm-12 form-inline">
                                    <input class="form-control w180 m-r-15" id="filter_name" type="text" name="filter[name]" @if(isset($filter['name'])) value="{{$filter['name']}}" @endif placeholder="候補者の名前で検索">
                                    <input class="form-control w150 m-r-15" id="filter_workplace_name" type="text" name="filter[workplace_name]" @if(isset($filter['workplace_name'])) value="{{$filter['workplace_name']}}" @endif placeholder="職場名で探す">

                                    @if(isset($sort))
                                        @foreach($sort as $key => $item)
                                            <input type="hidden" name="sort[{{$key}}]" value="{{$item}}">
                                        @endforeach
                                    @endif
                                    <button type="submit" id="filter_submit" class="btn btn-primary">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                <!-- Messsage area -->
                @include('inc.messages')
                <!-- Content -->
                    <script>
                        var filterData  = {};
                        var sortingData = {};
                        @if(isset($sort))
                            sortingData = {!! json_encode($sort) !!};
                        @endif
                        @if(isset($filter))
                            filterData = {!! json_encode($filter) !!};
                        @endif
                    </script>
                    <div class="table-responsive ">
                        <table class="table admin-table table-bordered table-striped" id="table-applicant">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2" style="width:180px;min-width: 180px;" class="text-left"><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'name')}}>名前</a></th>
                                    <th style="width:180px;min-width: 180px;" class="" width=""><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'seq')}}>シーケンス</a></th>
                                    <th style="width:180px;min-width: 180px;" class="" width=""><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'seq_update_dt')}}>採用日時</a></th>
                                    <th style="width:250px;min-width: 250px;" class="" width=""><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'workplace_name')}}>勤務先名</a></th>
                                    <th style="width:180px;min-width: 180px;" class="" width=""><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'job_category_cd')}}>職種</a></th>
                                    <th style="width:250px;min-width: 250px;" class="" width=""><a href="javascript:void(0)" class="multiple-sort-applicant" {{Supply::makeDataAttr($sort,'job_discription_cd')}}>職務内容</a></th>
                                    <th style="width:180px;min-width: 180px;" class="color-blue">アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($applicant as $item)
                                @include('admin.applicant.apply_row')
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="text-center navigation">
                        {{ $applicant->appends(['sort' => $sort,'filter' => $filter])->links('partials.pagination') }}
                    </div>
                </div>
            </section>
        <!-- Modal -->
        <div class="modal fade" id="modal-sequence-history" tabindex="-1" role="dialog" aria-labelledby="#sequence-history-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="sequence-history-label">Sequence history</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center color-blue">#</th>
                                <th scope="col" class="text-center color-blue">前のシーケンス</th>
                                <th scope="col" class="text-center color-blue">後のシーケンス</th>
                                <th scope="col" class="text-center color-blue">更新日</th>
                            </tr>
                            </thead>
                            <tbody id="data-sequence-history">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @include('supply_side.job.apply_modal.default_popup')
        <!-- /.content -->
        </div>
        <!-- /.container -->
        <script>
            $('.btn-outline-secondary').addClass('btn-info');
        </script>
    </div>
    <!-- /.content-wrapper -->
@stop

@section('footer')
    @include('layouts.supply_side_footer')
@stop
