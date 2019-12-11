$(document).ready(function() {
// show user register button scroll down
if($('#register-text').length > 0){
    $('#register-text').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            $('#register-btn').prop("disabled", false);
        }
    });
}

// registed close modal link to company page
$('.user-registed-modal').on('hidden.bs.modal', function () {
    window.location.href = "/company";
});

// registration user submit ajax
$("#register-btn").on("click", function(){
    var postData = $('#user_register_form').serializeArray();
    removeMessage();
    $.ajax({
        type: "POST",
        url:'/register',
        dataType:'json',
        data:postData,
        success: function( json ) {
            if(json.code == 1){
                // error messages
                var messagesString = '';
                $.each(json.messages,function(index, value){
                    $('#'+index).addClass('error');
                    messagesString = messagesString + '<p>'+value+'</p>';
                });

                if(messagesString.length > 0){
                    showMessage(messagesString);
                }
            }else{
                // register success
                $('#registed_email_result').text(json.data.login_id);
                $('.user-registed-modal').modal('show');
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
});

// focus input error register form
$( "#user_register_form .form-control" ).focus(function() {
    console.log($(this));
    $(this).removeClass('error');
    return;
});

});
