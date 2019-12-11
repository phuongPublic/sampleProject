@extends('admin.supply_admin' )

@section('title')
    {{__('supply.demand.title_update')}}
@stop

@section('admin.supply_admin_header')
@stop

@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bs-material/bootstrap-material-datetimepicker.css') }}" />
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/moment-with-locales.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/bootstrap-material-datetimepicker.js') }}"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('js/job.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/address.js') }}"></script>
{{--    <script type="text/javascript" src="{{ asset('js/jquery/jquery.form.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/multiple-select.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/multiple-select.css') }}" type="text/css">
    <script>
        var jobCategoryCd   = {};
        @if($categories)
            jobCategoryCd = {!! json_encode($categories) !!};
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
                                <h3 class="box-title bold">{{__('supply.demand.title_update')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                <!-- Messsage Error -->
                @include('admin.inc.messages')
                    <div class="admin-content ">
                        <div class="box-body">
                            <div class="modal-body">
                                <div class="row-bottom">

                                    <form class="form-horizontal demand_form" method="POST" href="{{route('admin.demand.update',['id' => $demand->id])}}" name="demand_form" id="demand_form" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <h2 class="detail-title">基本情報</h2>

                                            <div class="form-group row ">
                                                <div class="col-sm-6 ">
                                                    <div class="form-group row">
                                                        <div for="" class="col-lg-4 control-label text-left">名前</div>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="name" value="{{old('name', $demand->name)}}" class="form-control " id="name" placeholder="名前" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">性別</label>
                                                        <div class="col-lg-8">
                                                            <input type="radio" id="gender" name="gender" value="1"  @if((Input::old('gender', $demand->gender) == 1) || !Input::old('gender', $demand->gender) ) checked @endif   class="mg-r15"><label class="mg-r15">男性</label>
                                                            <input type="radio" name="gender" value="0" @if(Input::old('gender', $demand->gender) == 0 ) checked @endif class="mg-r15"><label class="mg-r15">女性</label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">有効期間</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="birth_day" value="{{old('birth_day', date('Y/m/d',strtotime($demand->birth_day)))}}" class="form-control " id="birth_day" placeholder="" >
                                                            <script>
                                                                $( function() {
                                                                    var datePicker = $('#birth_day').bootstrapMaterialDatePicker({
                                                                        time: false,
                                                                        format: 'YYYY/MM/DD',
                                                                        lang: 'ja',
                                                                        okText : '同意',
                                                                        cancelText : 'キャンセル',
                                                                        maxDate : new Date()
                                                                    });
                                                                    datePicker.bootstrapMaterialDatePicker('setDate', '{{old('birth_day', date('Y/m/d',strtotime($demand->birth_day)))}}');
                                                                } );
                                                            </script>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">国籍</label>
                                                        <div class="col-lg-8">
                                                            <select class="form-control m-r-15 " id="nationality_cd" name="nationality_cd">
                                                                <option value="">選択してください</option>
                                                                @foreach($country as $key => $item)
                                                                    <option value="{{$key}}" @if($demand->nationality_cd == $key) selected @endif>{{$item}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">郵便番号</label>
                                                        <div class="col-lg-8 form-inline">
                                                            <input type="text" maxlength="7" name="post_cd" value="{{old('post_cd', $demand->post_cd)}}" class="form-control post_cd" id="workplace_post_cd" placeholder="0000000">
                                                            <button type="button" id="find-address" class="btn btn-info center-block bg_blue text-light mg-l15 find-address">住所自動入力</button>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">都道府県</label>
                                                        <div class="col-lg-8">
                                                            <select class="form-control workplace_prefecture" id="workplace_prefecture" name="prefecture">
                                                                <option value="">選択してください</option>
                                                                @foreach($prefectures['prefectures'] as $key => $prefecture)
                                                                    <option value="{{ $key }}" @if (Input::old('prefecture', $demand->prefecture) == $key)  selected @endif>{{ $prefecture }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">市区町村1</label>
                                                        <div class="col-lg-8">
                                                            <select class="form-control city1 workplace_city1" id="workplace_city1" name="city1" @if (!Input::old('city1', $demand->city1) && !Input::old('prefecture', $demand->prefecture))  disabled @endif>
                                                                <option value="">選択してください</option>
                                                                @if(isset($prefectures['city1']))
                                                                    @foreach($prefectures['city1'] as $key => $item)
                                                                        <option value="{{ $item }}" @if (Input::old('city1', $demand->city1) == $item)  selected @endif>{{ $item }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row ">
                                                        <label for="" class="col-lg-4 control-label ">市区町村2</label>
                                                        <div class="col-lg-8">
                                                            <select class="form-control city2 workplace_city2" id="workplace_city2" name="city2" @if (!Input::old('city2', $demand->city2) && !Input::old('city1', $demand->city1))  disabled @endif>
                                                                <option value="">選択してください</option>
                                                                @if(isset($prefectures['city2']))
                                                                    @foreach($prefectures['city2'] as $key => $item)
                                                                        <option value="{{ $item }}" @if (Input::old('city2', $demand->city2) == $item)  selected @endif>{{ $item }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="avatar-img col-sm-12">
                                                        <img id="upload_img" width="250" data-default-url="/avatar/{{ $demand->id }}.png?w=250&h=auto" src="/avatar/{{ $demand->id }}.png?w=250&h=auto" alt="" class="img">
                                                    </div>
                                                    <div class="avatar-img col-sm-12 p-t-10">
                                                        <input type="file" id="upload" name="">
                                                        <textarea id="upload-base64" name="avatar" style="display: none"></textarea>
                                                    </div>

                                                </div>
                                            </div>



                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">丁目・番地</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="detail_address" value="{{old('detail_address', $demand->detail_address)}}" class="form-control " id="detail_address" >
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">自宅最寄り駅</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="is_home_station" value="{{old('is_home_station', $demand->is_home_station)}}" class="form-control ajax_find_station_name ui-autocomplete-input" id="workplace_nearest_station_cd" >
                                                    <input type="hidden" name="home_nearest_station_name_source" value="" id="workplace_nearest_station_name_source">
                                                    <input type="hidden" name="home_nearest_station" value="{{old('home_nearest_station', $demand->home_nearest_station)}}" id="workplace_nearest_station_source_cd">
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">自宅最寄り駅からの徒歩時間</label>
                                                <div class="col-lg-4 form-inline">
                                                    <input type="number" name="home_nearest_station_move_time" value="{{old('home_nearest_station_move_time', $demand->home_nearest_station_move_time)}}" class="form-control w100 " id="workplace_nearest_station_move_time" placeholder="分">
                                                    <label for="workplace_nearest_station_move_time" class="control-label"> &nbsp;分</label>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">学校最寄り駅</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="is_school_station" value="{{old('is_school_station', $demand->is_school_station)}}" class="form-control ajax_find_station_name ui-autocomplete-input" id="interview_nearest_station_cd" >
                                                    <input type="hidden" name="school_nearest_station_name_source" value="" id="interview_nearest_station_name_source">
                                                    <input type="hidden" name="school_nearest_station" value="{{old('school_nearest_station', $demand->school_nearest_station)}}" id="interview_nearest_station_source_cd">
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">学校最寄り駅からの徒歩時間</label>
                                                <div class="col-lg-4 form-inline">
                                                    <input type="number" name="school_nearest_station_move_time" value="{{old('school_nearest_station_move_time', $demand->school_nearest_station_move_time)}}" class="form-control w100" id="home_nearest_station_move_time" placeholder="分">
                                                    <label for="" class="control-label"> &nbsp;分</label>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">メールアドレス</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="mail" value="{{old('mail', $demand->mail)}}" class="form-control " id="mail" >
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">電話番号</label>
                                                <div class="col-lg-4">
                                                    <input type="number" name="tel" value="{{old('tel', $demand->tel)}}" class="form-control" id="tel" >
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">在留資格</label>
                                                <div class="col-lg-4">
                                                    <script type="text/javascript">
                                                        $(function() {
                                                            $("#demand_residences").multipleSelect({
                                                                multiple: true,
                                                                multipleWidth: 200,
                                                                width: '100%',
                                                                formatSelectAll: function () {
                                                                    return '[Select all]';
                                                                },
                                                                formatAllSelected: function () {
                                                                    return 'All selected';
                                                                },
                                                                formatCountSelected: function () {
                                                                    return '# of % selected';
                                                                },
                                                                onFocus: function () {
                                                                    $('.ms-parent.form-control').removeClass('error');
                                                                },
                                                            });
                                                        });

                                                    </script>

                                                    <select id="demand_residences" multiple="multiple" name="residences[]" class="form-control ">
                                                        @foreach($resiStatus as $key => $item )
                                                            <option value="{{$key}}" @if(in_array($key, $demand->residences)) data-thumbnail="images/icon-chrome.png" selected="selected" @endif>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <h2 class="detail-title">役に立つスキル</h2>
                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">日本語レベル</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control" id="japanese_level" name="japanese_level">
                                                        <option value="">選択してください</option>
                                                        @foreach($japaneseLevel as $key => $item)
                                                            <option value="{{ $key }}" @if (Input::old('japanese_level', $demand->japanese_level) == $key)  selected @endif>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">仕事経験①</label>
                                                <div class="col-lg-4 form-inline">
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control job_category_cd" id="experience1_category_cd" name="work_experience1_category_cd">
                                                            <option value="">選択してください</option>
                                                            @foreach($categories as $key => $item)
                                                                <option value="{{$item['id']}}" @if(Input::old('work_experience1_category_cd', $demand->work_experience1_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control" id="experience1_description_cd" name="work_experience1_discription_cd" @if(!Input::old('work_experience1_category_cd', $demand->work_experience1_category_cd)) disabled @endif>
                                                            <option value="">選択してください</option>
                                                            @if(Input::old('work_experience1_category_cd', $demand->work_experience1_category_cd))
                                                                @foreach($categories[Input::old('work_experience1_category_cd', $demand->work_experience1_category_cd)]['items'] as $key => $item)
                                                                    <option value="{{$item['id']}}" @if(Input::old('work_experience1_discription_cd', $demand->work_experience1_discription_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">仕事経験②</label>
                                                <div class="col-lg-4 form-inline">
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control job_category_cd" id="experience2_category_cd" name="work_experience2_category_cd">
                                                            <option value="">選択してください</option>
                                                            @foreach($categories as $key => $item)
                                                                <option value="{{$item['id']}}" @if(Input::old('work_experience2_category_cd', $demand->work_experience2_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control" id="experience2_description_cd" name="work_experience2_discription_cd" @if(!Input::old('work_experience1_category_cd', $demand->work_experience1_category_cd)) disabled @endif>
                                                            <option value="">選択してください</option>
                                                            @if(Input::old('work_experience2_category_cd', $demand->work_experience2_category_cd))
                                                                @foreach($categories[Input::old('work_experience2_category_cd', $demand->work_experience2_category_cd)]['items'] as $key => $item)
                                                                    <option value="{{$item['id']}}" @if(Input::old('work_experience2_discription_cd', $demand->work_experience2_discription_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">仕事経験③</label>
                                                <div class="col-lg-4 form-inline">
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control job_category_cd" id="experience3_category_cd" name="work_experience3_category_cd">
                                                            <option value="">選択してください</option>
                                                            @foreach($categories as $key => $item)
                                                                <option value="{{$item['id']}}" @if(Input::old('work_experience3_category_cd', $demand->work_experience3_category_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 p-l-0">
                                                        <select class="form-control" id="experience3_description_cd" name="work_experience3_discription_cd" @if(!Input::old('work_experience3_category_cd', $demand->work_experience3_category_cd)) disabled @endif>
                                                            <option value="">選択してください</option>
                                                            @if(Input::old('work_experience3_category_cd', $demand->work_experience3_category_cd))
                                                                @foreach($categories[Input::old('work_experience3_category_cd', $demand->work_experience3_category_cd)]['items'] as $key => $item)
                                                                    <option value="{{$item['id']}}" @if(Input::old('work_experience3_discription_cd', $demand->work_experience3_discription_cd) == $item['id']) selected @endif>{{$item['name']}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <h2 class="detail-title">仕事で大事なこと</h2>
                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">大事なこと①</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control importantCd" id="important1_cd" name="important1_cd">
                                                        <option value="">選択してください</option>
                                                        @foreach($important as $key => $item)
                                                            <option value="{{ $key }}" @if (Input::old('important1_cd', $demand->important1_cd) == $key)  selected @endif>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">大事なこと②</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control importantCd" id="important2_cd" name="important2_cd">
                                                        <option value="">選択してください</option>
                                                        @foreach($important as $key => $item)
                                                            <option value="{{ $key }}" @if (Input::old('important2_cd', $demand->important2_cd) == $key)  selected @endif>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row ">
                                                <label for="" class="col-lg-2 control-label ">大事なこと③</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control importantCd" id="important3_cd" name="important3_cd">
                                                        <option value="">選択してください</option>
                                                        @foreach($important as $key => $item)
                                                            <option value="{{ $key }}" @if (Input::old('important3_cd', $demand->important3_cd) == $key)  selected @endif>{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                        </div>


                                        <div class="row-bottom">
                                            <h2 class="detail-title">都合の良い時間帯</h2>
                                            <div class="row-bottom text-center work-time">
                                                <div class="col-sm-12 text-center">
                                                    <div class="form-check form-check-inline col-1">
                                                        <input id="days" style="width: unset;" class="form-check-input "  type="checkbox" name="days[]" value="1" @if(in_array(1, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">月</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="2" @if(in_array(2, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">火</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="3" @if(in_array(3, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">水</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="4" @if(in_array(4, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">木</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="5" @if(in_array(5, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">金</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="6" @if(in_array(6, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">土</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-1">
                                                        <input class="form-check-input" type="checkbox" name="days[]" value="0" @if(in_array(0, $demand->days)) checked @endif>
                                                        <label class="form-check-label" for="inlineCheckbox1">日</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <div class="form-check form-check-inline">
                                                        @php
                                                            $startTime  = (isset($demand->work_start_time))?date('H:i', strtotime($demand->work_start_time)):'';
                                                            $endTime    = (isset($demand->work_end_time))?date('H:i', strtotime($demand->work_end_time)):'';
                                                        @endphp

                                                        <input type="text" name="work_start_time" value="{{old('work_start_time', $startTime)}}" class="form-input form-control w120 col-sm-3 work_start_time unit_time_start" id="work_start_time" placeholder="{{__('supply.job.unit_time_start')}}" >&nbsp;
                                                        &nbsp;&nbsp;<label class="control-label">~</label>&nbsp;&nbsp;&nbsp;
                                                        <input type="text" name="work_end_time" value="{{old('work_end_time', $endTime)}}" class="form-input form-control w120 col-sm-3 work_end_time unit_time_start" id="work_end_time" placeholder="{{__('supply.job.unit_time_end')}}" >&nbsp;

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-bottom text-center close-btn">
                                            <button type="button" class="btn btn-primary mgt-20 bold submit-form-ajax" submit-form-ajax="true" data-form-id="demand_form"> 保存</button>
                                            <a href="{{ url()->previous() }}" class="btn btn-primary mgt-20 bold " >以前に </a>
                                        </div>


                                    </form>


                                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirm-modal">
                                        <div class="modal-dialog modal-sm" style="width: 400px">
                                            <div class="modal-content" >
                                                <div class="modal-header text-right">
                                                    <div class="" ><b id="title-modal-confirm">画</b></div>
                                                    <a href="javascript:void(0)" class="close " >
                                                        <span aria-hidden="true" onclick="$(function () {$('#confirm-modal').modal('toggle');});">&times;</span>
                                                    </a>
                                                </div>
                                                <div class="modal-body p-l-15 p-r-15 p-t-0 p-b-0" id="modal-body-confirm">
                                                    画像が無効です。
                                                </div>
                                                <div class="modal-footer" style="border-top: 0px;">
                                                    <a class="btn btn-secondary" href="javascript:void(0);" onclick="$(function () {$('#confirm-modal').modal('toggle');});" >キャンセル</a>
                                                </div>
                                            </div>
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

