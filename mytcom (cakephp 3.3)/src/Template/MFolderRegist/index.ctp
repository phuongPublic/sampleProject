<!DOCTYPE html>
<html>
    <head>
<?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />

        <script type="text/javascript">
            $(function () {
                $('input.btnovr').hover(function () {
                    $(this).addClass('btnovrOn');
                },
                        function () {
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
                        movie_folder_name: {
                            required: true,
                            maxlength: 25,
                            nospaces: true
                        },
                        movie_folder_comment: {
                            required: false,
                            maxlengthNonewline: 1000,
                            maxlength: false
                        }
                    },
                    messages: {
                        movie_folder_name: {
                            required: "フォルダ名が入力されていません｡",
                            maxlength: "フォルダ名には{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        movie_folder_comment: {
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
        <style>
            .space_3 {
                padding-bottom: 10px !important;
            }
        </style>
    </head>
    <body>

        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconMovie"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">動画フォルダを追加する</h3>
                            <?php if ($helpLinkUrl['MFolderRegist']) : ?>
                            <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['MFolderRegist'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <h3>動画フォルダを追加します。</h3>
                                <div class="space_5">必要事項を入力し、[追加する]ボタンをクリックしてください。</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="/movie/regist.html?<?php echo $cashe; ?>">
                                <div class="space_3">
                                    <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                        <tr>
                                            <th>動画フォルダ名<span class="txtRed">*</span></th>
                                            <td>
                                                <div class="space_5">
                                                <?php if (isset($errors['movie_folder_name'])) : ?>
                                                    <?php foreach ($errors['movie_folder_name'] as $err) : ?>
                                                    <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?> 
                                                </div>
                                                <?php if (isset($movieFolderName)) : ?>
                                                <input id="movie_folder_name" name="movie_folder_name" type="text" size="60" value="<?php echo h($movieFolderName); ?>" class="inputName" maxlength="25" />
                                                <?php else : ?>
                                                <input id="movie_folder_name" name="movie_folder_name" type="text" size="60" value="" class="inputName" maxlength="25" />
                                                <?php endif; ?>
                                                <p class="txtSmall tblReadTxt">※25文字以内</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>コメント</th>
                                            <td>
                                                <div class="space_5">
                                                    <?php if (isset($errors['movie_folder_comment'])) : ?>
                                                        <?php foreach ($errors['movie_folder_comment'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?> 
                                                </div>
                                                <?php if (isset($movieFolderComment)) : ?>
                                                    <textarea id="movie_folder_comment" name="movie_folder_comment" rows="4" cols="45" class="inputComment" ><?php echo h($movieFolderComment); ?></textarea>
                                                <?php else : ?>
                                                    <textarea id="movie_folder_comment" name="movie_folder_comment" rows="4" cols="45" class="inputComment" ></textarea>
                                                <?php endif; ?>
                                                <p class="txtSmall tblReadTxt">※1000文字以内
                                                    <br /> ※改行は無効となります。
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <p align="center" id="btnDiv" style="padding-top: 0px;">
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
