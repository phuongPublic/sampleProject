<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript">
            $(function(){
                $('input.btnovr').hover(function() {
                    $(this).addClass('btnovrOn');
                },
                function() {
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
                            <h3 class="contentsttl floL">写真を削除する</h3>
                            <?php if ($helpLinkUrl['PictureDelete']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['PictureDelete'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <?php if(isset($message)): ?><span class="txtRed"><?= $message ?></span>
                                <?php endif; ?>
                                <h3>以下の写真を削除します。</h3>
                                <div class="space_5">内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。
                                    <br /> 削除を中止する場合は[ 戻る ]ボタンをクリックしてください。
                                </div>
                            </div>
                            <form id="form" name="form1" method="post" action="/album/picture/delete.html?<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblPicList">
                                    <tr>
                                        <th>写真</th>
                                        <th>名前</th>
                                        <th>登録日</th>
                                        <th>容量</th>
                                        <th>アルバム</th>
                                        <th>公開状態</th>
                                    </tr>
                                    <?php foreach ($data as $index => $pic) : ?>
                                    <tr>
                                        <td style="text-align:center;">
                                            <img src="/album/picture/picture.html?pid=<?= $pic['pic_id'] ?>&type=1&<?= $cashe ?>" />
                                        </td>
                                        <td>
                                            <div style="word-wrap: break-word; width: 180px;"><?= h($pic['name']) ?></div>
                                        </td>
                                        <td>
                                            <?= $pic['up_date']->i18nFormat('YYYY-MM-dd') ?>
                                        </td>
                                        <td>
                                            <?= $this->Common->modifierKbyte($pic['amount']) ?>
                                        </td>
                                        <td>
                                            <div style="word-wrap: break-word; width: 140px;"><?= h($albumData[$index]['album_name']) ?></div>
                                        </td>
                                        <td>
                                            <?php if ($statusData[$index] == 1) : ?>
                                            公開中
                                            <?php else : ?>
                                            非公開
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="del[]" value="<?= $pic['pic_id'] ?>">
                                    <?php endforeach; ?>
                                </table>
                                <p align="center"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
                                <p align="center" class="space_4">写真を削除しますがよろしいですか？</p>
                                <p align="center">
                                    <input type="hidden" name="aid" value="<?= $aid ?>">
                                    <input id="submitForm" name="commit" type="submit" class="btnovr" value="削除する" onclick="blockSubmit();"/>
                                    <input name="return" type="button" class="btnovr" value="戻る"
                                           onclick="location.href='<?php echo $previousUrl;?>'" />
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