<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
    </head>
    <body>
        <div id="AllWidth">
            <?= $this->element($this->Common->getIsp() . '/admin/header') ?>
            <div id="BackgroundLeft_repeat">
                <div id="BackgroundRight_repeat">
                    <div id="BackgroundLeft">
                        <div id="BackgroundRight">
                            <div id="siteNavi">
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span>会員検索</span></div>
                            </div>
                            <div id="wrap">
                                <form name="form1" id='form' action="/admin/user/search.html" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                        <tr>
                                            <td id="side">
                                                <?= $this->element('/admin/menu') ?>
                                            </td>
                                            <td id="main">
                                                <div class="mainBox">
                                                    <div class="titlebarMain_bg">
                                                        <h2 class="titlebarMain_icon">会員検索</h2>
                                                    </div>
                                                    <p class="mBoxitem_txt">会員情報を検索します。検索条件を選択・入力して、[検索]ボタンをクリックしてください。
                                                        <br /> ※全てのユーザーを一覧を表示する場合は、未入力のまま検索ボタンを押してください。
                                                    </p>
                                                    <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                    <div class="mBoxitem_table">
                                                        <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                                                            <tr>
                                                                <th>会員区分</th>
                                                                <td>
                                                                    <div class="fAssist_row">
                                                                        <?=
                                                                        $this->Form->select(
                                                                            'searchType',
                                                                            Configure::read('Common.AdminModule.AdminUser.SearchType'),
                                                                            [
                                                                            'class' => 'fSelectBig',
                                                                            'default' => (isset($searchInfo['searchType']))? $searchInfo['searchType'] : 1
                                                                            ]
                                                                        );
                                                                        ?>
                                                                    </div>
                                                                    <div class="fAssist_row">
                                                                        <input type="text" class="txtbox" style="width:200px;" onkeydown="ignoreESC(this, event.keyCode)" onfocus="toggleColor(this)" onblur="toggleColor(this)" name="searchKeyword" value="<?= (isset($searchInfo['searchKeyword'])) ? $searchInfo['searchKeyword'] : '' ?>" />
                                                                    </div>
                                                                    <div class="fAssist_row">
                                                                        <span class="fCheckDATE">
                                                                            <label>
                                                                                <input type="checkbox" id="match_type_1" value="1" name="matchType" <?php if (isset($searchInfo['matchType'])&&($searchInfo['matchType'] == 1)) : ?>checked="checked"<?php endif; ?>/> 前方一致
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>ステータス</th>
                                                                <td>
                                                                    <?=
                                                                    $this->Form->select(
                                                                        'searchStatus',
                                                                        Configure::read('Common.AdminModule.AdminUser.SearchStatus'),
                                                                        [
                                                                        'class' => 'fSelectBig',
                                                                        'default' => (isset($searchInfo['searchStatus'])) ? $searchInfo['searchStatus'] : 0
                                                                        ]
                                                                    )
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>更新区分期間指定</th>
                                                                <td><span class="fTextAssist_left">更新区分：</span>
                                                                    <?=
                                                                    $this->Form->select(
                                                                        'searchClass',
                                                                        Configure::read('Common.AdminModule.AdminUser.SearchClass'),
                                                                        [
                                                                        'class' => 'fSelectBig selectBoxKubun',
                                                                        'default' => (isset($searchInfo['searchClass'])) ? $searchInfo['searchClass'] : 99
                                                                        ]
                                                                    )
                                                                    ?>
                                                                    <div class="fAssist_col"> <span class="fTextAssist_left">開始日時：</span>
                                                                        <?=
                                                                        $this->Form->year('searchStartTime', [
                                                                        'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                        'maxYear' => date('Y')+3,
                                                                        'value' => (isset($searchInfo['searchStartTime']['year'])) ? $searchInfo['searchStartTime']['year'] : date("Y"),
                                                                        'empty' => false,
                                                                        'orderYear' => 'asc'
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?=
                                                                        $this->Form->month('searchStartTime', [
                                                                        'monthNames' => false,
                                                                        'value' => (isset($searchInfo['searchStartTime']['month'])) ? $searchInfo['searchStartTime']['month'] : date("m"),
                                                                        'leadingZeroValue' => true,
                                                                        'empty' => false
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?=
                                                                        $this->Form->day('searchStartTime', [
                                                                        'leadingZeroValue' => true,
                                                                        'value' => (isset($searchInfo['searchStartTime']['day'])) ? $searchInfo['searchStartTime']['day'] : date("d"),
                                                                        'empty' => false
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?=
                                                                        $this->Form->hour('searchStartTime', [
                                                                        'leadingZeroValue' => true,
                                                                        'format' => 24,
                                                                        'empty' => false,
                                                                        'value' => (isset($searchInfo['searchStartTime']['hour'])) ? $searchInfo['searchStartTime']['hour'] : 0
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?=
                                                                        $this->Form->minute('searchStartTime', [
                                                                        'empty' => false,
                                                                        'value' => (isset($searchInfo['searchStartTime']['minute'])) ? $searchInfo['searchStartTime']['minute'] : 0
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span> </div>
                                                                    <div class="fAssist_col"> <span class="fTextAssist_left">終了日時：</span>
                                                                        <?=
                                                                        $this->Form->year('searchEndTime', [
                                                                        'minYear' => Configure::read('Common.AdminModule.Datetime.DefaultSelected.Year'),
                                                                        'maxYear' => date('Y')+3,
                                                                        'empty' => false,
                                                                        'value' => (isset($searchInfo['searchEndTime']['year'])) ? $searchInfo['searchEndTime']['year'] : date("Y"),
                                                                        'orderYear' => 'asc'
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">年</span>
                                                                        <?=
                                                                        $this->Form->month('searchEndTime', [
                                                                        'monthNames' => false,
                                                                        'leadingZeroValue' => true,
                                                                        'value' => (isset($searchInfo['searchEndTime']['month'])) ? $searchInfo['searchEndTime']['month'] : date("m"),
                                                                        'empty' => false
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">月</span>
                                                                        <?=
                                                                        $this->Form->day('searchEndTime', [
                                                                        'leadingZeroValue' => true,
                                                                        'value' => (isset($searchInfo['searchEndTime']['day'])) ? $searchInfo['searchEndTime']['day'] : date("d"),
                                                                        'empty' => false]);
                                                                        ?>
                                                                        <span class="fSelectAssist">日</span>
                                                                        <?=
                                                                        $this->Form->hour('searchEndTime', [
                                                                        'leadingZeroValue' => true,
                                                                        'format' => 24,
                                                                        'empty' => false,
                                                                        'value' => (isset($searchInfo['searchEndTime']['hour'])) ? $searchInfo['searchEndTime']['hour'] : 0
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">時</span>
                                                                        <?=
                                                                        $this->Form->minute('searchEndTime', [
                                                                        'empty' => false,
                                                                        'value' => (isset($searchInfo['searchEndTime']['minute'])) ? $searchInfo['searchEndTime']['minute'] : 0,
                                                                        ]);
                                                                        ?>
                                                                        <span class="fSelectAssist">分</span> </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="BtnArea">
                                                            <input type="submit" class="btnNormal_big" title="検索" value="検索" name="_search" />
                                                        </div>
                                                    </div>
                                                    <div class="mBoxitem_table">
                                                        <?php if (!empty($search_flg)) : ?>
                                                        <?php if ($search_count > 0) : ?>
                                                        <div class="mBoxitem_listinfo">
                                                            <div class="pageList_data"><strong>該当数：<?= $search_count ?>件</strong>
                                                                &nbsp;<a href="/admin/user/search.html?page=<?= $page ?>&type=csv">CSVダウンロード</a>
                                                            </div>
                                                        </div>
                                                        <div class="mBoxitem_listinfo">
                                                            <ul class="pageList_link">
                                                                <li>
                                                                    <?php if ($back) : ?>
                                                                    <a href="/admin/user/search.html?page=<?= $back-1 ?>">前のページへ≪</a>
                                                                    <?php else : ?>
                                                                    <span class="txtOff">前のページへ≪</span>
                                                                    <?php endif; ?>
                                                                </li>
                                                                <?php foreach ($linkNum as $item) : ?>
                                                                <li>
                                                                    <?php if ($page != $item) : ?>
                                                                    <a href="/admin/user/search.html?page=<?= $item-1 ?>"><?= $item ?></a>
                                                                    <?php else : ?>
                                                                    <strong><?= $item ?></strong>
                                                                    <?php endif; ?>
                                                                </li>
                                                                <?php endforeach; ?>
                                                                <li>
                                                                    <?php if ($next) : ?>
                                                                    <a href="/admin/user/search.html?page=<?= $next-1 ?>">≫次のページへ</a>
                                                                    <?php else : ?>
                                                                    <span class="txtOff">≫次のページへ</span>
                                                                    <?php endif; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <table cellpadding="0" cellspacing="0" border="0" class="tableYoko">
                                                            <tr class="trYoko">
                                                                <th>メールアドレス</th>
                                                                <th>POPID</th>
                                                                <th>ステータス</th>
                                                                <th>初回ログイン日 or 解約日</th>
                                                                <th>最終ログイン</th>
                                                                <th>使用量</th>
                                                            </tr>
                                                            <?php foreach ($user_array as $key => $list) : ?>
                                                            <tr class="<?php if ($key%2 == 0) : ?>colorEven<?php else : ?>colorOdd<?php endif; ?>">
                                                            <td>
                                                                <a href='/admin/user/detail.html?userSeq=<?= $list['user_seq'] ?>'>
                                                                    <?= h($list['user_address']) ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?= h($list['user_id']) ?>
                                                            </td>
                                                            <td>
                                                                <?= h($list['status']) ?>
                                                            </td>
                                                            <td>
                                                                <?= (!empty($list['up_date'])) ? $list['up_date']->i18nFormat('yyyy/MM/dd') :  date("Y/m/d")?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($list['log_date'])) : ?>
                                                                <?= $list['log_date']->i18nFormat('yyyy/MM/dd') ?><br><?= $list['log_date']->i18nFormat('HH:mm') ?>
                                                                <?php else : ?>
                                                                <?= '' ?>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?= $list['totalSize'] ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                    <div class="mBoxitem_listinfo">
                                                        <ul class="pageList_link">
                                                            <li>
                                                                <?php if ($back) : ?>
                                                                <a href="/admin/user/search.html?page=<?= $back-1 ?>">前のページへ≪</a>
                                                                <?php else : ?>
                                                                <span class="txtOff">前のページへ≪</span>
                                                                <?php endif; ?>
                                                            </li>
                                                            <?php foreach ($linkNum as $item) : ?>
                                                            <li>
                                                                <?php if ($page != $item) : ?>
                                                                <a href="/admin/user/search.html?page=<?= $item-1 ?>"><?= $item ?></a>
                                                                <?php else : ?>
                                                                <strong><?= $item ?></strong>
                                                                <?php endif; ?>
                                                            </li>
                                                            <?php endforeach; ?>
                                                            <li>
                                                                <?php if ($next) : ?>
                                                                <a href="/admin/user/search.html?page=<?= $next-1 ?>">≫次のページへ</a>
                                                                <?php else : ?>
                                                                <span class="txtOff">≫次のページへ</span>
                                                                <?php endif; ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <?php else : ?>
                                                    <div class="mBoxitem_table">
                                                        <div class="searchNoData">
                                                            <p class="txtWarning"><span class="iconNo">該当する会員情報が見つかりませんでした。</span></p>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
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