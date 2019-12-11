<!DOCTYPE html>
<html>
<head>
	<?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
	<script type="text/javascript">
        // In case of smartphone, redirect to Home screen
        var pathname = window.location.pathname;
        if (pathname.indexOf("Android") >= 0 || pathname.indexOf("android") >= 0) {
            window.location.replace("/android/index.html");
        } else if (pathname.indexOf("Iphone") >= 0 || pathname.indexOf("iphone") >= 0) {
            window.location.replace("/iphone/index.html");
        }

        function openLinkNewTab() {
            if (confirm('Webmailへ移動しますが、よろしいですか？')) {
                var urlJump = "/external/webmail.html?<?= $cashe ?>";
                window.open(urlJump, "_blank");
            }
        }

        var isMSIE = /*@cc_on!@*/false;
        var cookie = $.cookie("style");
        var title = cookie;
        if(title == 'undefined') title = '';
        setActiveStyleSheet(title);
        var color_cookie = $.cookie('color_style');
        if (!color_cookie) {
            color_cookie = 'blue';
        }
        jstyle(color_cookie);
        function fontSizeS(targetName) {
            if ($('#Z')) { //無い場合
                setActiveStyleSheet('fontS');
                return false;
            } else {
                setActiveStyleSheet('fontS');
                newZ.setActiveStyleSheet('fontS');
                return false;
            }
        }
        function fontSizeM(targetName) {
            if ($('#Z')) { //無い場合
                setActiveStyleSheet('');
                createCookie("style", '', 365);
                return false;
            } else {
                setActiveStyleSheet('');
                newZ.setActiveStyleSheet('');
                createCookie("style", '', 365);
                return false;
            }
        }
        function fontSizeL(targetName) {
            if ($('#Z')) { //無い場合
                setActiveStyleSheet('fontL');
                return false;
            } else {
                setActiveStyleSheet('fontL');
                newZ.setActiveStyleSheet('fontL');
                return false;
            }
        }
        function jstyle(id) {
            var ids;
            if(id == 'blue'){
                ids = '';
            } else {
                ids = '_' + id;
            }
            var page_color = $("link#blue");
            var href =page_color.attr("href");
            href = href.replace(/(common[a-z_]*)/gi, 'common'+ ids);
            page_color.attr("href", href);
            $.cookie('color_style', id, {expires: 30, path: '/'});
        }
        function moveWebmail() {
            if (window.confirm("Webmailへ移動しますが、よろしいですか？")) {
                var w = window.open('', '_blank');
                if (w == undefined) {
                    location.href = '/external/webmail.html?<?= $cashe ?>';
                } else {
                    w.location.href = '/external/webmail.html?<?= $cashe ?>';
                }
            }
        }
	</script>
</head>
<body>
	<div id="wrapper">
		<?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
		<div id="mainContents">
			<div id="messageArea">&nbsp; </div>
			<div id="contentsCenter">
				<div class="contentsBox">
					<div class="contentsTopGray">&nbsp;</div>
					<div class="contentsMain"><div style="padding:70px 0 80px 0;">
						<p class="txtBold txtGreen txtMiddle" align="center">指定されたページが見つかりません。</p>
						<p align="center">
							<input name="back_page" type="button" class="btnovr" value="戻る" onClick="history.go(-1);">
						</p></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
</body>
</html>