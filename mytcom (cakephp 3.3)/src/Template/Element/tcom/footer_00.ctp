<div id="foot">
    <div id="foottops"><p><a href="/index.html?<?= $cashe ?>" id="footHome">ホーム</a> ｜ <a href="/bbs/redirect.html">家族掲示板</a> ｜ <a href="/calender/monthly.html?<?= $cashe ?>" id="footSchedule">スケジュール</a> ｜ <a href="/weblog/monthly.html?<?= $cashe ?>">日記</a> ｜ <a href="/wallet/list.html?<?= $cashe ?>">家計簿</a> ｜ <a href="/album/list.html?<?= $cashe ?>">アルバム</a> ｜ <a href="/movie/list.html?<?= $cashe ?>">動画</a> ｜ <a href="/storage/folder/list.html?<?= $cashe ?>">ファイル管理</a> ｜ <a class="pcLinkMail showpopupclass" href="javascript:void(0);" id="footMail">メール</a> ｜ <a class="pcLinkAddress" href="/address/listview.html">アドレス帳</a> ｜ <a href="/user/index.html?<?= $cashe ?>">設定</a></p>
        <p><a href="http://www.t-com.ne.jp/infopolicy/" target="_blank">情報セキュリティ基本方針</a> ｜ <a href="http://www.t-com.ne.jp/policy/index.html" target="_blank">個人情報保護ポリシー</a> ｜ <a href="http://service.t-com.ne.jp/mytcom/rules/" target="_blank">利用規約</a> ｜ <a href="http://service.t-com.ne.jp/mytcom/help/" target="_blank">ヘルプ</a></p></div>
    <div id="footbottoms"><p>Copyright(c) 2011 TOKAI Communications Corporation All rights reserved. </p></div>
</div>
<!-- User Insight PCDF Code Start : t-com.ne.jp -->
<script type="text/javascript">
<!--
    var uilid = '';
    var uigr_1 = '';
    var uigr_2 = '';
    var uigr_3 = '';
    var uigr_4 = '';
    var uigr_5 = '';
    var uigr_6 = '';
    var uigr_7 = '';
    var uigr_8 = '';
    var uigr_9 = '';
    var uigr_10 = '';

// DO NOT ALTER BELOW THIS LINE
// WITHOUT F.P.C.

    var uiinit = uiinit || Math.floor(Math.random() * 9000000) + 1000000;
    var uihost = uihost || (("https:" == document.location.protocol) ? "https://bs." : "http://b13.") + "nakanohito.jp/b1/";
    document.write("<img id='id_shellfish' style='position: absolute' src='" + uihost + "?uisv=13&id=31373&mode=default&h=c1c1&rand=" + uiinit + "&url=" + encodeURIComponent(parent.document.URL) + "&ref=" + encodeURIComponent(parent.document.referrer) + "&uigr_1=" + encodeURIComponent(uigr_1) + "&uigr_2=" + encodeURIComponent(uigr_2) + "&uigr_3=" + encodeURIComponent(uigr_3) + "&uigr_4=" + encodeURIComponent(uigr_4) + "&uigr_5=" + encodeURIComponent(uigr_5) + "&uigr_6=" + encodeURIComponent(uigr_6) + "&uigr_7=" + encodeURIComponent(uigr_7) + "&uigr_8=" + encodeURIComponent(uigr_8) + "&uigr_9=" + encodeURIComponent(uigr_9) + "&uigr_10=" + encodeURIComponent(uigr_10) + "&lv=" + uilid + "&sb=" + encodeURIComponent(document.title) + "&guid=ON&eflg=1' border='0' width='1' height='1' alt='' />");
    if (typeof document.documentElement.style.maxHeight != "undefined") {
        document.write('<span  style="position: absolute" id="id_bivalves"></span>');
        document.write(decodeURI("%3Cscr" + "ipt src='" + uihost + "bivalves.js' charset='utf-8' type='text/javascript'%3E%3C/script%3E"));
        var uiLimit = 3000, uiInterval = 50, uiTime = 0;
        var uiLoadedId = setInterval(function () {
            if ((typeof (Vesicomyid) != "undefined") && (typeof (Vesicomyid.Bivalves) != "undefined") && (typeof (Vesicomyid.Bivalves.Loaded) == "function")) {
                clearInterval(uiLoadedId);
                try {
                    var lb = new Vesicomyid.Bivalves(31373, uiinit);
                    lb.host = uihost;
                    lb.uisv = 13;
                    lb.init();
                } catch (err) {
                }
            } else if ((uiTime += uiInterval) > uiLimit) {
                clearInterval(uiLoadedId);
            }
        }, uiInterval);
    }

//-->
</script>
<!-- User Insight PCDF Code End : t-com.ne.jp -->
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
<div class="clear"></div>