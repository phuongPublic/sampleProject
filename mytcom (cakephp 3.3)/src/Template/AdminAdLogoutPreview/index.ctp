<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>広告バナープレビュー画面</title>
    <link rel="stylesheet" type="text/css" href="/contents/js/yui/fonts/fonts-min.css" />
    <link href="/contents/css/<?= $this->Common->getIsp()?>/open_common.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="header">
        <div class="container">
            <div id="logo"><img src="/contents/images/<?= $this->Common->getIsp(); ?>/logo.gif" alt="" /></div>
            <div id="login"><p><a href="#" ><?= Configure::read('IspLogin');?></a>｜<a href="#" >会員サポート</a>｜<a href="#" >ヘルプ</a></p></div>
            <br />
            <br class="clear" />
        </div>
    </div>
    <div id="OpneContents" style="margin-bottom:70px;">
        <div class="container">
            <h1 class="pagettl">ログアウト</h1>
            <div class="padArea" style="margin-top:45px;">
                <h1 class="txtCneter">正常にログアウトが完了しました。</h1>
                <br />
                <br />
            </div>
            <?php if (isset($adData) && $adData['pos_flg'] == 3) : ?>
                <div class="adContents3">
                <?php if ($adData['file_path'] != "") : ?>
                <a href="<?= h($adData['contents']) ?>" /><img src="<?= $adData['file_path'] ?>" /></a>
                <?php else : ?>
                    <?= h($adData['contents']) ?>
                <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?= $this->element($this->Common->getIsp() . '/admin/footer_00_open'); ?>
</body>
</html>