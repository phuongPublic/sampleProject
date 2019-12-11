$(document).ready(function () {

    //show hide menu
    $(".hamburger-nav").on("click", function () {
        $(".menu").animate({
            height: 'toggle'
        });

    });

    //change language
    $('#lang-btn').change(function () {
        var queryStr = window.location.search;
        var pathStr = window.location.pathname;
        if (queryStr != '') {
            queryStr = queryStr.replace(/&lang=vn/g, '');
            queryStr = queryStr.replace(/\?lang=vn/g, '');
            queryStr = queryStr.replace(/lang=vn/g, '');
            queryStr = queryStr.replace(/&lang=jp/g, '');
            queryStr = queryStr.replace(/\?lang=jp/g, '');
            queryStr = queryStr.replace(/lang=jp/g, '');

        }
        var link = pathStr + queryStr;
        if ($(this).prop('checked')) {
            link = addLanguageStr(link, 'vn');
        } else {
            link = addLanguageStr(link, 'jp');
        }
        window.location.assign(link);
    });

    //show hide menu bar
    var $navi = $("#navigation"), scrollTop = 0;
    var is_safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    $(window).scroll(function () {
        if(!is_safari)
        {
            var y = $(this).scrollTop(), speed = 0.05, pos = y * speed, maxPos = 100;
            if (y > scrollTop) {
                pos = maxPos;
            } else {
                pos = 0;
            }
            scrollTop = y;
            $(".menu").hide();
            $navi.css({
                "-webkit-transform": "translateY(-" + pos + "%)",
                "-moz-transform": "translateY(-" + pos + "%)",
                "-o-transform": "translateY(-" + pos + "%)",
                "transform": "translateY(-" + pos + "%)"
            });
        }
    });
})
;

function addLanguageStr(link, language) {
    var result = '';
    if(link.match(/\?/))
    {
        result = link + '&'  + 'lang=' + language;
    }else
    {
        result = link + '?' + 'lang=' + language;
    }
    return result;
}
