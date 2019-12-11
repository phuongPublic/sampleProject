<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>

        <script language="JavaScript" type="text/javascript">
            function ChangeVisible(id, id2) {
                document.getElementById(id).style.visibility = "visible";
                document.getElementById(id).style.display = "inline";
                document.getElementById(id2).src = "/images/mark_arrow01_under.gif";

            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('input.textArea01').focus(function () {
                    $(this).css('background-image', 'none');
                });
            });
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
            $(document).ready(function () {
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
                        movie_contents_comment: {
                            required: false,
                            maxlengthNonewline: 1000
                        }
                    },
                    messages: {
                        name: {
                            required: "動画のタイトルが入力されていません｡",
                            maxlength: "動画のタイトルには{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        movie_contents_comment: {
                            maxlengthNonewline: "動画のコメントには{0}文字以内で入力してください。"
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.appendTo(element.prev());
                        $("#tongleSubmit").removeAttr('disabled');
                    }
                });
            });
        </script>  
        <!--{include file=$CssListPath}-->
        <link rel="alternate stylesheet" type="text/css" href="/css/font_small.css" title="fontS" media="screen,tv,print" />
        <link rel="alternate stylesheet" type="text/css" href="/css/font_large.css" title="fontL" media="screen,tv,print" />
        <script type="text/javascript" src="/js/styleswitcher.js"></script>
        <script src="/js/jquery.cookie.js" type="text/javascript"></script>
    </head>
    <body class="yui-skin-sam">
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
                            <h3 class="contentsttl floL">動画の情報を編集する</h3>
                            <?php if ($helpLinkUrl['MovieEdit']) : ?>
                            <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['MovieEdit'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <?php if (isset($message)) : ?>
                                <span class="txtRed"><?= $message ?></span>
                                <?php endif; ?>
                                <h3>動画の情報および基本設定を編集します。</h3>
                                <div class="space_5">必要事項を入力し、[更新する]ボタンをクリックしてください。</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="/movie/contents/edit.html?<?= $cashe ?>" enctype="multipart/form-data">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>動画タイトル<span class="txtRed">*</span></th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['name'])) : ?>
                                                    <?php foreach ($errors['name'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <input name="name" type="text" size="25" value="<?= h($currentMovie['name']) ?>" class="inputName" maxlength="125" />
                                            <p class="tblReadTxt txtSmall">※125文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>コメント</th>
                                        <td>
                                            <div class="space_5">
                                                <?php if (isset($errors['movie_contents_comment'])) : ?>
                                                    <?php foreach ($errors['movie_contents_comment'] as $err) : ?>
                                                        <div class="error"><?php echo $err; ?></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>                                            
                                            </div>
                                            <textarea name="movie_contents_comment" rows="4" cols="45" class="inputComment"  ><?= h($currentMovie['movie_contents_comment']) ?></textarea>
                                            <p class="tblReadTxt txtSmall">※1000文字以内<br />
                                                ※改行は無効となります。</p>
                                        </td>
                                    </tr>
                                </table>
                                <p align="center">
                                    <input type="hidden" name="extension" value="<?= $currentMovie['extension'] ?>">
                                    <input type="hidden" name="movie_contents_id" value="<?= $movie_contents_id ?>">
                                    <input name="edit" id="tongleSubmit" type="submit" class="btnovr"  value="更新する" />
                                    <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
                                </p>
                            <!--{form_input name="user_seq"}-->
                            <!--{uniqid}-->
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
