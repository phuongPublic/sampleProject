$(document).ready(function () {
    var isShow = $('#show_modal').val();
    if(isShow == 1){
        $('.company-modal').modal('show');
    }

    $("#company_submit").on("click", function(){
        $("#company_regist").val(1);
        $("#company_register_form").submit();
    });

    $(".company-close").on("click", function(){
        $('.company-modal').modal('hide');
    });

    $("form#company_register_form input" ).focus(function() {
        if($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio'){
            $('input[name="'+$(this).attr('name')+'"]').removeClass('error');
        }

        $(this).removeClass('error');
    });

    $("form#company_register_form select" ).focus(function() {
        $(this).removeClass('error');
    });

});
