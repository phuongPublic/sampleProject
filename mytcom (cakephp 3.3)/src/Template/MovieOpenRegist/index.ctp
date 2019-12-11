<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script>
            function blockSubmit() {
                var isValid = $('#form').valid();
                if(isValid) {
                    document.form1.open_reg.value = 1;
                }
            }

            function chkRegEmail(str) {
                var Seiki = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                /* 入力された値がパターンにマッチするか調べる */
                if (str != "") {
                    if (str.match(Seiki)) {
                        return true;
                    } else {
                        alert("メールアドレスの形式が不正です。");
                        return false;
                    }
                } else {
                    /* 何も入力されていない場合はアラート表示 */
                    alert("メールアドレスを入力してください。");
                    return false;
                }
            }

            $(document).ready(function () {
                $('#close_date_<?= $aOpenRegInput['close_date'] ?>').attr('checked', true);
                var accessCheck = <?= $aOpenRegInput['access_check'] ?>;
                (accessCheck == "1")? $('#access_check_1').attr('checked', true):$('#access_check_1').attr('checked', false);

                $('#add_btn').click(function () {
                    if (!chkRegEmail($('#add_address').val()))
                        return;
                    if ($("#address_list > *").length >= 10) {
                        alert("追加できるアドレスは10件までです。");
                        return;
                    }
                    var newNumber = 0;
                    if ($("#address_list > *").length > 0) {
                        newNumber = $("#address_list > *").length;
                    }

                    $('#address_list').append('<div id="mailItem' + newNumber + '"><div class="mailItemL">' + $('#add_address').val() + '</div>\
                                <div class="mailItemR"><a href="javascript:deleteMailItem(' + newNumber + ')"><img src="/contents/js/jquery.uploadify-v1.6.2.mit/cancel.png" border="0" alt="閉じる" /></a></div>\
                                        <input type="hidden" id="mail[]" name="mail[]" value="' + $('#add_address').val() + '">\
                                </div>');
                });
            });

            function deleteMailItem(number) {
                $('#mailItem' + number).remove();
            }

        </script>
        <script type="text/javascript">
            $(function () {
                $('input.btnovr').hover(function () {
                    $(this).addClass('btnovrOn');
                },
                function () {
                    $(this).removeClass('btnovrOn');
                });
            });
            $(function () {
                $('input.btnstd').hover(function () {
                    $(this).addClass('btnstdOn');
                },
                function () {
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
                $('#eMailClick').click(function () {
                    if ($("#address_list > *").length == 0 && $(".mesAppend > *").length >= 1) {
                        $( "#mesMailCheck" ).remove();
                        var error = "メールアドレスを入力してください。";
                        $('.mesAppend').append( '<div id="mesMailCheck"><p class="tblReadTxt txtRed">'+error+'</p></div>' );
                        return false;
                    }
                    if ($("#address_list > *").length == 0) {
                        var error = "メールアドレスを入力してください。";
                        $('.mesAppend').append( '<div id="mesMailCheck"><p class="tblReadTxt txtRed">'+error+'</p></div>' );
                        return false;
                    } else {
                        $( "#mesMailCheck" ).remove();
                    }
                });
                $("#form").validate({
                    onfocusout: false,
                    onkeyup: false,
                    onsubmit: function (element) {
                        this.element(element);
                    },
                    rules: {
                        nickname: {
                            required: true,
                            maxlength: 25,
                            nospaces: true
                        },
                        message: {
                            required: true,
                            maxlengthNonewline: 125,
                            maxlength: false,
                            nospaces: true
                        }
                    },
                    messages: {
                        nickname: {
                            required: "ニックネームが入力されていません｡",
                            maxlength: "ニックネームを{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        message: {
                            required: "メッセージが入力されていません｡",
                            maxlengthNonewline: "メッセージには{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.appendTo(element.prev().prev());
                    }
                });
            });
        </script>
        <style>
            li span { position: relative; left: 6px; }
            .radioLabel_2 label { margin-right: 11px; }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconMovie"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">動画を公開する</h3>
                            <?php if ($helpLinkUrl['MovieOpenRegist']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['MovieOpenRegist'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <?php if (!empty($message)) : ?>
                                    <span class="txtRed">
                                        <?= $message?>
                                    </span>
                                <?php endif; ?>
                                <h3>動画の公開ページのURLを指定したメールアドレス宛に送信することができます。</h3>
                                <div class="space_5">必要事項を入力し、[確認画面へ進む]ボタンをクリックしてください。</div>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" class="submitForm" name="form1" method="post" action="regist.html?return=1&<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th class="short">公開する動画</th>
                                        <?php if ($openflg == 4) : ?>
                                        <td>
                                            <?php if (isset($openMFolderName)) : ?>
                                            <?= $this->Common->mbwordwrap(h($openMFolderName['movie_folder_name'])); ?>
                                            <?php endif; ?> 一式
                                        </td>
                                        <?php else : ?>
                                        <td>
                                            <div class="liststyleC" style="margin-left:-5px;">
                                                <?php if (isset($aOpenRegInput['movieName'])) : ?>
                                                    <?php foreach (array_reverse($aOpenRegInput['movieName']) as $pic) : ?>
                                                <div class="forceBreak" style="word-wrap: break-word; width:480px; margin-left:5px;"><span>・<?= h($pic); ?></span></div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                </table>
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th class="short">ニックネーム<span class="txtRed">*</span></th>
                                        <td>
                                            <?php if (!empty($errorMessage['nickname'])) : ?>
                                            <p class="txtRed"><?= implode($errorMessage['nickname']) ?>
                                            <?php endif; ?>
                                            <div class="space_5"></div>
                                            <p class="tblReadTxt txtSmall">送信する相手に分かる名前を入力してください。</p>
                                            <input name="nickname" type="text" class="inputName" maxlength="25" required value="<?= $aOpenRegInput['nickname'] ?>" >
                                                <p class="tblReadTxt txtSmall">※25文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="short">あなたのアドレス</th>
                                        <td><?= h($userAddress); ?>
                                            <p class="tblReadTxt txtSmall">※このメールアドレスでお届け先に送信します（変更できません）。</p></td>
                                    </tr>
                                    <tr>
                                        <th class="short">公開期間<span class="txtRed">*</span></th>
                                        <td class="noinuputbdr radioLabel_2">
                                            <input type="hidden" name="close_date" class="inputCheck" value="<?= $aOpenRegInput['close_date'] ?>">
                                            <label for="close_date_3"><input class="inputCheck" type="radio" name="close_date" value="3" id="close_date_3" />1週間</label>
                                            <label for="close_date_2"><input class="inputCheck" type="radio" name="close_date" value="2" id="close_date_2" />2週間</label>
                                            <label for="close_date_1"><input class="inputCheck" type="radio" name="close_date" value="1" id="close_date_1" />1ヶ月</label>
                                            <label for="close_date_4"><input class="inputCheck" type="radio" name="close_date" value="4" id="close_date_4" />無期限</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="short">メッセージ<span class="txtRed">*</span></th>
                                        <td>
                                            <div class="space_5"></div>
                                            <?php if (!empty($errorMessage['message'])) : ?>
                                                <p class="txtRed"><?= implode($errorMessage['message']) ?></p>
                                            <?php endif; ?>
                                            </div>
                                            <div class="space_5"></div>
                                            <textarea name="message" cols="45" rows="10" class="inputMessage" required ><?= h($aOpenRegInput['message']) ?></textarea>
                                            <p class="tblReadTxt txtSmall">※125文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="short">送信先<span class="txtRed">*</span></th>
                                        <td>
                                            <p class="tblReadTxt txtRed"><?php if (!empty($errorMessage['mail'])) : ?><div class="tblReadTxt txtRed"><?= implode($errorMessage['mail']) ?></div><?php endif; ?></p>
                                            <div>
                                                <div class="mesAppend"></div>
                                                <p class="tblReadTxt">フォームにメールアドレスを入力し[追加する]ボタンをクリックしてください。<br />
                                                    <?php if ($this->Common->getAspSetting() == '00' || $this->Common->getAspSetting() == '02') : ?>
                                                    アドレス帳から選ぶ場合は[アドレス帳から選択する]ボタンをクリックしてください。
                                                    <?php endif; ?>
                                                </p>
                                                <p class="tblReadTxt txtSmall">※最大10件まで登録できます。</p>
                                                <input type="text" id="add_address" size="28"  value="" />
                                                <input type="button" id="add_btn" name="add_btn" value="追加" class="btnstd" style="padding-top:2px;" />
                                            </div>
                                            <?php if ($this->Common->getAspSetting() == '00' || $this->Common->getAspSetting() == '02') : ?>
                                            <p>
                                                <input type="submit" formnovalidate="formnovalidate" name="selection" class="submit01-album" value="アドレス帳から選択する">
                                            </p>
                                            <?php endif; ?>
                                            <div id="address_list">
                                                <?php for ($i = 0; $i < 10; $i++) : ?>
                                                <?php if (isset($aOpenRegInput['mail'][$i])) : ?>
                                                <div id="mailItem<?= $i ?>">
                                                    <div class="mailItemL">
                                                            <?= h($aOpenRegInput['mail'][$i]) ?>
                                                    </div>
                                                    <div class="mailItemR"><a href="javascript:deleteMailItem(<?= $i ?>)"><img src="/contents/js/jquery.uploadify-v1.6.2.mit/cancel.png" border="0" alt="閉じる" /></a></div>
                                                    <input type="hidden" id="mail[]" name="mail[]" value="<?= $aOpenRegInput['mail'][$i] ?>">
                                                </div>
                                                <?php endif; ?>
                                                <?php endfor; ?>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="short">アクセス確認</th>
                                        <td class="noinuputbdr checkLabel">
                                            <p class="tblReadTxt txtSmall">チェックを付けると、相手が公開ページにアクセスした時にあなたのメールアドレス宛に通知のメールが届きます。</p>
                                            <input type="hidden" name="access_check" value="0">
                                            <input value="1" class="inputCheck" type="checkbox" name="access_check" id="access_check_1">アクセス確認メールを受け取る
                                        </td>
                                    </tr>
                                </table>
                                <p align="center" style="margin-bottom:20px;">
                                    <input type="hidden" name="target_id" value="<?= $mid ?>">
                                    <input id="eMailClick" type="submit"  class="btnovr" value="確認画面へ進む" onclick="blockSubmit();"/>
                                    <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href='<?= $backUrl ?>'"/>
                                </p>
                                <input type="hidden" name="open_flg" value="<?= $openflg ?>">
                                <input type="hidden" name="movie_folder_id" value="<?= $mid ?>">
                                <input type="hidden" name="open_reg" >
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