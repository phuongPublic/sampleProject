<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script language="JavaScript">
            function ChangeVisible(id, id2) {
                document.getElementById(id).style.visibility = "visible";
                document.getElementById(id).style.display = "inline";
                document.getElementById(id2).src = "/contents/images/mark_arrow01_under.gif";
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("[name*=delete_open]", "#table").submit(function () {
                    var ensure = confirm("公開を終了しますがよろしいですか？");
                    if (ensure == true) {
                        return true;
                    } else {
                        return false;
                    }
                    return false;
                });
            });

            $(function () {
                $('input.btnovr').click(function () {
                });
                $('input.btnovr').hover(function () {
                    $(this).addClass('btnovrOn');
                },
                        function () {
                            $(this).removeClass('btnovrOn');
                        });
            });
            $(function () {
                $('input.btnstd').click(function () {
                });
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
        </script>
        <style type="text/css"><!-- 
            .tblPicList{font-size:13px;}
            li.sendlist_top,li.sendlist{word-break:break-all;}
            --></style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">

                <div id="messageArea"><h1 class="iconMovie">動画</h1></div>
                <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">公開状況を確認する</h3>
                            <?php if ($helpLinkUrl['MovieOpenStatus']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['MovieOpenStatus'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea space_4">
                                <h3 class="txtBold">「<?= h($openfname['movie_folder_name']) ?>」の公開状況</h3>
                            </div>
                            <?php if (isset($abssmessage)) : ?>
                                <div class="txtRed txtBold" style="padding-top: 10px;"><?= $abssmessage ?></div>
                                <?php endif; ?>
                            <p class="txtSmall space_4">※DL回数はダウンロードされた回数になります。<br />※送信先アドレスは、アクセスしてない人＝灰色細字、アクセスした人＝黒色太字となります。</p>
                            <div class="floR txtRight" style="width:680px;height:1.1em;">
                                <form name="selection" action="?<?= $cashe ?>" method="GET">
                                    <span>表示変更：</span>
                                    <?php echo $this->Form->select(
                                        'cid',
                                        $contents,
                                        ['class' => 'selectFile', 'default' => $selectedMovie]
                                    ); ?>
                                        <input type="hidden" name="mid" value="<?= $mid ?>">
                                        <input type="submit" name="movie_select" value="表示" class="submit01 btnstd" />
                                </form>
                            </div>
                            <div class="clear"></div>
                            <table id="table" align="center" cellpadding="0" cellspacing="0" class="tblPicList">
                                <tr>
                                    <th>期間</th>
                                    <th>ファイル</th>
                                    <th>DL回数</th>
                                    <th>送信先アドレス</th>
                                    <th style="width:80px;">機能</th>
                                </tr>
                                <?php if (!empty($data)) : ?>
                                <?php foreach ($data as $key => $list) : ?>
                                <form name="delete_open" action="?cid=<?= $selectedMovie ?>&mid=<?= $mid ?>&<?= $cashe ?>" method="POST">
                                    <tr>
                                        <td>
                                            <?php if ($list['close_type'] == 1) :  ?>
                                                1ヶ月
                                            <?php elseif ($list['close_type'] == 2) :  ?>
                                                2週間
                                            <?php elseif ($list['close_type'] == 3) :  ?>
                                                1週間
                                            <?php elseif ($list['close_type'] == 4) :  ?>
                                                無期限
                                            <?php endif; ?>
                                            <br />
                                            <?php if ($list['close_type'] != 4) :  ?>
                                            （<?= $list['reg_date']->i18nFormat('YYYY/MM/dd') ?>～<?= $list['close_date']->i18nFormat('YYYY/MM/dd') ?>）
                                            <?php endif; ?>
                                            <br /></td>
                                        <td>
                                            <ul class="liststyleC">
                                                <?php if ($list['open_type'] == 5) :  ?>
                                                    <input type="hidden" name="mov_mode" value="1">
                                                    <?php foreach ($list['open_info'] as $key => $item) : ?>
                                                        <li class="forceBreak"><?= h($item['name']) ?></li>
                                                        <input type="hidden" name="target_id[]" value="<?= $item['target_id'] ?>">
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    フォルダ一式
                                                    <input type="hidden" name="mov_mode" value="0">
                                                <?php endif; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?php if ($list['open_type'] == 5) :  ?>
                                            <?php foreach ($list['open_info'] as $key => $item) : ?>
                                            <?= $item['download_count'] ?><br>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                                <?= $list['download_count'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <ul>
                                                <?php foreach ($list['target_mail'] as $key => $itemMail) : ?>
                                                    <?php if ($key == 0) :  ?>
                                                        <?php if ($itemMail['login_date'] == "") :  ?>
                                                            <li class="sendlist_top"><span class="download txtGray forceBreak"><?= $itemMail['mail'] ?></span></li>
                                                        <?php else : ?>
                                                            <li class="sendlist_top"><strong class="txtBold forceBreak"><?= $itemMail['mail'] ?></strong></li>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <?php if ($itemMail['login_date'] == "") :  ?>
                                                            <li class="sendlist"><span class="download txtGray forceBreak"><?= $itemMail['mail'] ?></span></li>
                                                        <?php else : ?>
                                                            <li class="sendlist"><strong class="txtBold forceBreak"><?= $itemMail['mail'] ?></strong></li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <input type="hidden" name="target_user_seq[]" value="<?= $itemMail['target_user_seq'] ?>">
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td style="padding-left:10px;width:70px;">
                                            &nbsp;<input type="button" name="preview" class="btnstd txtSmall" value="プレビュー" onclick="window.open('/open/login.html?id=<?= $list['open_id'] ?>&seq=<?= $list['user_seq'] ?>');" />
                                            <input type="hidden" name="open_id" value="<?= $list['open_id'] ?>" />
                                            <input type="hidden" name="mid" value="<?= $mid ?>" />
                                            <input type="hidden" name="cid" value="<?= $selectedMovie ?>">
                                            <input type="submit" name="delete" class="submit01 btnstd" value="終了する" /></td>
                                    </tr>
                                </form>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="5" style="padding:10px 0 30px 20px;"><p class="txtGray">公開情報がありません。</p></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <p align="center">
                                <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href = '<?= $backUrl ?>'"/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>