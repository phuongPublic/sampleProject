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

@php
    //TODO
    $countryList = [
        'jp' => '日本語版',
        'vn' => 'ベトナム語版',
        'en' => '英語版',
        'cn' => '中国語版'
    ];
@endphp

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/admin_category.css') }}"/>
    <!-- Full Width Column -->
    <div class="content-wrapper job_category">
        <div class="container">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-2 text-right add-category">
                    <select id="change-lang" class="form-control select-lang">
                        @foreach($countryList as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 add-category text-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-job-category-modal">
                        職種・職務内容を追加
                    </button>
                </div>
            </div>
            <!-- Main content -->
            <section class="content">
                <!-- Messsage area -->
                @include('inc.messages')
                <!-- Start .flash-message -->
                @if(Session::has('Success'))
                    <div class="error-mesages-right bg-success text-left" id="successArea">
                        <p>{{ Session::get('Success') }}</p>
                    </div>
                @elseif(Session::has('Error'))
                    <div class="error-mesages-right text-left" id="errorArea">
                        <p>{{ Session::get('Error') }}</p>
                    </div>
                @endif
                <!-- End .flash-message -->
                <ul class="sortable-category">
                    @if (isset($lang))
                        @foreach($parent_category_multi_lang as $category)
                            <li class="category-parent-list" data-id="{{ $category->value }}">
                                <button data-id="{{$category->value}}" type="button" class="close delete-category" id="delete-category-{{$category->value}}"><span aria-hidden="true">&times;</span></button>
                                <div class="row category">
                                    <div class="col-md-4">
                                        <strong data-id="{{$category->value}}" class="category-name text-name-category" id="text-category-{{$category->value}}">{{$category->label}}</strong>
                                        <input data-id="{{$category->value}}" class="form-control input-name-category" id="input-category-{{$category->value}}" value="{{$category->label}}">
                                        {{--<button data-id="{{$category->id}}" type="button" class="close close-category-name" id="close-category-name-{{$category->id}}"><span aria-hidden="true">&times;</span></button>--}}
                                        <button data-id="{{$category->value}}" type="button" class="close done-save-name" id="done-save-category-name-{{$category->value}}"><span aria-hidden="true">&#10004;</span></button>
                                    </div>
                                    <div class="col-md-4">
                                        <ul id="sortable" class="sortable-category-child connected-sortable category-child" data-category-id="{{$category->value}}">
                                            @php
                                                $cid        = $category->value;
                                                $collect    = collect($child_category_multi_lang)->filter(function($item) use ($cid)
                                                    {
                                                        if($item['category_cd'] == $cid)
                                                            return $item;
                                                    })->toArray();
                                            @endphp

                                            @foreach($collect as $child)
                                                @if($child['category_cd'] == $category['value'])
                                                    <li data-id="{{ $child['value'] }}" class="ui-state-default category-child-list">
                                                        <button data-id="{{$child['value']}}" type="button" class="close delete-category" id="delete-category-{{$child['value']}}"><span aria-hidden="true">&times;</span></button>
                                                        <span data-id="{{ $child['value'] }}" class="text-name-category" id="text-category-{{$child['value']}}">{{$child['label']}}</span>
                                                        <input data-id="{{$child['value']}}" class="form-control input-name-category" id="input-category-{{$child['value']}}" value="{{$child['label']}}">
                                                        {{--<button data-id="{{$child['id']}}" type="button" class="close close-category-name" id="close-category-name-{{$child['id']}}"><span aria-hidden="true">&times;</span></button>--}}
                                                        <button data-id="{{$child['value']}}" type="button" class="close done-save-name" id="done-save-category-name-{{$child['value']}}"><span aria-hidden="true">&#10004;</span></button>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <img width="70" height="71" src="{{ $category->icon_filepath }}" id="image_category_view_{{$category->value}}">
                                        <br>
                                        <form class="form-upload" action="{{ route('admin.job.category.changeIcon') }}"
                                              method="post" enctype="multipart/form-data">
                                            <label class="btn btn-default">
                                                <input class="custom-file-input" data-iid="image_category_view_{{$category->value}}" type="file" name="icon_filepath" id="icon_filepath"
                                                       hidden accept="image/*">
                                                <span class="color-blue link-underline">Browse</span>
                                            </label>
                                            <button type="submit" class="btn btn-primary save-icon" name="submit">Save</button>
                                            <input type="hidden" value="{{ $category->value }}" name="category_id">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        @foreach($parent_category as $category)
                            <li class="category-parent-list" data-id="{{ $category->id }}">
                                <button data-id="{{$category->id}}" type="button" class="close delete-category" id="delete-category-{{$category->id}}"><span aria-hidden="true">&times;</span></button>
                                <div class="row category">
                                    <div class="col-md-4">
                                        <strong data-id="{{$category->id}}" class="category-name text-name-category" id="text-category-{{$category->id}}">{{$category->name}}</strong>
                                        <input data-id="{{$category->id}}" class="form-control input-name-category" id="input-category-{{$category->id}}" value="{{$category->name}}">
                                        {{--<button data-id="{{$category->id}}" type="button" class="close close-category-name" id="close-category-name-{{$category->id}}"><span aria-hidden="true">&times;</span></button>--}}
                                        <button data-id="{{$category->id}}" type="button" class="close done-save-name" id="done-save-category-name-{{$category->id}}"><span aria-hidden="true">&#10004;</span></button>
                                    </div>
                                    <div class="col-md-4">
                                        <ul id="sortable" class="sortable-category-child connected-sortable category-child" data-category-id="{{$category->id}}">
                                            @php
                                                $cid        = $category->id;
                                                $collect    = collect($child_category)->filter(function($item) use ($cid)
                                                    {
                                                        if($item['category_cd'] == $cid)
                                                            return $item;
                                                    })->toArray();
                                            @endphp

                                            @foreach($collect as $child)
                                                @if($child['category_cd'] == $category['id'])
                                                    <li data-id="{{ $child['id'] }}" class="ui-state-default category-child-list">
                                                        <button data-id="{{$child['id']}}" type="button" class="close delete-category" id="delete-category-{{$child['id']}}"><span aria-hidden="true">&times;</span></button>
                                                        <span data-id="{{ $child['id'] }}" class="text-name-category" id="text-category-{{$child['id']}}">{{$child['name']}}</span>
                                                        <input data-id="{{$child['id']}}" class="form-control input-name-category" id="input-category-{{$child['id']}}" value="{{$child['name']}}">
                                                        {{--<button data-id="{{$child['id']}}" type="button" class="close close-category-name" id="close-category-name-{{$child['id']}}"><span aria-hidden="true">&times;</span></button>--}}
                                                        <button data-id="{{$child['id']}}" type="button" class="close done-save-name" id="done-save-category-name-{{$child['id']}}"><span aria-hidden="true">&#10004;</span></button>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <img width="70" height="71" src="{{ $category->icon_filepath }}" id="image_category_view_{{$category->id}}">
                                        <br>
                                        <form class="form-upload" action="{{ route('admin.job.category.changeIcon') }}"
                                              method="post" enctype="multipart/form-data">
                                            <label class="btn btn-default">
                                                <input class="custom-file-input" data-iid="image_category_view_{{$category->id}}" type="file" name="icon_filepath" id="icon_filepath"
                                                       hidden accept="image/*">
                                                <span class="color-blue link-underline">Browse</span>
                                            </label>
                                            <button type="submit" class="btn btn-primary save-icon" name="submit">Save</button>
                                            <input type="hidden" value="{{ isset($lang) ? $lang : '' }}" name="lang">
                                            <input type="hidden" value="{{ $category->id }}" name="category_id">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <!-- Modal -->
                <div class="modal fade" id="add-job-category-modal" tabindex="-1" role="dialog" aria-labelledby="add-job-category-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="add-category" action="{{ route('admin.job.category.create') }}"
                                  method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title" id="add-job-category-label">職種・職務内容を追加</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">職種</div>
                                            <div class="col-md-9">
                                                <select class="form-control" name="category_cd" id="category_cd_custom">
                                                    <option value="">新規</option>
                                                    @if (isset($lang))
                                                        @foreach($parent_category_multi_lang as $key => $category)
                                                            <option class="list-parent-category" value="{{ $category->value }}">{{$key + 1}}. {{ $category->label }}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($parent_category as $key => $category)
                                                            <option class="list-parent-category" value="{{ $category->id }}">{{$key + 1}}. {{ $category->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($countryList) > 0)
                                        @foreach($countryList as $key => $value)
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span class="text-parent-category">職種</span>
                                                        <span class="text-child-category">職務内容</span>
                                                        {{$value}}
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input class="form-control" id="category_name_{{$key}}" name="name[job_category_cd_{{$key}}]" maxlength="255">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="form-group group-add-icon" id="group-add-icon">
                                        <div class="row">
                                            <div class="col-md-3">アイコン</div>
                                            <div class="col-md-9">
                                                <img width="70" height="71" src="/img/no-image.png" id="image_category_view_when_add">
                                                <br>
                                                <label class="btn btn-default">
                                                    <input class="custom-file-input icon-popup" data-iid="image_category_view_when_add" type="file" id="icon_filepath_add" name="icon_filepath"
                                                           accept="image/*">
                                                    <span class="color-blue link-underline">Browse</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                                <input type="hidden" name="lang" value="{{isset($lang) ? $lang : ''}}">
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    $( function() {
                        var lang = '{{isset($lang) ? $lang : ''}}';

                        $("#add-category").validate({});

                        $( "input[id*=category_name_vn]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=category_name_en]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=category_name_jp]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=category_name_cn]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "#icon_filepath_add" ).rules( "add", {
                            customValidate: true,
                            messages: {
                                customValidate: "アイコンを入力してください。!",
                            }
                        });

                        $('#category_cd_custom').change(function () {
                            if ($('#category_cd_custom').val() > 0) {
                                $( "#icon_filepath_add" ).rules("remove", "customValidate");
                            } else {
                                $( "#icon_filepath_add" ).rules("add", "customValidate");
                            }
                        });

                        jQuery.validator.addMethod("customValidate", function(value, element) {
                            if ($('#category_cd_custom').val() > 0) {
                                $('#icon_filepath_add').rules('remove', 'customValidate');  // removes only specified rule(s)
                            } else {
                                var fileName = $("#icon_filepath_add").val();
                                if(fileName.length) {
                                    return true;
                                }
                            }
                            return false;
                        }, "");

                        // Hide, show when selected parent category
                        $('.text-parent-category').css('display', 'inline-block');
                        $('.text-child-category').css('display', 'none');
                        $('#category_cd_custom').change(function () {
                            if ($('select[name="category_cd"]').val() == '') {
                                $('#group-add-icon').show();
                                $('.text-parent-category').css('display', 'inline-block');
                                $('.text-child-category').css('display', 'none');
                            } else {
                                $('#group-add-icon').hide();
                                $('.text-parent-category').css('display', 'none');
                                $('.text-child-category').css('display', 'inline-block');
                            }
                        });

                        //Change lang
                        if (lang != '') {
                            $('#change-lang').val(lang);
                        }
                        $('#change-lang').change(function () {
                            var selectedLang = $('#change-lang').val();
                            window.location.href = '{{route('admin.job.category')}}' + '?lang=' + selectedLang;
                        });

                        //Confirm save icon
                        $('.save-icon').click(function () {
                            if (confirm("保存しますか")) {
                                return true;
                            } else {
                                location.reload();
                                return false;
                            }
                        })

                        // Change Name
                        $('.text-name-category').dblclick(function () {
                            var categoryId = $(this).attr('data-id');
                            $('input#input-category-' + categoryId).css('display', 'inline-block').focus();
                            $('#text-category-' + categoryId).css('display', 'none');

                            $('.delete-category').css('display', 'none');
                            $('#close-category-name-' + categoryId).css('display', 'inline-block');
                            $('#done-save-category-name-' + categoryId).css('display', 'inline-block');
                            console.log($(this).attr('data-id'));
                        });

                        $('button.close-category-name').click(function () {
                            var categoryId = $(this).attr('data-id');
                            $('input#input-category-' + categoryId).css('display', 'none');
                            $('#text-category-' + categoryId).css('display', 'inline-block');
                            $('#close-category-name-' + categoryId).css('display', 'none');
                            $('#done-save-category-name-' + categoryId).css('display', 'none');
                        });
                        $('button.done-save-name').click(function () {
                            var categoryId = $(this).attr('data-id');
                            $('input#input-category-' + categoryId).css('display', 'none');
                            $('#text-category-' + categoryId).css('display', 'inline-block');
                            $('#close-category-name-' + categoryId).css('display', 'none');
                            $('#done-save-category-name-' + categoryId).css('display', 'none');

                            if (!$('input.input-name-category').is(':visible')) {
                                $('.delete-category').css('display', 'inline-block');
                            }

                            var nameCategory = $('input#input-category-' + categoryId).val();

                            if (confirm("保存しますか。")) {
                                $.ajax({
                                    url: '{{ route('admin.job.category.update') }}',
                                    type: 'POST',
                                    data: {id : categoryId, name : nameCategory, lang : lang},
                                    dataType: 'json',
                                    success: function( json ) {
                                        $('strong[data-id="'+categoryId+'"]').text(nameCategory);
                                        location.reload();
                                        return;
                                    },
                                    beforeSend: function() {
                                        $('.loader_gb').addClass('show');
                                    },
                                    complete: function () {
                                        $('.loader_gb').removeClass('show');
                                    }
                                });
                            } else {
                                location.reload();
                                return false;
                            }
                        });

                        // Remove category
                        $('.delete-category').click(function () {
                            var categoryId = $(this).attr('data-id');
                            if (confirm("本当に削除しますか。")) {
                                $.ajax({
                                    url: '{{ route('admin.job.category.delete') }}',
                                    type: 'POST',
                                    data: {id: categoryId},
                                    dataType: 'json',
                                    success: function (json) {
                                        if (json.status == 200) {
                                            $('li[data-id="' + categoryId + '"]').remove();
                                        } else {
                                            //showMessage(json.messages);
                                        }
                                    },
                                    beforeSend: function () {
                                        $('.loader_gb').addClass('show');
                                    },
                                    complete: function () {
                                        $('.loader_gb').removeClass('show');
                                    }
                                });
                                window.location.reload();
                            } else {
                                return false;
                            }
                        });
                        function updatePositionCategory(positionCategory) {
                            $.ajax({
                                url: '{{ route('admin.job.category.changePosition') }}',
                                type: 'POST',
                                data: {positionCategory : positionCategory},
                                dataType: 'json',
                                success: function( json ) {
                                    if(json.status == 200){
                                        showMessageSuccess(json.messages);
                                    }else{
                                        showMessage(json.messages);
                                    }
                                    return;
                                },
                                beforeSend: function() {
                                    $('.loader_gb').addClass('show');
                                },
                                complete: function () {
                                    $('.loader_gb').removeClass('show');
                                }
                            });
                        }

                        // Change position children category
                        $('ul.sortable-category-child').sortable({
                            axis: 'y',
                            start: function (event, ui) {
                                ui.item.css('margin-left', '10px');
                            },
                            stop: function (event, ui) {
                                var positionCategory = [];
                                ui.item.css('margin-left', 'auto');
                                $(this).find('li').each( function(index) {
                                    var dataId = $(this).attr('data-id');
                                    positionCategory.push({
                                        'id' : dataId,
                                        'display_order' : index + 1
                                    });
                                });

                                updatePositionCategory(positionCategory);
                            }
                        });

                        // Change position parent category
                        $('ul.sortable-category').sortable({
                            axis: 'y',
                            start: function (event, ui) {
                                ui.item.css('margin-left', '15px');
                            },
                            stop: function (event, ui) {
                                var positionCategory = [];
                                ui.item.css('margin-left', 'auto');
                                $(this).find('li.category-parent-list').each( function(index) {
                                    var dataId = $(this).attr('data-id');
                                    positionCategory.push({
                                        'id' : dataId,
                                        'display_order' : index + 1,
                                    });
                                });

                                updatePositionCategory(positionCategory);
                            }
                        });
                    } );
                </script>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
@stop

@section('footer')
    @include('layouts.supply_side_footer')
@stop
