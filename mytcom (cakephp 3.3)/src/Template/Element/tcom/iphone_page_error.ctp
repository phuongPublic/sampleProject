<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>システムエラー</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="content-style-type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <meta name="apple-mobile-web-app-capable" content="no">
        <script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
        <link type="text/css" rel="stylesheet" href="/contents/iphone/tcom/iui/iui.css" />
        <link type="text/css" rel="stylesheet" href="/contents/iphone/tcom/css/common.css" />
        <script type="text/javascript">
            $(document).ready(function ()
            {
                $.ajax({
                    url: "#",
                    method: "POST",
                    data: {},
                    dataType: 'jsonp',
                    success: function ()
                    {
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="toolbar">
            <h1 id="pageTitle">エラー</h1>
        </div>
        <ul id="logout" title="エラー" class="panel" selected="true">
            <li class="logoutBox">
                <p class="Centering" style="margin-top: -15px;">ウェブページを表示する事ができません。</p><br>
                <p class="Centering" style="margin-bottom: -15px;">恐れ入りますが、しばらく待ってから<br />再度アクセス頂きますようお願いいたします。</p>
            </li>
            <div class="button3"><a class="grayButton" type="button" href="/iphone/login.html" target="_self">ログインページへ</a></div>
            <div id="footer">
                <ul id="footerMenu">
            <?php $siteSetting = $this->Common->getSiteSetting(); ?>
                    <li><a href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?= $siteSetting['InfoPolicyName'] ?></a></li>
                    <br />
                    <li><a href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?= $siteSetting['PolicyName'] ?></a></li>
                </ul>
                <div id="switchView">
                    <a href="/login.html" target="_blank"><img src="/contents/iphone/tcom/images/icon_pc.png" />パソコン版で表示する</a>
                </div>
                <div id="footerBottom">
                    <div id="logo"><img src="/contents/iphone/tcom/images/logo.png"></div>
                    <address>(c) TOKAI Communications Corporation All rights reserved.</address>
                </div>
            </div>
        </ul>
        <noscript>
        当サイトはJavaScriptをオンにしてご利用ください。
        </noscript>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
    </body>
</html>
