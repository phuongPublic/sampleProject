<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>公開設定アドレス選択｜My@T COM（マイアットティーコム）</title>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
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
            $(function () {
                $('input.btnstd').hover(function () {
                    $(this).addClass('btnstdOn');
                },
                        function () {
                            $(this).removeClass('btnstdOn');
                        });
                $(function () {
                    var $targetElement = '.forceBreak';
                    if (checkMsie()) {
                        $($targetElement).css('word-break', 'break-all');
                    } else {
                        $($targetElement).each(function () {
                            if (navigator.userAgent.indexOf('Firefox/2') != -1) {
                                $(this).html($(this).text().split('').join('<wbr />'));
                            } else {
                                $(this).html($(this).text().split('').join(String.fromCharCode(8203)));
                            }
                        });
                    }
                });
            });
            // Confirm whether address is checked or not
            function Confirmation() {
                var emailElements = document.getElementsByName("adrdata_seq[]");
                var checkFlagAddress = false;
                for (i = 0; i < emailElements.length; i++) {
                    element = emailElements[i];
                    if (element.checked) {
                        checkFlagAddress = true;
                    }
                }
                if (checkFlagAddress == true) {
                    document.getElementById("adr").submit();
                } else {
                    alert("アドレスが選択されていません。");
                }
            }

        </script>
        <script language="JavaScript">
            function ChangeVisible(id, id2) {
                document.getElementById(id).style.visibility = "visible";
                document.getElementById(id).style.display = "inline";
                document.getElementById(id2).src = "/contents/images/mark_arrow01_under.gif";
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php if ($departure == 1) : ?>
                <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <?php elseif ($departure == 2) : ?>
                <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <?php else : ?>
                <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <?php endif; ?>
            
            <div id="mainContents">
                <?php if ($departure == 1) : ?>
                    <div id="messageArea"><h1 class="iconAlbum"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php elseif ($departure == 2) : ?>
                    <div id="messageArea"><h1 class="iconFiles"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php else : ?>
                    <div id="messageArea"><h1 class="iconMovie"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php endif; ?>

                <?php if ($departure == 1) : ?>
                    <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>
                <?php elseif ($departure == 2) : ?>
                    <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>
                <?php else : ?>
                    <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
                <?php endif; ?>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">
                                <?php if ($departure == 1) : ?>
                                写真を公開する
                                <?php elseif ($departure == 2) : ?>
                                ファイルを公開する
                                <?php else : ?>
                                動画を公開する
                                <?php endif; ?>
                            </h3>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot">
                                <p class="space_3"><strong class="txtBold">【送信先アドレス選択】</strong><br />
                                    <?php if (isset($message)) : ?>
                                        <span class="txtRed"><?= $message ?></span><br />
                                    <?php endif; ?>
                                    送信したいアドレスのチェックボックスをチェックして、[選択する]ボタンをクリックしてください。</p>
                            </div>
                            <div class="space_3"></div>
                            <form name="selection" action="" method="GET">
                                <label>グループ選択：</label>
                                <select name="group_id">
                                    <option value="">すべてのアドレス</option>
                                    <?php foreach ($groupData as $tmpGroupId => $tmpGroupName) : ?>
                                        <?php if ($selectedGroupId == $tmpGroupId) : ?>
                                            <option label="<?= h($tmpGroupName) ?>" value="<?= h($tmpGroupId) ?>" selected="selected"><?= h($tmpGroupName) ?></option>
                                        <?php else : ?>
                                            <option label="<?= h($tmpGroupName) ?>" value="<?= h($tmpGroupId) ?>"><?= h($tmpGroupName) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <input name="selection" type="submit" value="表示" class="submit02 btnstd"/>
                            </form>
                            <br />
                            <form id="adr" name="address" action="" method="POST">
                                <table class="tblFilesList" style="margin-top:0; table-layout:fixed;">
                                    <tr>
                                        <th class="xshort"></th>
                                        <th>ニックネーム</th>
                                        <th>メールアドレス</th>
                                    </tr>
                                    <?php if (!empty($address_data)) : ?>
                                        <?php foreach ($address_data as $list) : ?>
                                        <tr>
                                            <td class="txtCneter xshort"><input type="checkbox" name="adrdata_seq[]" value="<?= h($list['adrdata_seq']) ?>"></td>
                                            <td class="forceBreak"><?= h($list['nickname']) ?></td>
                                            <td class="forceBreak"><?= h($list['email']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3" style="padding:10px 0 0 0;text-align:center;"><p class="txtGray" style="padding-bottom:10px;">メールアドレスが登録されていません。<br />アドレス帳のメニューからアドレスを登録してください。</p></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                                <br />
                                <div align="center" class="padArea">
                                    <input type="hidden" name="commit1" value="1">
                                    <input type="button" name="commit" value="選択する" class="btnovr" onclick="Confirmation();" >&nbsp;&nbsp;
                                    <input type="submit" name="back" value="戻る" class="btnovr">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?= $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>
