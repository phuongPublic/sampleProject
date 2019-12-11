<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if (isset($deviceTypeId)) { ?>
    <title><?php echo $this->Header->getTitleStr($menu_now_flg) ?>｜TNCポケット</title>
<?php } else { ?>
    <title>TNCポケット</title>
<?php } ?>
<?php // Javascript ?>
<script type="text/javascript" src="/contents/js/jquery-3.1.1.min.js"></script>
<?php
    if (!isset($deviceTypeId)) {
        $deviceTypeId = $this->Common->getDeviceType();
    }
?>
<?php if ($deviceTypeId == 1) : ?>
<script type="text/javascript" src="/contents/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/contents/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/contents/js/styleswitcher.js"></script>
<script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
<script type="text/javascript" src="/contents/js/Lytebox/lytebox.js"></script>
<script type="text/javascript" src="/contents/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/contents/js/jquery.validate.min.js"></script>
<?php elseif ($deviceTypeId == 3) : ?>
<script type="text/javascript" src="/contents/android/js/avoid.go.button.js"></script>
<script type="text/javascript" src="/contents/android/tnc/iui/iui.js"></script>
<script type="text/javascript" src="/contents/android/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/contents/android/js/jquery.scrollfollow.js"></script>
<script type="text/javascript" src="/contents/android/js/uploadbutton.js"></script>
<?php elseif ($deviceTypeId == 2) : ?>
<script type="text/javascript" src="/contents/iphone/js/avoid.go.button.js"></script>
<script type="text/javascript" src="/contents/iphone/tnc/iui/iui.js"></script>
<script type="text/javascript" src="/contents/iphone/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/contents/iphone/js/jquery.scrollfollow.js"></script>
<script type="text/javascript" src="/contents/iphone/js/uploadbutton.js"></script>
<?php endif;?>

<?php // css ?>
<?php if ($deviceTypeId == 1) : ?>
<link type="text/css" rel="stylesheet" href="/contents/js/yui/reset/reset.css" />
<link type="text/css" id="blue" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/common_blue.css?c=new" disabled="true"/>
<link type="text/css" id="pink" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/common_pink.css?c=new" disabled="true"/>
<link type="text/css" id="gray" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/common_gray.css?c=new" disabled="true"/>
<link type="text/css" id="orange" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/common_orange.css?c=new" disabled="true"/>
<link type="text/css" id="white" rel="stylesheet" media="screen" title="green" href="/contents/css/tnc/common_white.css?c=new" disabled="true"/>
<link type="text/css" id="none" rel="stylesheet" href="/contents/css/tnc/common.css?c=new" />
<link type="text/css" id="green" rel="stylesheet" href="/contents/css/tnc/common.css?c=new" />
<link type="text/css" rel="stylesheet" href="/contents/js/yui/container/assets/container.css" />
<link type="text/css" rel="stylesheet" href="/contents/js/yui/fonts/fonts-min.css" />
<link type="text/css" rel="stylesheet" href="/contents/js/Lytebox/lytebox.css" />
<?php elseif ($deviceTypeId == 3) : ?>
<link type="text/css" rel="stylesheet" href="/contents/android/tnc/iui/iui.css" />
<link type="text/css" rel="stylesheet" href="/contents/android/tnc/css/common.css" />
<?php elseif ($deviceTypeId == 2) : ?>
<link type="text/css" rel="stylesheet" href="/contents/iphone/tnc/iui/iui.css" />
<link type="text/css" rel="stylesheet" href="/contents/iphone/tnc/css/common.css" />
<?php endif;?>