<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script language="JavaScript">

            var text = "<? $errorMessage ?>";

            function ChangeVisible(id, id2) {
                document.getElementById(id).style.visibility = "visible";
                document.getElementById(id).style.display = "inline";
                document.getElementById(id2).src = "/contents/images/mark_arrow01_under.gif";
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
            
            function blockSubmit(param) {
                        if(param.id == "subCommit") {
                            document.form1.open_file_commit.value = 1;
                        } else {
                            document.form1.back_confirm.value = 1;
                        }
                        document.getElementById("subCommit").disabled = true;
                        document.getElementById("subBack").disabled = true;
                        document.form1.submit();

                }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconFiles">ファイル管理 <?php if(isset($errorMessage)) echo $errorMessage; ?></h1></div>
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
                                <p class="space_3"><span class="txtBold">内容の確認</span><br />
                                    入力内容を確認の上、問題がなければ[ 送信する ]ボタンをクリックしてください。<br />
                                    内容を修正する場合は[ 戻る ]ボタンをクリックしてください。<br />
                                    <span style="color:#F00; font-weight:bold;">※ダウンロードできる回数は、送信先数×3回となります。</span></p>
                            </div>
                            <div class="space_5"></div>
                            <form id="form" name="form1" method="post" action="regist.html?return=1<?= $cashe ?>">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>公開するファイル</th>
                                        <td>
                                            <ul class="liststyleC">
                                            <?php foreach ($fOpenRegInput['fileName'] as $key => $name) : ?>
                                                <div class="forceBreak" style="word-wrap: break-word; width:480px;">・<?= h($name); ?><br/></div>
                                                    <input type="hidden" name="selected[]" value="<?= $fOpenRegInput['selected'][$key]?>"/>
                                            <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                <tr>
                                    <th>ニックネーム</th>
                                    <td>
                                        <?= h($fOpenRegInput['nickname']); ?>
                                        <input type="hidden" name="nickname" value="<?= $fOpenRegInput['nickname'] ?>"
                                </td>
                            </tr>
                            <tr>
                                <th>あなたのアドレス</th>
                                <td><?= h($userAddress); ?></td>
                                <input type="hidden" name="userAddress" value="<?= $userAddress ?>">
                            </tr>
                            <tr>
                                <th>公開期間</th>
                                <td>1週間</td>
                            </tr>
                            <tr>
                                <th>メッセージ</th>
                                <td><?= $this->Common->mbwordwrap(h($fOpenRegInput['message']), 40) ?><textarea name="message"  style="display:none"><?= h($fOpenRegInput['message']) ?></textarea></td>
                            </tr>
                            <tr>
                                <th>送信先</th>
                                <td>
                                    <?php foreach ($fOpenRegInput['mail'] as $mail) : ?>
                                    <?= h($mail) ?><br />
                                    <input type="hidden" name="mail[]" value="<?= $mail ?>">
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>アクセス確認</th>
                                <td>
                                    <?php if ($fOpenRegInput['access_check'] == "1") : ?>
                                    アクセス確認メールを受け取る
                                    <?php else : ?>
                                    アクセス確認メールを受け取らない
                                    <?php endif; ?>
                                    <input type="hidden" name="access_check" value="<?= $fOpenRegInput['access_check'] ?>" >
                                </td>
                            </tr>
                        </table>
                        <p align="center">
                            <input type="hidden" name="fid" value="<?= $fOpenRegInput['fid'] ?>">
                            <input type="button" id="subCommit" class="btnovr" value="送信する" onclick="blockSubmit(this);" />
                            <input type="button" id="subBack" class="btnovr" value="戻る" onclick="blockSubmit(this);" />
                            <input type="hidden" name="open_flg" value="2">
                            <input type="hidden" name="close_date" value="3">
                            <input type="hidden" name="open_file_commit" >
                            <input type="hidden" name="back_confirm" >
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
