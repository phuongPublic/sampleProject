<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        
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
                $('input.btnstd').hover(function() {
                    $(this).addClass('btnstdOn');
                },
                function() {
                    $(this).removeClass('btnstdOn');
                });
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconFiles"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>

               
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">ファイルを削除する</h3>
                            <?php if ($helpLinkUrl['FileDelete']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['FileDelete'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <?php if (isset($message) && $message) : ?><span class="txtRed"><?php echo $message; ?></span>
                                <?php endif; ?>
                            <div class="padArea bdrbot">
                                <h3>以下のファイルを削除します。</h3>
                                内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。<br />削除を中止する場合は[ 戻る ]ボタンをクリックしてください。
                            </div>
                            <div class="space_3"></div>
                            <form  name="form1" method="post" action="/storage/file/delete.html?<?php echo $cashe ?>">
                                <table cellpadding="0" cellspacing="0" class="tblfFlis">
                                    <tr>
                                        <th nowrap="nowrap">ファイル名</th>
                                        <th>登録日</th>
                                        <th nowrap="nowrap">容量</th>
                                        <th nowrap="nowrap">フォルダ</th>
                                        <th>コメント</th>
                                        <th nowrap="nowrap">公開状態</th>
                                    </tr>
                                    <?php foreach ($fileList as $list) : ?>
                                    <tr>
                                        <td class="txtBold">
                                            <div style="word-wrap: break-word; width: 180px;"><?= ($list['extension']!="" ? h($list['name'].".".$list['extension']) : h($list['name'])) ?></div>
                                        </td>
                                        <td><?= $list['up_date']->i18nFormat('YYYY-MM-dd') ?></td>
                                        <td>
                                            <?php echo $this->Common->modifierByte($list['amount']) ?>
                                        </td>
                                        <td>
                                            <div style="word-wrap: break-word; width: 100px;"><?= isset($list['folderName']) ? $this->Common->mbwordwrap(h($list['folderName']), 10) : '' ?></div>
                                        </td>
                                        <td>
                                            <div style="word-wrap: break-word; width: 100px;"><?= h($list['file_comment']) ?></div>
                                        </td>
                                        <td>
                                            <?php if ($list['openstatus'] == 0) : ?>
                                            非公開
                                            <?php else : ?>
                                            公開中
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                                <p align="center">ファイルを削除しますがよろしいですか？</p>
                                <p align="center" class="space_3"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
                                <p align="center" class="space_3">
                                    <input name="commit" type="submit" class="btnovr" value="削除する" />
                                    <input name="name" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'" />
                                </p>
                                <input type="hidden" name="del[]" value="" />
                                <input type="hidden" name="fid" value="<?php echo $fid ?>" />
                                <input type="hidden" name="fromsrc" value="<?php echo $fromsrc ?>" />
                            </form>
                        </div>
                    </div>
                </div>
                <div id="goTop"><a href="#top">▲ページトップへ</a></div>
            </div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>


