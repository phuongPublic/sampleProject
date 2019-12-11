<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            $(function(){
                $('input.btnovr').hover(function() {
                    $(this).addClass('btnovrOn');
                },
                function() {
                    $(this).removeClass('btnovrOn');
                });
            });
            $(function(){
                $('input.btnLong').hover(function() {
                    $(this).addClass('btnlongOn');
                },
                function() {
                    $(this).removeClass('btnlongOn');
                });
            });
            $(function(){
                $('input.btnstd').hover(function() {
                    $(this).addClass('btnstdOn');
                },
                function() {
                    $(this).removeClass('btnstdOn');
                });
            });

            // validate
            $(document).ready(function() {
                jQuery.validator.addMethod("checkCsv", function(value, element) {
                    var pattern = /.+(\.csv)$/;
                    return this.optional(element) || pattern.test(value);
                });

                $("#form").validate({
                    onfocusout: false,
                    onkeyup: false,
                    onsubmit: function (element) {
                        this.element(element);
                    },
                    rules: {
                        file: {
                            required: true,
                            checkCsv: true
                        }
                    },
                    messages: {
                        file: {
                            required: "ファイルを選択してください。",
                            checkCsv: "ファイルフォーマット形式に誤りがあります。CSV形式のファイルを指定してください。"
                        }
                    },
                    errorPlacement: function (error) {
                        $('.msg_error').html('');
                        $('.srv_msg').html('');
                        if (error) {
                            error.appendTo($('.msg_error'));
                        }
                    },
                    success: function () {
                        $('.srv_msg').html('');
                        $('.msg_error').html('');
                    }
                });
            });
        </script>
        <style type="text/css">
            .tblForm th { text-align: left; font-weight: normal }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconAddress"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <div id="contentsLeft">
                    <div class="sideBox">
                        <div class="sideTopGray">
                            <h2>メニュー</h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?<?= $cashe ?>">アドレスを登録</a></li>
                                <li class="bdr"><a href="/address/group/regist.html?<?= $cashe ?>">グループを追加</a></li>
                                <li class="bdr"><a href="/address/import.html?<?= $cashe ?>">インポート</a></li> 
                                <li><a href="/address/listview.html?<?= $cashe ?>">アドレス帳を見る</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h2 class="contentsttl floL">アドレス帳をインポートする</h2>
                                <?php if (isset($helpLinkUrl['AddressImport'])) : ?>
                                    <div class="searchAreaN floR">
                                        <a class="iconHelp" href="<?php echo $helpLinkUrl['AddressImport'] ?>" target="_blank">この機能のヘルプ</a>
                                    </div>
                                <?php endif;?> 
                        </div>
                        <div class="contentsMain">
                            <div class="padArea bdrbot">
                                <?php if (isset($message)) : ?>
                                    <div class="txtRed txtBold space_5 srv_msg">
                                        <?= $message ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <span class="msg_error txtRed txtBold"></span>
                                    アドレス帳を、CSV形式のテキストファイルからインポートすることができます。<br/>
                                    アップロードするファイルを選択し、[登録する]ボタンをクリックしてください。
                                </div>
                            </div>
                            <p><span class="txtSmall">
                               ※同じアドレスが登録されている場合でも、上書きせずにすべて新規に追加します。<br />
                               ※登録できるアドレス数は<?= h($addressQuota) ?>件までとなります。また一度にインポートできるアドレス数は<?= h($limitImport) ?>件までとなります。<br/>
                               ※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</span></p>
                                <form id="form" method="post" enctype="multipart/form-data" action="?<?= $cashe ?>">
                                    <table class="tblForm">
                                        <tbody>
                                            <tr>
                                                <th>ファイル<span class="txtRed">*</span></th>
                                                <td>
                                                    <input type="file" name="file" size="40" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p align="center" class="txtCenter">
                                        <input type="submit" class="btnovr" name="submit_import" value="登録する" />
                                        <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl; ?>'" />
                                    </p>
                                </form>
                        </div><!---contentsMain--->
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?= $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>
