$(document).ready(function() {
    //$('.change-proccess-status').click(function () {
    $(document).on('click', '.change-proccess-status', function(){
            var dataUrl  = $(this).attr('data-url');
            var url         = '/job/applicant/update/'+dataUrl;
            $.ajax({
                type: 'GET',
                url:url,
                success: function( data ) {
                    $('.application_modal').remove();
                    $('.modal-backdrop').hide();
                    $('body').append(data);
                    $('.application_modal').modal('show');
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
    );

    $(document).on('change', '#job_apply_popup_form select', function(){
        $(this).removeClass('error');
        $('#error_for_'+this.id).remove();
    });

    $(document).on('change', '#apply-modal-form input', function(){
        $(this).removeClass('error');
        $('#error_for_'+this.id).text('');
    });
    // Submit ajax popup form
    $(document).on('click', '#job_apply_popup_form button[submit-ajax="true"]', function(){
        removeMessage();
        var formId      = $(this).attr('data-form-id');
        if($('#'+formId).attr('data-ajax') == 'loading')
            return;

        var method      = $('#'+formId).attr('method');
        var url         = $('#'+formId).attr('action');
        var param       = $('#'+formId).serializeArray();
        $.ajax({
            type: method,
            url:url,
            dataType:'json',
            data:param,
            success: function( json ) {
                var messagesString = '';
                if(json.status == 200){
                    // success
                    messagesString = json.messages;
                    if(messagesString.length > 0) {
                        showMessageSuccess(messagesString);
                    }
                    $('.modal').remove();
                    $('.modal-backdrop').hide();
                    if(typeof json.update_row != 'undefined'){
                        $('#apply-'+json.update_row).html(json.content);
                        $('[data-toggle="tooltip"]').tooltip({html:true});
                    }else{
                        location.reload();
                    }

                    return;
                }else{
                    $.each(json.messages,function(index, value){
                        $('#'+index).addClass('error');
                        if($("#error_for_"+index).length  > 0){
                            $("#error_for_"+index).text(value);
                        }else{
                            $('#'+index).after('<p class="text-center color-red m-b-0" id="error_for_'+index+'">'+value+'</p>');
                        }
                    });
                }

                return;
            },
            beforeSend: function() {
                $('#'+formId).attr('data-ajax','loading');
                $('#'+formId+' .submit-form-ajax').prop('disabled',true)
                $('.loader_gb').addClass('show');
            },
            complete: function () {
                $('#'+formId).attr('data-ajax','loaded');
                $('#'+formId+' .submit-form-ajax').prop('disabled',false);
                $('.loader_gb').removeClass('show');
            }
        });
    });

    //popup apply step region
    $(document).on('click', '.job-apply-action', function(){
        var applyId = $(this).attr('data-apply-id');
        var action = $(this).attr('data-action');
        var comId = $(this).attr('com-id');
        var customAction = $(this).attr('custom-action');
        var dataSec = $(this).attr('data-sec');
        var getData = { companyId: comId };

        var url = '/job/apply/' + action + '/' + applyId;
        if(customAction == 'customM03'){
            url = url + '?custom='+customAction;
        }

        $.ajax({
            type: "GET",
            url: url,
            data: getData,
            success: function success(data) {
                if(customAction == 'customM03'){
                    $('body').append(data);
                    $('.job-apply-modal.'+customAction).modal('show');
                }else{
                    $('.job-apply-modal').remove();
                    $('#m03-dialog').remove();
                    $('.modal-backdrop').hide();
                    $('body').append(data);
                    $('.job-apply-modal').modal('show');
                }

                return;
            },
            beforeSend: function beforeSend() {
                $('.loader_gb').addClass('show');
            },
            complete: function complete() {
                $('.loader_gb').removeClass('show');
            }
        });
    });

    $(document).on('click', '.apply-modal-submit', function(){
        removeMessage();
        var formId      = $(this).attr('data-form-id');
        var customAction = $(this).attr('custom-action');
        var classCustom = '';
        if(typeof customAction != 'undefined' && customAction.length > 0){
            classCustom = '.'+customAction;
        }

        if($('#'+formId).attr('data-ajax') == 'loading')
            return;

        var method      = $('#'+formId+classCustom).attr('method');
        var url         = $('#'+formId+classCustom).attr('action');
        var param       = $('#'+formId+classCustom).serializeArray();

        console.log(param);
        console.log('#'+formId+classCustom);
        console.log(url);

        $.ajax({
            type: method,
            url:url,
            dataType:'json',
            data:param,
            success: function( json ) {
                var messagesString = '';
                if(json.status == 200){
                    // success
                    messagesString = json.messages;
                    if(messagesString.length > 0) {
                        showMessageSuccess(messagesString);
                    }
                    $('.modal').remove();
                    $('.modal-backdrop').hide();
                    if(typeof json.update_row != 'undefined'){
                        $('#apply-'+json.update_row).html(json.content);
                        $('[data-toggle="tooltip"]').tooltip({html:true});
                    }else{
                        location.reload();
                    }
                    return;
                }else{
                    $.each(json.errors,function(index, value){
                        $('#'+index).addClass('error');
                        if($("#error_for_"+index).length  > 0){
                            $("#error_for_"+index).text(value);
                        }else{
                            $('#'+index).after('<p class="text-center color-red m-b-0" id="error_for_'+index+'">'+value+'</p>');
                        }
                    });
                }

                return;
            },
            beforeSend: function() {
                $('#'+formId).attr('data-ajax','loading');
                $('#'+formId+' .submit-form-ajax').prop('disabled',true)
                $('.loader_gb').addClass('show');
            },
            complete: function () {
                $('#'+formId).attr('data-ajax','loaded');
                $('#'+formId+' .submit-form-ajax').prop('disabled',false);
                $('.loader_gb').removeClass('show');
            }
        });
    });

    $(document).on('click', '.apply-modal-edit', function(){
        $('.time-edit').removeAttr('disabled');
        $('.apply-modal-submit').removeClass('dis-none');
        $('#apply-modal-edit-view').removeClass('show-view').addClass('show-input');
        $(this).addClass('dis-none');
        $('.apply-modal-close').addClass('dis-none');
        $('.title-toggle').toggle();
    });

    // $(document).on('change', '.apply-modal #apply-modal-form .form-check-input', function(){
    //     $('#error_for_job_interview_day').text('');
    // });

    window.showViewCalendar = function (view, index) {
        var curdate = new Date();
        var viewdate = new Date(view.start);
        var timeview30dayaffer = new Date(viewdate.getFullYear(), viewdate.getMonth(), viewdate.getDate() + 30).getTime();
        var curdate30dayaffer = new Date(curdate.getFullYear(), curdate.getMonth(), curdate.getDate() + 30).getTime();
        var test = new Date(curdate.getFullYear(), curdate.getMonth(), curdate.getDate() + 30);
        test.setHours(5,0,0);
        $('#calendar' + index + ' .fc-day-top').each(function () {
            var dataDate = new Date($(this).attr('data-date'));
            dataDate.setHours(0,0,0);
            if (dataDate.getTime() > curdate30dayaffer) {
                $(this).addClass('fc-past');
            }
        });
        // PREV - force minimum display month to current month
        if (new Date(viewdate.getFullYear(), viewdate.getMonth() + 1, 1).getTime() <=
            new Date(curdate.getFullYear(), curdate.getMonth(), 1).getTime()) {
            $('#calendar' + index + ' .fc-prev-button').prop('disabled', true).css('opacity', 0.5);
        } else {
            $('#calendar' + index + ' .fc-prev-button').prop('disabled', false).css('opacity', 1);
        }
        // NEXT - force max display month to a year from current month
        if (timeview30dayaffer > curdate30dayaffer) {
            $('#calendar' + index + ' .fc-next-button').prop('disabled', true).css('opacity', 0.5);
        } else {
            $('#calendar' + index + ' .fc-next-button').prop('disabled', false).css('opacity', 1);
        }
    }

    window.dayClickEvent = function (date, index) {
        var dateObj = new Date(moment(date).format('YYYY/MM/DD'));
        var curdate = new Date(moment().format('YYYY/MM/DD'));
        var curdate30dayaffer = new Date(curdate.getFullYear(), curdate.getMonth(), curdate.getDate() + 30);
        if (dateObj < curdate || dateObj > curdate30dayaffer)
            return;

        if ($('#interview_date_' + index).prop("disabled") == true)
            return;
        $('#calendar' + index + ' td').removeClass('fc-day-selected');
        $('#calendar' + index + ' td[data-date="' + date.format() + '"]').addClass('fc-day-selected');
        $('.calendar' + index).val(moment(date).format('YYYY/MM/DD'));
        $('#interview_date_' + index).removeClass('error');
        $('#interview_time_' + index).removeClass('error');
        // $('#error_for_interview_date_' + index).html();
        document.getElementById('error_for_interview_date_' + index).innerHTML = '';
        document.getElementById('error_for_interview_time_' + index).innerHTML = '';
    }
        //end apply step region
});

