<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>My@T COM（マイアットティーコム）</title>
    <script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/contents/js/yui/fonts/fonts-min.css" />
    <script type="text/javascript" src="/contents/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/contents/js/styleswitcher.js"></script>
    <link type="text/css" rel="stylesheet" href="/contents/js/yui/reset/reset.css" />
    <link type="text/css" id="blue" rel="stylesheet" href="/contents/css/tcom/open_common.css" />
    <![if !(lte IE 6)]>
    <link type="text/css" id="green" rel="stylesheet" media="screen" title="green" href="/contents/css/tcom/open_common_blue.css" />
    <link type="text/css" id="pink" rel="stylesheet" media="screen" title="green" href="/contents/css/tcom/open_common_pink.css" />
    <link type="text/css" id="gray" rel="stylesheet" media="screen" title="green" href="/contents/css/tcom/open_common_gray.css" />
    <link type="text/css" id="orange" rel="stylesheet" media="screen" title="green" href="/contents/css/tcom/open_common_orange.css" />
    <link type="text/css" id="white" rel="stylesheet" media="screen" title="green" href="/contents/css/tcom/open_common_white.css" />
    <![endif]>
    <script type="text/javascript">
    var color_cookie = $.cookie('color_style');
    if(!color_cookie){
        color_cookie = 'blue';
    }
    jstyle(color_cookie);

    function jstyle(id){
        $("link").each(function() {
            if ($(this).attr("id") != ""){
                $(this).attr("disabled", true);
                if ($(this).attr("id") == id) {
                    $(this).attr("disabled", false);
                    $.cookie('color_style',id,{expires:30,path:'/'});
                }
            }
        });
    }
    $(document).ready(function () {
        $.ajax({
            url: "http://test1.mytcombbs.t-com.ne.jp/opt_bbs/logout/",
            method: "POST",
            data: {},
            dataType: 'jsonp',
            success: function() {
            }
        });
    });
    </script>
</head>
<body>

<div id="header">
    <div class="container">
        <div id="logo"><img src="/contents/images/tcom/logo.gif" alt="MY@TCOM" width="140" height="40" /></div>
        <div id="login"><p><a href="http://www.t-com.ne.jp/" target="_blank">@T COM(アットティーコム)</a>｜<a href="http://support.t-com.ne.jp/" target="_blank">会員サポート</a>｜<a href="http://service.t-com.ne.jp/mytcom/help/" target="_blank">ヘルプ</a></p></div>
        <br class="clear" />
    </div>
</div>

<div id="OpneContents" style="margin-bottom:30px;">
    <div class="container">
        <h1 class="pagettl"></h1>
        <div class="padArea" style="margin-top:40px;">
            <p class="txtRed txtCneter">エラーが発生しました。</p>
            <br>
            <p class="txtCneter">ウェブページを表示する事ができません。</p><br>
            <p class="txtCneter">恐れ入りますが、しばらく待ってから<br/>
                再度アクセス頂きますようお願いいたします。<br/>
            </p>
        </div>
    </div>
</div>

<div id="footer">
    <p id="foottops" class="txtCenter"><a href="/login.html">My＠T COM(マイアットティーコム)ログインページ</a>｜ <a href="http://www.t-com.ne.jp/" target="_blank">＠T COM(アットティーコム)トップページ</a><br />
        <a href="http://www.t-com.ne.jp/infopolicy/" target="_blank">情報セキュリティ基本方針</a>｜ <a href="http://www.t-com.ne.jp/policy/index.html" target="_blank">個人情報保護ポリシー</a>｜ <a href="http://service.t-com.ne.jp/mytcom/rules/" target="_blank">利用規約</a></p>
    <p id="footbottoms" class="txtCenter">Copyright(c) 2011 TOKAI Communications Corporation All rights reserved. </p>
</div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
</body>
</html>