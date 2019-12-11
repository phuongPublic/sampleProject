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
                        file_folder_name: {
                            required: true,
                            maxlength: 25,
                            nospaces: true
                        },
                        comment: {
                            required: false,
                            maxlengthNonewline: 1000,
                            maxlength: false
                        }
                    },
                    messages: {
                        file_folder_name: {
                            required: "フォルダ名が入力されていません。",
                            maxlength: "フォルダ名には{0}文字以内で入力してください。",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        comment: {
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
        <style>
            #foot{
                margin-top: 7px;
            }
        </style>
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
                                <h3 class="contentsttl floL">フォルダを編集する</h3>
                                <?php if ($helpLinkUrl['FolderEdit']) : ?>
                                    <div class="searchAreaN floR">
                                        <a class="iconHelp" href="<?php echo $helpLinkUrl['FolderEdit'] ?>" target="_blank">この機能のヘルプ</a>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div class="contentsMain">
                                <?php if (isset($message) && $message) : ?><span class="txtRed"><?php echo $message; ?></span>
                                <?php endif; ?>
                                <div class="bdrbot">
                                <p class="space_3">フォルダを編集します。<br />
                                    必要事項を入力し、[更新する]ボタンをクリックしてください。</p>
                                </div>
                                <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                                <form id="form" name="form1" class="submitForm" method="post" action="/storage/folder/edit.html?<?= $cashe ?>">
                                    <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                        <tr>
                                            <th>フォルダ名<span class="txtRed">*</span></th>
                                            <td>
                                                <div class="space_5">
                                                    <?php if (isset($errors) && isset($errors['file_folder_name'])) {?>
                                                        <div class="error">
                                                            <?= h(implode($errors['file_folder_name'], '<br/>')) ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <input type="text" style="margin-top: -5px;" name="file_folder_name" value="<?php echo isset($folderInfo[0]) ? $folderInfo[0]['file_folder_name'] : ''; ?>" size="40" class="inputName" maxlength="25"/>
                                                <p class="txtSmall tblReadTxt">※25文字以内</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>コメント</th>
                                            <td>
                                                <div class="space_5">
                                                    <?php if (isset($errors) && isset($errors['comment'])) {?>
                                                        <div class="error">
                                                        <?= h(implode($errors['comment'], '<br/>')) ?></div>
                                                    <?php } ?>
                                                </div>
                                                <textarea name="comment" rows="4" cols="45" style="margin-top: -5px;" class="inputComment"><?php echo isset($folderInfo[0]) ? h($folderInfo[0]['comment']) : '';?></textarea>
                                                <p class="txtSmall tblReadTxt">※1000文字以内<br />
                                                 ※改行は無効となります。</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <p align="center">
                                        <input type="submit" class="btnovr" value="更新する"/>
                                        <input name="Submit" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
                                    </p>
                                    <?php if (!empty($fid)) : ?>
                                        <input type="hidden" name="file_folder_id" value="<?= $fid ?>"/>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <div id="goTop" style="padding-top: 8px;"><a href="#top">▲ページトップへ</a></div>
            </div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>


