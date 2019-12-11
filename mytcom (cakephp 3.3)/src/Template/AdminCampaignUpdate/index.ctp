<?php

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#startTime<?= $campaignObj['viewflg'] ?>").attr('checked', true);
                $("#endTime<?= $campaignObj['timerflg'] ?>").attr('checked', true);

                ChangeView();
                ChangeTimerView();
            });
            function ChangeView() {
                if ($('#startTime1').is(':checked') || $('#startTime2').is(':checked') || $('#startTime4').is(':checked')) {
                    $(".startTime").prop('disabled', true);
                }

                if ($('#startTime3').is(':checked')) {
                    $(".startTime").prop('disabled', false);
                }
            }

            function ChangeTimerView() {
                if ($('#endTime2').is(':checked')) {
                    $(".endTime").prop('disabled', true);
                }
                if ($('#endTime1').is(':checked')) {
                    $(".endTime").prop('disabled', false);
                }
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
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span><a href="/admin/campaign/list.html">会員限定キャンペーンバナー一覧</a></span>&nbsp;&gt;&nbsp;<span>会員限定キャンペーンバナーの編集</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                        <td id="main"><div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">会員限定キャンペーンバナーの編集</h2>
                                                </div>
                                                <p class="mBoxitem_txt">会員限定キャンペーンのバナーを編集します。<br />
                                                    必要事項を入力し、[書き込み内容をよく確認してから投稿する]ボタンをクリックしてください。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <div class="mBoxitem_table">
                                                    <form id="form" name="topic"  enctype="multipart/form-data" method="POST" action=''>
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                                                            <tr>
                                                                <th>公開日時</th>
                                                                <td>
                                                                    <div class="txtWarning space_5"><?php if (isset($errors) && isset($errors['checkTime'])) { ?>
                                                                            <div class="error">
                                                                                <?= h(implode($errors['checkTime'], '<br/>')) ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (isset($errors) && isset($errors['openData'])) { ?>
                                                                            <div class="error">
                                                                                <?= h(implode($errors['openData'], '<br/>')) ?>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeView()" id="startTime1" value="1" name="viewFlg"/><span class="fRadioAssist"><?= $campaignStatus[1] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeView()" id="startTime2" value="2" name="viewFlg"/><span class="fRadioAssist"><?= $campaignStatus[2] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeView()" id="startTime3" value="3" name="viewFlg"/><span class="fRadioAssist"><?= $campaignStatus[3] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeView()" id="startTime4" value="4" name="viewFlg"/><span class="fRadioAssist"><?= $campaignStatus[4] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?php
                                                                        $opendataYear = date("Y", strtotime($campaignObj['opendata']));
                                                                        echo $this->Form->year('openData', [
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date('Y') + 3,
                                                                            'id' => 'startYear',
                                                                            'orderYear' => 'asc',
                                                                            'empty' => false,
                                                                            'class' => 'startTime',
                                                                            'value' => ($campaignObj['viewflg'] != 2) ? $opendataYear : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'))
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?php
                                                                        $opendataMonth = date("m", strtotime($campaignObj['opendata']));
                                                                        echo $this->Form->month('openData', [
                                                                            'id' => 'startMonth',
                                                                            'empty' => false,
                                                                            'monthNames' => false,
                                                                            'class' => 'startTime',
                                                                            'leadingZeroValue' => true,
                                                                            'value' => ($campaignObj['viewflg'] != 2) ? $opendataMonth : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Month'))
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?php
                                                                        $opendataDay = date("d", strtotime($campaignObj['opendata']));
                                                                        echo $this->Form->day('openData', [
                                                                            'id' => 'startDay',
                                                                            'empty' => false,
                                                                            'class' => 'startTime',
                                                                            'leadingZeroValue' => true,
                                                                            'value' => ($campaignObj['viewflg'] != 2) ? $opendataDay : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Day'))
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?php
                                                                        $opendataHour = date("H", strtotime($campaignObj['opendata']));
                                                                        echo $this->Form->hour('openData', [
                                                                            'format' => 24,
                                                                            'empty' => false,
                                                                            'id' => 'startHour',
                                                                            'class' => 'startTime',
                                                                            'leadingZeroValue' => true,
                                                                            'value' => ($campaignObj['viewflg'] != 2) ? $opendataHour : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Hour'))
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?php
                                                                        $opendataMinute = date("i", strtotime($campaignObj['opendata']));
                                                                        echo $this->Form->minute('openData', [
                                                                            'empty' => false,
                                                                            'id' => 'startMinute',
                                                                            'class' => 'startTime',
                                                                            'value' => ($campaignObj['viewflg'] != 2) ? $opendataMinute : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Minute'))
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span></div></td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開終了日時</th>
                                                                <td>
                                                                    <?php if (isset($errorMessage)): ?>
                                                                        <div class="txtWarning space_5"><?= $errorMessage; ?></div>
                                                                    <?php endif; ?>
                                                                    <?php if (isset($errors) && isset($errors['timerData'])) { ?>
                                                                        <div class="txtWarning space_5">
                                                                            <div class="error">
                                                                                <?= h(implode($errors['timerData'], '<br/>')) ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeTimerView()" id="endTime1" value="1" name="timerFlg"/><span class="fRadioAssist"><?= $campaignTimerFlags[1] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="ChangeTimerView()" id="endTime2" value="2" name="timerFlg"/><span class="fRadioAssist"><?= $campaignTimerFlags[2] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?php
                                                                        $timerdataYear = ($campaignObj['timerflg'] == 1) ? date("Y", strtotime($campaignObj['timerdata'])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'));
                                                                        echo $this->Form->year('timerData', [
                                                                            'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                            'maxYear' => date('Y') + 3,
                                                                            'id' => 'endYear',
                                                                            'orderYear' => 'asc',
                                                                            'empty' => false,
                                                                            'class' => 'endTime',
                                                                            'value' => $timerdataYear
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?php
                                                                        $timerdataMonth = ($campaignObj['timerflg'] == 1) ? date("m", strtotime($campaignObj['timerdata'])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Month'));
                                                                        echo $this->Form->month('timerData', [
                                                                            'id' => 'endMonth',
                                                                            'empty' => false,
                                                                            'monthNames' => false,
                                                                            'class' => 'endTime',
                                                                            'leadingZeroValue' => true,
                                                                            'value' => $timerdataMonth
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?php
                                                                        $timerdataDay = ($campaignObj['timerflg'] == 1) ? date("d", strtotime($campaignObj['timerdata'])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Day'));
                                                                        echo $this->Form->day('timerData', [
                                                                            'id' => 'endDay',
                                                                            'empty' => false,
                                                                            'class' => "endTime",
                                                                            'leadingZeroValue' => true,
                                                                            'value' => $timerdataDay
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?php
                                                                        $timerdataHour = ($campaignObj['timerflg'] == 1) ? date("H", strtotime($campaignObj['timerdata'])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Hour'));
                                                                        echo $this->Form->hour('timerData', [
                                                                            'format' => 24,
                                                                            'empty' => false,
                                                                            'id' => 'endHour',
                                                                            'class' => "endTime",
                                                                            'leadingZeroValue' => true,
                                                                            'value' => $timerdataHour
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?php
                                                                        $timerdataMinute = ($campaignObj['timerflg'] == 1) ? date("i", strtotime($campaignObj['timerdata'])) : date(Configure::read('Common.AdminModule.Datetime.DefaultSelected.Minute'));
                                                                        echo $this->Form->minute('timerData', [
                                                                            'empty' => false,
                                                                            'id' => 'endMinute',
                                                                            'class' => 'endTime',
                                                                            'value' => $timerdataMinute
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span></div>
                                                                    <div class="fAssist_col_line txtSub">※予約した日時で公開を自動的に取り下げる場合に設定します。<br />
                                                                        今すぐ公開を終了する場合は公開日時の「公開終了」をチェックしてください。</div></td>
                                                            </tr>
                                                            <tr>
                                                                <th>画像&nbsp;</th>
                                                                <td><p class="fTextAssist_top">画像を変更する場合は、[参照]をクリックして新しい画像を再度登録してください。</p>
                                                                    <div class="txtWarning space_5">
                                                                        <?php if (isset($errors) && isset($errors['banner'])) { ?>
                                                                            <div class="error">
                                                                                <p> <?= nl2br(implode($errors['banner'], '<br />')) ?></p>
                                                                            </div>
                                                                        <?php } ?></div>
                                                                    <input type="file" class="fFile" name="banner" size="60%" />
                                                                    <p class="fTextAssist_bottom txtSub">※アップロードできる画像形式はgif、jpg、pngとなります。<br />
                                                                        ※幅200pixel以上の画像はレイアウトが崩れる恐れがあります。</p></td>
                                                            </tr>
                                                            <tr>
                                                                <th>URL</th>
                                                                <td>
                                                                    <?php if (isset($errorWindowflg)): ?>
                                                                        <div class="txtWarning space_5"><?= $errorWindowflg; ?></div>
                                                                    <?php endif; ?>
                                                                    <div>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" <?php if ($campaignObj['windowflg'] == 1): ?>checked="checked"<?php endif; ?> value="1" name="windowFlg" id="radioOpenOther" /><span class="fRadioAssist"><?= $campaignWindowFlags[1] ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" <?php if ($campaignObj['windowflg'] == 2): ?>checked="checked"<?php endif; ?> value="2" name="windowFlg" id="radioOpenSame"/><span class="fRadioAssist"><?= $campaignWindowFlags[2] ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <input name="filePath1" class="txtbox" onblur="toggleColor(this)" onfocus="toggleColor(this)" onkeydown="ignoreESC(this, event.keyCode)" style="width:200px;" value="<?= $campaignObj['file_path1'] ?>"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="BtnArea">
                                                            <div class="BtnAreaitem">
                                                                <input id="toggleSubmit" type="submit" class="btnNormal_xbig" title="書き込み内容をよく確認してから登録する" value="書き込み内容をよく確認してから登録する" name="action_topics_update" />
                                                                <input type="hidden" name="topicsSeq" value="<?= $campaignObj['topicsseq'] ?>"/>
                                                                <input type="hidden" name="categoryId" value="<?= $campaignObj['categoryid'] ?>"/>
                                                                <input type="hidden" name="filePath2" value="<?= $campaignObj['file_path2'] ?>"/>
                                                            </div>
                                                            <div class="BtnAreaitem">
                                                                <input type="button" class="btnNormal_big" title="戻る" value="戻る" name="return" onclick="history.back();"/>
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
