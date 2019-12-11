<?php
use Cake\Core\Configure;
?>
<div id="logo"><a href="/index.html?<?= $cashe ?>" name="top"><img src="/contents/images/tcom/logo.gif" alt="MY@TCOM" width="140" height="40" /></a></div>
<div id="login"><p><a href="http://www.t-com.ne.jp/" target="_blank">@T COM(アットティーコム)</a>｜<a href="http://support.t-com.ne.jp/" target="_blank">会員サポート</a>｜<a href="http://service.t-com.ne.jp/mytcom/help/" target="_blank">ヘルプ</a></p>｜<p><a href="/logout.html?<?= $cashe ?>">[ログアウト]</a></p></div>
<br />
<script language="javascript" type="text/javascript">
    function openLinkNewTab()
    {
        if (confirm('Webmailへ移動しますが、よろしいですか？')) {
            var urlJump = "/external/webmail.html?<?= $cashe ?>";
            window.open(urlJump, "_blank");
        }
    }
    // duplicated click
    $(document).ready(function () {
        jQuery.validator.addMethod("nospaces", function(value, element, params) {
            if (params) {
                return this.optional(element) || value.trim().length == 0 ? false : true;
            }
        });

        $("#tongleSubmit").on("click", function(e) {
            $("#tongleSubmit").prop('disabled', true);
            var isValid = $('#form').valid();
            if(!isValid) {
                e.preventDefault();
                $("#tongleSubmit").prop('disabled', false);
            }
            if (isValid) {
                document.form1.submit();
            }
        });

        $(".showpopupclass").click(function () {
            openLinkNewTab();
        });
        // enter search textbox
        $('.textArea01').on('click', function() {
            $(this).css('background', 'none');
            $(this).css('background-color', 'white');
        });
    });
</script>
<script language="JavaScript">
    function searchCategory() {
        if ($('#globalSearch').val().length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
            alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
            return false;
        } else {
            var action = document.globalsearch.elements["optSearch"].value;
            var keyword = document.globalsearch.keyword.value;
            document.globalsearch.searchWord.value = keyword;
            document.globalsearch.action = action;
            document.globalsearch.submit();
        }
    }

    function enter(event) {
        if (!event) { /* For IE. */
            event = window.event;
        }
        if (event.keyCode == 13) {
            return searchCategory();
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
/*         if (isMSIE) {
            $("link").each(function () {
                if ($(this).attr("id") != "") {
                    $(this).attr("disabled", true);
                    if ($(this).attr("id") == id) {
                        $(this).attr("disabled", false);
                        $.cookie('color_style', id, {expires: 30, path: '/'});
                    }
                }
            });
        } else {
            var str_id = "#" + id;
            $(str_id).attr("disabled", false);
            $("link").each(function () {
                if ($(this).attr("id") != "") {
                    if ($(this).attr("id") == id) {
                        $(this).attr("disabled", false);
                        $.cookie('color_style', id, {expires: 30, path: '/'});
                    } else {
                        $(this).attr("disabled", true);
                    }
                }
            });
        } */
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

<div class="topToolArea">
    <div class="topToolLeft">
        <form action="" name="globalsearch" method="post">
            <select name="optSearch">
                <option value="/album/preview.html?src=all&fromsrc=1&<?= $cashe ?>">アルバム</option>
                <option value="/movie/preview.html?src=all&fromsrc=1&<?= $cashe ?>">動画</option>
                <option value="/storage/file/list.html?src=all&fromsrc=1&<?= $cashe ?>">ファイル管理</option>
                <?php if ($deviceTypeId == 1) : ?>
                <option value="/address/listview.html?<?= $cashe ?>">アドレス</option>
                <?php endif;?>
            </select>
            <input type="text" size="15" id="globalSearch" name="keyword" class="textArea01" value="" OnKeyDown="return enter(event);" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>"/><input type="button" class="submit01" value=" " name="search" onclick="searchCategory();" style="margin-left: 5px;"/>
            <input type="hidden" name="searchWord" />
            <input type="hidden" name="searchMail_x" value="1"/>
        </form>
    </div>
    <div class="topToolRight">
        <ul id="clr">
            <li id="clr1"><a href="#" onclick="jstyle('blue')">ブルー</a></li>
            <li id="clr2"><a href="#" onclick="jstyle('pink')">ピンク</a></li>
            <li id="clr3"><a href="#" onclick="jstyle('orange')">オレンジ</a></li>
            <li id="clr4"><a href="#" onclick="jstyle('green')">グリーン</a></li>
            <li id="clr5"><a href="#" onclick="jstyle('gray')">グレー</a></li>
            <li id="clr6"><a href="#" onclick="jstyle('white')">ホワイト</a></li>
        </ul>
        <div class="topToolRightImg"><img src="/contents/images/txt_txtsize.gif" alt="文字サイズ" /></div>
        <div class="fontsize">
            <a href="javascript:;" class="fontsize01" onclick="fontSizeS('Z');">小</a><a href="javascript:;" class="fontsize02" onclick="fontSizeM('Z');">中</a><a href="javascript:;" class="fontsize03" onclick="fontSizeL('Z');">大</a></div>
    </div>
</div>
<div id="topMenu">
    <div class="<?php if ($menu_now_flg == '1'): ?>topMenu01Now<?php else: ?>topMenu01<?php endif; ?>"><a href="/index.html?<?= $cashe ?>">トップ</a></div>
    <div class="topMenu11"><a href="/bbs/redirect.html">家族掲示板</a></div>
    <div class="<?php if ($menu_now_flg == '2'): ?>topMenu02Now<?php else: ?>topMenu02<?php endif; ?>"><a href="/calender/monthly.html?<?= $cashe ?>">スケジュール</a></div>
    <div class="<?php if ($menu_now_flg == '3'): ?>topMenu03Now<?php else: ?>topMenu03<?php endif; ?>"><a href="/weblog/monthly.html?<?= $cashe ?>">日記</a></div>
    <div class="<?php if ($menu_now_flg == '4'): ?>topMenu04Now<?php else: ?>topMenu04<?php endif; ?>"><a href="/wallet/list.html?<?= $cashe ?>">家計簿</a></div>
    <div class="<?php if ($menu_now_flg == '5'): ?>topMenu05Now<?php else: ?>topMenu05<?php endif; ?>"><a href="/album/list.html?<?= $cashe ?>">アルバム</a></div>
    <div class="<?php if ($menu_now_flg == '6'): ?>topMenu06Now<?php else: ?>topMenu06<?php endif; ?>"><a href="/movie/list.html?<?= $cashe ?>">動画</a></div>
    <div class="<?php if ($menu_now_flg == '7'): ?>topMenu07Now<?php else: ?>topMenu07<?php endif; ?>"><a href="/storage/folder/list.html?<?= $cashe ?>">ファイル管理</a></div>
    <div class="<?php if ($menu_now_flg == '8'): ?>topMenu08Now<?php else: ?>topMenu08<?php endif; ?>"><a class="pcLinkMail showpopupclass" href="javascript:void(0);">メール</a></div>
    <div class="<?php if ($menu_now_flg == '9'): ?>topMenu09Now<?php else: ?>topMenu09<?php endif; ?>"><a class="pcLinkAddress" href="/address/listview.html?<?= $cashe ?>">アドレス</a></div>
    <div class="<?php if ($menu_now_flg == '10'): ?>topMenu10Now<?php else: ?>topMenu10<?php endif; ?>"><a href="/user/index.html?<?= $cashe ?>">設定</a></div>
</div>
<div id="loginName"><span class="textGray">ようこそ、</span><span class="textBlackBold"><?php echo h($this->Header->getUsername()); ?></span><span class="textGray"> さん</span>&nbsp;&nbsp;[&nbsp;<a href="/user/option.html?<?= $cashe ?>">編集</a>&nbsp;]
</div>
<div id="memory">
    <table cellspacing="0" cellpadding="0" width="200" bgcolor="#FFFFFF"><tr><td bgcolor="#FFFFFF" align="left"><div style="width:<?php echo $this->Header->getUseCapacityPercent(); ?>; height:8px; background-color:#ACCFEC;"><img src="/contents/images/spacer.gif" width="1" height="1" alt=""></div></td></tr></table>
    <p style="line-height: 9px;">
        <span class="textGray">使用量：</span><span class="textBlackBold"><?php echo $this->Header->getUseCapacityPercent(); ?>(<?php echo $this->Header->getUseCapacity(); ?>/<?php echo $this->Header->getContractCapacityStr(); ?>)</span>
    </p>
</div>

<!-- ローディング部分 -->
<script type="text/javascript" src="/contents/js/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    //ajax停止時に前面表示解除
    $().ajaxStop($.unblockUI);
    //ローディング状態を表示する。
    $('#sync_btn, .topMenu01, .topMenu02, #footHome, #footSchedule').click(function () {
        $.blockUI({message: $('#loading')});
    });
});
// check IE
function checkMsie() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
        return true;
    }
    return false;
}
</script>
<div id="loading" style="display:none; cursor: default">
    <img src="/contents/images/ajax-loader.gif">
    <h1 style="no-repeat center top; color:#FFFFFF;font-weight:bold;font-size:12px;"><br />
        ローディング中です。<br />
        しばらくお待ちください。</h1>
</div>
