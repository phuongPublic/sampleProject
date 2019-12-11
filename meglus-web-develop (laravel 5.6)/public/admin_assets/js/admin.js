$(document).ready(function() {
    $(".reset-code").on("click", function(){
        updateOtp($(this).attr('data-id'),'reset');
    });

    $(".update-owner").on("click", function(){
        updateOtp($(this).attr('data-id'),'set-owner');
    });

    $("input[type=file].custom-file-input ").change(function() {
        readURL(this);
    });

    $("#filter_job_category_cd").change(function() {
        if($(this).val() == ''){
            $('#filter_job_discription_cd').val('');
            $('#filter_job_discription_cd').prop("disabled", true);
        }else{
            resetSelect('filter_job_discription_cd');
            $('#filter_job_discription_cd').prop("disabled", false);
            $.each(jobCategory[$(this).val()]['items'],function(index, value){
                setValuetoSelectBox(value.id, '\xa0\xa0'+value.name, 'filter_job_discription_cd', false);
            });
        }
        return;
    });

    $(".multiple-sort-otp").on("click", function(){
        sortingAdminList($(this).attr('data-sort'), '/admin/otp');
    });

    $(".multiple-sort-admin-list").on("click", function(){
        sortingAdminList($(this).attr('data-sort'), pageUrl);
    });

    $(".multiple-sort-applicant").on("click", function(){
        sortingAdminList($(this).attr('data-sort'), pageUrl);
    });

    $(".multiple-sort-user").on("click", function(){
        sortingAdminList($(this).attr('data-sort'), pageUrl);
    });

    $(".multiple-sort-company").on("click", function(){
        sortingAdminList($(this).attr('data-sort'), pageUrl);
    });

    $( "a.multiple-sort-otp" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            //text = $( this ).text() + '<span class="icon">'+$( this ).attr('data-sort-icon')+'</span>'+ '<span class="index">'+$( this ).attr('data-sort-index')+'</span>';
            text = $( this ).html()+'<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

    $( "a.multiple-sort-admin-list" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            //text = $( this ).text() + '<span class="icon">'+$( this ).attr('data-sort-icon')+'</span>'+ '<span class="index">'+$( this ).attr('data-sort-index')+'</span>';
            text = $( this ).html()+'<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

    $( "a.multiple-sort-applicant" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            //text = $( this ).text() + '<span class="icon">'+$( this ).attr('data-sort-icon')+'</span>'+ '<span class="index">'+$( this ).attr('data-sort-index')+'</span>';
            text = $( this ).html()+'&nbsp;<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'&nbsp;<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

    $( "a.multiple-sort-user" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            //text = $( this ).text() + '<span class="icon">'+$( this ).attr('data-sort-icon')+'</span>'+ '<span class="index">'+$( this ).attr('data-sort-index')+'</span>';
            text = $( this ).html()+'&nbsp;<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'&nbsp;<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

    $( "a.multiple-sort-company" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            //text = $( this ).text() + '<span class="icon">'+$( this ).attr('data-sort-icon')+'</span>'+ '<span class="index">'+$( this ).attr('data-sort-index')+'</span>';
            text = $( this ).html()+'&nbsp;<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'&nbsp;<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

    $('#modal-btn-no').on("click", function(){
        $("#confirm-modal").modal('hide');
    });

    $('#upload').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload_img').attr('src', e.target.result);
                $('#upload-base64').val(e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#upload_img').attr('src', $('#upload_img').attr('data-default-url'));
            $("#confirm-modal").modal('show');
            $(this).val('');
            $('#upload-base64').val('');

        }
    });

    //Get data when set max job num
    $('.action-change-max-job').click(function () {
        $('#company_id_change_max_job').val($(this).attr('data-id'));
        $('#max_job_num_current').val($(this).attr('data-num'));
    });

    // Validate form change num
    $("#change_max_num_job").validate({});

    $( "input[id*=max_job_num_current]" ).rules( "add", {
        required: true,
        messages: {
            required: "数字を入力してください。",
        }
    });
    $('#datepicker-month-before').click(function () {
        var now = new Date($('#datepicker').val()+'/01');
        var year = now.getFullYear();
        var month = now.getMonth();
        if(month == 0){
            month = 11;
            year = year - 1;
        }else{
            month = month - 1;
        }
        month = month + 1;
        var formatDateComponent = function(dateComponent) {
            return (dateComponent < 10 ? '0' : '') + dateComponent;
        };

        var date = year+'/'+ formatDateComponent(month);
        $('#datepicker').val(date);
        window.location = pageUrl+'?month_filter='+date;
        return;
    });

    $('#datepicker-month-after').click(function () {
        var now = new Date($('#datepicker').val()+'/01');
        var year = now.getFullYear();
        var month = now.getMonth();
        if(month == 11){
            month = 0;
            year = year + 1;
        }else{
            month = month + 1;
        }
        month = month + 1;

        var formatDateComponent = function(dateComponent) {
            return (dateComponent < 10 ? '0' : '') + dateComponent;
        };

        var date = year+'/'+ formatDateComponent(month);
        $('#datepicker').val(date);
        window.location = pageUrl+'?month_filter='+date;
        return;
    });

});

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}



//Show sequence history
function showSequenceHistory(content_id) {
    $.ajax({
        type: "GET",
        url:'/admin/applicant/get-sequence-history/' + content_id,
        success: function( data ) {
            $('#data-sequence-history').html('');
            if (data) {
                $.each(data, function (key, val) {
                    var seqBefore = (val.before != null) ? JSON.parse(val.before).seq : '';
                    var seqAfter = (val.after != null) ? JSON.parse(val.after).seq : '';
                    $('#data-sequence-history').append(
                        '<tr>' +
                        '<td class="text-center">' + (key+1) + '</td>' +
                        '<td class="text-center">' + seqBefore + '</td>' +
                        '<td class="text-center">' + seqAfter + '</td>' +
                        '<td class="text-center">' + val.updated_at + '</td>' +
                        '</tr>'
                    );
                })
            };
            $('#modal-sequence-history').modal('show');
        },
        beforeSend: function() {
            $('.loader_gb').addClass('show');
        },
        complete: function () {
            $('.loader_gb').removeClass('show');
        }
    });
}

// function sorting data
function sortingAdmin(filed, pageUrl) {
    if(typeof filed == 'undefined')
        return;

    if(sortingData.hasOwnProperty(filed)){
        var sortValue = sortingData[filed];
        if(sortValue == 'ASC'){
            sortValue = 'DESC';
        }else if(sortValue == 'DESC'){
            sortValue = '';
        }else{
            sortValue = 'ASC';
        }
    }else{
        sortValue = 'ASC';
    }

    var newSort = [];
    if(sortValue == 'ASC' || sortValue == 'DESC')
        newSort.push('sort['+filed + ']=' + encodeURIComponent(sortValue));

    for(var k in sortingData) {
        if(k != filed){
            if(sortingData[k] == 'ASC' || sortingData[k] == 'DESC')
                newSort.push('sort['+k+ ']=' + encodeURIComponent(sortingData[k]));
        }else{
            delete sortingData[filed];
        }
    }

    sortingData[filed] = sortValue;
    var url = newSort.join('&');
    if($('.page-item.active span').length > 0){
        if(url.length > 0){
            url = url+'&page='+$('.page-item.active span').first().html();
        }else{
            url = 'page='+$('.page-item.active span').first().html();
        }
    }
    window.location = pageUrl+'?'+url;


}


function linkConfirm(title,message,link) {
    $('#title-modal-confirm').text(title);
    $('#modal-body-confirm').text(message);
    $("#link-modal").attr('href',link);
    $("#confirm-modal").modal('show');
}

// function sorting data
function sortingAdminList(filed, pageUrl) {
    if(typeof filed == 'undefined')
        return;

    if(sortingData.hasOwnProperty(filed)){
        var sortValue = sortingData[filed];
        if(sortValue == 'ASC'){
            sortValue = 'DESC';
        }else if(sortValue == 'DESC'){
            sortValue = '';
        }else{
            sortValue = 'ASC';
        }
    }else{
        sortValue = 'ASC';
    }

    var newSort = [];
    if(sortValue == 'ASC' || sortValue == 'DESC')
        newSort.push('sort['+filed + ']=' + encodeURIComponent(sortValue));

    for(var k in sortingData) {
        if(k != filed){
            if(sortingData[k] == 'ASC' || sortingData[k] == 'DESC')
                newSort.push('sort['+k+ ']=' + encodeURIComponent(sortingData[k]));
        }else{
            delete sortingData[filed];
        }
    }

    sortingData[filed] = sortValue;
    var url = newSort.join('&');

    for(var k in filterData) {
        if(filterData[k] != null)
         url = url+'&filter['+k+']='+filterData[k];
    }
    if($('.page-item.active span').length > 0){
        if(url.length > 0){
            url = url+'&page='+$('.page-item.active span').first().html();
        }else{
            url = 'page='+$('.page-item.active span').first().html();
        }
    }

    window.location = pageUrl+'?'+url;


}


//function view image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            console.log(input);
            $('#'+$(input).attr('data-iid')).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
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

