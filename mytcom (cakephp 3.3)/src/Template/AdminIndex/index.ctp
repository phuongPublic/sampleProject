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
            <?php echo $this->element($this->Common->getIsp() . '/admin/header'); ?>
            <div id="BackgroundLeft_repeat">
                <div id="BackgroundRight_repeat">
                    <div id="BackgroundLeft">
                        <div id="BackgroundRight">
                            <div id="siteNavi">
                                <div id="topicPath"><span>トップ</span>&nbsp;</div>
                            </div>
                            <div id="wrap">
                                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                                    <tr>
                                        <td id="side"><?php echo $this->element('/admin/menu'); ?></td>
                                        <td id="main"><div class="mainBox">
                                                <div class="titlebarMain_bg">
                                                    <h2 class="titlebarMain_icon">管理者画面TOP</h2>
                                                </div>
                                                <p class="mBoxitem_txt"><?php echo Configure::read('IspName');?>の管理者用ページです。<br />
                                                    左のメニューから機能を選択してください。</p>
                                                <div class="mBoxitem_txt lineDotted">&nbsp;</div>
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
            <?php echo $this->element($this->Common->getIsp() . '/admin/footer'); ?>
        </div>
    </body>
</html>