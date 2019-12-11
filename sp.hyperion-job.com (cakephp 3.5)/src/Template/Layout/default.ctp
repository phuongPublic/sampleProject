<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>hyperion-job</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/common/bootstrap.css"/>
    <link rel="stylesheet"  href="css/font-awesome.css" />
    <!--<link rel="stylesheet" href="css/common/jquery.mobile-1.4.5.min.css">-->
    <link rel="stylesheet" href="css/common/common.css"/>
    <link href="css/bootstrap-toggle.css" rel="stylesheet">
    <link href="css/common/util.css" rel="stylesheet">

    <script type="text/javascript" src="js/common/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/common/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common/Jscommon.js"></script>
    <script src="js/common/bootstrap-toggle.js"></script>
    <!--<script src="js/jquery/jquery.mobile-1.4.5.min.js"></script>-->
</head>
<body>

<div class="container">
    <div class="row">
        <nav id="navigation" class="navbar navbar-fixed-top " role="">
            <div class="logo">
                <i>
                    <a href="/"><img style="height: 42px;margin-top: 5px" src="img/common_img/icon/Hyperion.png"  /></a>
                </i>
                    <span class="float-r m-r-70 m-t-7">
                        <input type="checkbox" id="lang-btn" <?php if($lang == 'vn'): ?>checked<?php endif; ?> data-toggle="toggle" data-on="JP" data-off="VN" data-onstyle="success" data-offstyle="danger">
                    </span>

            <div class="main-nav">
                <a class="hamburger-nav"></a>
                <ul class="menu m-t-19">
                    <!--<a href="#home"><li><i class="fa fa-home"></i> Home</li></a>-->
                    <!--<a href="#about"><li><i class="fa fa-user"></i>&nbsp;<?= Configure::read('Common.about_us.'.$lang) ?></li></a>-->
                    <!--<a href="#contact"><li><i class="fa fa-envelope"></i>&nbsp;<?= Configure::read('Common.contact.'.$lang) ?></li></a>-->
                    <?php if(!isset($userData)) : ?>
                        <a href="/regist"><li><i class="fa fa-file-image-o text-black" ></i>&nbsp;<?= Configure::read('Common.regist.'.$lang) ?></li></a>
                        <a href="/login"><li><i class="fa fa-sign-in text-black"></i>&nbsp;<?= Configure::read('Common.login.'.$lang) ?></li></a>
                    <?php else : ?>
                        <a href="/MyPage"><li><i class="fa fa-user text-black"></i>&nbsp;<?= Configure::read('Common.mypage.'.$lang) ?></li></a>
                        <a href="/MyJob"><li><i class="fa fa-vcard text-black"></i>&nbsp;<?= Configure::read('Common.myjob.'.$lang) ?></li></a>
                        <a href="/Logout"><li><i class="fa fa-sign-out text-black"></i>&nbsp;<?= Configure::read('Common.logout.'.$lang) ?></li></a>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<?= $this->fetch('content') ?>

<footer>
    <div class="container footer-container">
        <div class="row">
            <div class="col-xs-12">
                <li class="footer-main-logo">
                    <img src="img/common_img/logo/HyperionLogo.png">
                </li>
            </div>
            <div class="col-xs-12 footer-contact">
                <p class="font-design-lg footer-contact-place-title">
                    <b class="font-fooder-title"><?= Configure::read('Common.address.'.$lang) ?></b>
                    <img src="img/common_img/icon/icon_place.png" alt=""/>
                </p>
                <img class="img-responsive" src="img/common_img/icon/dotted-line-white-med.png" alt=""/>
                <p class="footer-contact-place-detail lead"><?= Configure::read('Common.country_vn.'.$lang) ?></p>
                <p class="footer-contact-place-detail lead m-l-20"><?= Configure::read('Common.address_info.'.$lang) ?></p>
                <p class="footer-contact-place-detail lead"><?= Configure::read('Common.country_jp.'.$lang) ?></p>
                <p class="footer-contact-place-detail lead m-l-20"><?= Configure::read('Common.address_info_jp.'.$lang) ?></p>
                <p class="font-design-lg contact-title-color">
                    <b class="font-fooder-title"><?= Configure::read('Common.connect.'.$lang) ?></b>
                    <img src="img/common_img/icon/connect_icon.png" alt=""/>
                </p>
                <img class="img-responsive" src="img/common_img/icon/dotted-line-white-med.png" alt=""/>

            </div>
            <div class="col-xs-12 ol-xs-offset-1 footer-contact-icon">
                <a href="https://www.facebook.com/hyperionjobvn/" target="_blank">
                    <img src="img/common_img/icon/facebook_icon.png" alt="Facebook"/>
                </a>
                <a href="https://www.facebook.com/hyperionjobvn/" target="_blank">
                    <img src="img/common_img/icon/yotube_icon.png" alt="Facebook"/>
                </a>
                <a href="https://www.facebook.com/hyperionjobvn/" target="_blank">
                    <img src="img/common_img/icon/twitter_icon.png" alt="Facebook"/>
                </a>
                <a href="https://www.facebook.com/hyperionjobvn/" target="_blank">
                    <img src="img/common_img/icon/linkedin_icon.png" alt="Facebook"/>
                </a>
            </div>
            <div class="col-xs-12 footer-contact-icon">
                <p class="lead-phone"><?= Configure::read('Common.country_jp.'.$lang) ?></p>
                <a href="tel:81359573475" data-icon="phone" data-role="button">
                    <img src="img/common_img/icon/tel_full_jp.png" alt="Facebook"/>
                </a>
            </div>
            <div class="col-xs-12 footer-contact-icon">
                <p class="lead-phone"><?= Configure::read('Common.country_vn.'.$lang) ?></p>
                <a href="tel:84902297658" data-icon="phone" data-role="button">
                    <img src="img/common_img/icon/tel_full.png" alt="Facebook"/>
                </a>
            </div>
            <div class="col-xs-12 footer-contact-icon">
                <p class="lead-phone"><?= Configure::read('Common.email.'.$lang) ?></p>
                <i>
                    <img src="img/common_img/icon/mail_full.png" alt="Facebook"/>
                </i>
            </div>
            <div class="col-xs-12 col-xs-offset-1 footer-contact-relation">
                <div class="col-xs-6  ">
                    <a href="https://pharmapremium.jp/" target="_blank">
                        <img class="img-responsive" src="img/common_img/logo/logo-pharmapremium.png" alt="Pharma premium"/>
                    </a>
                </div>
                <div class="col-xs-6  ">
                    <a href="https://matebank.jp/" target="_blank">
                        <img class="img-responsive" src="img/common_img/logo/logo-matebank.png" alt="Matebank"/>
                    </a>
                </div>
                <div class="col-xs-6 col-xs-offset-3 footer-contact-relation-logo">
                    <a href="http://www.hyperion-job.jp/" target="_blank">
                        <img class="img-responsive" src="img/common_img/logo/logo-hyperionjob.png" alt="Hyperion job"/>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 copyright-style">
                <p class="lead">Copyright © Hyperion All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
