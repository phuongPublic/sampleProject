
function showPreviewjob(id) {
    var url         = '/job/preview/'+id;
    $.ajax({
        type: 'GET',
        url:url,
        success: function( data ) {
            $('#job_preview').remove();
            $('.modal-backdrop').hide();
            $('body').append(data);
            $('#job_preview').modal('show');
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

function showWorkingTimeDetail(status) {
    if(status == 'hidden'){
        $('#popup-working-time').show('fast');
        $('#popup-working-time').attr('show-detail', 'show');
    }else{
        $('#popup-working-time').hide('fast');
        $('#popup-working-time').attr('show-detail', 'hidden');

    }
}








