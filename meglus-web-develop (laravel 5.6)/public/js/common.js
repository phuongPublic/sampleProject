$(document).ready(function() {
    // min height content
    setMinHeight();
    $(".move_top").on("click", function(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
    $(".expire-code").on("click", function(){
        activeCode('expire-code','');
    });
    $('[data-toggle="tooltip"]').tooltip({html:true});

    // input mask
    $('.unit_time_start').inputmask("99:99",{ "placeholder": "" });
    $('.unit_time_end').inputmask("99:99",{ "placeholder": "" });
    $('.post_cd').inputmask("9999999",{ "placeholder": "" });
    $('.input_salary').inputmask("99999",{ "placeholder": "" });
    $('.tel').inputmask("999999999999999");
    var option = {
        twentyFour: true,
        title: '時間',
        showSeconds: false,
    };
    if($('.timepicker-24-hr').length > 0){
        $('.timepicker-24-hr').wickedpicker(option);
    }
    return;
});

$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    //>=, not <=
    if (scroll >= 30) {
        //clearHeader, not clearheader - caps H
        $("body").addClass("scroll_down");
    }else{
        $("body").removeClass("scroll_down");
    }
}); //missing );

// show user info region
function showUserInfo(id, jid) {
    var postData = {id:id,jid:jid};
    $.ajax({
        type: "POST",
        url:'/get-user-info',
        data:postData,
        success: function( data ) {
            $('.user-info-modal').remove();
            $('.modal-backdrop').hide();
            $('body').append(data);
            $('.user-info-modal').modal('show');
            return;
        },
        beforeSend: function() {
            $('.loader_gb').addClass('show');
        },
        complete: function () {
            $('.loader_gb').removeClass('show');
            // var screen_height = $(window).height();
            // $('.modal-content').css({"height" : screen_height - 100});
            // $('.user-info-modal').show();
        }
    });
}

// Set min height content-wrapper
function setMinHeight() {
    var height = $(window).height();
    var footerHeight = $("footer.footer ").height();
    var paddingTop = $('#content-wrapper .container').css('padding-top');
    if(typeof paddingTop == 'undefined')
        paddingTop = '';

    var paddingBottom = $('#content-wrapper .container').css('padding-bottom');
    if(typeof paddingBottom == 'undefined')
        paddingBottom = '';

    var padding = parseInt(paddingTop.replace('px','')) + parseInt(paddingBottom.replace('px',''));
    $('#content-wrapper .container').attr('style','min-height:'+( (height + footerHeight + 10) - padding)+'px');
}

function showMessage(string) {
    if(string.length > 0){
        removeMessage();
        $("#errorArea").html(string).show('slow');
    }
    return;
}

function showMessageSuccess(string) {
    if(string.length > 0){
        removeMessage();
        $("#successArea").html(string).show('slow');
    }
    return;
}

// remove right message
function removeMessage() {
    $('.error-mesages-right').html('').hide();
    return;
}

function setMinSalary(prefecture, interview){
    // set salary
    if(typeof minimumWages != 'undefined' && $('#min_salary').length > 0 && interview == false ){
        if(typeof minimumWages[prefecture] != 'undefined' ){
            if(parseInt($('#min_salary').val()) >= minimumWages[prefecture]){
                $('#min_salary').attr('data-min',minimumWages[prefecture]);
                $('#min_salary').removeClass('error');
            }else{
                $('#min_salary').attr('data-min',minimumWages[prefecture]);
                $('#min_salary').val(minimumWages[prefecture]);
                $('#min_salary').removeClass('error');
            }
        }
    }
    return;
}

// set value address to select box
function setAddress(value, id, active) {
    if($("#"+id+" option[value='"+value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: value,text : value}));
    }
    if(active == true){
        $('#'+id).val(value);
    }

    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }
}

// set value address Prefcode to select box
function setAddressPrefcode(data, id, active) {
    if($("#"+id+" option[value='"+data.value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: data.value,text : data.label}));
    }

    if(active == true){
        $('#'+id).val(data.value);
    }

    if(typeof data.value != 'undefined' && data.value != ''){
        $('#'+id).removeClass('error');
    }
    return;
}

function setAddress2(value, id) {
    if($("#"+id+" option[value='"+value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: value,text : value}));
    }else{
        $("#"+id+" option[value='"+value+"']").remove();
        $('#'+id).append($('<option/>', { value: value,text : value}));
        $('#'+id).val(value);
    }

    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }

    return;
}

// reset select box by id
function resetSelect(id) {
    var value = '';
    if($("#"+id+" option[value='']").length > 0){
        value = $("#"+id+" option[value='']").text();
    }

    $('#'+id).find('option').remove().end();

    if(value != ''){
        $('#'+id).append($('<option/>', { value: '',text : value}));
    }
}

// show message: city1, city2 is not result
function showMessageCity(type){
    var string = i18n.supply.job.address_city1_null;
    if(type == 'city2'){
        string = i18n.supply.job.address_city2_null;
    }
    showMessage(string);
}

// set value to select box
function setValuetoSelectBox(value, label, id, active) {
    if($("#"+id+" option[value='"+value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: value,text : label}));
    }

    if(active == true){
        $('#'+id).val(value);
    }

    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }
}

// set value address to select box
function setAddress(value, id, active) {
    if($("#"+id+" option[value='"+value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: value,text : value}));
    }

    if(active == true){
        $('#'+id).val(value);
    }

    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }
}

// set value address Prefcode to select box
function setAddressPrefcode(data, id, active) {
    if($("#"+id+" option[value='"+data.value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: data.value,text : data.label}));
    }

    if(active == true){
        $('#'+id).val(data.value);
    }

    if(typeof data.value != 'undefined' && data.value != ''){
        $('#'+id).removeClass('error');
    }
    return;
}

// set active Prefcode.
function setActivePrefcode(val, id) {
    $('#'+id).val(val);
    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }
    return;
}

// set active Prefcode.
function setValuetoInput(val, id) {
    $('#'+id).val(val);

    if(typeof val != 'undefined' && val != ''){
        $('#'+id).removeClass('error');
    }
    return;
}

function setAddress2(value, id) {
    if($("#"+id+" option[value='"+value+"']").length == 0){
        $('#'+id).append($('<option/>', { value: value,text : value}));
    }else{
        $("#"+id+" option[value='"+value+"']").remove();
        $('#'+id).append($('<option/>', { value: value,text : value}));
        $('#'+id).val(value);
    }
    if(typeof value != 'undefined' && value != ''){
        $('#'+id).removeClass('error');
    }

    return;
}

// reset select box by id
function resetSelect(id) {
    var value = '';
    if($("#"+id+" option[value='']").length > 0){
        value = $("#"+id+" option[value='']").text();
    }

    $('#'+id).find('option').remove().end();

    if(value != ''){
        $('#'+id).append($('<option/>', { value: '',text : value}));
    }
}
// function clone select box
function cloneSelectBox(id,secondId) {
    if($('#'+id).attr('disabled') != 'disabled')
        $('#'+secondId).prop("disabled", false);

    $('#'+secondId).find('option').remove().end();

    var $options = $('#'+id+' > option').clone();
    $('#'+secondId).append($options);
    cloneInput(id,secondId);
    return;
}

// conlone value input
function cloneInput(id,secondId) {
    var val = '';
    if($('input[name='+id+']').attr('type') == 'radio'){
        val =  $('input[name='+id+']:checked').val();
        $("input[name="+secondId+"][value=" + val + "]").prop('checked', true);
    }else{
        val = $('#'+id).val();
        $('#'+secondId).val(val);
    }

    if(typeof val != 'undefined' && val != ''){
        $('#'+secondId).removeClass('error');
    }
    return;
}









