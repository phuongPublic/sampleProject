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
        <script type="text/javascript"> 
                $(function(){
                        $('input.btnovr').hover(
                                function() {$(this).addClass('btnovrOn'); },
                                function() {$(this).removeClass('btnovrOn');}
                        );
                });
                $(function(){
                        $('input.btnstd').click(function(){});
                        $('input.btnstd').hover(
                                function() {$(this).addClass('btnstdOn');}, 
                                function() {$(this).removeClass('btnstdOn')}
                        );
                        $('input.btnovr').click(function(){});
                });
                
                function blockSubmit(param) {
                        if(param.id == "subCommit") {
                            document.form1.open_commit.value = 1;
                        } else {
                            document.form1.back_confirm.value = 1;
                        }
                        document.getElementById("subCommit").disabled = true;
                        document.getElementById("subBack").disabled = true;
                        document.form1.submit();

                }
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
                            <h3 class="contentsttl floL">アルバムを公開する</h3>
                            <div class="searchAreaN floR"><a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumOpenRegist']; ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea" style="padding-bottom: 15px;">
                                <h3 class="txtBold">内容の確認</h3>
                                入力内容を確認の上、問題がなければ[ 送信する ]ボタンをクリックしてください。<br />
                                内容を修正する場合は[ 戻る ]ボタンをクリックしてください。
                            </div>
                            <form id="form" name="form1" method="post" action="regist.html?return=1&<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>公開する写真</th>
                                        <?php if ($openflg == "1") : ?>
                                            <td><?= $this->Common->mbwordwrap(h($openAlbumName['album_name']), 60); ?> 一式</td>
                                        <?php else : ?>
                                        <td>
                                            <ul class="liststyleC">
                                                <?php foreach (array_reverse($aOpenRegInput['picName']) as $key => $pic) : ?>
                                                <div class="forceBreak" style="word-wrap: break-word; width:480px;">
                                                ・<?= h($pic) ?></br></div>
                                                    <input type="hidden" name="pic_open[]" value="<?= $picOpenId[$key] ?>">
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                </table>
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>ニックネーム</th>
                                        <td>
                                            <?php if (isset($aOpenRegInput['nickname'])) : ?>
                                                <?= h($aOpenRegInput['nickname']) ?>
                                            <?php endif; ?>
                                            <input type="hidden" name="nickname" value="<?= $aOpenRegInput['nickname'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>あなたのアドレス</th>
                                        <td>
                                            <?= h($userAddress) ?>
                                            <input type="hidden" name="userAddress" value="<?= $userAddress ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>公開期間</th>
                                        <td>～<?= $endOpen ?>
                                            <input type="hidden" name="close_date" value="<?= $aOpenRegInput['close_date'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>メッセージ</th>
                                        <td><?= $this->Common->mbwordwrap(h($aOpenRegInput['message']), 40) ?><textarea name="message"  style="display:none"><?= h($aOpenRegInput['message']) ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <th>送信先</th>
                                        <td>
                                            <?php foreach ($aOpenRegInput['mail'] as $list) : ?>
                                            <?= h($list) ?></br>
                                            <input type="hidden" name="mail[]" value="<?= $list ?>">
                                            <?php endforeach; ?>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>アクセス確認</th>
                                        <td>
                                            <?php if ($aOpenRegInput['access_check'] == "1") : ?>
                                                アクセス確認メールを受け取る
                                            <?php else : ?>
                                                アクセス確認メールを受け取らない
                                            <?php endif; ?>
                                            <input type="hidden" name="access_check" value="<?= $aOpenRegInput['access_check'] ?>">
                                        </td>
                                    </tr>
                                </table>
                                <p align="center" style="margin-bottom:20px;">
                                    <input type="hidden" name="target_id" value="">
                                    <input type="hidden" name="open_type" value="1">
                                    <input type="button" id="subCommit" class="btnovr" value="送信する" onclick="blockSubmit(this);" />
                                    <input type="button" id="subBack" class="btnovr" value="戻る" onclick="blockSubmit(this);" />
                                </p>
                                <input type="hidden" name="open_flg" value="<?= $openflg ?>">
                                <input type="hidden" name="album_id" value="<?= $aid ?>">
                                <input type="hidden" name="open_commit" >
                                <input type="hidden" name="back_confirm" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
    </html>