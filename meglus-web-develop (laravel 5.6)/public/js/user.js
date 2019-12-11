$(document).ready(function() {

    $(".multiple-sort").on("click", function(){
        sorting($(this).attr('data-sort'));
    });
    $( "a.multiple-sort" ).each(function( index ) {
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
});

// function sorting data
function sorting(filed) {
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
    window.location = '/mypage?'+url;


}

