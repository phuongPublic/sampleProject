<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script>
            $(document).ready(function() {
                timerDisable();
                reserveDisable();
            });

            function timerDisable() {
                if ($("#setting_mainte_end_1").is(":checked")) {
                    $(".mainte_end_time").prop("disabled", false);
                }
                if ($("#setting_mainte_end_2").is(":checked")) {
                    $(".mainte_end_time").prop("disabled", true);
                }
            };

            function reserveDisable() {
                if ($("#mainte_status_1").is(":checked") || $("#mainte_status_2").is(":checked") || $("#mainte_status_4").is(":checked")) {
                    $(".mainte_start_time").prop("disabled", true);
                }
                if ($("#mainte_status_3").is(":checked")) {
                    $(".mainte_start_time").prop("disabled", false);
                }
            };
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
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span><a href="list.html">過去のメンテナンス画面一覧</a></span>&nbsp;&gt;&nbsp;<span>メンテナンス画面の編集</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                        <td id="main">
                                            <div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">メンテナンス画面の編集</h2>
                                                </div>
                                                <p class="mBoxitem_txt">メンテナンス画面の編集を行います。<br />
                                                    必要事項を入力し、[書き込み内容をよく確認してから投稿する]ボタンをクリックしてください。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <p class="mBoxitem_txt txtSub">※<span class="txtWarning">*</span>印のついている項目は、入力必須項目となります。</p>
                                                <div class="mBoxitem_table">
                                                    <form id="mainteEditForm" method="post" name="mainteform" action="/admin/mainte/update.html">
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                                                            <tr>
                                                                <th>公開日時</th>
                                                                <td>
                                                                    <div>
                                                                        <?php if (isset($errors['checkTime'])) { ?>
                                                                            <?php foreach ($errors['checkTime'] as $err) { ?>
                                                                                <div class="txtWarning space_5"><?= $err; ?></div>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <?php if (isset($errors['mainte_start_time'])) { ?>
                                                                            <?php foreach ($errors['mainte_start_time'] as $err) { ?>
                                                                                <div class="txtWarning space_5"><?= $err; ?></div>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <label class="fLabel"><input class="fRadio" id="mainte_status_1" type="radio" value="1" name="mainte_status" onclick="reserveDisable()" <?php if ($mainteObj['mainte_status'] == 1) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $adminMainteStatus[1] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" id="mainte_status_2" type="radio" value="2" name="mainte_status" onclick="reserveDisable()" <?php if ($mainteObj['mainte_status'] == 2) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $adminMainteStatus[2] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" id="mainte_status_3" type="radio" value="3" name="mainte_status" onclick="reserveDisable()" <?php if ($mainteObj['mainte_status'] == 3) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $adminMainteStatus[3] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" id="mainte_status_4" type="radio" value="4" name="mainte_status" onclick="reserveDisable()" <?php if ($mainteObj['mainte_status'] == 4) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $adminMainteStatus[4] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?=
                                                                        $this->Form->year('mainte_start_time', [
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date("Y") + 3,
                                                                            'value' => ($mainteObj['mainte_status'] != 2) ? date("Y", strtotime($mainteObj["mainte_start_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year')),
                                                                            'empty' => false,
                                                                            'orderYear' => 'asc',
                                                                            'class' => 'mainte_start_time']);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?=
                                                                        $this->Form->month('mainte_start_time', [
                                                                            'monthNames' => false,
                                                                            'value' => ($mainteObj['mainte_status'] != 2) ? date("m", strtotime($mainteObj["mainte_start_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Month')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_start_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?=
                                                                        $this->Form->day('mainte_start_time', [
                                                                            'value' => ($mainteObj['mainte_status'] != 2) ? date("d", strtotime($mainteObj["mainte_start_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Day')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_start_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?=
                                                                        $this->Form->hour('mainte_start_time', [
                                                                            'value' => ($mainteObj['mainte_status'] != 2) ? date("H", strtotime($mainteObj["mainte_start_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Hour')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_start_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?=
                                                                        $this->Form->minute('mainte_start_time', [
                                                                            'value' => ($mainteObj['mainte_status'] != 2) ? date("i", strtotime($mainteObj["mainte_start_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Minute')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_start_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開終了日時</th>
                                                                <td>
                                                                    <div>
                                                                        <?php if (isset($errors['mainte_end_time'])) { ?>
                                                                            <?php foreach ($errors['mainte_end_time'] as $err) { ?>
                                                                                <div class="txtWarning space_5"><?= $err; ?></div>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" id="setting_mainte_end_1" value="1" name="mainte_end_flg" onclick="timerDisable();" <?php if ($mainteObj['mainte_end_flg'] == 1) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $timerFlags[1] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" id="setting_mainte_end_2" value="2" name="mainte_end_flg" onclick="timerDisable();" <?php if ($mainteObj['mainte_end_flg'] == 2) { ?> checked="check" <?php } ?> /><span class="fRadioAssist"><?= $timerFlags[2] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?=
                                                                        $this->Form->year('mainte_end_time', [
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date("Y") + 3,
                                                                            'value' => ($mainteObj['mainte_end_flg'] == 1) ? date("Y", strtotime($mainteObj["mainte_end_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year')),
                                                                            'empty' => false,
                                                                            'orderYear' => 'asc',
                                                                            'class' => 'mainte_end_time']);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?=
                                                                        $this->Form->month('mainte_end_time', [
                                                                            'monthNames' => false,
                                                                            'value' => ($mainteObj['mainte_end_flg'] == 1) ? date("m", strtotime($mainteObj["mainte_end_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Month')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_end_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?=
                                                                        $this->Form->day('mainte_end_time', [
                                                                            'value' => ($mainteObj['mainte_end_flg'] == 1) ? date("d", strtotime($mainteObj["mainte_end_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Day')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_end_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?=
                                                                        $this->Form->hour('mainte_end_time', [
                                                                            'value' => ($mainteObj['mainte_end_flg'] == 1) ? date("H", strtotime($mainteObj["mainte_end_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Hour')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_end_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?=
                                                                        $this->Form->minute('mainte_end_time', [
                                                                            'value' => ($mainteObj['mainte_end_flg'] == 1) ? date("i", strtotime($mainteObj["mainte_end_time"])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Minute')),
                                                                            'empty' => false,
                                                                            'class' => 'mainte_end_time',
                                                                            'leadingZeroValue' => true]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                    <div class="fAssist_col_line txtSub">※予約した日時で自動的に通常画面に戻したい場合に設定します。<br />
                                                                        今すぐに通常画面に戻したい場合は公開日時の「公開終了」をチェックしてください。 </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>内容&nbsp;<span class="txtWarning">*</span></th>
                                                                <td style="padding-bottom: 7px">
                                                                    <?php if (isset($errors['mainte_body'])) { ?>
                                                                        <?php foreach ($errors['mainte_body'] as $err) { ?>
                                                                            <div class="txtWarning space_5"><?= $err; ?></div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                    <textarea class="txt_bigbox" style="height:250px;" onkeydown="ignoreESC(this,event.keyCode)" onfocus="toggleColorBig(this)" onblur="toggleColorBig(this)" name="mainte_body" rows="10" cols=""><?= $mainteObj["mainte_body"] ?></textarea>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="BtnArea">
                                                            <div class="BtnAreaitem">
                                                                <input type="submit" id="toggleSubmit" class="btnNormal_xbig" title="書き込み内容をよく確認してから登録する" value="書き込み内容をよく確認してから登録する" name="mainteEditSubmit" />
                                                                <input type="hidden" name="mainte_id" value="<?= $mainteObj['mainte_id'] ?>"/>
                                                                <input type="hidden" name="mainte_year" value="<?= $mainteYear ?>"/>
                                                                <input type="hidden" name="sort" value="<?= $sort ?>"/>
                                                            </div>
                                                            <div class="BtnAreaitem">
                                                                <input type="button" class="btnNormal_big" title="戻る" value="戻る" name="" onclick="history.back();"/>
                                                            </div>
                                                        </div>
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
