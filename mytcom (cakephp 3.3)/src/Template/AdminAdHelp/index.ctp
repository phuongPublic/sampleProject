<!DOCTYPE html>
<head>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php if ($this->Common->getIsp() == 'tcom') : ?>
    <title>My@T COM（マイアットティーコム）</title>
    <?php else : ?>
    <title>広告表示例</title>
    <?php endif; ?>
    <script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript"> 
        $(document).ready(function(){
            $(function(){
                $('input.btnovr').hover(function() {
                    $(this).addClass('btnovrOn');
                },
                function() {
                    $(this).removeClass('btnovrOn');
                });
            });
        });
    </script>
    <style type="text/css">
        body {
            border-top:5px solid #0275AA;
            background:#fff url(/contents/admin/img/bg_head.jpg) repeat-x 0 5px;
            font:13px/1.6 "ＭＳ Ｐゴシック", "MS P Gothic", "メイリオ", Meiryo, Arial, Osaka, sans-serif;
            *font-size:small;/*IE7*/
            *font:x-small;/*IE6*/
            font-style: normal;
            color: #000000;
            text-decoration: none;
            width:auto;
            margin-right: auto;
            margin-left: auto;
            margin-top:0px;
            text-align:center;
        }
        * {
            color:#333333;
            margin:0;
            padding:0;
        }
        ul, dl, ol { list-style:none; }
        input, select, option, textarea { font-family: "ＭＳ Ｐゴシック", "MS P Gothic", "メイリオ", Meiryo, Arial, Osaka, sans-serif; }
        a { text-decoration: none; }
        a:link {
            color: #00608D;
            text-decoration: none;
        }
        a:visited {
            color: #4F7384;
            text-decoration: none;
        }
        a:hover {
            color: #1AB5FF;
            text-decoration: underline;
        }
        img {
            border:0;
            outline:none;
        }
        a img, a:hover img {
            text-decoration:none;
            border:none;
            outline:none;
        }
        table {
            border-collapse:collapse;
            border-spacing:0;
        }
        form, input {
            margin: 0px;
            padding: 0px;
            border:0;
        }
        input {
            padding: 2px;
            vertical-align: middle;
        }
        h1 { font-size: 120%; }
        h2, h3 { font-size: 100%; }
        #head {
            margin:0 20px;
            height:85px;
            text-align:left;
        }
        #headLogo {
            margin:15px 0px -20px 0px;
            position:relative;
            display:inline;
            clear:both;
            float:left;
            width:400px;
        }
        #headLogo span {
            position:absolute;
            left:194px;
            top:18px;
            vertical-align:top;
            color:#444;
            font-size:16px;
            font-weight:bold;
        }
        div.container {
            padding:0 20px;
            margin:0 auto;
            text-align:left;
        }
        #logo { margin-top:20px; }
        .clear { clear:both; }
        .floL { float:left; }
        .floR { float:right; }
        h1.pagettl {
            text-align:center;
            padding:7px 0 0 0;
            margin-bottom:10px;
        }
        .BGColorSkyColor { background:#EDF5FB url(/contents/images/bg_lightblue_gra.jpg) repeat-x left bottom; }
        .bdrbotdot { border-bottom:1px dotted #d7d7d7; }
        .padArea { padding:10px 0px; }
        .imgLine { border:1px solid #999; }
        .btnovr {
            width:130px;
            height:30px;
            letter-spacing:.2em;
            background:transparent url(/contents/images/btn_input.jpg) no-repeat center center;
            cursor:pointer;
            color:#00608D;
            font-size:13px !important;
        }
        .txtCenter { text-align:center; }
        #foot {
            margin-top:30px;
            border-top:3px solid #0275AA;
            clear:both;
            width:100%;
            height:70px;
            text-align:center;
        }
        #footCopy {
                margin:10px 20px;
                text-align:left;
        }
    </style>
</head>
<body>
    <div id="head">
        <?php if ($this->Common->getIsp() == 'tcom') : ?>
        <h1 id="headLogo"><a href="/admin/index.html"><img src="/contents/admin/img/logo_head_tcom.jpg" alt="My@T COM" /></a><span>管理者用サイト</span></h1>
        <?php else : ?>
        <h1 id="headLogo"><a href="/admin/index.html"><img src="/contents/admin/img/logo_head_tnc.jpg" alt="TNCポケット" /></a><span>管理者用サイト</span></h1>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1 class="pagettl BGColorSkyColor" style="padding-bottom:5px;">広告表示例</h1>
        <p style="padding-bottom:20px;">広告を表示可能な場所については以下のようになります。</p>
        <h2 class="bdrbotdot">1) PCサイト公開ページ（アルバム、動画、ファイルを公開した場合の閲覧ページ）</h2>
        <div class="padArea">
            <div><img src="/contents/admin/img/img_ad_help01.jpg" alt="PCサイト公開ページ" /></div>
            <br class="clear" />
        </div>
        <br />
        <h2 class="bdrbotdot">2) PCサイト ログアウトページ/セッションタイムアウトページ</h2>
        <div class="padArea">
            <div><img src="/contents/admin/img/img_ad_help02.jpg" alt="PCサイト ログアウトページ/セッションタイムアウトページ" /></div>
            <br class="clear" />
        </div>
        <br />
        <div class="txtCenter">
            <input type="button" class="btnovr" onclick="window.close();" value="閉じる" />
        </div>
    </div>
    <div id="foot">
        <div id="footCopy">Copyright(c) 2011 TOKAI Communications Corporation All rights reserved. </div>
    </div>
</body>
</html>
