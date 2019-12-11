$(document).on('change','.up_cv', function(){
    var names = [];
    var length = $(this).get(0).files.length;
    $('.addedFile_cv span').text($(this).get(0).files[0].name);
    $('.addedFile_cv').show();
});

$(document).on('change','.up_resume', function(){
    var names = [];
    var length = $(this).get(0).files.length;
    $('.addedFile_resume span').text($(this).get(0).files[0].name);
    $('.addedFile_resume').show();
}); 