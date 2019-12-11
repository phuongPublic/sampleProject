$(document).ready(function () {

    //detail screen show hide group
    $(".detail-title").click(function () {
        // $(this).next(".detail-info").slideToggle("fast");
        var collection = $( this ).find( "i.fa-plus-square" );
        if(collection.length > 0) {
            collection.addClass('fa-minus-square');
            collection.removeClass('fa-plus-square');
            $( this ).next(".detail-info").show();
        }else{
            $( this ).find("i.fa-minus-square").addClass('fa-plus-square');
            $( this ).find("i.fa-minus-square").removeClass('fa-minus-square');
            $( this ).next(".detail-info").hide();
        }
    });
});
