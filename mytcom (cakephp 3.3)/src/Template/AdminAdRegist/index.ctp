<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html xmlns="http:www.w3.org/1999/xhtml">
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script type="text/javascript">
            
            window.onload = function() {
                manageView();
            }

            function manageView() {
                changeView('<?= $adData['viewFlg'] ?>');
                changeTimerView('<?= $adData['timerFlg'] ?>');
            }

            function changeView(num) {
                if (num != 3) {
                    $(".startOpenDate").prop('disabled', true);
                } else {
                    $(".startOpenDate").prop('disabled', false);
                }
            }

            function changeTimerView(num){
                if (num == 2) {
                    $(".endOpenDate").prop('disabled', true);
                } else {
                    $(".endOpenDate").prop('disabled', false);
                }
            }
        </script>
    </head>
    <body>
        <div id="AllWidth">
            <?= $this->element($this->Common->getIsp() . '/admin/header') ?>
            <div id="BackgroundLeft_repeat">
                <div id="BackgroundRight_repeat">
                    <div id="BackgroundLeft">
                        <div id="BackgroundRight">
                            <div id="siteNavi">
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>広告の登録</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu') ?></td>
                                        <td id="main"><div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">広告の登録</h2>
                                                </div>
                                                <p class="mBoxitem_txt">広告を登録します。<br />
                                                    必要事項を入力し、[書き込み内容をよく確認してから投稿する]ボタンをクリックしてください。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <p class="mBoxitem_txt txtSub">※<span class="txtWarning">*</span>印のついている項目は、入力必須項目となります。</p>
                                                <div class="mBoxitem_table">
                                                    <form id="form" method="post" enctype="multipart/form-data" name="ad" action="">
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                                                            <tr>
                                                                <th>名前</th>
                                                                <td><p class="fTextAssist_top txtSub">一覧での参照用に名前をつけることができます。</p>
                                                                    <div class="txtWarning space_5">
                                                                        <?php if (isset($error['title'])) : ?>
                                                                            <?= array_values($error['title'])[0] ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <input type="text" name="title" class="txtbox" onblur="toggleColor(this)" onfocus="toggleColor(this)" onkeydown="ignoreESC(this,event.keyCode)" style="width:400px;" <?php if (isset($adData['title'])) : ?>value="<?= $adData['title'] ?>" <?php endif; ?>/>
                                                                    <p class="fTextAssist_bottom txtSub">※例）「GoogleAdSenseその1」「<?php if ($this->Common->getIsp() == "tcom") : ?>MY@TCOM<?php elseif ($this->Common->getIsp() == "tnc") : ?>TNCポケット<?php endif; ?>へのリンク」など<br />
                                                                        ※全角50文字以内</p></td>
                                                            </tr>
                                                            <tr>
                                                                <th>掲載サイト</th>
                                                                <td><div class="fAssist_row">
                                                                        <?=
                                                                            $this->Form->select(
                                                                                'pub_flg',
                                                                                Configure::read('Common.AdminModule.Advertisement.PubFlg'),
                                                                                [
                                                                                    'default' => 1,
                                                                                ]
                                                                            );
                                                                        ?>
                                                                    </div>
                                                                    <div class="fAssist_row"><a href="javascript:;" onclick="MM_openBrWindow('/admin/ad/help.html', '_blank', 'width=760, resizable=yes, scrollbars=yes')">※表示箇所について</a></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>表示位置</th>
                                                                <td>
                                                                    <p class="fTextAssist_top txtSub">広告を表示するスペースを選択してください。</p>
                                                                    <?=
                                                                        $this->Form->select(
                                                                            'pos_flg',
                                                                            Configure::read('Common.AdminModule.Advertisement.PosFlg'),
                                                                            [
                                                                                'class' => 'fSelectBig',
                                                                                'default' => isset($adData['pos_flg']) ? $adData['pos_flg'] : 1,
                                                                            ]
                                                                        );
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開日時</th>
                                                                <td><div class="txtWarning space_5">
                                                                        <?php if (isset($error['checkTime'])) : ?>
                                                                            <?= array_values($error['checkTime'])[0] . '<br>' ?>
                                                                        <?php endif; ?>
                                                                        <?php if (isset($error['openData'])) : ?>
                                                                            <?= array_values($error['openData'])[0] ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeView(this.value)" <?php if ($adData['viewFlg'] == Configure::read('Common.AdminModule.ViewFlag.Public')) : ?> checked="checked" <?php endif; ?> value="1" name="viewFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.ViewFlags.1'); ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeView(this.value)" <?php if ($adData['viewFlg'] == Configure::read('Common.AdminModule.ViewFlag.Draft')) : ?> checked="checked" <?php endif; ?> value="2" name="viewFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.ViewFlags.2'); ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeView(this.value)" <?php if ($adData['viewFlg'] == Configure::read('Common.AdminModule.ViewFlag.Reserve')) : ?> checked="checked" <?php endif; ?> value="3" name="viewFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.ViewFlags.3'); ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeView(this.value)" <?php if ($adData['viewFlg'] == Configure::read('Common.AdminModule.ViewFlag.FinishPublic')) : ?> checked="checked" <?php endif; ?> value="4" name="viewFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.ViewFlags.4'); ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?= $this->Form->year('openData', [
                                                                                'value' => !empty($adData['openData']) ? $adData['openData']->i18nFormat('YYYY') : date('Y'),
                                                                                'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                                'maxYear' => date('Y') + 3,
                                                                                'orderYear' => 'asc',
                                                                                'empty' => false,
                                                                                'class' => 'startOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?= $this->Form->month('openData', [
                                                                                'value' => !empty($adData['openData']) ? $adData['openData']->i18nFormat('MM') : date('M'),
                                                                                'empty' => false,
                                                                                'monthNames' => false,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'startOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?= $this->Form->day('openData', [
                                                                                'value' => !empty($adData['openData']) ? $adData['openData']->i18nFormat('dd') : date('d'),
                                                                                'empty' => false,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'startOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?= $this->Form->hour('openData', [
                                                                                'value' => !empty($adData['openData']) ? $adData['openData']->i18nFormat('HH') : date('H'),
                                                                                'empty' => false,
                                                                                'format' => 24,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'startOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?= $this->Form->minute('openData', [
                                                                                'value' => !empty($adData['openData']) ? $adData['openData']->i18nFormat('mm') : date('i'),
                                                                                'empty' => false,
                                                                                'class' => 'startOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>公開終了日時</th>
                                                                <td>
                                                                    <?php if (isset($error['timerData'])) : ?>
                                                                        <div class="txtWarning space_5">
                                                                            <?= array_values($error['timerData'])[0] ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeTimerView(this.value)" <?php if ($adData['timerFlg'] == Configure::read('Common.AdminModule.TimerFlag.Setting')) : ?> checked="checked" <?php endif; ?> value="1" name="timerFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.TimerFlags.1'); ?></span></label>
                                                                        <label class="fLabel"><input class="fRadio" type="radio" onclick="changeTimerView(this.value)" <?php if ($adData['timerFlg'] == Configure::read('Common.AdminModule.TimerFlag.NoSetting')) : ?> checked="checked" <?php endif; ?> value="2" name="timerFlg"/><span class="fRadioAssist"><?= Configure::read('Common.AdminModule.Advertisement.TimerFlags.2'); ?></span></label>
                                                                    </div>
                                                                    <div class="fAssist_col_line">
                                                                        <?= $this->Form->year('timerData', [
                                                                                'value' => !empty($adData['timerData']) ? $adData['timerData']->i18nFormat('YYYY') : date('Y'),
                                                                                'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                                'maxYear' => date('Y') + 3,
                                                                                'orderYear' => 'asc',
                                                                                'empty' => false,
                                                                                'class' => 'endOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?= $this->Form->month('timerData', [
                                                                                'value' => !empty($adData['timerData']) ? $adData['timerData']->i18nFormat('MM') : date('M'),
                                                                                'empty' => false,
                                                                                'monthNames' => false,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'endOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?= $this->Form->day('timerData', [
                                                                                'value' => !empty($adData['timerData']) ? $adData['timerData']->i18nFormat('dd') : date('d'),
                                                                                'empty' => false,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'endOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?= $this->Form->hour('timerData', [
                                                                                'value' => !empty($adData['timerData']) ? $adData['timerData']->i18nFormat('HH') : date('H'),
                                                                                'empty' => false,
                                                                                'format' => 24,
                                                                                'leadingZeroValue' => true,
                                                                                'class' => 'endOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?= $this->Form->minute('timerData', [
                                                                                'value' => !empty($adData['timerData']) ? $adData['timerData']->i18nFormat('mm') : date('i'),
                                                                                'empty' => false,
                                                                                'class' => 'endOpenDate'
                                                                            ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span>
                                                                    </div>
                                                                    <div class="fAssist_col_line txtSub">※予約した日時で公開を自動的に取り下げる場合に設定します。<br />
                                                                        今すぐ公開を終了する場合は公開日時の「公開終了」をチェックしてください。</div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>画像</th>
                                                                <td>
                                                                    <div class="txtWarning space_5">
                                                                        <?php if (isset($error['adImage'])) : ?>
                                                                            <?= array_values($error['adImage'])[0] ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <input type="file" class="fFile" name="adImage" size="60%" />
                                                                    <p class="fTextAssist_bottom txtSub">※通常のバナーリンクを設置する場合のみ登録してください。<br />
                                                                        ※アップロードできる画像形式はgif、jpg、pngとなります。</p></td>
                                                            </tr>
                                                            <tr>
                                                                <th>HTMLタグ<br />
                                                                    （URLリンク）&nbsp;<span class="txtWarning">*</span></th>
                                                                <td><p class="fTextAssist_top txtSub">HTMLタグかURLを入力してください。</p>
                                                                    <div class="txtWarning space_5">
                                                                        <?php if (isset($error['contents'])) : ?>
                                                                            <?= array_values($error['contents'])[0] ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <?= $this->Form->textarea('contents', [
                                                                        'value' => isset($adData['contents']) ? $adData['contents'] : '',
                                                                        'class' => 'txt_bigbox',
                                                                        'style' => 'height:200px; margin-bottom: -3px;',
                                                                        'onkeydown' => 'ignoreESC(this,event.keyCode)',
                                                                        'onfocus' => 'toggleColorBig(this)',
                                                                        'onblur' => 'toggleColorBig(this)',
                                                                        'rows' => '10', 'cols' => '']);
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="BtnArea">
                                                            <div class="BtnAreaitem">
                                                                <input type="submit" id="toggleSubmit" class="btnNormal_xbig" title="書き込み内容をよく確認してから登録する" value="書き込み内容をよく確認してから登録する" name="action_ads_regist" />
                                                            </div>
                                                            <div class="BtnAreaitem">
                                                                <input type="button" class="btnNormal_big" title="戻る" value="戻る" name="" onclick="history.back();"/>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div></td>
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
            <?= $this->element($this->Common->getIsp() . '/admin/footer') ?>
        </div>
    </body>
</html>
