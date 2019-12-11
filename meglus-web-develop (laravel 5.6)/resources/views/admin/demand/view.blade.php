@extends('admin.supply_admin' )

@section('title')
    {{__('supply.demand.title_view')}}
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
                                <h3 class="box-title bold">{{__('supply.demand.title_view')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- Messsage Error -->
                    @include('inc.messages')
                    <div class="admin-content ">
                        <div class="box-body">
                            <div class="modal-body">
                                <div class="row-bottom">
                                    <h2 class="detail-title">基本情報</h2>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th>名前</th>
                                            <td class="p-l-15">{{ $data->name }}</td>
                                            <td rowspan="10" class="avatar">
                                                <div class="text-center avatar-img p-t-130">
                                                    <img src="/avatar/{{ $data->id }}.png?w=250&h=auto" alt="" class="img">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>性別</th>
                                            <td class="p-l-15">{{ $data->gender == 1 ? '男性' : '女性' }}</td>
                                        </tr>
                                        <tr>
                                            <th>年齢</th>
                                            <td class="p-l-15">{{ $data->age.'歳' }}</td>
                                        </tr>
                                        <tr>
                                            <th>国籍</th>
                                            <td class="p-l-15">{{ $data->country }}</td>
                                        </tr>
                                        <tr>
                                            <th>住所</th>
                                            <td class="p-l-15">{{ $data->add_str }}</td>
                                        </tr>
                                        <tr>
                                            <th>自宅最寄り駅</th>
                                            <td class="p-l-15">{{ $data->home_nearest_station_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>学校最寄り駅</th>
                                            <td class="p-l-15">{{ $data->school_nearest_station_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>メールアドレス</th>
                                            <td class="p-l-15">{{ $data->mail }}</td>
                                        </tr>
                                        <tr>
                                            <th>電話番号</th>
                                            <td class="p-l-15">{{ $data->tel }}</td>
                                        </tr>
                                        <tr>
                                            <th>在留資格</th>
                                            <td class="p-l-15">{{ $data->residence_status }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row-bottom">
                                    <h2 class="detail-title">役に立つスキル</h2>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th width="25%">日本語レベル</th>
                                            <td class="p-l-15">{{ $data->japanese_level }}</td>
                                        </tr>
                                        <tr>
                                            <th>仕事経験①</th>
                                            <td class="p-l-15">{{ $data->exp1 }}</td>
                                        </tr>
                                        <tr>
                                            <th>仕事経験②</th>
                                            <td class="p-l-15">{{ $data->exp2 }}</td>
                                        </tr>
                                        <tr>
                                            <th>仕事経験③</th>
                                            <td class="p-l-15">{{ $data->exp3 }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row-bottom">
                                    <h2 class="detail-title">仕事で大事なこと</h2>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th width="25%">大事なこと①</th>
                                            <td class="p-l-15">{{ $data->important_1 }}</td>
                                        </tr>
                                        <tr>
                                            <th>大事なこと②</th>
                                            <td class="p-l-15">{{ $data->important_2 }}</td>
                                        </tr>
                                        <tr>
                                            <th>大事なこと③</th>
                                            <td class="p-l-15">{{ $data->important_3 }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row-bottom">
                                    <h2 class="detail-title">都合の良い時間帯</h2>
                                    <div class="row-bottom text-center work-time">
                                        <div class="col-sm-12 text-center">
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(1, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">月</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(2, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">火</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(3, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">水</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(4, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">木</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(5, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">金</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(6, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">土</label>
                                            </div>
                                            <div class="form-check form-check-inline col-1">
                                                <input class="form-check-input" type="checkbox" onclick="return false;" @if(in_array(0, $data->work_days)) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">日</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <div class="form-check form-check-inline">
                                                {{ date('H:i', strtotime($data->work_start_time)) }}
                                                &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                                {{ date('H:i', strtotime($data->work_end_time)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-bottom text-center close-btn">
                                    <a href="{{route('admin.demand.update',['id' => $data->id])}}" class="btn btn-primary mgt-20 bold " >編集 </a>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary mgt-20 bold " >以前に  </a>
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

