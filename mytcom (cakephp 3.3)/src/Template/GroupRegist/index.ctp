<!DOCTYPE html>
<html>
    <head>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            $(function() {
                $('.pagination').click(function() {
                    var address = $('input[name="adrdata_seq[]"]:checked').length;
                    if(address > 0) {
                        if(!confirm("ページを移動すると、チェックボックスの状態がリセットされます。よろしいですか？")) {
                            return false;
                        }
                    }
                });
            });
            $(function() {
                $('input.btnovr').hover(function() {
                        $(this).addClass('btnovrOn');
                    },
                    function() {
                        $(this).removeClass('btnovrOn');
                    });
            });
            $(function() {
                $('input.btnLong').hover(function() {
                        $(this).addClass('btnlongOn');
                    },
                    function() {
                        $(this).removeClass('btnlongOn');
                    });
            });
            $(function() {
                $('input.btnstd').hover(function() {
                        $(this).addClass('btnstdOn');
                    },
                    function() {
                        $(this).removeClass('btnstdOn');
                    });
                $(function() {
                    var $targetElement = '.forceBreak';
                    if (checkMsie()) {
                        $($targetElement).css('word-break', 'break-all');
                    } else {
                        $($targetElement).each(function() {
                            if (navigator.userAgent.indexOf('Firefox/2') != -1) {
                                $(this).html($(this).text().split('').join('<wbr />'));
                            } else {
                                $(this).html($(this).text().split('').join(String.fromCharCode(8203)));
                            }
                        });
                    }
                });
            });
        </script>
        <script type="text/javascript">
            function procNextCtrl(e) {
                var c = e.keyCode;
                if (c == 13) {
                    document.all.item("submit").focus();
                    document.form.submit();
                }
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#form").validate({
                    onfocusout: false,
                    onkeyup: false,
                    onsubmit: function (element) {
                        this.element(element);
                    },
                    rules: {
                        group_name: {
                            required: true,
                            maxlength: 25,
                            nospaces: true
                        }
                    },
                    messages: {
                        group_name: {
                            required: "<span class='txtRed txtBold'>" + "グループ名を入力してください。" + "</span>",
                            maxlength: "<span class='txtRed txtBold'>" + "グループ名は25文字以内で入力してください。" + "</span>",
                            nospaces: "<span class='txtRed txtBold'>" + "半角スペースのみの登録はできません。" + "</span>"
                        }
                    },
                    errorPlacement: function (error, element) {
                        $('.more_error').html('');
                        if (error) {
                            error.appendTo($('.more_error'));
                        }
                        $("#tongleSubmit").removeAttr('disabled');
                    },
                    success: function(element) {
                        $('.more_error').html('');
                        $("#tongleSubmit").prop('disabled', 'true');
                    }
                });
            });
        </script>
        <style type="text/css">
            .tblFilesList td {
                border-right: 1px solid #A3B8CD !important;
            }

            .tblFilesList .borderNone {
                border-right: none !important;
            }

            .forceBreak {
                max-width: 40%;
                _width: 35%;
            }

            .forceBreak,
            .forceBreak a {
                word-break: break-all;
            }
            
            .tblReadText {
                padding-top:5px !important;
            }
            
            .arrowDown {
                width:10px;
            }
            
            .tblForm.mrgTop5 {
                margin-top:5px;
            }
            table th {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea"><h1 class="iconAddress"><?= $this->Header->getTitleStr($menu_now_flg) ?>
                    </h1>
                </div>

                <div id="contentsLeft">
                    <div class="sideBox">
                        <div class="sideTopGray">
                            <h2>メニュー</h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?<?= $cashe ?>">アドレスを登録</a></li>
                                <li class="bdr"><a href="/address/group/regist.html?<?= $cashe ?>">グループを追加</a></li>
                                <li class="bdr"><a href="/address/import.html?<?= $cashe ?>">インポート</a></li> 
                                <li><a href="/address/listview.html?<?= $cashe ?>">アドレス帳を見る</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h2 class="contentsttl floL">グループを追加する</h2>
                        </div>
                        <div class="contentsMain">
                            <div class="padArea bdrbot">
                                グループを作成します。<br/>
                                必要事項を入力し、[登録する]ボタンをクリックしてください。
                                <?php if (!empty($ErrorMsg)) : ?><br /><span class="txtRed txtBold"><?= h($ErrorMsg) ?></span><?php endif; ?>
                                <p class="more_error"></p>
                            </div>
                            <p>
                            <span class="txtSmall">※ひとつのアドレスを複数のグループに登録することはできません。</span><br />
                            <span class="txtSmall">※登録できるグループ数は<?= h($groupQuota) ?>件までとなります。</span><br />
                            <span class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</span></p>
                            <br />
                            <form method="POST" id="form" name="form1" class="submitForm" action="/address/group/regist.html?<?= $cashe ?>">
                                <h3 class="txtBold"><img class="arrowDown" src="/contents/images/icon_arrow_downB.gif" alt="▼" />グループ名の登録</h3>
                                <table class="tblForm mrgTop5">
                                    <tbody>
                                        <tr>
                                            <th>グループ名<span class="txtRed">*</span></th>
                                            <td>
                                                <input type="text" id="group_name" name="group_name" size="40" maxlength="25" value="<?= h($groupName) ?>" required />
                                                <p class="tblReadText txtSmall">※25文字以内</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br />
                                <h3 class="txtBold space_5"><img class="arrowDown" src="/contents/images/icon_arrow_downB.gif" alt="▼" />アドレス選択</h3>
                                <div class="space_5" style="margin-left:5px;">登録したいアドレスにチェックを入れてください。</div>
                                <table class="tblFilesList" style="margin-top:0;">
                                    <tfoot>
                                        <tr>
                                            <td class="BGColorGray borderNone" colspan="3" align="right" nowrap="nowrap" style="border-left:0 !important;text-align:right;">
                                                <?php if ($link['pageTotal'] == 0) : ?>
                                                    <?= h($link['pageTotal']) ?>件&nbsp;
                                                <?php else : ?>
                                                    <?= h($link['pageTotal']) ?>件中&nbsp;<?= h($link['pageStart']) ?>-<?= h($link['pageEnd']) ?>件&nbsp;&nbsp;
                                                <?php endif; ?>
                                                <?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/regist.html?group_pg=1&<?= $cashe ?>">最初</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最初</span>
                                                <?php endif; ?>
                                                ｜<?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/regist.html?group_pg=<?= h($link['pagePrev']) ?>&<?= $cashe ?>">≪前</a>
                                                <?php else : ?>
                                                    <span class="txtGray">&lt;&lt;前</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?>
                                                    <a class="pagination" href="/address/group/regist.html?group_pg=<?= h($link['pageNext']) ?>&<?= $cashe ?>">次≫</a>
                                                <?php else : ?>
                                                    <span class="txtGray">次&gt;&gt;</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?>
                                                    <a class="pagination" href="/address/group/regist.html?group_pg=<?= h($link['pageLast']) ?>&<?= $cashe ?>">最後</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最後</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tr>
                                        <th class="xshort"></th>
                                        <th><b>ニックネーム</b></th>
                                        <th><b>メールアドレス</b></th>
                                    </tr>
                                    <?php foreach ($addressList as $list) : ?>
                                    <tr>
                                        <td class="txtCneter xshort">
                                            <input type="checkbox" name="adrdata_seq[]" value="<?= h($list['adrdata_seq']) ?>" />
                                        </td>
                                        <td><?= h($list['nickname']) ?></td>
                                        <td class="forceBreak" style="word-break: break-word;"><?= h($list['email']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>

                                </table>
                                <p align="center" class="txtCneter">
                                    <input type="hidden" name="register" value="1"/>
                                    <input type="submit" id="tongleSubmit" class="btnovr" value="登録する" />
                                    <input type="button" name="return" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
                                </p>
                            </form>
                        </div><!---contentsMain--->
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?= $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>
