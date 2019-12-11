<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>TNCポケット</title>
        <script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/contents/js/yui/fonts/fonts-min.css" />
        <script type="text/javascript" src="/contents/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="/contents/js/styleswitcher.js"></script>
        <link type="text/css" id="green" rel="stylesheet" href="/contents/css/tnc/open_common.css" />
        <![if !(lte IE 6)]>
        <link type="text/css" id="blue" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/open_common_blue.css" />
        <link type="text/css" id="pink" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/open_common_pink.css" />
        <link type="text/css" id="gray" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/open_common_gray.css" />
        <link type="text/css" id="orange" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/open_common_orange.css" />
        <link type="text/css" id="white" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/open_common_white.css" />
        <![endif]>

        <script type="text/javascript">
            var color_cookie = $.cookie('color_style');
            if (!color_cookie) {
                color_cookie = 'green';
            }
            jstyle(color_cookie);

            function jstyle(id)
            {
                $("link").each(function ()
                {
                    if ($(this).attr("id") != "") {
                        $(this).attr("disabled", true);
                        if ($(this).attr("id") == id) {
                            $(this).attr("disabled", false);
                            $.cookie('color_style', id, {expires: 30, path: '/'});
                        }
                    }
                });
            }
        </script>

    </head>
    <body>
        <div id="header">
            <div class="container">
                <div id="logo"><img src="/contents/images/tnc/logo.gif" alt="TNCポケット" /></div>
                <div id="login"><p><a href="http://www.tnc.ne.jp/" target="_blank">TNCトップ</a>｜<a href="http://www.tnc.ne.jp/support/" target="_blank">会員サポート</a>｜<a href="http://www.tnc.ne.jp/pocket/pt_05.html" target="_blank">ヘルプ</a></p></div>
                <br />
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
            <p id="foottops" class="txtCenter">
                <a href="/login.html">TNCポケット ログインページ</a>｜ <a href="http://www.tnc.ne.jp/pocket/" target="_blank">TNCポケット トップページ</a>
            </p>
            <div id="footbottoms">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td class="footLeft">TOKAIネットワーククラブ<br />
                            <img src="/contents/images/copyright.gif" alt="Copyright" /></td>
                    <?php $siteSetting = $this->Common->getSiteSetting(); ?>
                        <td class="footRight"><a class="linkG" href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?= $siteSetting['PolicyName'] ?></a>｜<a classs="linkG" href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?= $siteSetting['InfoPolicyName'] ?></a></td>
                    </tr>
                </table>
            </div>
        </div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
    </body>
</html>
