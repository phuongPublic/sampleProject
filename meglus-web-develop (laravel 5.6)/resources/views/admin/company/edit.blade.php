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
                    <!-- Messsage area -->
                    @include('inc.messages')

                    <div class="box-header with-border">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h3 class="box-title bold text-center">{{__('supply.company.title_screen')}}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal register_form" method="post" href="{{route('admin.company.edit', ['companyId' => $companyId])}}" name="register_form" id="company_register_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_regist" id="company_regist" value="">
                        <!--勤務先住所の入力 -->
                        <div class="box-body">
                            <!--company_name -->
                            <div class="form-group row ">
                                <label for="company_name" class="col-sm-3 control-label">{{__('supply.company.company_name')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="company_name" class="form-control @if(isset($errors) && $errors->has('company_name')) error @endif" id="company_name"  maxlength="20" value="{{ old( 'company_name', isset($data->company_name) ? $data->company_name : '') }}" placeholder="{{__('supply.company.company_name')}}" >
                                </div>
                            </div>
                            <!--company_name_en -->
                            <div class="form-group row">
                                <label for="company_name_en" class="col-sm-3 control-label">{{__('supply.company.company_name_en')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="company_name_en" class="form-control @if(isset($errors) && $errors->has('company_name_en')) error @endif" id="company_name_en" value="{{ old( 'company_name_en', isset($data->company_name_en) ? $data->company_name_en : '') }}" placeholder="company name" >
                                </div>
                            </div>
                            <!--job_category_cd -->
                            <div class="form-group row">
                                <label for="job_category_cd" class="col-sm-3 control-label">{{__('supply.job.job_category_cd')}}</label>
                                <div class="col-sm-9">
                                    <select class="form-control @if(isset($errors) && $errors->has('job_category_cd')) error @endif" id="job_category_cd" name="job_category_cd">
                                        <option value="">{{__('supply.common.choose')}}</option>
                                        @foreach($categories as $key => $item)
                                            <option value="{{$item['id']}}" @if($item['id'] == old( 'job_category_cd', isset($data->job_category_cd) ? $data->job_category_cd : '')) selected @endif>{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--tel -->
                            <div class="form-group row">
                                <label for="tel" class="col-sm-3 control-label">{{__('supply.company.tel')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="tel" id="tel" maxlength="15" class="form-control @if(isset($errors) && $errors->has('tel')) error @endif"  value="{{ old( 'tel', isset($data->tel) ? $data->tel : '') }}" placeholder="0000000000" >
                                </div>
                            </div>
                            <!--post_cd -->
                            <div class="form-group row">
                                <label for="workplace_post_cd" class="col-sm-3 control-label">{{__('supply.company.post_cd')}}</label>
                                <div class="col-sm-9 form-inline">
                                    <input type="text" name="post_cd" maxlength="7" class="form-control post_cd @if(isset($errors) && $errors->has('post_cd')) error @endif" id="workplace_post_cd" value="{{ old( 'post_cd', isset($data->post_cd) ? $data->post_cd : '') }}" placeholder="0000000" >
                                    <button type="button" id="find-address" class="btn btn-info center-block bg_blue text-light mg-l15 find-address">{{__('supply.job.find_address_btn')}}</button>
                                </div>
                            </div>
                            <!--prefecture -->
                            <div class="form-group row">
                                <label for="prefecture" class="col-sm-3 control-label">{{__('supply.company.prefecture')}}</label>
                                <div class="col-sm-9">
                                    <select class="form-control workplace_prefecture @if(isset($errors) && $errors->has('prefecture')) error @endif" id="workplace_prefecture" name="prefecture">
                                        <option value="">{{__('supply.common.choose')}}</option>
                                        @foreach($prefectures as $key => $prefecture)
                                            <option value="{{ $key }}" @if($key == old( 'prefecture', isset($data->prefecture) ? $data->prefecture : '')) selected @endif >{{ $prefecture }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--city1 -->
                            <div class="form-group row">
                                <label for="city1" class="col-sm-3 control-label">{{__('supply.company.city1')}}</label>
                                <div class="col-sm-9">
                                    <select class="form-control workplace_city1 @if(isset($errors) && $errors->has('city1')) error @endif" id="workplace_city1" name="city1" @if(empty($data->prefecture)) disabled @endif>
                                        <option value="">{{__('supply.common.choose')}}</option>
                                        @foreach($cities1 as $key => $city1)
                                            <option value="{{ $city1 }}" @if($city1 == old( 'city1', isset($data->city1) ? $data->city1 : '')) selected @endif >{{ $city1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--city2 -->
                            <div class="form-group row">
                                <label for="workplace_city2" class="col-sm-3 control-label">{{__('supply.company.city2')}}</label>
                                <div class="col-sm-9">
                                    <select class="form-control @if(isset($errors) && $errors->has('city2')) error @endif" id="workplace_city2" name="city2" @if(empty($data->city1)) disabled @endif>
                                        <option value="">{{__('supply.common.choose')}}</option>
                                        @foreach($cities2 as $key => $city2)
                                            <option value="{{ $city2 }}" @if($city2 == old( 'city2', isset($data->city2) ? $data->city2 : '')) selected @endif >{{ $city2 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--detail_address -->
                            <div class="form-group row">
                                <label for="detail_address" class="col-sm-3 control-label">{{__('supply.company.detail_address')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="detail_address" class="form-control @if(isset($errors) && $errors->has('detail_address')) error @endif" id="detail_address" value="{{ old( 'detail_address', isset($data->detail_address) ? $data->detail_address : '') }}" placeholder="{{__('supply.company.detail_address')}}" >
                                </div>
                            </div>
                            <!--building_name -->
                            <div class="form-group row">
                                <label for="building_name" class="col-sm-3 control-label">{{__('supply.company.building_name')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="building_name" class="form-control" id="building_name" value="{{ old( 'building_name', isset($data->building_name) ? $data->building_name : '') }}" placeholder="{{__('supply.company.building_name_p_holder')}}" >
                                </div>
                            </div>
                            <!--building_name_en -->
                            <div class="form-group row">
                                <label for="workplace_building_name_en" class="col-sm-3 control-label">{{__('supply.company.building_name_en')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="building_name_en" class="form-control @if(isset($errors) && $errors->has('building_name_en')) error @endif" id="building_name_en" value="{{ old( 'building_name_en', isset($data->building_name_en) ? $data->building_name_en : '') }}" placeholder="Bulding name" >
                                </div>
                            </div>
                        </div>
                        <div class="row-bottom text-center close-btn">
                            <button type="submit" class="btn btn-primary mgt-20 ">{{__('supply.company.submit_btn')}}</button>
                            <a href="{{ route('admin.company.index') }}" class="btn btn-primary mgt-20" >以前に</a>
                        </div>
                        <!-- /.box-footer -->
                    </form>
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
