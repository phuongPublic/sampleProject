<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>        
        <script type="text/javascript">
            $(function ()
            {
                $('input.btnovr').hover(function ()
                {
                    $(this).addClass('btnovrOn');
                },
                        function ()
                        {
                            $(this).removeClass('btnovrOn');
                        });
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">アルバムを削除する</h3>
                            <?php if ($helpLinkUrl['AlbumDelete']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumDelete'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                            <?php if (isset($message)) : ?><span class="txtRed"><?= $message; ?></span>
                            <?php endif; ?>
                                <h3>以下のアルバムを削除します。</h3>
                                <div class="space_5">内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。
                                    <br /> 削除を中止する場合は[ 戻る ]ボタンをクリックしてください。</div>
                            </div>
                            <form id="form" name="form1" method="post" action="/album/delete.html?<?= $cashe; ?>">
                            <?php if (!empty($currentAlbum)) : ?>
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>アルバム名</th>
                                        <td>
                                        <?php echo h($currentAlbum['album_name']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>コメント</th>
                                        <td>
                                            <div style="word-wrap: break-word; width: 500px;">
                                                <?php echo h($currentAlbum['album_comment']); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>容量</th>
                                    <?php if (isset($amount)) : ?>
                                        <td>
                                        <?= $this->Common->modifierByte($amount) ?>
                                        </td>
                                    <?php endif; ?>
                                    </tr>
                                </table>
                                <input type="hidden" name="aid" value="<?= $currentAlbum['album_id'] ?>">
                            <?php endif; ?>
                                <p align="center"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
                                <p align="center" class="txtRed space_4">このアルバムとアルバムに含まれる全てのデータが
                                    <br /> 削除されますがよろしいですか？
                                </p>
                                <p align="center">
                                    <input name="commit" id="submitForm" type="submit" class="btnovr" value="削除する" onclick="blockSubmit();"/>
                                    <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
        <script>
            function blockSubmit() {
                document.getElementById("submitForm").disabled = true;
                document.form1.submit();
            }
        </script>
    </body>
</html>
