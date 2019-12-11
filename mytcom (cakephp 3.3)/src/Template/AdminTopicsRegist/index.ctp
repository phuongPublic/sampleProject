<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin') ?>
        <script type="text/javascript">
            $(document).ready(function () {
                startTimerCheckShow();
                endTimerCheckShow();
            });

            function startTimerCheckShow() {
                if ($("#radStartTimerStatus_3").is(":checked")) {
                    $(".slbOpenData").prop("disabled", false);
                } else {
                    $(".slbOpenData").prop("disabled", true);
                }
            }
            ;

            function endTimerCheckShow() {
                if ($("#radEndTimerStatus_2").is(":checked")) {
                    $(".slbTimerData").prop("disabled", true);
                } else {
                    $(".slbTimerData").prop("disabled", false);
                }
            }
            ;

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
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>お知らせの登録</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                        <td id="main">
                                            <div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">お知らせの登録</h2>
                                                </div>
                                                <p class="mBoxitem_txt">お知らせの記事を登録します。<br>
                                                    必要事項を入力し、[書き込み内容をよく確認してから投稿する]ボタンをクリックしてください。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <p class="mBoxitem_txt txtSub">※<span class="txtWarning">*</span>印のついている項目は、入力必須項目となります。</p>
                                                <div class="mBoxitem_table">
                                                    <?php
                                                    echo $this->Form->create('frmTopicRegist', array('url' => '/admin/topics/regist.html', 'id' => 'frmTopicRegist', 'type' => 'POST', 'class' => 'classname'));
                                                    ?>
                                                    <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                                                        <tbody>
                                                            <tr>
                                                                <th>カテゴリー</th>
                                                                <td>
                                                                    <?php echo $this->Form->select('categoryId', $topicsCategory, ['default' => $topicData['categoryId'], 'class' => 'fSelectBig']); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開日時</th>
                                                                <td>
                                                                    <div class="txtWarning space_5">
                                                                    <?php
                                                                    if (isset($errors['checkTime'])) {
                                                                        foreach ($errors['checkTime'] as $err) {
                                                                            echo $err . nl2br("\n");
                                                                        }
                                                                    }
                                                                    if (isset($errors['openData'])) {
                                                                        foreach ($errors['openData'] as $err) {
                                                                            echo $err;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    </div>
                                                                    <div>
                                                                        <label class="fLabel"><input name="viewFlg" value="1" <?php if ($topicData['viewFlg'] == 1) { ?> checked="checked" <?php } ?> class="fRadio" id="radStartTimerStatus_1" type="radio" onclick="startTimerCheckShow()"><span class="fRadioAssist"><?= $viewFlg[1] ?></span></label>
                                                                        <label class="fLabel"><input name="viewFlg" value="5" <?php if ($topicData['viewFlg'] == 5) { ?> checked="checked" <?php } ?> class="fRadio" id="radStartTimerStatus_5" type="radio" onclick="startTimerCheckShow()"><span class="fRadioAssist"><?= $viewFlg[5] ?></span></label>
                                                                        <label class="fLabel"><input name="viewFlg" value="2" <?php if ($topicData['viewFlg'] == 2) { ?> checked="checked" <?php } ?> class="fRadio" id="radStartTimerStatus_2" type="radio" onclick="startTimerCheckShow()"><span class="fRadioAssist"><?= $viewFlg[2] ?></span></label>
                                                                        <label class="fLabel"><input name="viewFlg" value="3" <?php if ($topicData['viewFlg'] == 3) { ?> checked="checked" <?php } ?> class="fRadio" id="radStartTimerStatus_3" type="radio" onclick="startTimerCheckShow()"><span class="fRadioAssist"><?= $viewFlg[3] ?></span></label>
                                                                        <label class="fLabel"><input name="viewFlg" value="4" <?php if ($topicData['viewFlg'] == 4) { ?> checked="checked" <?php } ?> class="fRadio" id="radStartTimerStatus_4" type="radio" onclick="startTimerCheckShow()"><span class="fRadioAssist"><?= $viewFlg[4] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?php
                                                                        $openYear = date("Y", strtotime($topicData['openData']));
                                                                        echo $this->Form->year('slbOpenData', [
                                                                            'name' => 'openData',
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date("Y") + 3,
                                                                            'value' => $openYear,
                                                                            'empty' => false,
                                                                            'orderYear' => 'asc',
                                                                            'class' => 'slbOpenData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?php
                                                                        $openMonth = date("m", strtotime($topicData['openData']));
                                                                        echo $this->Form->month('slbOpenData', [
                                                                            'name' => 'openData',
                                                                            'monthNames' => false,
                                                                            'value' => $openMonth,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbOpenData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?php
                                                                        $openDay = date("d", strtotime($topicData['openData']));
                                                                        echo $this->Form->day('slbOpenData', [
                                                                            'name' => 'openData',
                                                                            'value' => $openDay,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbOpenData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?php
                                                                        $openHour = date("H", strtotime($topicData['openData']));
                                                                        echo $this->Form->hour('slbOpenData', [
                                                                            'name' => 'openData',
                                                                            'value' => $openHour,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbOpenData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?php
                                                                        $openMinute = date("i", strtotime($topicData['openData']));
                                                                        echo $this->Form->minute('slbOpenData', [
                                                                            'name' => 'openData',
                                                                            'value' => $openMinute,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbOpenData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開終了日時</th>
                                                                <td>
                                                                    <?php if (isset($errors['timerData'])) { ?><div id="textWarningTitle" class="txtWarning space_5">
                                                                        <?php
                                                                        foreach ($errors['timerData'] as $err) {
                                                                            echo $err;
                                                                        }
                                                                        ?>
                                                                        </div><?php } ?>
                                                                    <div>
                                                                        <label class="fLabel"><input name="timerFlg" value="1" <?php if ($topicData['timerFlg'] == 1) { ?> checked="checked" <?php } ?> class="fRadio" id="radEndTimerStatus_1" type="radio" onclick="endTimerCheckShow()"><span class="fRadioAssist"><?= $timerFlg[1] ?></span></label>
                                                                        <label class="fLabel"><input name="timerFlg" value="3" <?php if ($topicData['timerFlg'] == 3) { ?> checked="checked" <?php } ?> class="fRadio" id="radEndTimerStatus_3" type="radio" onclick="endTimerCheckShow()"><span class="fRadioAssist"><?= $timerFlg[3] ?></span></label>
                                                                        <label class="fLabel"><input name="timerFlg" value="2" <?php if ($topicData['timerFlg'] == 2) { ?> checked="checked" <?php } ?> class="fRadio" id="radEndTimerStatus_2" type="radio" onclick="endTimerCheckShow()"><span class="fRadioAssist"><?= $timerFlg[2] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?php
                                                                        $timerYear = date("Y", strtotime($topicData['timerData']));
                                                                        echo $this->Form->year('slbTimerData', [
                                                                            'name' => 'timerData',
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date("Y") + 3,
                                                                            'value' => $timerYear,
                                                                            'empty' => false,
                                                                            'orderYear' => 'asc',
                                                                            'class' => 'slbTimerData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?php
                                                                        $timerMonth = date("m", strtotime($topicData['timerData']));
                                                                        echo $this->Form->month('slbTimerData', [
                                                                            'name' => 'timerData',
                                                                            'monthNames' => false,
                                                                            'value' => $timerMonth,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbTimerData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?php
                                                                        $timerDay = date("d", strtotime($topicData['timerData']));
                                                                        echo $this->Form->day('slbTimerData', [
                                                                            'name' => 'timerData',
                                                                            'value' => $timerDay,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbTimerData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?php
                                                                        $timerHour = date("H", strtotime($topicData['timerData']));
                                                                        echo $this->Form->hour('slbTimerData', [
                                                                            'name' => 'timerData',
                                                                            'value' => $timerHour,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbTimerData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?php
                                                                        $timerMinute = date("i", strtotime($topicData['timerData']));
                                                                        echo $this->Form->minute('slbTimerData', [
                                                                            'name' => 'timerData',
                                                                            'value' => $timerMinute,
                                                                            'empty' => false,
                                                                            'leadingZeroValue' => true,
                                                                            'class' => 'slbTimerData']);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                    <div class="fAssist_col_line txtSub">
                                                                        ※予約した日時で公開を自動的に取り下げる場合に設定します。<br>
                                                                        今すぐ公開を終了する場合は公開日時の「公開終了」をチェックしてください。
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>日付の有無</th>
                                                                <td>
                                                                    <div>
                                                                        <label class="fLabel"><input name="dateViewFlg" value="1" <?php if ($topicData['dateViewFlg'] == 1) { ?> checked="checked" <?php } ?> class="fRadio" type="radio"><span class="fRadioAssist"><?= $dateViewFlg[1] ?></span></label>
                                                                        <label class="fLabel"><input name="dateViewFlg" value="2" <?php if ($topicData['dateViewFlg'] == 2) { ?> checked="checked" <?php } ?> class="fRadio" type="radio"><span class="fRadioAssist"><?= $dateViewFlg[2] ?></span></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>タイトル&nbsp;<span class="txtWarning">*</span></th>
                                                                <td>
                                                                    <div id="textWarningTitle" class="txtWarning space_5"><?php
                                                                        if (isset($errors['title'])) {
                                                                            foreach ($errors['title'] as $err) {
                                                                                echo $err;
                                                                            }
                                                                        }
                                                                        ?></div>
                                                                    <input type="text" id="title" name="title" value="<?= $topicData['title'] ?>" class="txtbox" onblur="toggleColor(this)" onfocus="toggleColor(this)" onkeydown="ignoreESC(this, event.keyCode)" style="width:370px;">
                                                                    <p class="fTextAssist_bottom txtSub">※全角85文字以内（半角255文字以内）</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>本文</th>
                                                                <td>
                                                                    <div id="textWarningTitle" class="txtWarning space_5"><?php
                                                                        if (isset($errors['contents'])) {
                                                                            foreach ($errors['contents'] as $err) {
                                                                                echo $err;
                                                                            }
                                                                        }
                                                                        ?></div>
                                                                    <textarea name="contents" class="txt_bigbox" style="height:250px;" onkeydown="ignoreESC(this, event.keyCode)" onfocus="toggleColorBig(this)" onblur="toggleColorBig(this)" rows="10" cols="20"><?= $topicData['contents'] ?></textarea>
                                                                    <p class="fTextAssist_bottom txtSub">※全角21845文字以内（半角65535文字以内）</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>URL</th>
                                                                <td><?php if (isset($errors['filePath1'])) { ?>
                                                                        <?php foreach ($errors['filePath1'] as $err) { ?>
                                                                            <div class="txtWarning space_5"><?= $err; ?></div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                    <div>
                                                                        <label class="fLabel"><input name="windowFlg" value="1" <?php if ($topicData['windowFlg'] == 1) { ?> checked="checked" <?php } ?> class="fRadio" type="radio"><span class="fRadioAssist"><?= $windowFlg[1] ?></span></label>
                                                                        <label class="fLabel"><input name="windowFlg" value="2" <?php if ($topicData['windowFlg'] == 2) { ?> checked="checked" <?php } ?> class="fRadio" type="radio"><span class="fRadioAssist"><?= $windowFlg[2] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <input class="txtbox" onblur="toggleColor(this)" onfocus="toggleColor(this)" onkeydown="ignoreESC(this, event.keyCode)" style="width:200px;" type="text" name="filePath1" value="<?= $topicData['filePath1'] ?>">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="BtnArea">
                                                        <div class="BtnAreaitem">
                                                            <input type="submit" class="btnNormal_xbig" title="書き込み内容をよく確認してから登録する" value="書き込み内容をよく確認してから登録する" name="btnTopicRegistSubmit"  id="toggleSubmit">
                                                        </div>
                                                        <div class="BtnAreaitem">
                                                            <input type="button" class="btnNormal_big" title="戻る" value="戻る" name="戻る" onclick="history.back();" >
                                                        </div>
                                                    </div>
                                                    <?= $this->Form->end(); ?>
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