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
        <script type="text/javascript" src="/contents/js/jquery.blockUI.js"></script>
<script>

        $(document).ready(function() {
                var folderName = "<?= $folderName ?>";
                $("#ffid").change(function () {
                        if($("select option:selected").val() == "all"){
                                $("#currentTarget").text(folderName);
                        }else{
                           $("#currentTarget").text($("select option:selected").text());
                        }
                }).change();


                $("[name*=delete_open]","#table").submit(function() {

                        var ensure = confirm("公開を終了しますがよろしいですか？");
                        if (ensure == true) { 
                                return true;
                        } else { 
                                return false;
                        } 
                        return false;
                });

        });

</script>
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
    $(function(){
            var $targetElement = '.forceBreak';
            if(checkMsie()) {
                    $($targetElement).css('word-break', 'break-all');
                    } else {
                     $($targetElement).each(function(){
                    if(navigator.userAgent.indexOf('Firefox/2') != -1) {
                            $(this).html($(this).text().split('').join('<wbr />'));
                    } else {
                            $(this).html($(this).text().split('').join(String.fromCharCode(8203)));
                    }
            });
    }});
    });
</script>
<style type="text/css"><!-- 
.tblPicList{font-size:13px;}
li.sendlist_top,li.sendlist{word-break:break-all;}
li.forceBreak{ margin-bottom: 2px;}
span.txt_download{
        display: block;
        margin-bottom: 2px;
}
 --></style>
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
                        <h3 class="contentsttl floL">公開状況を確認する</h3>
                        <?php if ($helpLinkUrl['FileOpenStatus']) : ?>
                            <div class="searchAreaN floR">
                            <a class="iconHelp" href="<?php echo $helpLinkUrl['FileOpenStatus'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="contentsMain">
                        <div class="bdrbot padArea">
                                <h3 class="txtBold"><?php echo h($folderName) ?>の公開状態</h3>
                                <?php if ($message) : ?><span class="txtRed"><?php echo $message ?></span><?php endif; ?>
                        </div>
                        <p class="txtSmall space_4">※DL回数はダウンロードされた回数になります。<br />※送信先アドレスは、アクセスしてない人＝灰色細字、アクセスした人＝黒色太字となります。</p>
                        <div class="floR txtRight" style="width:680px;height:1.1em;">
                            <form action="?<?php echo $cashe ?>" method="GET">
                                <span>表示変更：</span>
                                    <select id="ffid" name="ffid" class="selectFile">
                                        <?php foreach ($file as $id => $name) : ?>
                                            <?php if ($id == $selectedFile) : ?>
                                                <option label="<?= $name ?>" value="<?= $id ?>" selected><?= h($name) ?></option>
                                            <?php else : ?>
                                                <option label="<?= $name ?>" value="<?= $id ?>"><?= h($name) ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="fid" value="<?php echo $fid ?>"/>
                                    <input type="submit" class="submit01 btnstd" value="表示" />
                            </form>
                        </div>
                        <div class="clear"></div>
                        <table id="table" align="center" cellpadding="0" cellspacing="0" class="tblPicList">
                            <tr>
                                <th>公開情報</th>
                                <th>ファイル</th>
                                <th>DL回数</th>
                                <th>送信先アドレス</th>
                                <th style="width:80px;">機能</th>
                            </tr>
                            <?php if ($openData) : ?>
                                <?php foreach ($openData as $key => $item) : ?>
                                    <form name="delete_open" action="?<?php echo $cashe ?>" method="POST">
                                        <tr class="<?php if ($key %2==0) : ?>
                                                        even
                                                    <?php else : ?>
                                                        odd
                                                    <?php endif; ?>">
                                            <td class="Stutas">
                                                １週間 <br />
                                                （<?= $item['reg_date']->i18nFormat('YYYY/MM/dd') ?>～<?= $item['close_date']->i18nFormat('YYYY/MM/dd') ?>）
                                            </td>
                                            <td>
                                                <ul style="list-style:none;">
                                                    <?php foreach ($item['open_info'] as $item1) : ?>
                                                        <li class="forceBreak">・<?= h($item1['name']) ?></li>
                                                        <input type="hidden" name="target_id[]" value="<?= $item1['target_id'] ?>"/>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </td>
                                                <td style="text-align:center;">
                                                    <?php foreach ($item['open_info'] as $item1) : ?>
                                                        <span class="txt_download"><?= $item1['download_count'] ?></span>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td>
                                                    <ul style="list-style:none;">
                                                        <?php foreach ($item['mail_address'] as $key2 => $item2) : ?>
                                                            <li class=" <?php if ($key2 == 0) : ?>
                                                                             sendlist_top
                                                                        <?php else : ?>
                                                                             sendlist
                                                                        <?php endif; ?>">
                                                                        <?php if ($item2['login_date']=="") : ?>
                                                                            <span class="download txtGray forceBreak"><?= h($item2['mail']) ?></span>
                                                                        <?php else : ?>
                                                                            <strong class="txtBold forceBreak"><?= h($item2['mail']) ?></strong>
                                                                        <?php endif; ?></li>
                                                            <input type="hidden" name="target_user_seq[]" value="<?= $item2['target_user_seq'] ?>"/>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </td>
                                                <td style="padding-left:10px;width:70px;">
                                                    &nbsp;<input type="button" name="preview" class="btnstd txtSmall" value="プレビュー" onclick="window.open('/open/login.html?id=<?= $item['open_id'] ?>&seq=<?= $item['user_seq'] ?>');" />
                                                    <input type="hidden" name="open_id" value="<?= $item['open_id'] ?>">
                                                    <input type="hidden" name="fid" value="<?= $fid ?>">
                                                    <input type="hidden" name="ffid" value="<?= $selectedFile ?>">
                                                    <input type="submit" name="delete" class="submit01 btnstd txtSmall" value="終了する" />
                                                </td>
                                        </tr>
                                    </form>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" style="padding:10px 0 30px 20px;"><p class="txtGray">公開情報がありません。</p></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                            <!--ページング処理-->
                        <div id="PageList" class="floR">
                        <?php if (isset($pagedata['back']) && $pagedata['back'] !="") : ?>
                                <a href="/storage/file/open/status.html?fid=<?php echo $fid ?>&ffid=<?php echo $ffid ?>&page=<?php echo $pagedata['back'] ?>&<?php echo $cashe ?>">&lt;&lt; 前のページ</a>&nbsp;
                        <?php endif; ?>
                        <?php foreach ($pagedata['link_num'] as $list) : ?>
                            <?php if ($pagedata['page'] == $list) : ?><span class="now-page" ><?php echo $list ?></span><?php else : ?><span><a href="/storage/file/open/status.html?fid=<?php echo $fid ?>&ffid=<?php echo $ffid ?>&page=<?php echo $list ?>&<?php echo $cashe ?>"><?php echo $list ?></a></span><?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (isset($pagedata['next']) && $pagedata['next']!="") : ?>
                                <a href="/storage/file/open/status.html?fid=<?php echo $fid ?>&ffid=<?php echo $ffid ?>&page=<?php echo $pagedata['next'] ?>&<?php echo $cashe ?>">&nbsp;次のページ &gt;&gt;</a>
                        <?php endif; ?>
                        </div>
                        <p align="center" style="margin-bottom:20px;">
                                <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href='<?= $previousUrl ?>'"/>
                        </p>
                        <br class="clear" />
                    </div>
                </div>
                </div>                
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>

        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>


