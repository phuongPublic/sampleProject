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
                        pic_comment: {
                            required: false,
                            maxlengthNonewline: 1000
                        }
                    },
                    messages: {
                        name: {
                            required: "写真のタイトルが入力されていません｡",
                            maxlength: "写真のタイトルには{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        pic_comment: {
                            maxlengthNonewline: "写真のコメントには{0}文字以内で入力してください。"
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
                <div id="messageArea"><h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">写真を編集する</h3>
                            <?php if ($helpLinkUrl['PictureEdit']) : ?>
                            <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['PictureEdit'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <?php if (isset($message)) : ?>
                                <span class="txtRed"><?= $message ?></span>
                                <?php endif; ?>
                                <h3>写真を編集します。</h3>
                                <div class="space_5">必要事項を入力し、[更新する]ボタンをクリックしてください</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="/album/picture/edit.html?<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>該当写真</th>
                                        <td><img src="/album/picture/picture.html?pid=<?= $pid ?>&type=1&<?= $cashe ?>" width="100"></td>
                                    </tr>
                                    <tr>
                                        <th>タイトル<span class="txtRed">*</th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['name'])) : ?>
                                                    <?php foreach ($errors['name'] as $err) : ?>
                                                <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <input id="name" name="name" type="text" size="40" value="<?= h($currentPic['name']) ?>" class="inputName" maxlength="125" />
                                            <p class="tblReadTxt txtSmall">※125文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>コメント</th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['pic_comment'])) : ?>
                                                    <?php foreach ($errors['pic_comment'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <textarea id="pic_comment" name="pic_comment" rows="4" cols="45" class="inputComment"><?= h($currentPic['pic_comment']) ?></textarea>
                                            <p class="tblReadTxt txtSmall">※1000文字以内<br />
                                                ※改行は無効となります。</p>
                                        </td>
                                    </tr>
                                </table>
                                <p align="center">
                                    <input type="hidden" name="extension" value="<?= $currentPic['extension'] ?>">
                                    <input type="hidden" name="pic_id" value="<?= $pid ?>">
                                    <input name="edit" id="tongleSubmit" type="submit" class="btnovr"  value="更新する" />
                                    <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
                                </p>
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