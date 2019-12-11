<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
        <script type="text/javascript" src="/contents/js/Lytebox/lytebox.js"></script>
        <link href="/contents/js/Lytebox/lytebox.css" rel="stylesheet" type="text/css" media="screen"/>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
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
                document.form1.elements["picture"].value = num;
                document.form1.elements["singledownload"].value = 1;
                document.form1.submit();
                document.form1.elements["singledownload"].value = "";
            }

            function BookMarkMenu(id) {
                if (document.getElementById(id).style.display == "none") {
                    document.getElementById(id).style.display = "block";
                } else {
                    document.getElementById(id).style.display = "none";
                }
            }

            function goToSorting(url) {
                window.location.href = url;
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#current_rev").html("v" + $.mcDropdown.version);
                $("#sort_menu").mcDropdown("#menulist");
                $("form").submit(function () {
                    var flg;
                    if (!document.getElementsByName("del[]")) {
                        alert('ファイルが存在しません。');
                        return false;
                    } else {
                        if (document.form1.elements["del[]"].length > 1) {
                            for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                                if (document.form1.elements["del[]"][i].checked == true) {
                                    flg = 1;
                                }
                            }

                            if (flg == 1) {
                                document.form1.submit();
                            } else {
                                msg = "画像が選択されていません。";
                                alert(msg);
                                return false;
                            }
                        } else {
                            if (document.form1.elements["del[]"].checked == true) {
                                document.form1.submit();
                            } else {
                                msg = "画像が選択されていません。";
                                alert(msg);
                                return false;
                            }
                        }
                    }
                    return true;
                });
                // init lytebox
                initLytebox();
            });
        </script>
        <style type="text/css" media="screen">
            div.mcdropdown,div.mcdropdownDisabled {
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
            div.curBlcok {
                width:7em !important;
                float:left;
                text-align:left;
                *position:absolute !important;*left:11em;
                _position:absolute;_top:0px;_left:.5em;
            }
        </style>
    </head>
    <body>
        <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
        <div id="OpneContents">
            <div class="container">
                <h1 class="pagettl"><?= h($opendata['nickname']) ?>さんのアルバム</h1>
                <table id="open_storage_status" class="tblForm">
                    <tr>
                        <th nowrap>送信者</th>
                        <td><?= h($opendata['nickname']) ?>< <?= $UserData['user_address'] ?> ></td>
                    </tr>
                    <tr>
                        <th nowrap>アルバム名</th>
                        <td><?= $this->Common->mbwordwrap(h($album['album_name'])) ?></td>
                    </tr>
                    <tr>
                        <th nowrap>公開期間</th>
                        <td>
                            <?php if ($opendata['close_type'] == 4) : ?>
                                無期限
                            <?php else : ?>
                                <?= $enddate ?>まで
                            <?php endif; ?>
                        </td>
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
                <div class="padArea" style="padding-left:10px;">※チェックボックスにチェックを入れてダウンロードするとファイルはzip圧縮されます。<br />
                    解凍ソフトをお持ちでない方は、あらかじめソフトをインストールしてからダウンロードしてください。 </div>
                <?php if (isset($helpLinkUrl['OpenAlbum'])) : ?>
                    <div class="openHelpArea">
                    <a class="iconHelp" href="<?php echo $helpLinkUrl['OpenAlbum'] ?>" target="_blank">ヘルプ</a>
                    </div>
                <?php endif;?>
                <?php if(isset($message) && !(!isset($picture) || count($picture) == 0)): ?>
                <div style="padding:10px 0 30px 0;width:680px;text-align:center;border:1px solid #d1d1d1;margin:auto;" align="center">
                    <p class="txtRed"><?= $message ?></p>
                </div>
                <?php endif; ?>
                <div class="space_5"></div>
                <div style="clear:both;"></div>
                <form action="/open/album.html?id=<?= $openid ?>&<?= $cashe ?>" method="post" name="form1">
                    <?php if (!isset($picture) || count($picture) == 0) : ?>
                        <div style="padding:10px 0 30px 0;width:680px;text-align:center;border:1px solid #d1d1d1;margin:auto;" align="center">
                            <p class="txtRed">データがありません。送信者により削除された可能性があります。</p>
                        </div>
                    <?php else : ?>
                        <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                            <thead>
                                <tr>
                                    <th class="bgBlueGra txtWhite" colspan="2">
                                        <div style="position:relative;">
                                            <div style="float:left;">
                                                <?php foreach ($picture as $num => $list) : ?>
                                                    <?php if ($num == 0 || $num % $limitpage == 0) : ?>
                                                        <a class="lyteshow" rel="lyteshow[vacation]" href="/album/open/display.html?pid=<?= $list['pic_id'] ?>&type=2&num=<?= $num ?>&<?= $cashe ?>" title="スライドショー" alt="<?= h($list['name']) ?><br /><?= h($list['pic_comment']) ?>">スライドショー</a>
                                                    <?php else : ?>
                                                        <a href="/album/open/display.html?pid=<?= $list['pic_id'] ?>&type=2&num=<?= $num ?>&<?= $cashe ?>" rel="lyteshow[vacation]" style="display:none" title="スライドショー" alt="<?= h($list['name']) ?><br /><?= h($list['pic_comment']) ?>">スライドショー</a>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                ｜
                                            </div>
                                            <div class="curBlcok">
                                                <a href="javascript:" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="古い順" align="absmiddle" /></a>
                                                <div class="contextMenu" style="width:7em;">
                                                    <ul id="menulist" class="dropMenu" style="background-color:#fff;width:7em;_overflow:hiden;">
                                                        <li class="BookmarkMenu">
                                                            <a onclick="goToSorting('/open/album.html?id=<?= $openid ?>&page=<?= $page ?>&sort=new&<?= $cashe ?>')">新しい順</a>
                                                        </li>
                                                        <li class="BookmarkMenu">
                                                            <a onclick="goToSorting('/open/album.html?id=<?= $openid ?>&page=<?= $page ?>&sort=old&<?= $cashe ?>')">古い順</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td>
                                        <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;
                                        <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" />
                                        <input name="download" type="submit" value="ダウンロード" class="submitxx" style="width: 6em ; font:99% ＭＳ Ｐゴシック,MS P Gothic,メイリオ,Meiryo, Arial, Osaka, sans-serif; border: none;" />
                                    </td>
                                    <td class="txtRight">
                                        <div class="pagelistArea">
                                            <?php if (!empty($back)) : ?>
                                                <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $back ?>&sort=<?= $sort ?>&<?= $cashe ?>">≪前へ</a></span>
                                            <?php endif; ?>
                                            <?php foreach ($link_num as $list) : ?>
                                                <?php if ($list == $page) : ?>
                                                    <span class="txtBold now-page">&nbsp;<?= $list ?></span>
                                                <?php else : ?>
                                                    <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $list ?>&sort=<?= $sort ?>&<?= $cashe ?>"><?= $list ?></a></span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (!empty($next)) : ?>
                                            <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $next ?>&sort=<?= $sort ?>&<?= $cashe ?>">次へ≫</a></span>
                                            <?php endif; ?>
                                            <!--ページング処理-->
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td class="BGColorGray">
                                        <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp
                                        <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" /><input name="download" type="submit" value="ダウンロード" class="submitxx" style="width: 6em ;font:99% ＭＳ Ｐゴシック,MS P Gothic,メイリオ,Meiryo, Arial, Osaka, sans-serif; border: none;" />
                                    </td>
                                    <td class="txtRight BGColorGray">
                                        <div class="pagelistArea">
                                            <?php if (!empty($back)) : ?>
                                                <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $back ?>&sort=<?= $sort ?>&<?= $cashe ?>">≪前へ</a></span>
                                            <?php endif; ?>
                                            <?php foreach ($link_num as $list) : ?>
                                                <?php if ($list == $page) : ?>
                                                    <span class="now-page">&nbsp;<?= $list ?></span>
                                                <?php else : ?>
                                                    <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $list ?>&sort=<?= $sort ?>&<?= $cashe ?>"><?= $list ?></a></span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (!empty($next)) : ?>
                                            <span><a href="/open/album.html?id=<?= $openid ?>&page=<?= $next ?>&sort=<?= $sort ?>&<?= $cashe ?>">次へ≫</a></span>
                                            <?php endif; ?>
                                            <!--ページング処理-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table class="bottomTable">
                                            <tr>
                                                <?php foreach ($picture as $key => $list) : ?>
                                                    <?php if ($key > 0 && $key % 5 == 0) : ?>
                                                        </tr><tr>
                                                    <?php endif; ?>
                                                <td>
                                                    <div class="photo02" title="<?= $list['pic_name'] ?>">
                                                        <a href="/open/picture.html?id=<?= $openid ?>&pid=<?= $list['pic_id'] ?>&page=<?= $page ?>&<?= $cashe ?>"><img src="/album/open/display.html?pid=<?= $list['pic_id'] ?>&type=1" /></a>
                                                        <div class="txtXSmall">
                                                            <input name="del[]" type="checkbox" class="chechBox01" value="<?= $list['pic_id'] ?>" /><br />
                                                            <a href="/open/picture.html?id=<?= $openid ?>&pid=<?= $list['pic_id'] ?>&page=<?= $page ?>&<?= $cashe ?>"><?= h($this->Common->limitWord($list['name'])) ?></a><br />
                                                            <a href="javascript:SingleDownload('<?= $list['pic_id'] ?>')">ダウンロード</a>
                                                        </div></div></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <input type="hidden" name="picture" value="">
                    <input type="hidden" name="singledownload" value="">
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


