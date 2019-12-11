<div id="foot">
    <div id="foottops"><p><a href="/index.html?<?= $cashe ?>" id="footHome">ホーム</a> ｜ <a href="/bbs/redirect.html">家族掲示板</a> ｜ <a href="/calender/monthly.html?<?= $cashe ?>" id="footSchedule">スケジュール</a> ｜ <a href="/weblog/monthly.html?<?= $cashe ?>">日記</a> ｜ <a href="/wallet/list.html?<?= $cashe ?>">家計簿</a> ｜ <a href="/album/list.html?<?= $cashe ?>">アルバム</a> ｜ <a href="/movie/list.html?<?= $cashe ?>">動画</a> ｜ <a href="/storage/folder/list.html?<?= $cashe ?>">ファイル管理</a> ｜ <a class="pcLinkMail showpopupclass" href="javascript:void(0);" id="footMail">メール</a> ｜ <a class="pcLinkAddress" href="/address/listview.html">アドレス帳</a> ｜ <a href="/user/index.html?<?= $cashe ?>">設定</a></p>
</div>
<div id="footbottoms">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="footLeft">TOKAIネットワーククラブ<br />
            <img src="/contents/images/copyright.gif" alt="Copyright" /></td>
            <?php $siteSetting = $this->Common->getSiteSetting(); ?>
            <td class="footRight"><a class="linkG" href="<?= $siteSetting['PolicyUrl'] ?>" target="_blank"><?= $siteSetting['PolicyName'] ?></a>｜<a classs="linkG" href="<?= $siteSetting['InfoPolicyUrl'] ?>" target="_blank"><?= $siteSetting['InfoPolicyName'] ?></a></td>
        </tr>
    </table></div>
</div>
<?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
<div class="clear"></div>
