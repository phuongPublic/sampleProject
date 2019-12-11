<?php

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script type="text/javascript">
            $(document).ready(function(){
                if ($("#selectYear").val() == 99) {
                    $(".fSelectAssist").html('');
                } else {
                    $(".fSelectAssist").html('年');
                }
            });
            function YearChange(id) {
                location.href = "/admin/campaign/list.html?selectYear=" + id;
            }

            function AlertMessage(id, del_date, category, year, sort) {
                msg = "選択したキャンペーンバナーを削除しますが、よろしいですか？";
                flg = window.confirm(msg);
                if (flg) {
                    location.href = "/admin/campaign/list.html?topicsSeq=" + id + "&selectYear=" + year + "&sort=" + sort;
                }
                return flg;
            }
        </script>
    </head>
    <body>
        <div id="AllWidth">
            <?= $this->element($this->Common->getIsp() . '/admin/header'); ?>
            <div id="BackgroundLeft_repeat">
                <div id="BackgroundRight_repeat">
                    <div id="BackgroundLeft">
                        <div id="BackgroundRight">
                            <div id="siteNavi">
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>会員限定キャンペーンバナー一覧</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                        <td id="main"><div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">会員限定キャンペーンバナー一覧</h2>
                                                </div>
                                                <p class="mBoxitem_txt">会員限定キャンペーンバナーの一覧です。<br />
                                                    [編集]ボタンで記事の編集、[削除］ボタンで記事の削除が可能です。</p>
                                                <!-- 完了メッセージ -->
                                                <p class="mBoxitem_txt txtWarning">
                                                    <?php
                                                    if (!empty($message)) {
                                                        echo $message;
                                                    }
                                                    ?>
                                                </p>
                                                <!-- //完了メッセージ -->
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <div class="mBoxitem_table">
                                                    <form action="">
                                                        <div class="mBoxitem_listinfo">
                                                            <div class="fAssist_row">
                                                                <?php
                                                                echo
                                                                $this->Form->select('selectYear', $yearOption, [
                                                                    'empty' => false,
                                                                    'onchange' => 'YearChange(this.value)',
                                                                    'default' => $selectYear,
                                                                    'id' => 'selectYear'
                                                                ]);
                                                                ?>
                                                                <span class="fSelectAssist"></span></div>
                                                            <div style="clear:both;"></div>
                                                        </div>
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableYoko">
                                                            <tr class="trYoko">
                                                                <th class="thYokoM"><a href="/admin/campaign/list.html?selectYear=<?= $selectYear ?>&sort=<?= $sortStatus ?>">ステータス</a></th>
                                                                <th class="thYokoMPlus">公開日時・公開終了日時</th>
                                                                <th>画像</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            <?php
                                                            $trBgcolor = 0;
                                                            foreach ($campaignArray as $list):
                                                                ?>
                                                                <tr class="<?php if ($trBgcolor % 2 == 0): ?>colorOdd<?php else: ?>colorEven<?php endif ?>">
                                                                    <td>
                                                                        <?php if ($list["viewflg"] == Configure::read('Common.AdminModule.ViewFlag.Public')): ?>
                                                                            公開
                                                                        <?php elseif ($list["viewflg"] == Configure::read('Common.AdminModule.ViewFlag.FinishPublic')) : ?>
                                                                            公開終了
                                                                        <?php else: ?>
                                                                            <?= $adminCampaignStatus[$list['viewflg']] ?>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($list["viewflg"] != Configure::read('Common.AdminModule.ViewFlag.Draft')): ?>
                                                                            <?= !empty($list['opendata']) ? $list["opendata"]->i18nFormat('MM月dd日 HH:mm') : '' ?>
                                                                        <?php endif ?>
                                                                        ・<br />
                                                                        <?php if ($list["timerflg"] == Configure::read('Common.AdminModule.TimerFlag.Setting')): ?>
                                                                            <?= !empty($list['timerdata']) ? $list["timerdata"]->i18nFormat('MM月dd日 HH:mm') : '' ?>
                                                                        <?php else: ?>
                                                                            指定無
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td>
                                                                        <img src="<?= $list['file_path2'] ?>" <?php if (isset($list["img_width"]) && $list["img_width"] >= 170): ?> width="170"<?php endif ?> />
                                                                        <?php if ($list["file_path1"]): ?>
                                                                            <?php if ($list["title"] != ""): ?>
                                                                                <?= $list["title"] ?><br />
                                                                            <?php endif ?>
                                                                        <?php else: ?>
                                                                            <?= $list["title"] ?>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td class="tdYoko_btn_s2">
                                                                        <input type="button" class="btnTable_small" value="編集" onclick="location.href = '/admin/campaign/update.html?topicsSeq=<?= $list["topicsseq"] ?>&selectYear=<?= $selectYear ?>&sort=<?= $sort ?>'" />
                                                                        <input type="button" class="btnTable_small" value="削除" onclick="AlertMessage('<?= $list["topicsseq"] ?>', '<?= !empty($list['opendata']) ? $list["opendata"]->i18nFormat('MM月dd日 HH:mm') : '' ?>', 'キャンペーンバナー', '<?= $selectYear ?>', '<?= $sort ?>')" /></td>
                                                                </tr>
                                                                <?php $trBgcolor = $trBgcolor + 1; ?>
                                                            <?php endforeach; ?>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="BackgroundBottom">
                <div>&nbsp;</div>
            </div>
            <?= $this->element($this->Common->getIsp() . '/admin/footer'); ?>
        </div>
    </body>
</html>
