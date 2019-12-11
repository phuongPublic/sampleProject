<div id="footer">
    <ul id="footerMenu">
        <li><a href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?php echo $siteSetting['InfoPolicyName'] ?></a></li>
        <br />
        <li><a href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?php echo $siteSetting['PolicyName']; ?></a></li>
    </ul>
    <div id="footerBottom">
        <div id="logo"><img src="/contents/android/tcom/images/logo.png"></div>
        <address>(c) TOKAI Communications Corporation All rights reserved.</address>
    </div>
</div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
