<div id="footer">
<?php if ($UserData) : ?>
    <p class="space_4 Centering"><?php echo h($this->Header->getUsername()); ?>さん</p>
    <div class="buttonLogout"><a class="button logoutButton" type="button" href="/iphone/logout.html?<?= $cashe ?>" target="_self">ログアウト</a></div>
<?php endif; ?>
    <ul id="footerMenu">
        <li><a href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?= $siteSetting['InfoPolicyName'] ?></a></li>
        <br />
        <li><a href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?= $siteSetting['PolicyName'] ?></a></li>
    </ul>
    <div id="switchView">
        <?php if ($UserData) : ?>
        <a href="/index.html" target="_blank"><img src="/contents/iphone/tcom/images/icon_pc.png" />パソコン版で表示する</a>
        <?php else : ?>
        <a href="/login.html" target="_blank"><img src="/contents/iphone/tcom/images/icon_pc.png" />パソコン版で表示する</a>
        <?php endif; ?>
    </div>
    <div id="footerBottom">
        <div id="logo"><img src="/contents/iphone/tcom/images/logo.png"></div>
        <address>(c) TOKAI Communications Corporation All rights reserved.</address>
    </div>
</div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
