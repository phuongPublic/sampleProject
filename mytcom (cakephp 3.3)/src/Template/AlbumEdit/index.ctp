<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript">
            $(function ()
            {
                $('input.btnovr').click(function ()
                {
                });
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
                        album_name: {
                            required: true,
                            maxlength: 25,
                            nospaces: true
                        },
                        album_comment: {
                            required: false,
                            maxlengthNonewline: 1000
                        }
                    },
                    messages: {
                        album_name: {
                            required: "アルバム名が入力されていません｡",
                            maxlength: "アルバム名には{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        album_comment: {
                            maxlengthNonewline: "コメントには{0}文字以内で入力してください｡"
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
                            <h3 class="contentsttl floL">アルバムを編集する</h3>
                            <?php if ($helpLinkUrl['AlbumEdit']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumEdit'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <?php if (isset($message) && $message) : ?><span class="txtRed"><?php echo $message; ?></span>
                                <?php endif; ?>
                                <h3>アルバムを編集します。</h3>
                                <div class="space_5">必要事項を入力し、[更新する]ボタンをクリックしてください。</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>

                            <form id="form" class="submitForm" name="form1" method="post" action="/album/edit.html?<?php echo $cashe; ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>アルバム名<span class="txtRed">*</span></th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['album_name'])) : ?>
                                                    <?php foreach ($errors['album_name'] as $err) : ?>
                                                <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($currentAlbum)) : ?>
                                                <input name="album_name" id="album_name" type="text" size="40" value="<?php echo h($currentAlbum['album_name']); ?>" class="inputName" maxlength="25" />
                                            <?php else : ?>
                                                <input name="album_name" id="album_name" type="text" size="40" value="" class="inputName" maxlength="25" />
                                            <?php endif; ?>
                                            <p class="tblReadTxt txtSmall">※25文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>コメント</th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['album_comment'])) : ?>
                                                    <?php foreach ($errors['album_comment'] as $err) : ?>
                                                <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (isset($currentAlbum)) : ?>
                                            <textarea name="album_comment" rows="4" cols="45" class="inputComment"><?php echo h($currentAlbum['album_comment']); ?></textarea>
                                            <?php else : ?>
                                            <textarea name="album_comment" rows="4" cols="45" class="inputComment"></textarea>
                                            <?php endif; ?>
                                            <p class="tblReadTxt txtSmall">※1000文字以内
                                                <br />※改行は無効となります。</p>
                                        </td>
                                    </tr>
                                </table>
                                <p align="center">
                                    <?php if (isset($currentAlbum)) : ?>
                                    <input type="hidden" name="aid" value="<?php echo $currentAlbum['album_id']; ?>">
                                    <?php endif; ?>
                                    <input id="tongleSubmit" name="album_edit" type="submit" class="btnovr" value="更新する"/>
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
    </body>
</html>
