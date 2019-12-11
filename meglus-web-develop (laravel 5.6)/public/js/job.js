
$(document).ready(function() {

    //Remove option when selected job important
    var important1Selected = $('#important1_cd').val() ? $('#important1_cd').val() : 0;
    var important2Selected = $('#important2_cd').val() ? $('#important2_cd').val() : 0;
    var important3Selected = $('#important3_cd').val() ? $('#important3_cd').val() : 0;

    //Remove option
    $('#important2_cd option[value=' + important1Selected + ']').css('display', 'none');
    $('#important3_cd option[value=' + important1Selected + ']').css('display', 'none');

    //Remove option
    $('#important1_cd option[value=' + important2Selected + ']').css('display', 'none');
    $('#important3_cd option[value=' + important2Selected + ']').css('display', 'none');

    //Remove option
    $('#important1_cd option[value=' + important3Selected + ']').css('display', 'none');
    $('#important2_cd option[value=' + important3Selected + ']').css('display', 'none');

    $('#important1_cd').change(function () {
        important1Selected = $('#important1_cd').val() ? $('#important1_cd').val() : 0;
        important2Selected = $('#important2_cd').val() ? $('#important2_cd').val() : 0;
        important3Selected = $('#important3_cd').val() ? $('#important3_cd').val() : 0;

        //Set default
        $('#important1_cd option').css('display', 'inline-block');
        $('#important2_cd option').css('display', 'inline-block');
        $('#important3_cd option').css('display', 'inline-block');

        //Remove option
        $('#important2_cd option[value=' + important1Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important1Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important2Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important2Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important3Selected + ']').css('display', 'none');
        $('#important2_cd option[value=' + important3Selected + ']').css('display', 'none');
    });

    $('#important2_cd').change(function () {
        important1Selected = $('#important1_cd').val() ? $('#important1_cd').val() : 0;
        important2Selected = $('#important2_cd').val() ? $('#important2_cd').val() : 0;
        important3Selected = $('#important3_cd').val() ? $('#important3_cd').val() : 0;

        //Set default
        $('#important1_cd option').css('display', 'inline-block');
        $('#important2_cd option').css('display', 'inline-block');
        $('#important3_cd option').css('display', 'inline-block');

        //Remove option
        $('#important2_cd option[value=' + important1Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important1Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important2Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important2Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important3Selected + ']').css('display', 'none');
        $('#important2_cd option[value=' + important3Selected + ']').css('display', 'none');
    });

    $('#important3_cd').change(function () {
        important1Selected = $('#important1_cd').val() ? $('#important1_cd').val() : 0;
        important2Selected = $('#important2_cd').val() ? $('#important2_cd').val() : 0;
        important3Selected = $('#important3_cd').val() ? $('#important3_cd').val() : 0;

        //Set default
        $('#important1_cd option').css('display', 'inline-block');
        $('#important2_cd option').css('display', 'inline-block');
        $('#important3_cd option').css('display', 'inline-block');

        //Remove option
        $('#important2_cd option[value=' + important1Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important1Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important2Selected + ']').css('display', 'none');
        $('#important3_cd option[value=' + important2Selected + ']').css('display', 'none');

        //Remove option
        $('#important1_cd option[value=' + important3Selected + ']').css('display', 'none');
        $('#important2_cd option[value=' + important3Selected + ']').css('display', 'none');
    });

    // get company info
    $(".get-workplace").on("click", function(){
        copyCompanyInfo();
        return;
    });

    $("#job_register_form :input").change(function() {
        $("#job_register_form #copy-job").prop("disabled", false);
    });

    $( "#application_method_0").change(function() {
        if(this.checked == true){
            $('#job-radio-item-0').addClass('selected');
            $("#application_method_1").prop('checked', false);
            $('#job-radio-item-1').removeClass('selected');
        }else{
            $("#application_method_1").prop('checked', true);
            $('#job-radio-item-1').addClass('selected');
            $('#job-radio-item-0').removeClass('selected');
        }
    });

    $( "#application_method_1").change(function() {
        if(this.checked == true){
            $('#job-radio-item-1').addClass('selected');
            $("#application_method_0").prop('checked', false);
            $('#job-radio-item-0').removeClass('selected');
        }else{
            $("#application_method_0").prop('checked', true);
            $('#job-radio-item-0').addClass('selected');
            $('#job-radio-item-1').removeClass('selected');
        }
    });

    // Change min salary
    $( "#min_salary").change(function() {
        removeMessage();
        var val = $(this).val();
        var min = $(this).attr('data-min');
        if(typeof min == 'undefined'){
            var  pre = $('#workplace_prefecture').val();
            if(pre != ''){
                min = minimumWages[pre];
                $(this).attr('data-min', min);
            }
        }


        if(typeof min != 'undefined'){
            if(parseInt(min) > parseInt(val)){
                var string = i18n.supply.job.min_salary_min_value;
                string = string.replace('%d',min);
                showMessage(string);
                return;
            }
        }
        return;
    });

    // Change min salary
    $( "#max_salary").change(function() {
        removeMessage();
        var val = $(this).val();
        if(parseInt(maximumWages) < parseInt(val)){
            //var string = i18n.supply.job.max_salary_max_value;
            //string = string.replace('%d',maximumWages);
            return;
        };
        return;
    });

    // ajax get job discription by category
    $( ".job_category_cd").change(function() {

        var discriptionId = 'job_discription_cd';
        var id =  this.id;
        if(id == 'experience1_category_cd')
            discriptionId = 'experience1_description_cd';

        if(id == 'experience2_category_cd')
            discriptionId = 'experience2_description_cd';

        if(id == 'experience3_category_cd')
            discriptionId = 'experience3_description_cd';

        var val = $(this).val();
        if(typeof val == 'undefined' || val == '' || val.length == 0){
            $('#'+discriptionId).val('');
            $('#'+discriptionId).prop("disabled", true);
           return;
        }

        getJobDiscription(val, discriptionId);
        return;
    });

    function getJobDiscription(val,id){
        var  param = {id:val};
        if(typeof jobCategoryCd[val] != 'undefined' && typeof jobCategoryCd[val].items != 'undefined'){
            var result = jobCategoryCd[val].items;
            resetSelect(id);
            $('#'+id).prop("disabled", false);
            $.each(result,function(index, value){
                setValuetoSelectBox(value.id, value.name, id, false);
            });
            return;
        }

        $.ajax({
            type: "POST",
            url:'/job/get-description',
            dataType:'json',
            data:param,
            success: function( json ) {
                if(json.status == 200){
                    var result = json.results;
                    jobCategoryCd[val].items = json.results;
                    resetSelect(id);
                    $.each(result,function(index, value){
                        setValuetoSelectBox(value.id, value.name, id, false);
                    });
                }else{
                    showMessage(json.message);
                }
            },
            beforeSend: function() {
                $('#'+id).attr('data-ajax','loadding');
                $('.loader_gb').addClass('show');
            },
            complete: function () {
                $('#'+id).attr('data-ajax','loaded');
                $('.loader_gb').removeClass('show');
                $('#'+id).prop("disabled", false);
            }
        });
        return ;
    }


    // job create submit form
    $('button[submit-form-ajax="true"]').click(function(event) {
        removeMessage();
        var formId      = $(this).attr('data-form-id');
        if($('#'+formId).attr('data-ajax') == 'loading')
            return;

        var method      = $('#'+formId).attr('method');
        var url         = $('#'+formId).attr('href');
        var postData    = $('#'+formId).serializeArray();
        $.ajax({
            type: method,
            url:url,
            dataType:'json',
            data:postData,
            success: function( json ) {
                if(json.status == 200){
                    // error messages
                    var messagesString = '';
                    $.each(json.messages,function(index, value){
                        if(index == 'residences'){
                            $('.ms-parent').addClass('error');
                        }else{
                            $('#'+index).addClass('error');
                        }

                        messagesString = messagesString + '<p>'+value+'</p>';
                    });

                    if(messagesString.length > 0) {
                        showMessage(messagesString);
                    }else{
                        // success submit error = null
                        var redirectUrl = $('#'+formId).attr('data-redirect');
                        if(json.redirect_url)
                            redirectUrl = json.redirect_url;
                        window.location.href = redirectUrl;
                    }
                }else{
                    showMessage(json.messages);
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

    // get company info
    $(".get-company-info").on("click", function(){
        var id = this.id;
        var interview = false;
        var alias = 'workplace';
        if(id.indexOf('interview') >= 0){
            interview = true;
            alias = 'interview';
        }

        if(typeof companyInfo != 'undefined' && typeof companyInfo.status != 'undefined' ){
            if(companyInfo.status == 200){
                if(companyInfo.results != null ){
                    setCompanyInfo(companyInfo, alias, interview);
                }else{
                    showMessage(companyInfo.message);
                }
            }else{
                showMessage(companyInfo.message);
            }
            return;

        }else{
            $.ajax({
                type: "POST",
                url:'/job/get-company-address',
                dataType:'json',
                data:{},
                success: function( json ) {
                    companyInfo = json;
                    if(json.status == 200){
                        if(json.results == null ){
                            showMessage(json.message);
                        }else{
                            setCompanyInfo(json, alias, interview);
                        }

                    }else{
                        showMessage(json.message);
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
        return;

    });

    function setCompanyInfo(prefectureInfo, alias, interview) {
        resetSelect(alias+'_city1');
        $('#'+alias+'_city1').prop("disabled", false);
        resetSelect(alias+'_city2');
        $('#'+alias+'_city2').prop("disabled", false);

        // attach city 1
        if(prefectureInfo.attach_city1 && prefectureInfo.attach_city1.length > 0){
            $.each(prefectureInfo.attach_city1,function(index, value){
                setAddress2(value,alias+'_city1');
            });
        }

        // attach city 2
        if(prefectureInfo.attach_city2 && prefectureInfo.attach_city2.length > 0){
            $.each(prefectureInfo.attach_city2,function(index, value){
                setAddress2(value,alias+'_city2');
            });
        }


        setAddress(prefectureInfo.results.city1,alias+'_city1',true);
        setAddress(prefectureInfo.results.city2,alias+'_city2',true);
        setValuetoInput(prefectureInfo.results.prefecture,alias+'_prefecture');
        setValuetoInput(prefectureInfo.results.detail_address,alias+'_detail_address');
        setValuetoInput(prefectureInfo.results.building_name,alias+'_building_name');
        setValuetoInput(prefectureInfo.results.building_name_en,alias+'_building_name_en');
        if(interview == true){
            setValuetoInput(prefectureInfo.results.post_cd,alias+'_place_post_cd');
        }else {
            setValuetoInput(prefectureInfo.results.post_cd,alias+'_post_cd');
        }

        if(typeof prefectureInfo.results.prefecture != 'undefined' && interview == false){
            setMinSalary(prefectureInfo.results.prefecture, interview);
        }
    }

    function copyCompanyInfo() {

        cloneInput('workplace_post_cd','interview_place_post_cd');
        cloneInput('workplace_prefecture','interview_prefecture');

        cloneSelectBox('workplace_city1','interview_city1');
        cloneSelectBox('workplace_city2','interview_city2');

        cloneInput('workplace_detail_address','interview_detail_address');
        cloneInput('workplace_building_name','interview_building_name');
        cloneInput('workplace_building_name_en','interview_building_name_en');
        cloneInput('workplace_nearest_station_cd','interview_nearest_station_cd');
        cloneInput('workplace_nearest_station_name_source','interview_nearest_station_name_source');
        cloneInput('workplace_nearest_station_source_cd','interview_nearest_station_source_cd');
        cloneInput('workplace_nearest_station_move_type','interview_nearest_station_move_type');
        cloneInput('workplace_nearest_station_move_time','interview_nearest_station_move_time');
        return;
    }

    $("form#job_register_form input, form#demand_form input" ).focus(function() {
        if($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio'){
            $('input[name="'+$(this).attr('name')+'"]').removeClass('error');
        }
        $(this).removeClass('error');
    });

    $("form#job_register_form select,form#demand_form select" ).focus(function() {
        $(this).removeClass('error');
    });

    $("form#job_register_form .importantCd, form#demand_form .importantCd" ).focus(function() {
        $('.importantCd').removeClass('error');
    });

    $("form#demand_form .ms-parent button" ).focus(function() {
        $('.ms-parent').removeClass('error');
    });

    $(".multiple-sort-apply").on("click", function(){
        sortingApply($(this).attr('data-sort'));
    });

    $( "a.multiple-sort-apply" ).each(function( index ) {
        var text = '';
        if(parseInt($( this ).attr('data-sort-index')) > 0){
            text = $( this ).html()+'<span class="sort sort-'+$( this ).attr('data-sort-icon')+'"></span>';
            $( this ).html(text);
        }else{
            text = $( this ).html()+'<span class="sort sort-none"></span>';
            $( this ).html(text);
        }
    });

});


// function sorting data
function sortingApply(filed) {
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

    if($('#datepicker_confirm').length >0 ){
        url = url+'&month_filter='+$('#datepicker_confirm').val();
    }

    if($('.page-item.active span').length > 0){
        if(url.length > 0){
            url = url+'&page='+$('.page-item.active span').first().html();
        }else{
            url = 'page='+$('.page-item.active span').first().html();
        }
    }

    //window.location = $('#job-apply-url').val()+'?'+url;
    window.location = pageUrl+'?'+url;
}

