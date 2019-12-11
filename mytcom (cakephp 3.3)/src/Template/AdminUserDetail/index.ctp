<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('/admin/HtmlHeaderAdmin'); ?>
    </head>
    <body>
        <div id="AllWidth">
            <?= $this->element($this->Common->getIsp() . '/admin/header'); ?>
            <div id="BackgroundLeft_repeat">
                <div id="BackgroundRight_repeat">
                    <div id="BackgroundLeft">
                        <div id="BackgroundRight">
                            <div id="siteNavi">
                                <div id="topicPath"><span><a href="/admin/index.html">トップ</a></span>&nbsp;&gt;&nbsp;<span><a href="/admin/user/search.html">会員検索</a></span>&nbsp;&gt;&nbsp;<span>会員情報詳細</span></div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?= $this->element('/admin/menu'); ?></td>
                                        <td id="main"><div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">会員情報詳細</h2>
                                                </div>
                                                <p class="mBoxitem_txt">会員の詳細情報を表示します。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
                                                <div class="mBoxitem_table">
                                                    <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableTateForAdminUserDetail">
                                                        <tr>
                                                            <th>メールアドレス</th>
                                                                <td><?= (isset($userData['user_address'])) ? h($userData['user_address']) : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>POPID</th>
                                                            <td><?= (isset($userData['user_id'])) ? h($userData['user_id']) : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>パスワード</th>
                                                            <td><?= (isset($userData['user_password'])) ? h($userData['user_password']) : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>ニックネーム</th>
                                                            <td><?= (isset($userData['user_name'])) ? h($userData['user_name']) : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>ステータス</th>
                                                            <td>
                                                                <?= (isset($userData['status'])) ? h($userData['status']) : '' ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>初回ログイン日 or 解約日</th>
                                                            <td><?= (!empty($userData['up_date'])) ? $userData['up_date']->i18nFormat('YYYY/MM/dd') : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>最終ログイン</th>
                                                            <td>
                                                                <?php if (empty($userData['log_date'])) : ?>
                                                                    -
                                                                <?php else : ?>
                                                                    <?= $userData['log_date']->i18nFormat('yyyy/MM/dd HH:mm') ?>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>使用量</th>
                                                            <td><?= (isset($userData['totalSize'])) ? $userData['totalSize'] : '0B' ?>
                                                                (ファイル：<?= (isset($userData['fileAllSize'])) ? $userData['fileAllSize'] : '0B' ?>&nbsp;
                                                                 アルバム：<?= (isset($userData['picAllSize'])) ? $userData['picAllSize'] : '0B' ?>&nbsp;
                                                                 動画：<?= (isset($userData['movieAllSize'])) ? $userData['movieAllSize'] : '0B' ?>)
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="BtnArea"><input type="button" class="btnNormal_big" title="戻る" value="戻る" name="" onclick="history.back();"/></div>
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