$(document).ready(function() {
    $(".active-code").on("click", function(){
        activeCode('active-code','');
    });

    $(document).on('click', '.active_otp_code_submit', function(){
        var active_code = $('#active_otp_code').val();
        $('#for_active_otp_code').text(' ');
        $('#active_otp_code').removeClass('error')
        if(typeof active_code == 'undefined' || active_code.length != 8){
            $('#active_otp_code').addClass('error');
            if(active_code == ''){
                $('#for_active_otp_code').text(i18n.supply.otp.otp_empty).show();
            }else if(active_code.length != 8){
                $('#for_active_otp_code').text(i18n.supply.otp.otp_length).show();
            }
            return;
        }

        activeCode('submit', active_code);
    });

    $(document).on('focus', '#active_otp_code', function(){
        $(this).removeClass('error');
        $('#for_active_otp_code').text(String.fromCharCode(160)).removeClass('error');
    });

});

// Update active code
function activeCode(action, val) {
    if(typeof action == 'undefined')
        return;
    var param = {action:action, val:val};
    var url = '/active-code';
    $.ajax({
        type: "GET",
        url:url,
        data:param,
        success: function( data ) {
            if(data){
                $('.modal').remove();
                $('.modal-backdrop').hide();
                $('body').append(data);
                $('.modal').modal('show');
                if($('#active_otp_code_success').length > 0)
                    $('#active-code-btn').remove();
                return;
            }
        },
        beforeSend: function() {
            $('body').attr('data-ajax','loadding');
            $('.loader_gb').addClass('show');
        },
        complete: function () {
            $('body').attr('data-ajax','loaded');
            $('.loader_gb').removeClass('show');
        }
    });
}

