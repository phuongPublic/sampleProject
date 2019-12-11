<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
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
                <div id="messageArea"><h1 class="iconFiles"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">フォルダを削除する</h3>
                            <?php if ($helpLinkUrl['FolderDelete']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['FolderDelete'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot">
                            <p class="space_3">以下のフォルダを削除します。<br />
                            内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。<br />
                            削除を中止する場合は[ 戻る ]ボタンをクリックしてください。</p>
                            </div>
                            <div class="space_3"></div>
                            <form name="form1" method="POST" action="/storage/folder/delete.html?<?= $cashe ?>">
                                <table cellpadding="0" cellspacing="0" class="tblfFlis">
                                    <tr>
                                        <th nowrap="nowrap">フォルダ名</th>
                                        <th nowrap="nowrap">ファイル</th>
                                        <th nowrap="nowrap">容量</th>
                                        <th>コメント</th>
                                        <th nowrap="nowrap">公開状態</th>
                                    </tr>
                                    <?php foreach ($folderList as $list) : ?>
                                    <tr>
                                        <td>
                                        <div style="word-wrap: break-word; width: 200px;">
                                        <h3 <?php if ($list['file_folder_id'] == "0001") : ?> 
                                        class="iconFolderRed"<?php else : ?>
                                        class="iconFolder"<?php endif; ?> ><?= h($list['file_folder_name']) ?></h3></div></td>
                                        <td><?= $list['count'] ?></td>
                                        <td>
                                            <?php echo $this->Common->modifierByte($list['amount']) ?>
                                        </td>
                                        <td><div style="word-wrap: break-word; width: 150px;"><?= h($list['comment']) ?></div></td>
                                        <td>
                                            <?php if ($list['openstatus'] == 0) : ?>
                                                非公開
                                            <?php else : ?>
                                                公開中
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <input type="hidden" name="del[]" value=""/>
                                </table>
                                <p align="center" class="space_4"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
                                <p align="center" class="txtRed space_3">フォルダとフォルダに含まれる全てのデータが<br />削除されますがよろしいですか？</p>
                                <div align="center">
                                    <?php if ($flag == 1) : ?>
                                        <p align="center" class="space_3 txtRed">初期フォルダは削除できません。</p>
                                    <?php else : ?>
                                        <input name="commit" type="submit" class="btnovr" value="削除する" />
                                    <?php endif; ?>
                                    <input name="Submit" type="button" class="btnovr" value="戻る"  onclick="location.href = '<?= $previousUrl ?>'"/>
                                </div>
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


