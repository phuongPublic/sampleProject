
$(document).ready(function() {

    // 最寄り駅名 key press find suggestion
    $(".ajax_find_station_name").autocomplete({
        source: function( request, response ) {
            var id = $(this.element).prop("id");
            var attDiv = $('#'+id).attr('data-ajax');
            if(attDiv == 'loadding'){
                return;
            }

            $.ajax( {
                type: "POST",
                url:'/address/station/suggestion',
                dataType:'json',
                data: {name: request.term,id: id},
                beforeSend: function() {
                    var alias = 'workplace_nearest_station';
                    if(id.indexOf('interview') >= 0) {
                        alias = 'interview_nearest_station';
                    }
                    // set id, name station to input hidden
                    $('#'+alias+'_name_source').val('');
                    //$('#'+alias+'_cd').val('');

                    $('#'+id).attr('data-ajax','loadding');
                    $('.loader_gb').addClass('show');
                },
                success: function( json ) {
                    if(json.status == 200) {
                        response( json.results );
                        $('body .ui-autocomplete').css('max-width:', $('#'+id).width()+'px !important');
                        $('body .ui-autocomplete').css('width:', $('#'+id).width()+'px !important');
                    }
                },
                complete: function () {
                    $('#'+id).attr('data-ajax','loaded');
                    $('.loader_gb').removeClass('show');
                }
            } );
        },
        minLength: 1,
        select: function( event , ui ) {
            var alias = 'workplace_nearest_station';
            var id = this.id;
            if(id.indexOf('interview') >= 0) {
                alias = 'interview_nearest_station';
            }
            // set id, name station to input hidden
            $('#'+alias+'_name_source').val(ui.item.station_name);
            $('#'+alias+'_source_cd').val(ui.item.id);
        },
        messages: {
            noResults: ''
        }
    } );


    // prefecture change
    // ajax get city by prefecture or city
    $( ".workplace_prefecture").change(function() {
        var id = this.id;
        var interview = false;
        if(id.indexOf('interview') >= 0){
            interview = true;
        }
        var prefecture = this.value;
        if(prefecture == ''){
            disabledCity1(interview);
            disabledCity2(interview);
        }else{
            getCity(prefecture,'city1',interview);
            setMinSalary(prefecture, interview);
        }
        return;
    });

    // find city2 by city1 name
    $( ".workplace_city1").change(function() {
        var id = this.id;
        var interview = false;
        if(id.indexOf('interview') >= 0){
            interview = true;
        }

        var prefecture = this.value;
        if(prefecture == ''){
            disabledCity2(interview);
        }else{
            getCity(prefecture,'city2',interview);
        }
    });

    // find address by post code
    $(".find-address").on("click", function(){
        var id = this.id;
        var code = $('#workplace_post_cd').val();
        var interview = false;
        var alias = 'workplace';
        if(id.indexOf('interview') >= 0){
            interview = true;
            code = $('#interview_place_post_cd').val();
            alias = 'interview';
        }

        code = code.replace("__","");
        if(code.length != 7){
            if(interview == true){
                $('#interview_place_post_cd').addClass('error');
            }else{
                $('#workplace_post_cd').addClass('error');
            }

            showMessage(i18n.validation.job.workplace_post_cd_length);
            return;
        }else{
            $.ajax({
                type: "POST",
                url:'/address/get',
                dataType:'json',
                data:{code:code},
                success: function( json ) {
                    if(json.status == 200){
                        if(json.results == null ){
                            if(interview == true){
                                $('#interview_place_post_cd').addClass('error');
                            }else{
                                $('#workplace_post_cd').addClass('error');
                            }
                            showMessage(i18n.supply.job.address_null);
                        }else{
                            var result = json.results;
                            if(result.length > 0){

                                resetSelect(alias+'_city1');
                                $('#'+alias+'_city1').prop("disabled", false);

                                resetSelect(alias+'_city2');
                                $('#'+alias+'_city2').prop("disabled", false);

                                $.each(result,function(index, value){
                                    if(index == 0){
                                        var prefcode = {value: value.prefcode, label: value.address1};
                                        setMinSalary(value.prefcode, interview);
                                        setAddressPrefcode(prefcode,alias+'_prefecture',true);
                                        $('#'+alias+'_prefecture').removeClass('error');
                                        setAddress(value.address2,alias+'_city1',true);
                                        $('#'+alias+'_city1').removeClass('error');
                                        setAddress(value.address3,alias+'_city2',true);
                                        $('#'+alias+'_city2').removeClass('error');

                                    }else{
                                        setAddress(value.address2,alias+'_city1',false);
                                        setAddress(value.address3,alias+'_city2',false);
                                    }
                                });
                                // attach city 1
                                if(json.attach_city1 && json.attach_city1.length > 0){
                                    $.each(json.attach_city1,function(index, value){
                                        setAddress2(value,alias+'_city1');
                                    });
                                }
                                // attach city 2
                                if(json.attach_city2 && json.attach_city2.length > 0){
                                    $.each(json.attach_city2,function(index, value){
                                        setAddress2(value,alias+'_city2');
                                    });
                                }

                            }else{
                                if(interview == true){
                                    $('#interview_place_post_cd').addClass('error');
                                }else{
                                    $('#workplace_post_cd').addClass('error');
                                }
                                showMessage(i18n.supply.job.address_null);
                                return;
                            }
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
    });
});

// disabled City by prefecture
function disabledCity1(interview){
    if(interview == true){
        $('#interview_city1').val('').prop("disabled", true);
    }else{
        $('#workplace_city1').val('').prop("disabled", true);
    }
    return;
}

// disabled City by prefecture
function disabledCity2(interview){
    if(interview == true){
        $('#interview_city2').val('').prop("disabled", true);
    }else{
        $('#workplace_city2').val('').prop("disabled", true);
    }
    return;
}


// ajax get city by prefecture or city
function getCity(val, type, interview) {
    var alterDiv = 'workplace';
    if(interview == true)
        alterDiv = 'interview';

    var prefectureVal = '';
    prefectureVal = $('#'+alterDiv+'_prefecture option:selected').text();

    removeMessage();
    var param = {id:val,type:type,prefecture:prefectureVal};

    if(type == 'city2')
        var param = {name:val,type:type,prefecture:prefectureVal};

    $.ajax({
        type: "POST",
        url:'/address/'+type,
        dataType:'json',
        data:param,
        success: function( json ) {
            if(json.status == 200){
                if(json.results == null ){
                    showMessageCity(type);
                }else{
                    var result = json.results;
                    if(result.length > 0){
                        var selectId = alterDiv+'_city1';
                        if(type == 'city2')
                            selectId = alterDiv+'_city2';

                        resetSelect(selectId);

                        if(type == 'city1')
                            disabledCity2(interview);


                        $.each(result,function(index, value){
                            $('#'+selectId).append($('<option/>', { value: value,text : value}));
                        });

                        $('#'+selectId).prop("disabled", false);

                    }else{
                        showMessageCity(type);
                    }
                }

            }else{
                showMessage(json.message);
            }
        },
        beforeSend: function() {
            $('.loader_gb').addClass('show');
        },
        complete: function () {
            $('.loader_gb').removeClass('show');
        }
    });
}


