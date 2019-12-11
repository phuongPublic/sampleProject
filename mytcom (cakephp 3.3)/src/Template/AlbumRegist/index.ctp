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
                <div id="messageArea">
                    <h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">アルバムを追加する</h3>
                            <?php if ($helpLinkUrl['AlbumRegist']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumRegist'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot">
                                <p class="space_3">アルバムを追加します。
                                    <br /> 必要事項を入力し、[追加する]ボタンをクリックしてください。
                                </p>
                            </div>
                            <p class="txtSmall">※<span style="color : red">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="/album/regist.html?<?php echo $cashe; ?>" onsubmit="return false;">
                                <div class="space_3">
                                    <table align="center" cellpadding="0" cellspacing="0" class="tblForm" style="width:620px;">
                                        <tr>
                                            <th class="short">アルバム名<span style="color : red">*</span></th>
                                            <td>
                                                <div class="space_5">
                                                    <?php if (isset($errors['album_name'])) : ?>
                                                        <?php foreach ($errors['album_name'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?> 
                                                </div>
                                                <?php if (isset($albumName)) : ?>
                                                    <input id="album_name" name="album_name" type="text" size="60" value="<?php echo h($albumName); ?>" class="inputName" maxlength="25" />
                                                <?php else : ?>
                                                    <input id="album_name" name="album_name" type="text" size="60" value="" class="inputName" maxlength="25" />
                                                <?php endif; ?>
                                                <p class="txtSmall tblReadTxt">※25文字以内</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="short">コメント</th>
                                            <td>
                                                <div class="space_5">
                                                    <?php if (isset($errors['album_comment'])) : ?>
                                                        <?php foreach ($errors['album_comment'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?> 
                                                </div>
                                                <?php if (isset($albumComment)) : ?>
                                                    <textarea id="album_comment" name="album_comment" rows="4" cols="45" class="inputComment"><?php echo h($albumComment); ?></textarea>
                                                <?php else : ?>
                                                    <textarea id="album_comment" name="album_comment" rows="4" cols="45" class="inputComment"></textarea>
                                                <?php endif; ?>
                                                <p class="txtSmall tblReadTxt" style="margin-top: -1px;">※1000文字以内
                                                    <br /> ※改行は無効となります。
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <p align="center" class="space_2">
                                    <input type="submit" id="tongleSubmit" class="btnovr" value="追加する"/>
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