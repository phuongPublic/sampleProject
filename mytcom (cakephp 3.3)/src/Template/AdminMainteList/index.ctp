<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
        <script>
            $(document).ready(function(){
                if ($("#selectYear").val() == 99) {
                    $(".fSelectAssist").html('');
                } else {
                    $(".fSelectAssist").html('年');
                }
            });
            function yearChange(Obj) {
                var year = Obj.value.toString();
                document.location = "?Year=" + year;
            }
            function deleteConfirm(date, mainte_id, mainte_year, sort) {
                if (confirm(date + "のメンテナンス画面を削除します。宜しいですか？")) {
                    location.href = "/admin/mainte/list.html?mainte_id=" + mainte_id + "&mainte_year=" + mainte_year + "&sort=" + sort;
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
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>過去のメンテナンス画面一覧</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side">
                                            <?= $this->element('/admin/menu'); ?>
                                        </td>
                                        <td id="main">
                                            <div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">過去のメンテナンス画面一覧</h2>
                                                </div>
                                                <p class="mBoxitem_txt">過去のメンテナンス画面の一覧です。<br />
                                                    [編集]ボタンで登録内容の編集、[削除］ボタンで削除が可能です。
                                                </p>
                                                <!-- 完了メッセージ -->
                                                <p class="mBoxitem_txt txtWarning">
                                                   <?php if (!empty($message)) {echo $message;} ?>
                                                </p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <div class="mBoxitem_table">
                                                    <form method="post" name="mainteForm" action="/admin/mainte/list.html">
                                                        <div class="mBoxitem_listinfo">
                                                            <div class="fAssist_row">
                                                                <?php
                                                                echo
                                                                $this->Form->select('mainte_year', $yearOption, [
                                                                    'empty' => [99 => '下書き'],
                                                                    'onchange' => 'yearChange(this)',
                                                                    'default' => $mainteYear,
                                                                    'id' => 'selectYear'
                                                                ]);
                                                                ?>
                                                                <span class="fSelectAssist"></span>
                                                            </div>
                                                            <div style="clear:both;"></div>
                                                        </div>
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableYoko">
                                                            <tr class="trYoko">
                                                                <th class="thYokoM" ><a href="?Year=<?php if(isset($mainteYear)) echo $mainteYear;?>&sort=<?=$orderChange?>" class="sort_colum">ステータス</a></th>
                                                                <th class="thYokoMPlus">公開日時・公開終了日時</th>
                                                                <th>内容</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            <?php $trBgcolor = 0; ?>
                                                            <?php foreach ($mainteArray as $mainte): ?>
                                                                <tr class="<?php if ($trBgcolor % 2 == 0): ?>colorOdd<?php else: ?>colorEven<?php endif ?>">
                                                                    <td><?= $adminMainteStatus[$mainte['mainte_status']] ?></td>
                                                                    <td><?= !empty($mainte["mainte_start_time"]) ? $mainte["mainte_start_time"]->i18nFormat("YYYY/MM/dd HH:mm") : ''; ?>・<br />
                                                                        <?= ($mainte["mainte_end_flg"] == 1) ? $mainte["mainte_end_time"]->i18nFormat("YYYY/MM/dd HH:mm") : '指定無'; ?>
                                                                    </td>
                                                                    <td><?= h($mainte["mainte_body"]) ?></td>
                                                                    <td class="tdYoko_btn_s2"><input class="btnTable_small" type="button" title="編集" value="編集" onclick="document.location = 'update.html?mainte_id=<?= $mainte['mainte_id'] ?>&mainte_year=<?= $mainteYear ?>&sort=<?= $order ?>'" />
                                                                        <input class="btnTable_small" type="button" title="削除" value="削除" onclick="deleteConfirm('<?= date("Y年m月d日 H:i", strtotime($mainte["mainte_start_time"])) ?>', '<?= $mainte['mainte_id'] ?>', '<?= $mainteYear ?>', '<?= $order ?>')" />
                                                                    </td>
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
