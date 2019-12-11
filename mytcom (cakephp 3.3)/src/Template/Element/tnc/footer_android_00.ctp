<div id="footer">
<?php if ($UserData) : ?>
    <p class="space_4 Centering"><?php echo h($this->Header->getUsername()); ?>さん</p>
    <div class="buttonLogout"><a class="button logoutButton" type="button" href="/android/logout.html?<?= $cashe ?>" target="_self">ログアウト</a></div>
<?php endif; ?>
    <ul id="footerMenu">
        <li><a href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?= $siteSetting['InfoPolicyName'] ?></a></li>
        <br />
        <li><a href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?= $siteSetting['PolicyName'] ?></a></li>
    </ul>
    <div id="footerBottom">
        <div id="logo"><img src="/contents/android/tnc/images/logo.png"></div>
        <address>(c) TOKAI Communications Corporation All rights reserved.</address>
    </div> 
</div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>