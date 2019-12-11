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
        function yearChange(id) {
            location.href = "/admin/ad/list.html?selectYear=" + id;
        }

        function alertMessage(id, year, sort) {
            msg = "選択した広告を削除しますが、よろしいですか？";
            flg = window.confirm(msg);
            if (flg) {
                location.href = "/admin/ad/list.html?adseq=" + id + "&selectYear=" + year + "&sort=" + sort;
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
                        <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>広告一覧</span></div>
                    </div>
                    <div id="wrap">
                        <table cellpadding="0" cellspacing="0" border="0" id="contents">
                            <tr>
                                <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                <td id="main"><div class="mainBox">
                                    <div class="titlebarMain_bg">
                                        <h2 class="titlebarMain_icon">広告一覧</h2>
                                    </div>
                                    <p class="mBoxitem_txt">登録済みの広告の一覧です。<br />
                                    名前をクリックすることで表示内容を確認することができます。<br />
                                    また、[編集]ボタンで記事の編集、[削除］ボタンで記事の削除が可能です。</p>
                                    <p class="mBoxitem_txt txtWarning">
                                        <?php
                                            if (!empty($message)) {
                                                echo $message;
                                            }
                                        ?>
                                    </p>
                                    <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                    <div class="mBoxitem_table">
                                        <form action="">
                                            <div class="mBoxitem_listinfo">
                                                <div class="fAssist_row">
                                                    <?=
                                                    $this->Form->select('selectYear', $yearOption, [
                                                        'empty' => false,
                                                        'id' => 'selectYear',
                                                        'onchange' => 'yearChange(this.value)',
                                                        'value' => $selectYear,
                                                        'id' => 'selectYear'
                                                    ]);
                                                    ?>
                                                    <span class="fSelectAssist"></span>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </div>
                                            <table cellspacing="0" cellpadding="0" border="0" class="tableYoko">
                                                <tr class="trYoko">
                                                    <th class="thYokoM"><a href="/admin/ad/list.html?selectYear=<?= $selectYear ?>&sort=<?= $sortStatus ?>">ステータス</a></th>
                                                    <th class="thYokoMPlus">公開日時・公開終了日時</th>
                                                    <th>名前</th>
                                                    <th class="thYokoXS">サイト</th>
                                                    <th class="thYokoM">表示位置</th>
                                                    <th>操作</th>
                                                </tr>
                                                <?php foreach ($adList as $key => $adData) : ?>
                                                <tr class="<?php if ($key%2 == 0) : ?>colorOdd<?php else : ?>colorEven<?php endif; ?>" >
                                                    <td>
                                                        <?= $viewFlags[$adData['viewflg']] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($adData['viewflg'] != Configure::read('Common.AdminModule.ViewFlag.Draft')) : ?>
                                                            <?= $adData['opendata']->i18nFormat('MM月dd日 HH:mm'); ?>
                                                        <?php endif; ?>
                                                        ・<br />
                                                        <?php if ($adData['timerflg'] == 1) : ?>
                                                            <?= $adData['timerdata']->i18nFormat('MM月dd日 HH:mm'); ?>
                                                        <?php else : ?>
                                                            指定無
                                                        <?php endif;?>
                                                    </td>
                                                    <td>
                                                        <?php if ($adData['pos_flg'] == 3) : ?>
                                                        <a href="/admin/ad/logoutpreview.html?adseq=<?= $adData['adseq'] ?>" target="_blank"><?= h($adData['title']) ?></a>
                                                        <?php else : ?>
                                                        <a href="/admin/ad/preview.html?adseq=<?= $adData['adseq'] ?>" target="_blank"><?= h($adData['title']) ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        PC
                                                    </td>
                                                    <td>
                                                        <?php if ($adData['pos_flg'] == 1) : ?>
                                                            ヘッダー
                                                        <?php elseif ($adData['pos_flg'] == 2) : ?>
                                                            コンテンツ内1
                                                        <?php elseif ($adData['pos_flg'] == 3) : ?>
                                                            コンテンツ内2
                                                        <?php elseif ($adData['pos_flg'] == 4) : ?>
                                                            コンテンツ内3
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="tdYoko_btn_s2">
                                                      <input type="button" class="btnTable_small" value="編集" onclick="location.href='/admin/ad/update.html?adseq=<?= $adData['adseq'] ?>&selectYear=<?= $selectYear ?>&sort=<?= $sort ?>'" />
                                                      <input type="button" class="btnTable_small" value="削除" onclick="alertMessage('<?= $adData['adseq'] ?>', '<?= $selectYear ?>', '<?= $sort ?>')" /></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </table>
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
    <?= $this->element($this->Common->getIsp() . '/admin/footer'); ?>
</div>
</body>
</html>