<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
        <script type="text/javascript" src="/contents/js/lytebox_v3.22/lytebox.js"></script>
        <link href="/contents/js/lytebox_v3.22/lytebox.css" rel="stylesheet" type="text/css" media="screen"/>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script>
            function change(obj){
                document.form1.elements["checkbox"][0].checked = obj.checked;
                document.form1.elements["checkbox"][1].checked = obj.checked;
                if(document.form1.elements["del[]"]){
                    document.form1.elements["del[]"].checked = obj.checked;
                    for (var i=0; i< document.form1.elements["del[]"].length; i++){
                        document.form1.elements["del[]"][i].checked = obj.checked;
                    }
                }
            }
            function SingleDownload(num){
                document.form1.elements["file"].value = num;
                document.form1.elements["singledownload"].value = 1;
                document.form1.submit();
                document.form1.elements["singledownload"].value = "";
            }
            function goToSorting(url) {
                window.location.href = url;
            }
            var timer = "300000";
            function ReloadAddr(){
                window.location.reload();//ページをリロード
            }
            setTimeout(ReloadAddr, timer);
        </script>
        <script type="text/javascript"> 
            $(document).ready(function(){
                $("#current_rev").html("v"+$.mcDropdown.version);
                $("#sort_menu").mcDropdown("#menulist");
                $("form").submit(function() {
                    var flg;
                    if(!document.getElementsByName("del[]")){
                            alert('ファイルが存在しません。');
                            return false;
                    }else{
                        if(document.form1.elements["del[]"].length > 1 ){
                            for (var i=0; i< document.form1.elements["del[]"].length; i++){
                                if(document.form1.elements["del[]"][i].checked == true){
                                    flg = 1;
                                }
                            }
                            if(flg == 1){
                                document.form1.submit();
                            }else{
                                msg = "ファイルが選択されていません。";
                                alert(msg);
                                return false;
                            }
                        }else{
                            if(document.form1.elements["del[]"].checked == true){
                                document.form1.submit();
                            }else{
                                msg = "ファイルが選択されていません。";
                                alert(msg);
                                return false;
                            }
                        }
                    }
                    return true;
                });
            });
        </script>
        <style type="text/css" media="screen">
            div.mcdropdown,div.mcdropdownDisabled{
                display: -moz-inline-block;
                display: inline;
                min-width:7em;
                width:7em;
                float:left;
                *float:none;
                _overflow:hidden;
                text-align:left;
                margin:0;
                padding:0;
            }
            ul.dropMenu {
                margin-left:-90px;
            }
            div.curBlcok{
                width:7em !important;
                float:left;
                text-align:left;
                *position:absolute !important;*left:0em;
                _position:absolute;_top:0px;_left:.5em;
            }
            table.tblForm, table.tblAlbumList{
                width: 720px;
            }
            div.openHelpArea{
                width: 722px;
            }
        </style>
    </head>
    <body>
        <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
        <div id="OpneContents">
            <div class="container">
                <h1 class="pagettl"><?= h($opendata['nickname']) ?>さんのファイル</h1>
                <table id="open_storage_status" class="tblForm">
                <tr>
                    <th nowrap>送信者</th>
                    <td width="100%"><?= h($opendata['nickname']) ?> < <a href="mailto:<?= $UserData['user_address'] ?>"><?= $UserData['user_address'] ?></a> ></td>
                </tr>
                <tr>
                    <th nowrap>公開期間</th>
                    <td width="100%"><?= $enddate ?>まで</td>
                </tr>
                <tr>
                    <th nowrap>メッセージ</th>
                    <td>
                        <?= $this->Common->htmlEscapeNotQuote($opendata['message']) ?>
                    </td>
                </tr>
                </table>
                <!--広告管理タグ-->
                <div class="adContents2">
                    <?php $this->Advertising->AdPublish(1,4);?>
                </div>
                <!--広告管理タグ-->
                <div class="padArea" style="padding-left:10px;">
                    ※チェックボックスにチェックを入れてダウンロードするとファイルはzip圧縮されます。<br />
                    解凍ソフトをお持ちでない方は、あらかじめソフトをインストールしてからダウンロードしてください。</div>
                <?php if (isset($helpLinkUrl['OpenStorage'])) : ?>
                    <div class="openHelpArea">
                    <a class="iconHelp" href="<?php echo $helpLinkUrl['OpenStorage'] ?>" target="_blank">ヘルプ</a>
                    </div>
                <?php endif;?>
                <?php if(isset($message) && !(!isset($filedata) || count($filedata) == 0)): ?>
                <div style="padding:10px 0 30px 0;width:680px;text-align:center;border:1px solid #d1d1d1;margin:auto;" align="center">
                    <p class="txtRed"><?= $message ?></p>
                </div>
                <?php endif; ?>
                <div class="space_5"></div>
                <div style="clear:both;"></div>
                <form id="form1" name="form1" method="post" action="/open/storage.html?id=<?= $openid ?>&<?= $cashe ?>">
                    <?php if (!isset($filedata) || count($filedata) == 0) : ?>
                        <div style="padding:10px 0 30px 0; width:680px;text-align:center;border:1px solid #d1d1d1;margin:auto;" align="center">
                            <p class="txtRed">データがありません。送信者により削除された可能性があります。</p>
                        </div>
                    <?php else : ?>
                        <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                            <thead>
                                <tr>
                                    <th class="bgBlueGra txtWhite" colspan="6">
                                        <div style="position:relative;height:1.5em;">
                                            <div class="curBlcok">
                                                <a href="javascript:;" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="古い順" align="absmiddle" /></a>
                                                <div class="contextMenu" style="width:7em;">
                                                    <ul id="menulist" class="dropMenu" style="background-color:#fff;width:7em;_overflow:hiden;">
                                                        <li class="BookmarkMenu">
                                                            <a onclick="goToSorting('/open/storage.html?id=<?= $openid ?>&sort=new&<?= $cashe ?>&id=<?= $openid ?>')" >新しい順</a>
                                                        </li>
                                                        <li class="BookmarkMenu">
                                                            <a onclick="goToSorting('/open/storage.html?id=<?= $openid ?>&sort=old&<?= $cashe ?>&id=<?= $openid ?>')" >古い順</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <td colspan="6">
                                    <input name="checkbox" type="checkbox" class="chechBox01" onClick="change(this)" /><span>すべて選択</span>&nbsp;
                                    <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" /><input name="download" type="submit" value="ダウンロード" class="submitxx downloadMenu"  style="width: 6em ;font:99% ＭＳ Ｐゴシック,MS P Gothic,メイリオ,Meiryo, Arial, Osaka, sans-serif; border: none;" />
                                </td>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td class="BGColorGray" colspan="6">
                                        <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;
                                        <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" /><input name="download" type="submit" value="ダウンロード" class="submitxx downloadMenu"  style="width: 6em ;font:99% ＭＳ Ｐゴシック,MS P Gothic,メイリオ,Meiryo, Arial, Osaka, sans-serif; border: none;" />
                                    </td>
                                </tr>
                                <tr class="openttl">
                                    <th></th>
                                    <th>ファイル名 </th>
                                    <th>容量</th>
                                    <th>コメント</th>
                                    <th>公開状態</th>
                                    <th>ダウンロードの<br />残り回数</th>
                                </tr>
                                <?php foreach ($filedata as $key => $list) : ?>
                                    <?php if ($list['download_count'] < $downloadamount) : ?>
                                        <tr class="<?php if ($key%2==0) : ?>even<?php else : ?>odd<?php endif; ?>">
                                            <td width="12" style="vertical-align:middle;">
                                                <input name="del[]" type="checkbox" class="chechBox01" value="<?= $list['file_id'] ?>" />
                                            </td>
                                            <td width="170" style="vertical-align:middle;"><div style="word-wrap: break-word; width:170px;"><a href="javascript:SingleDownload('<?= $list['file_id'] ?>');" class="underLine"><?php echo $list['extension']!="" ? h($list['name'].".".$list['extension']) : h($list['name']) ?></a></div></td>
                                            <td width="55" style="vertical-align:middle; text-align:right;"><?= $this->Common->modifierKbyte($list['amount']) ?></td>
                                            <td width="166" style="vertical-align:middle; text-align:left;"><div style="word-wrap: break-word; width:166px;"><?= $this->Common->htmlEscapeNotQuote($list['file_comment']) ?></div></td>
                                            <td width="60" style="vertical-align:middle; text-align:center;">公開中</td>
                                            <td width="86" style="vertical-align:middle; text-align:center;"><?= $downloadamount-$list['download_count'] ?>回</td>
                                        </tr>
                                    <?php else : ?>
                                        <tr class="<?php if ($key%2==0) : ?>even<?php else : ?>odd<?php endif; ?>">
                                            <td width="12" style="vertical-align:middle;"><input type="checkbox" class="chechBox01" disabled="disabled" /></td>
                                            <td width="170"  style="color:#666666;vertical-align:middle;"><div style="word-wrap: break-word; width:170px;color:#666666;"><?php echo $list['extension']!="" ? h($list['name'].".".$list['extension']) : h($list['name']) ?></div></td>
                                            <td width="55" style="color:#666666;vertical-align:middle; text-align:right;"><?= $this->Common->modifierKbyte($list['amount']) ?></td>
                                            <td width="166" style="color:#666666;vertical-align:middle; text-align:left;"><div style="word-wrap: break-word; width:166px;color:#666666;"><?= $this->Common->htmlEscapeNotQuote($list['file_comment']) ?></div></td>
                                            <td width="60" style="color:#666666;vertical-align:middle; text-align:center;">公開終了</td>
                                            <td width="86" style="color:#666666;vertical-align:middle; text-align:center;">0回</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <input type="hidden" name="file" value="">
                    <input type="hidden" name="singledownload" value="">
                    <input type="hidden" name="fid" value="0002">
                </form>
            </div>
            <!--広告管理タグ-->
            <div class="adContents1">
                <?php $this->Advertising->AdPublish(1,2);?>
            </div>
            <!--広告管理タグ-->
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/open/footer_' . $this->Common->getAspSetting() . '_open'); ?>
    </body>
</html>


