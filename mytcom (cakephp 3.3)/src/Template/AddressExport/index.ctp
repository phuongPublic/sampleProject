<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>

        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            $(function () {
                $('input.btnovr').hover(function () {
                    $(this).addClass('btnovrOn');
                },
                        function () {
                            $(this).removeClass('btnovrOn');
                        });
            });
            $(function () {
                $('input.btnLong').hover(function () {
                    $(this).addClass('btnlongOn');
                },
                        function () {
                            $(this).removeClass('btnlongOn');
                        });
            });
            $(function () {
                $('input.btnstd').hover(function () {
                    $(this).addClass('btnstdOn');
                },
                        function () {
                            $(this).removeClass('btnstdOn');
                        });
            });
        </script>
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
                            <h2 class="contentsttl floL">アドレス帳をエクスポートする</h2>
                            <?php if (isset($helpLinkUrl['AddressExport'])) : ?>
                                <div class="searchAreaN floR">
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['AddressExport'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?> 
                        </div>
                        <div class="contentsMain">
                            <div class="padArea bdrbot">
                                <div class="space_5">
                                    アドレス帳のデータをファイルとして出力することができます。<br />
                                    エクスポートしたいファイル形式を選択して、[ダウンロード]ボタンをクリックしてください。
                                </div>
                                <?php if (isset($message)) : ?>
                                    <p class="txtRed"><?= h($message)?></p>
                                <?php endif; ?>
                            </div>
                            <form method="post" action="?<?= $cashe ?>">
                                <table class="tblForm">
                                    <tbody>
                                        <tr>
                                            <th rowspan="3" style="width:26%">ファイルタイプの選択</th>
                                            <td style="width:15px;" class="nopad"><input type="radio" name="type" value="1" class="nobdr" /></td>
                                            <td style="width:480px;" class="nopad"><div class="p10tb">CSV形式&nbsp;(文字コード：SJIS)<br /><span class="txtRed">※Outlook系をご利用の方はこちらを使用してください。</span></div></td>
                                        </tr>
                                        <tr>
                                            <td class="nopad"><input checked="checked" type="radio" name="type" value="2" class="nobdr"></td>
                                            <td><div class="p10tb">CSV形式&nbsp;(文字コード：UTF-8)<br /><span class="txtRed">※Windows Live Mail系をご利用の方はこちらを使用してください。</span></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p align="center" class="txtCneter">
                                    <input type="submit" class="btnovr" name="download_export" value="ダウンロード" id="export" />
                                    <input type="submit" class="btnovr"  name="cancel_export" value="戻る" />
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
