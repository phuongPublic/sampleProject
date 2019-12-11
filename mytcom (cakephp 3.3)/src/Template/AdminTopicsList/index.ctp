<?php

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($("#selectYear").val() == 99) {
                    $(".fSelectAssist").html('');
                } else {
                    $(".fSelectAssist").html('年');
                }
            });
            function yearChange(year) {
                location.href = "/admin/topics/list.html?selectYear=" + year;
            }
            function alertMessage(topicId, selectYear, categoryId, sort) {
                msg = "選択したお知らせを削除しますが、よろしいですか？";
                if (confirm(msg)) {
                    location.href = "/admin/topics/list.html?topicsSeq=" + topicId + "&selectYear=" + selectYear + "&categoryId=" + categoryId + "&sort=" + sort;
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
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>お知らせ一覧</span></div>
                            </div>
                            <div id="wrap">
                                <table id="contents" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td id="side">
                                                <?= $this->element('/admin/menu'); ?>
                                            </td>
                                            <td id="main">
                                                <div class="mainBox">
                                                    <div class="titlebarMain_bg">
                                                        <h2 class="titlebarMain_icon">お知らせ一覧</h2>
                                                    </div>
                                                    <p class="mBoxitem_txt">
                                                        登録済みの記事の一覧です。<br>
                                                        [編集]ボタンで記事の編集、[削除］ボタンで記事の削除が可能です。
                                                    </p>
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
                                                        <?= $this->Form->create('AdminTopicsList', array('url' => '/admin/topics/list.html', 'type' => 'GET')); ?>
                                                        <div class="mBoxitem_listinfo">
                                                            <div class="fAssist_row">
                                                                <?php
                                                                echo $this->Form->select('selectYear', $minYear, [
                                                                    'empty' => false,
                                                                    'default' => $selectYear,
                                                                    'id' => 'selectYear'
                                                                ]);
                                                                ?>
                                                                <span class="fSelectAssist"></span>
                                                            </div>
                                                            <div class="fAssist_row">
                                                                <?=
                                                                $this->Form->input('categoryId', ['type' => 'select', 'options' => $topicsCategory, 'value' => $categoryId, 'label' => false]);
                                                                ?>
                                                            </div>
                                                            <div class="fAssist_row" style="width:100px;">
                                                                <input type="submit" class="btnTable_middle" name="search" title="一覧表示" value="一覧表示" />
                                                            </div>
                                                            <div style="clear: both;"></div>
                                                        </div>
                                                        <table class="tableYoko" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr class="trYoko">
                                                                    <th class="thYokoM"><a href="/admin/topics/list.html?selectYear=<?= $selectYear; ?>&amp;categoryId=<?= $categoryId; ?>&amp;sort=<?= $sortChange ?>">ステータス</a></th>
                                                                    <th class="thYokoMPlus">公開日時・公開終了日時</th>
                                                                    <th>タイトル</th>
                                                                    <th>操作</th>
                                                                </tr>
                                                                <?php $trBgcolor = 0; ?>
                                                                <?php foreach ($topicsList as $topic) { ?>
                                                                <tr class="<?php
                                                                    if ($trBgcolor % 2 == 0) {
                                                                        echo 'colorOdd';
                                                                    } else {
                                                                        echo 'colorEven';
                                                                    }
                                                                    ?>">
                                                                    <td><?= $viewFlg[$topic['viewflg']]; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($topic['dateviewflg'] == 2) {
                                                                            echo '日付非表示' . '<br />';
                                                                        }
                                                                        ?>
                                                                        <?php if($topic['viewflg'] != Configure::read('Common.AdminModule.ViewFlag.Draft')) { ?>
                                                                            <?= $topic['opendata']->i18nFormat('MM月dd日 HH:mm') ?>
                                                                        <?php } ?>
                                                                        ・<br />
                                                                        <?php if ($topic['timerflg'] == Configure::read('Common.AdminModule.TimerFlag.Setting') || $topic['timerflg'] == Configure::read('Common.AdminModule.TimerFlag.HideTop')): ?>
                                                                            <?= $topic["timerdata"]->i18nFormat('MM月dd日 HH:mm') ?>
                                                                        <?php else: ?>
                                                                        指定無
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td><?= h($topic['title']); ?></td>
                                                                    <td class="tdYoko_btn_s2">
                                                                        <input type="button" class="btnTable_small" value="編集" onclick="location.href = '/admin/topics/update.html?topicsSeq=<?= $topic['topicsseq']; ?>&selectYear=<?= $selectYear ?>&categoryId=<?= $categoryId ?>&sort=<?= $sort ?>'">
                                                                        <input type="button" class="btnTable_small" value="削除" onclick="alertMessage(<?= $topic['topicsseq'] ?>, <?= $selectYear ?>, <?= $categoryId ?>, <?= ($sort != 0) ? $sort : 0 ?>)">
                                                                    </td>
                                                                </tr>
                                                                    <?php $trBgcolor = $trBgcolor + 1; ?>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->Form->end(); ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
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