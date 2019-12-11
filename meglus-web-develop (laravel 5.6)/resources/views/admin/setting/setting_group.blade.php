@extends('admin.supply_admin' )

@section('title')
    {{ \Config::get('site.name') }} | 仕事で大事な事を追加
@stop

@section('layouts.supply_side_header')
    Outlet / Edit
@stop

@section('header')
    @include('layouts.supply_side_header')
@stop

<style>
    .sortable-category {
        list-style: none;
    }
    ul {
        list-style: none;
        counter-reset: my-awesome-counter;
    }
    ul li {
        counter-increment: my-awesome-counter;
    }
    ul li.category-child-list::before {
        content: counter(my-awesome-counter) ". ";
        color: #2779aa;
        font-weight: 500;
    }
    ul li .category-name::before {
        content: counter(my-awesome-counter) ". ";
        color: #2779aa;
        font-weight: normal;
        font-size: 28px;
    }
    .add-category {
        margin-top: -20px;
        margin-bottom: 15px;
    }
    .category .input-name-category {
        display: none;
        width: 85%;
    }
    .category .done-save-name {
        display: none;
        font-size: 18px;
        margin-top: 5px;
    }
    .job_category .delete-group-list {
        margin-left: 10px;
        color: red;
    }
    .job_category .category.group-list {
        background: transparent;
        padding: 0;
    }
    .job_category .category.group-list .item-list {
        background: #ecf3f9;
        padding: 10px;
    }
    .job_category .category.group-list .item-list .form-upload {
        margin-bottom: auto;
    }

</style>

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
                <div class="col-md-2 add-category text-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#setting-group-modal">
                        仕事で大事な事を追加
                    </button>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2 text-right add-category">
                    <select id="change-lang" class="form-control select-lang">
                        @foreach($countryList as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7"></div>
            </div>
            <!-- Main content -->
            <section class="content">
                <!-- Messsage area -->
                @include('inc.messages')
                <ul class="sortable-category">
                    @foreach($infoGroup as $group)
                        <li class="category-parent-list" data-id="{{ $group->value }}">
                            <div class="row category group-list">
                                <div class="col-md-4 item-list">
                                    <strong data-id="{{$group->value}}" class="category-name text-name-category" id="text-category-{{$group->value}}">{{$group->label}}</strong>
                                    <input data-id="{{$group->value}}" class="form-control input-name-category" id="input-category-{{$group->value}}" value="{{$group->label}}">
                                    {{--<button data-id="{{$category->id}}" type="button" class="close close-category-name" id="close-category-name-{{$category->id}}"><span aria-hidden="true">&times;</span></button>--}}
                                    <button data-id="{{$group->value}}" type="button" class="close done-save-name" id="done-save-category-name-{{$group->value}}"><span aria-hidden="true">&#10004;</span></button>
                                </div>
                                <div class="col-md-4 text-right item-list">
                                    <img width="70" height="71" src="{{ $group->img_path }}" id="image_category_view_{{$group->value}}">
                                    <br>
                                    <form class="form-upload" action="{{ route('admin.setting.changeImg') }}"
                                          method="post" enctype="multipart/form-data">
                                        <label class="btn btn-default">
                                            <input class="custom-file-input" data-iid="image_category_view_{{$group->value}}" type="file" name="img_path" id="icon_filepath"
                                                   hidden accept="image/*">
                                            <span class="color-blue link-underline">Browse</span>
                                        </label>
                                        <button type="submit" class="btn btn-primary save-icon" name="submit">Save</button>
                                        <input type="hidden" value="{{ $groupCurrent }}" name="group_current">
                                        <input type="hidden" value="{{ $group->value }}" name="group_value">
                                        <input type="hidden" value="{{ $lang }}" name="lang">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                    </form>
                                </div>
                                <button data-id="{{$group->value}}" type="button" class="close delete-category delete-group-list" id="delete-category-{{$group->value}}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <!-- Modal -->
                <div class="modal fade" id="setting-group-modal" tabindex="-1" role="dialog" aria-labelledby="setting-group-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="add-group" action="{{ route('admin.setting.create') }}"
                                  method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title" id="setting-group-label">仕事で大事な事を追加</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    @if (count($countryList) > 0)
                                        @foreach($countryList as $lg => $label)
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">{{ $label }}</div>
                                                    <div class="col-md-9">
                                                        @if ($lg == 'jp')
                                                            <input class="form-control" id="label_group_{{$lg}}" name="name[{{$groupCurrent}}]" maxlength="255">
                                                        @else
                                                            <input class="form-control" id="label_group_{{$lg}}" name="name[{{$groupCurrent}}_{{$lg}}]" maxlength="255">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="form-group" id="group-add-icon">
                                        <div class="row">
                                            <div class="col-md-3">アイコン</div>
                                            <div class="col-md-9">
                                                <img width="70" height="71" src="/img/no-image.png" id="image_category_view_when_add">
                                                <br>
                                                <label class="btn btn-default">
                                                    <input class="custom-file-input icon-popup" data-iid="image_category_view_when_add" type="file" name="img_path" id="img_path_add"
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
                                <input type="hidden" name="group_current" value="{{$groupCurrent}}">
                                <input type="hidden" name="lang" value="{{isset($lang) ? $lang : ''}}">
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    $( function() {

                        var groupCurrent = '{{ $groupCurrent }}';
                        var lang = '{{isset($lang) ? $lang : ''}}';

                        $("#add-group").validate({});

                        $( "input[id*=label_group_jp]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=label_group_vn]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=label_group_en]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "input[id*=label_group_cn]" ).rules( "add", {
                            required: true,
                            messages: {
                                required: "この欄に入力してください!",
                            }
                        });

                        $( "#img_path_add" ).rules( "add", {
                            customValidate: true,
                            messages: {
                                customValidate: "アイコンを入力してください。!",
                            }
                        });

                        jQuery.validator.addMethod("customValidate", function(value, element) {
                            if ($('#category_cd_custom').val() > 0) {
                                $('#img_path_add').rules('remove', 'customValidate');  // removes only specified rule(s)
                            } else {
                                var fileName = $("#img_path_add").val();
                                if(fileName.length) {
                                    return true;
                                }
                            }
                            return false;
                        }, "");

                        //Change lang
                        if (lang != '') {
                            $('#change-lang').val(lang);
                        }
                        $('#change-lang').change(function () {
                            var selectedLang = $('#change-lang').val();
                            window.location.href = '{{route('admin.setting.group', ['group' => $groupCurrent])}}' + '?lang=' + selectedLang;
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
                            var groupValue = $(this).attr('data-id');
                            var groupLabel = $('input#input-category-' + groupValue).val();

                            $('input#input-category-' + groupValue).css('display', 'none');
                            $('#text-category-' + groupValue).css('display', 'inline-block');
                            $('#close-category-name-' + groupValue).css('display', 'none');
                            $('#done-save-category-name-' + groupValue).css('display', 'none');

                            if (!$('input.input-name-category').is(':visible')) {
                                $('.delete-category').css('display', 'inline-block');
                            }

                            if (confirm("保存しますか。")) {
                                $.ajax({
                                    url: '{{ route('admin.setting.update') }}',
                                    type: 'POST',
                                    data: {groupCurrent : groupCurrent, value : groupValue, name : groupLabel, lang : lang},
                                    dataType: 'json',
                                    success: function( json ) {
                                        $('strong[data-id="'+groupValue+'"]').text(groupLabel);
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

                        $('.delete-category').click(function () {
                            var groupValue = $(this).attr('data-id');
                            if (confirm("本当に削除しますか。")) {
                                $.ajax({
                                    url: '{{ route('admin.setting.delete') }}',
                                    type: 'POST',
                                    data: {groupCurrent: groupCurrent, value: groupValue},
                                    dataType: 'json',
                                    success: function (json) {
                                        if (json.status == 200) {
                                            $('li[data-id="' + groupValue + '"]').remove();
                                        } else {
                                            showMessage(json.messages);
                                        }
                                        return;
                                    },
                                    beforeSend: function () {
                                        $('.loader_gb').addClass('show');
                                    },
                                    complete: function () {
                                        $('.loader_gb').removeClass('show');
                                    }
                                });
                                location.reload();
                            } else {
                                location.reload();
                                return false;
                            }
                        });
                        function updatePositionCategory(positionGroup) {
                            $.ajax({
                                url: '{{ route('admin.setting.changePosition') }}',
                                type: 'POST',
                                data: {positionGroup : positionGroup},
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

                        // Change position
                        $('ul.sortable-category').sortable({
                            axis: 'y',
                            start: function (event, ui) {
                                ui.item.css('margin-left', '15px');
                            },
                            stop: function (event, ui) {
                                var positionGroup = [];
                                ui.item.css('margin-left', 'auto');
                                $(this).find('li.category-parent-list').each( function(index) {
                                    var dataId = $(this).attr('data-id');
                                    var dataGroup = '{{ $groupCurrent }}';
                                    positionGroup.push({
                                        'groupCurrent' : dataGroup,
                                        'value' : dataId,
                                        'seq' : index + 1
                                    });
                                });

                                console.log(positionGroup);

                                updatePositionCategory(positionGroup);
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
