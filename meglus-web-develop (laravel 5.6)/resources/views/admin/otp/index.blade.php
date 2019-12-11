@extends('admin.supply_admin' )

@section('title')
    {{__('supply.otp.index')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')
    <script>
        var filterData  = {};
        var sortingData = {};
        @if(isset($sort))
            sortingData = {!! json_encode($sort) !!};
        @endif
    </script>
    <!-- Full Width Column -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12 text-left">
                                <h3 class="box-title bold">{{__('supply.otp.index')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- Messsage Error -->
                @include('inc.messages')
                    <div class="table-responsive ">
                        <table class="table admin-table table-bordered table-striped" id="table-otp">
                            <thead>
                                <tr>
                                    <th style="width:180px;min-width: 180px;" class="text-center code"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'code')}} >コード</a></th>
                                    <th style="width:100px;min-width: 100px;" class="text-center generation_num"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'generation_num')}}>発行回数</a></th>
                                    <th style="width:180px;min-width: 180px;" class="text-center expire_dt"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'expire_dt')}}>発行日（認証期限）</a></th>
                                    <th style="width:150px;min-width: 150px;" class="text-center company_created"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'company_created')}}>企業情報登録日</a></th>
                                    <th style="width:180px;min-width: 180px;" class="text-center company_name"><a href="javascript:void(0)" class="multiple-sort-otp " {{Supply::makeDataAttr($sort,'company_name')}}>企業名</a></th>
                                    <th style="width:180px;min-width: 180px;" class="text-center company_owner"><a href="javascript:void(0)" class="multiple-sort-otp " {{Supply::makeDataAttr($sort,'company_owner')}}>姓名</a></th>
                                    <th style="width:180px;min-width: 180px;" class="text-center detail_address"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'detail_address')}}>住所</a></th>
                                    <th style="width:130px;min-width: 130px;" class="text-center company_tel"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'company_tel')}}>電話</a></th>
                                    <th style="width:100px;min-width: 100px;" class="text-center status"><a href="javascript:void(0)" class="multiple-sort-otp  float-left " {{Supply::makeDataAttr($sort,'status')}}>認証状況</a></th>
                                    <th style="width:130px;min-width: 130px;" class="text-center owner"><a href="javascript:void(0)" class="multiple-sort-otp" {{Supply::makeDataAttr($sort,'owner')}}>対応者</a></th>
                                    <th style="min-width: 100px;" class="text-center action color-blue " style="width: 200px;">再発行</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($otps as $item)
                                    <tr class="text-center table-row row-{{$item->id}}  grid-b-b p-l-0 p-r-0" id="row-{{$item->id}}"  data-id="{{$item->id}}">
                                        <td class="text-center  code">
                                            {{$item->code}}
                                        </td>

                                        <td class="text-center  generation_num border-left ">
                                            {{$item->generation_num}}
                                        </td>

                                        <td class="text-center  expire_dt border-left">
                                                {{date('Y/m/d', strtotime($item->expire_from_dt))}}
                                                <br/>{{date('(Y/m/d)', strtotime($item->expire_dt))}}
                                        </td>

                                        <td class="text-center  company_created border-left">
                                            {{date('Y/m/d', strtotime($item->company_created_at))}}
                                        </td>

                                        <td class="text-left  company_name border-left">
                                            {{$item->company_name}}
                                        </td>

                                        <td class="text-left  company_owner border-left">
                                           {{$item->last_name}} {{$item->first_name}}
                                        </td>

                                        <td class="text-left  detail_address border-left">
                                            @if(isset($prefecture[$item->company_prefecture]))
                                                {{$prefecture[$item->company_prefecture]}}
                                            @endif
                                            {{$item->city1}}
                                            {{$item->city2}}
                                            {{$item->detail_address}}
                                        </td>

                                        <td class="text-left  company_tel border-left">
                                            {{$item->company_tel}}
                                        </td>

                                        <td class="text-center  status border-left">
                                            @if($item->status == 1)
                                                認証済
                                            @else
                                                未認証
                                            @endif
                                        </td>

                                        <td class="text-center  owner border-left">
                                            @if($item->interaction_user_id )
                                                {{$item->interaction_user_last_name}} {{$item->interaction_user_first_name}}
                                            @else
                                                <button type="button" data-id="{{$item->id}}" class="btn btn-info text-white update-owner">対応完了</button>
                                            @endif
                                        </td>

                                        <td class="float-right1 text-center  action color-blue">
                                            @if($item->status != 1)
                                                <button type="button" data-id="{{$item->id}}" class="btn btn-info text-white reset-code">再発行</button>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center navigation">
                        @if(request()->sort)
                            {{ $otps->appends(['sort' => $sort])->links('partials.pagination') }}
                        @else
                            {{ $otps->links() }}
                        @endif
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
