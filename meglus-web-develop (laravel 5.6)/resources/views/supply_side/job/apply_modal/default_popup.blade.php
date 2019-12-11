<!-- Modal -->
@php($count = count($attentionText))
{{--@if($count > 0 && \Illuminate\Support\Facades\Session::get('show', null) == null)--}}
@if($count > 0)
@php(\Illuminate\Support\Facades\Session::put('show', 'show'))
<script type="text/javascript">
    $(window).on('load',function(){
        $('.apply_default_popup').modal('show');
    });
</script>
<div class="modal apply_default_popup" id="apply_default_popup" tabindex="-1" role="dialog" style="">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 1000px;">
            <div class="modal-header text-right">
                <div class="title-user-info color-red bold w-100 text-center">!!更新してください!!</div>
                <a href="javascript:void(0)" class="close " >
                    <span aria-hidden="true" onclick="$(function () {$('.apply_default_popup').modal('toggle');});">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group row form-group-list color-red">
                    @foreach($attentionText as $key => $item)
                        <div class="@if($count > 4) col-sm-6 @else col-sm-12 @endif"><p class="mgb-0">・{!! $item !!}</p></div>
                    @endforeach
                </div>

                <div class="row-bottom text-center close-btn">
                    <a href="javascript:void(0)" class="btn btn-primary mgt-20 bold " >
                        <span aria-hidden="true" onclick="$(function () {$('.apply_default_popup').modal('toggle');});">{{__('閉じる')}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
