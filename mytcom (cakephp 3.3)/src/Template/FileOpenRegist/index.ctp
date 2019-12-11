<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>

        <script language="JavaScript">

            function blockSubmit() {
                var isValid = $('#form').valid();
                if(isValid) {
                    document.form1.open_file_reg.value = 1;
                }
            }

            function chkRegEmail(str) {

                var Seiki = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                /* 入力された値がパターンにマッチするか調べる */
                if (str != "") {
                    if (str.match(Seiki)) {
                        //alert(str.match(Seiki)+"\n\nメールアドレスの形式は正しいです");
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
                var accessCheck = <?= $fOpenRegInput['access_check'] ?>;
                (accessCheck == "1") ? $('#access_check_1').attr('checked', true) : $('#access_check_1').attr('checked', false);
                $('#add_btn').click(function () {
                    if (!chkRegEmail($('#add_address').val()))
                        return;
                    if ($("#address_list > *").length >= 10) {
                        //$.blockUI({ message: '追加できるアドレスは10件までです。' });
                        //$('.blockOverlay').attr('title','クリックで閉じます。').click($.unblockUI);
                        alert("追加できるアドレスは10件までです。");
                        return;
                    }
                    var newNumber = 0;
                    if ($("#address_list > *").length > 0) {
                        newNumber = $("#address_list > *").length;
                    }

                    $('#address_list').append('<div id="mailItem' + newNumber + '"><div class="mailItemL">' + $('#add_address').val() + '</div>\
                                <div class="mailItemR"><a href="javascript:deleteMailItem(' + newNumber + ')"><img src="/contents/js/jquery.uploadify-v1.6.2.mit/cancel.png" border="0" /></a></div>\
                                        <input type="hidden" id="mail[]" name="mail[]" value="' + $('#add_address').val() + '">\
                                </div>');
                });
            });

            function deleteMailItem(number) {
                $('#mailItem' + number).remove();
            }
            function ChangeVisible(id, id2) {
                document.getElementById(id).style.visibility = "visible";
                document.getElementById(id).style.display = "inline";
                document.getElementById(id2).src = "/contents/images/mark_arrow01_under.gif";
            }
            function SingleDownload(num) {
                document.form1.elements["file"].value = num;
                document.form1.elements["singledownload"].value = 1;
                document.form1.action = "/storage/file/list.html?fid=<?= $fid ?>&<?= $cashe ?>";
                document.form1.submit();
                document.form1.elements["singledownload"].value = "";
                document.form1.action = "regist.html?<?= $cashe ?>";
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
                $(function () {
                    var n = $('ul.fileDataBox li').size();
                    var ulHeight = 0;
                    if (n >= 10) {
                        $('ul.fileDataBox')
                                .css('height', '315px')
                                .css('overflow-y', 'scroll');
                    } else {
                        $('ul.fileDataBox').css('height', 'auto');
                    }
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
                        'selected[]': {
                            required: true,
                            maxlength: 10
                        },
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
                        'selected[]': {
                            required: "<p class='txtRed'>公開ファイルを選択してください。</p>",
                            maxlength: "<p class='txtRed'>一度に公開できるファイルは10個までです。</p>"
                        },
                        nickname: {
                            required: "ニックネームが入力されていません｡",
                            maxlength: "ニックネームには{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        },
                        message: {
                            required: "メッセージが入力されていません｡",
                            maxlengthNonewline: "メッセージには{0}文字以内で入力してください｡",
                            nospaces: "半角スペースのみの登録はできません。"
                        }
                    },
                    errorPlacement: function (error, element) {
                        if(element.attr("name") == "selected[]") error.insertAfter("#nameSelectedError");
                        else error.appendTo(element.prev().prev());
                    }
                });
            });
        </script>
        <style>
            <?php if (count($data) > 10) : ?>
            .fileDataBox {
                height: 315px;
                overflow-y: scroll;
            }
            <?php else : ?>
            .fileDataBox {
                height: auto;
            }
            <?php endif; ?>
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconFiles">ファイル管理 </h1></div>
                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">ファイルを公開する</h3>
                            <?php if ($helpLinkUrl['FileOpenRegist']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['FileOpenRegist'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot">
                                <p class="space_3">ファイルの公開ページのURLを指定したメールアドレス宛に送信することができます。<br />
                                    必要事項を入力し、[確認画面へ進む]ボタンをクリックしてください。</p>
                                <?php if (isset($message)) : ?>
                                    <span class="txtRed"><?= $message ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" name="form1" class="submitForm" method="post" action="regist.html?return=1&<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>公開するファイル</th>
                                        <td class="noinuputbdr">
                                            <p class="tblReadTxt txtSmall">公開するファイルのチェックボックスをチェックしてください。<br />
                                                <span class="txtRed">※一度に公開できるファイルは10ファイルまでとなります</span></p>
                                            <?php if (!empty($errorFileMsg)) : ?>
                                                <p class="txtRed">
                                                    <?= $errorFileMsg ?>
                                                </p>
                                            <?php endif; ?>
                                            <div id="nameSelectedError"></div>
                                            <ul class="fileDataBox">
                                            <?php
                                                $unSelectFiles = array();
                                                foreach ($data as $list) :
                                                    if (!$list['selected']) { $unSelectFiles[] = $list; continue; } ?>
                                                    <li class="<?php if ($list['selected'] == 1) : ?>Item2<?php else : ?>Item1<?php endif ; ?>">
                                                        <div class="forceBreak" style="word-wrap: break-word; width:480px;">
                                                        <input type="checkbox" name="selected[]" value="<?= $list['file_id'] ?>" <?php if($list['selected'] == 1) : ?>checked<?php elseif ($list['file_id'] == $ffid) :  ?>checked<?php endif; ?>>&nbsp;&nbsp;
                                                            <a href="javascript:SingleDownload('<?= $list['file_id'] ?>');">
                                                                <?php echo $list['extension']!="" ? h($list['name'].".".$list['extension']) : h($list['name']) ?>
                                                            </a>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php
                                                if (!empty($unSelectFiles)) {
                                                    foreach (array_reverse($unSelectFiles) as $list) : ?>
                                                        <li class="Item1">
                                                            <div class="forceBreak" style="word-wrap: break-word; width:480px;">
                                                                <input type="checkbox" name="selected[]" value="<?= $list['file_id'] ?>" <?php if ($list['file_id'] == $ffid) :  ?>checked<?php endif; ?>>&nbsp;&nbsp;
                                                                <a href="javascript:SingleDownload('<?= $list['file_id'] ?>');">
                                                                    <?php echo $list['extension']!="" ? h($list['name'].".".$list['extension']) : h($list['name']) ?>
                                                                </a>
                                                            </div>
                                                        </li>
                                                <?php endforeach; } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>ニックネーム<span class="txtRed">*</span></th>
                                        <td>
                                            <?php if (!empty($errorMessage['nickname'])) : ?>
                                                <div class="tblReadTxt txtRed">
                                                    <?= h(implode($errorMessage['nickname'])) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="space_5"></div>
                                            <p class="tblReadTxt txtSmall">※送信する相手に分かる名前を入力してください。</p>
                                            <input name="nickname" type="text" class="inputName" required maxlength="25" value="<?= $fOpenRegInput['nickname'] ?>" >
                                                <p class="tblReadTxt txtSmall">※25文字以内</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>あなたのアドレス</th>
                                        <td><?= h($userAddress) ?><br />
                                            <p class="tblReadTxt txtSmall">※このメールアドレスでお届け先に送信します（変更できません）。</p></td>
                                    </tr>
                                    <tr>
                                        <th>公開期間</th>
                                        <td>1週間</td>
                                        <input type="hidden" value="3" name="close_date"/>
                                    </tr>
                                    <tr>
                                        <th>メッセージ<span class="txtRed">*</span></th>
                                        <td>
                                            <div class="space_5">
                                            <?php if (!empty($errorMessage['message'])) : ?>
                                                <p class="txtRed"><?= implode($errorMessage['message']) ?></p>
                                            <?php endif; ?>
                                            </div>
                                            <div class="space_5"></div>
                                            <textarea name="message" cols="45" rows="10" required class="inputMessage"><?= h($fOpenRegInput['message']) ?></textarea>
                                            <p class="tblReadTxt txtSmall">※125文字以内<br />
                                                ※改行は無効となります。</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>送信先<span class="txtRed">*</span></th>
                                        <div id="nameMailError"></div>
                                        <td><div class="mesAppend"></div>
                                            <p class="tblReadTxt txtRed">
                                                <?php if (!empty($errorMessage['mail'])) : ?>
                                                    <div class="tblReadTxt txtRed"><?= implode($errorMessage['mail']) ?></div>
                                                <?php endif; ?>
                                            </p>
                                            <div>
                                                <p class="tblReadTxt">フォームにメールアドレスを入力し[追加する]ボタンをクリックしてください。<br />
                                                    <?php if($this->Common->getAspSetting() == '00' || $this->Common->getAspSetting() == '02'): ?>
                                                    アドレス帳から選ぶ場合は[アドレス帳から選択する]ボタンをクリックしてください。
                                                    <?php endif; ?>
                                                </p>
                                                <p class="tblReadTxt txtSmall">※最大10件まで登録できます。</p>
                                                <input type="text" id="add_address" size="40" value="" class="inputAddress" />
                                                <input type="button" id="add_btn" name="add_btn" value="追加する" class="btnstd" />
                                            </div>
                                            <?php if($this->Common->getAspSetting() == '00' || $this->Common->getAspSetting() == '02') : ?>
                                            <p>
                                                <input type="submit" formnovalidate="formnovalidate" name="selection" class="submit01-album" value="アドレス帳から選択する">
                                            </p>
                                            <?php endif; ?>
                                            <div id="address_list">
                                                <?php for ($i = 0; $i < 10; $i++) : ?>
                                                <?php if (isset($fOpenRegInput['mail'][$i])) : ?>
                                                <div id="mailItem<?= $i ?>">
                                                    <div class="mailItemL">
                                                            <?= h($fOpenRegInput['mail'][$i]) ?>
                                                    </div>
                                                    <div class="mailItemR"><a href="javascript:deleteMailItem(<?= $i ?>)"><img src="/contents/js/jquery.uploadify-v1.6.2.mit/cancel.png" border="0" alt="閉じる" /></a></div>
                                                    <input type="hidden" id="mail[]" name="mail[]" value="<?= $fOpenRegInput['mail'][$i] ?>">
                                                </div>
                                                <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>アクセス確認</th>
                                        <td class="noinuputbdr checkLabel">
                                            <p class="tblReadTxt txtSmall">チェックを付けると、相手が公開ページにアクセスした時にあなたのメールアドレス宛に通知のメールが届きます。</p>
                                            <input type="hidden" name="access_check" value="0">
                                            <input value="1" class="inputCheck" type="checkbox" name="access_check" id="access_check_1">アクセス確認メールを受け取る
                                            </td>
                                            </tr>
                                </table>
                                        <p align="center" style="margin-bottom:20px;">
                                            <input type="hidden" name="fid" value="<?= $fid ?>">
                                            <input type="hidden" name="open_file_reg" >
                                            <input type="hidden" value="" name="file"/>
                                            <input type="hidden" value="" name="singledownload"/>
                                            <input id="eMailClick" type="submit" class="btnovr" value="確認画面へ進む" onclick="blockSubmit();" />
                                            <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $backUrl ?>'"/>
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
