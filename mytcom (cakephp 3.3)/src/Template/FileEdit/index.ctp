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
        <script type="text/javascript">
            $(document).ready(function() {
                jQuery.validator.addMethod("maxlengthNonewline", function(value, element, param) {
                    var noNewlineString = value.replace(/\r?\n/g, '');
                    var wordcount = noNewlineString.length;
                    return this.optional(element) || wordcount <= param;
                });
                $("#form").validate({
                    onfocusout: false,
                    onkeyup: false,
                    onsubmit: true,
                    rules: {
                        name: {
                            required: true,
                            maxlength: 125,
                            nospaces: true
                        },
                        file_comment: {
                            required: false,
                            maxlengthNonewline: 1000
                        }
                    },
                    messages: {
                        name: {
                            required: "ファイル名が入力されていません。",
                            maxlength: "ファイル名には{0}文字以内で入力してください。",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        file_comment: {
                            maxlengthNonewline: "コメントには{0}文字以内で入力してください。"
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.appendTo(element.prev());
                        $("#tongleSubmit").removeAttr('disabled');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconFiles"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">ファイルを編集する</h3>
                            <?php if ($helpLinkUrl['FileEdit']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['FileEdit'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <?php if (isset($message) && $message) : ?><span class="txtRed"><?php echo $message; ?></span>
                                <?php endif; ?>
                            <div class="padArea bdrbot">
                                <h3>ファイルの情報を編集します。</h3>
                                <div class="space_5">必要事項を入力し、[更新する]ボタンをクリックしてください。</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="/storage/file/edit.html?<?php echo $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>ファイル名<span class="txtRed">*</span></th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors) && isset($errors['name'])) {?>
                                                    <div class="error">
                                                        <?= h(implode($errors['name'], '<br/>')) ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <input name="name" type="text" value="<?php echo isset($fileInfo[0]) ? $fileInfo[0]['name'] : ''; ?>" size="40" class="inputName" maxlength="125" required/><br/>
                                            <p class="txtSmall tblReadTxt">※125文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>コメント</th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors) && isset($errors['file_comment'])) {?>
                                                    <div class="error">
                                                        <?= h(implode($errors['file_comment'], '<br/>')) ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <textarea name="file_comment" rows="4" cols="45" class="inputComment"><?php echo isset($fileInfo[0]) ? h($fileInfo[0]['file_comment']) : ''; ?></textarea><br/>
                                            <p class="txtSmall tblReadTxt">※1000文字以内<br />
                                                ※改行は無効となります。</p>
                                        </td>
                                    </tr>
                                </table>
                                <p align="center">
                                    <?php if (!empty($fileInfo)) : ?>
                                    <input type="hidden" name="file_id" value="<?php echo $fileInfo[0]['file_id'] ?>"/>
                                    <input type="hidden" name="file_folder_id" value="<?php echo $fileInfo[0]['file_folder_id'] ?>"/>
                                    <input type="hidden" name="extension" value="<?php echo $fileInfo[0]['extension'] ?>">
                                    <?php else : ?>
                                    <input type="hidden" name="file_id" value=""/>
                                    <input type="hidden" name="file_folder_id" value=""/>
                                    <input type="hidden" name="extension" value="">
                                    <?php endif; ?>
                                    <input name="commit" type="hidden" class="btnovr" value="更新する" />
                                    <input type="submit" class="btnovr" value="更新する"/>
                                    <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
                                </p>
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


