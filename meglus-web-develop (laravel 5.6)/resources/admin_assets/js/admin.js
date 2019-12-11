$(document).ready(function() {
    $(".reset-code").on("click", function(){
        updateOtp($(this).attr('data-id'),'reset');
    });

    $(".update-owner").on("click", function(){
        updateOtp($(this).attr('data-id'),'set-owner');
    });

    $('#modal-btn-no').on("click", function(){
        $("#confirm-modal").modal('hide');
    });

});


function linkConfirm(title,message,link) {
    $('#title-modal-confirm').text(title);
    $('#modal-body-confirm').text(message);
    $("#link-modal").attr('href',link);
    $("#confirm-modal").modal('show');
}


// Update otp code
function updateOtp(id, type) {
    if(typeof id == 'undefined')
        return;
    var url = '/admin/otp/'+type+'/'+id;
    $.ajax({
        type: "GET",
        url:url,
        dataType:'json',
        success: function( json ) {
            console.log(json);
            if(json.code == 200){
                if(json.result.status == 0){
                    $('#table-otp #row-'+id+' .status').text('未認証');
                }else{
                    $('#table-otp #row-'+id+' .status').text('認証済');
                }

                if(typeof json.result.expire_dt != 'undefined'){
                    $('#table-otp #row-'+id+' .expire_dt').text(json.result.expire_dt);
                }
                if(typeof json.result.otp_code != 'undefined'){
                    $('#table-otp #row-'+id+' .code').text(json.result.otp_code);
                }

                if(typeof json.result.owner != 'undefined'){
                    $('#table-otp #row-'+id+' .owner').text(json.result.owner);
                }
                if(typeof json.result.generation_num != 'undefined'){
                    $('#table-otp #row-'+id+' .generation_num').text(json.result.generation_num);
                }
            }else{
                showMessage(json.messages);
            }
        },
        beforeSend: function() {
            $('#'+id).attr('data-ajax','loadding');
            $('.loader_gb').addClass('show');
        },
        complete: function () {
            $('#'+id).attr('data-ajax','loaded');
            $('.loader_gb').removeClass('show');
        }
    });
}
