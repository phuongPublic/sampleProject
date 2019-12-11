<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>

        <script type="text/javascript" src="/contents/js/Lytebox/lytebox.js"></script>
        <link href="/contents/js/Lytebox/lytebox.css" rel="stylesheet" type="text/css" media="screen"/>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />

        <script>
            function change(obj)
            {
                document.form1.elements["checkbox"][0].checked = obj.checked;
                document.form1.elements["checkbox"][1].checked = obj.checked;
                if (document.form1.elements["del[]"]) {
                    document.form1.elements["del[]"].checked = obj.checked;
                    for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                        document.form1.elements["del[]"][i].checked = obj.checked;
                    }
                }
            }
            function RemoveFileData(id)
            {
                var flg;
                if (id == "" || id == null) {
                    alert('移動できません。');
                    return;
                }

                if (!document.getElementsByName("del[]")) {
                    alert('ファイルが存在しません。');
                } else {

                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            msg = "画像を移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            msg = "画像を移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }

                    }
                }

            }

            function DeleteFileData()
            {
                var flg;
                if (!document.getElementsByName("del[]")) {
                    alert('ファイルが存在しません。');
                } else {

                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
            }

            function OpenFileData()
            {
                var flg;
                if (!document.getElementsByName("del[]")) {
                    alert('ファイルが存在しません。');
                } else {

                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["open"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["open"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = 0;
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
            }


            function DownloadFileData()
            {
                var flg;
                if (!document.getElementsByName("del[]")) {
                    alert('ファイルが存在しません。');
                } else {

                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["downloadfiles"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["downloadfiles"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "画像が選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
            }

            function SingleDownload(num)
            {
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["picture"].value = num;
                document.form1.elements["singledownload"].value = 1;
                document.form1.submit();
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["downloadfiles"].value = "";
            }

            function BookMarkMenu(id)
            {
                if (document.getElementById(id).style.display == "none") {
                    document.getElementById(id).style.display = "block";
                } else {
                    document.getElementById(id).style.display = "none";
                }
            }

            function sort(sel)
            {
                mlink = sel.options[sel.selectedIndex].value;
                if (mlink != "-") {
                    location.href = mlink;
                }
            }

            function validatorLength() {
                if ($('#keyword').val().length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    return false;
                } else {
                    var url_action = '/album/preview.html?aid=<?php echo $aid; ?>&fromsrc=1<?php if (!$aid): ?>&src=all<?php endif; ?>&search=1&<?php echo $cashe; ?>';
                    $('#form1').attr('action', url_action);
                    $('#form1').submit();
                }
            }
            function goToSorting(url) {
                window.location.href = url;
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                var cbox = $("input.chechBox01:checkbox").val([]);
                var cbox2 = $("input.chechBox02:checkbox").val([]);
                cbox = false;
                cbox2 = false;
                $("#current_rev").html("v" + $.mcDropdown.version);
                $("#sort_menu").mcDropdown("#menulist");
                $('a#dropbtn1').click(function () {
                    $("div#folder_list").slideToggle("fast");
                });
                $('a#dropbtn1').blur(function () {
                    setTimeout(function() {
                        $("div#folder_list").slideUp();
                    }, 200);
                });
                $('a#dropbtn2').click(function () {
                    $("div#folder_list2").slideToggle("fast");

                });
                $('a#dropbtn2').blur(function () {
                    setTimeout(function() {
                        $("div#folder_list2").slideUp();
                    }, 200);
                });

                // init lytebox
                initLytebox();
            });
        </script>
        <style type="text/css" media="screen">
            div.mcdropdown,div.mcdropdownDisabled{
                display: -moz-inline-block;
                display: inline;
                min-width:6em;
                width:6em;
                float:left;
                *float:none;
                _overflow:hidden;
                text-align:left;
            }
            ul.dropMenu {
                margin-left:-75px;
            }
            div.curBlcok{
                width:6em;
                float:left;
                text-align:left;
                *position:absolute !important;*left:15em;
                _position:absolute;_top:0px;_left:.5em;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <form action="preview.html?aid=<?=$aid?>&fromsrc=1<?php if (!$aid):?>&src=all<?php endif;?>&<?=$cashe?>" method="post" name="form1" id="form1">
                        <input type="hidden" name="aid" content="<?php echo $aid; ?>" />
                        <div class="contentsBox">
                            <div class="contentsTopGray">
                                <h3 class="contentsttl floL">
                                アルバムの<?php if ((isset($keyword) && $keyword != "") || $fromsrc) : ?>検索結果
                                <?php else : ?>詳細<?php endif; ?>
                                </h3>
                                <div class="searchArea floR">
                                    <input class="textArea01" type="text" value="" size="15" id="keyword" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>"/>
                                    <a class="submit01 btn" onclick = "validatorLength();"></a>
                                    <?php if ($helpLinkUrl['AlbumPreview']) : ?>
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumPreview'] ?>" target="_blank">この機能のヘルプ</a>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="contentsMain">
                                <?php if (isset($errorLength)): ?>
                                    <p class="txtRed txtBold">
                                        <?= $message ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ((isset($keyword) && $keyword != "") || $fromsrc) : ?>
                                <div style="word-wrap: break-word; width:auto;">
                                    <p class="txtBold bdrbot space_4">
                                    <?php if (!isset($errorLength)) : ?>
                                        "<?= $this->Common->htmlEscapeNotQuote($keyword) ?>"の 該当件数：<?php echo $resultNum; ?>件
                                    <?php endif; ?>
                                    </p></div>
                                <?php else : ?>
                                <?php
                                    $width = '440px';
                                    $album_name = '';
                                    $album_comment = '';
                                    foreach ($albumList as $item) {
                                        if ($aid == $item['album_id']) {
                                            $album_name     = $item['album_name'];
                                            $album_comment  = $item['album_comment'];
                                            if(mb_strlen($album_comment) > 80) {
                                                $width = '620px';
                                            }
                                        }
                                    }
                                ?>
                                <div class="iconAlbum" style="width: 410px;">
                                    <h1 class="txtBold" id="title" style="word-wrap: break-word; width: 410px;">
                                        <?php echo h($album_name); ?>
                                    </h1>
                                    <div style="word-wrap: break-word; width: 410px;"><?php echo h($album_comment); ?></div>
                                </div>
                                <?php if ($src != "all") : ?>
                                    <div class="kmBox">ファイル数:<span class="txtBold"><?php echo $resultNum; ?>(<?php echo $this->Common->modifierByte($dataSize)?>)</span><br /><?php if ($openStatus == 0 && $openFlg == 0) : ?>非公開<?php else : ?>公開中 [ <a href="/album/open/status.html?pid=all&aid=<?php echo $aid; ?>&<?php echo $cashe; ?>" class="open_status" style="white-space:nowrap;">公開状況を確認</a> ]<?php endif; ?>
                                        <div class="kmBoxLT"></div>
                                        <div class="kmBoxRT"></div>
                                        <div class="kmBoxLB"></div>
                                        <div class="kmBoxRB"></div>
                                    </div>
                                <?php endif; ?>
                                <div class="clear space_4"></div>
                                <?php if (!$keyword) : ?>
                                <div class="alubumItems space_4">
                                    <?php if ($message) : ?>
                                    <p class="txtRed txtBold floL" style="margin-top:-8px;">
                                        <?php echo $message; ?>
                                    </p>
                                    <?php endif; ?>
                                    <div class="floR">
                                        <a href="/album/open/regist.html?openflg=1&aid=<?php echo $aid; ?>&<?php echo $cashe; ?>">友人に公開する</a> ｜
                                        <a href="/album/edit.html?aid=<?php echo $aid; ?>&<?php echo $cashe; ?>">編集</a>
                                        <?php if (intval($aid) == 1) : ?>
                                        <?php else : ?>
                                        ｜ <a href="/album/delete.html?aid=<?php echo $aid; ?>&<?php echo $cashe; ?>">削除</a>
                                        <?php endif; ?>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <!-- TO DO -->
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if ((isset($keyword) && $keyword != "") || $fromsrc) : ?>
                                    <?php if ($resultNum == 0) : ?>
                                <p class="txtRed txtBold">該当する写真はありません。</p>
                                    <?php else : ?>
                                <p class="txtRight space_4">
                                    表示順変更：
                                    <select name="sortmenu" onChange="sort(this)">
                                    <?php if (isset($aid)): ?>
                                        <option value="/album/preview.html?aid=<?= $aid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=new&<?= $cashe ?>" <?php if ($sort=="new" || $sort=="") : ?>selected
                                                <?php endif; ?>>新しい順</option>
                                        <option value="/album/preview.html?aid=<?= $aid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=old&<?= $cashe ?>" <?php if ($sort=="old") : ?>selected
                                                <?php endif; ?>>古い順</option>
                                    <?php else: ?>
                                        <option value="/album/preview.html?aid=&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=new&<?= $cashe ?>" <?php if ($sort=="new" || $sort=="") : ?>selected
                                                <?php endif; ?>>新しい順</option>
                                        <option value="/album/preview.html?aid=&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=old&<?= $cashe ?>" <?php if ($sort=="old") : ?>selected
                                                <?php endif; ?>>古い順</option>
                                    <?php endif; ?>
                                    </select>
                                </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($data) : ?>
                                <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                                        <?php if (!$keyword && $fromsrc == 0) : ?>
                                    <thead>
                                        <tr>
                                            <th class="bgBlueGra txtWhite" colspan="2">
                                                <div style="position:relative;">
                                                    <div style="float:left;">
                                                        <a href="/album/picture/regist.html?aid=<?= $aid ?>&<?= $cashe ?>">写真を登録する</a> ｜

                                                            <?php foreach ($data as $picItem) : ?>
                                                            <?php if ($picItem == array_values($data)[0]) : ?>
                                                        <a href="/album/picture/picture.html?pid=<?= $picItem['pic_id'] ?>&type=2&<?= $cashe ?>" rel="lyteshow[vacation]" title="スライドショー" alt="<?= $picItem['name'] ?><br><?= $this->Common->htmlEscapeNotQuote($picItem['pic_comment']) ?>">スライドショー</a> ｜
                                                            <?php endif; ?>
                                                        <a href="/album/picture/picture.html?pid=<?= $picItem['pic_id'] ?>&type=2&<?= $cashe; ?>" rel="lyteshow[vacation]" style="display:none" title="スライドショー" alt="<?= $picItem['name'] ?><br><?= $this->Common->htmlEscapeNotQuote($picItem['pic_comment']) ?>">スライドショー</a>

                                                            <?php endforeach; ?>
                                                    </div>
                                                    <div class="curBlcok">
                                                        <div style="white-space:nowrap;"><a href="javascript:;" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="" align="absmiddle" /></a></div>
                                                        <div class="contextMenu" style="width:6em;">
                                                            <ul id="menulist" class="dropMenu" style="background-color:#fff;width:6em;_overflow:hidden;">
                                                                    <?php foreach ($optsort as $key => $val) : ?>
                                                                <li class="BookmarkMenu">
                                                                    <a onclick="goToSorting('/album/preview.html?aid=<?= $aid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $key ?>&<?= $cashe ?>')">
                                                                        <?php echo $val; ?>
                                                                    </a>
                                                                </li>
                                                                    <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                        <?php endif; ?>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" />
                                                    <span>すべて選択</span>&nbsp;&nbsp;
                                                    <?php if ($src != "all") : ?>
                                                    <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" />
                                                    <input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="javascript:OpenFileData()" /> ｜
                                                    <?php endif; ?>
                                                    <img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" />
                                                    <input id="download" name="download" type="button" value="ダウンロード" class="submitxx" onclick="DownloadFileData()" style="padding-right: 0px;" /> ｜
                                                    <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" />
                                                    <a href="javascript:void(0);" id="dropbtn2">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />
                                                    <?php if ($resultNum > 0) : ?>｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" />
                                                    <input name="delete" type="button" value="削除する  " class="submitxx" onclick="javascript:DeleteFileData()" /><?php endif; ?>
                                                    <div id="folder_list2" style="position:absolute;left:250px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                                                        <ul style="padding:10px;">
                                                            <?php foreach ($albumListName as $key => $val) : ?>
                                                            <li style="padding:0;display:block;">
                                                                <a href="javascript:;" onclick="javascript:RemoveFileData('<?php echo $key; ?>')" style="padding:0 0 5px 0;display:block;color:#00608D;">
                                                                    <?php echo h($val); ?>
                                                                </a>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="txtRight BGColorGray">
                                                <div class="pagelistArea">
                                                        <?php if ($back) : ?>
                                                    <a href="/album/preview.html?aid=<?php echo $aid; ?>&page=<?php echo $back; ?>&src=<?php echo $src; ?>&fromsrc=<?php echo $fromsrc; ?>&keyword=<?php echo $keyword64; ?>&sort=<?php echo $sort; ?>&<?php echo $cashe; ?>">≪ 前へ</a>
                                                        <?php endif; ?>
                                                        <?php foreach ($linkNum as $item) : ?>
                                                        <?php if($page == $item): ?><span class="now-page"><?php echo $item; ?></span>
                                                        <?php else : ?>
                                                    <span><a href="/album/preview.html?aid=<?php echo $aid; ?>&page=<?php echo $item; ?>&src=<?php echo $src; ?>&fromsrc=<?php echo $fromsrc; ?>&keyword=<?php echo $keyword64; ?>&sort=<?php echo $sort; ?>&<?php echo $cashe; ?>"><?php echo $item; ?></a></span>
                                                        <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if ($next) : ?>
                                                    <a href="/album/preview.html?aid=<?php echo $aid; ?>&page=<?php echo $next; ?>&src=<?php echo $src; ?>&fromsrc=<?php echo $fromsrc; ?>&keyword=<?php echo $keyword64; ?>&sort=<?php echo $sort; ?>&<?php echo $cashe; ?>">次へ ≫</a>
                                                        <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td class="BGColorGray">
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" />
                                                    <span>すべて選択</span>&nbsp;&nbsp;
                                                    <?php if ($src != "all") : ?>
                                                            <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" />
                                                            <input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="javascript:OpenFileData()" /> ｜
                                                    <?php endif; ?>
                                                    <img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" />
                                                    <input id="download" name="download" type="button" value="ダウンロード" class="submitxx" onclick="DownloadFileData()" style="padding-right: 0px;" /> ｜
                                                    <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" />
                                                    <a href="javascript:void(0);" id="dropbtn1">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />
                                                    <?php if ($resultNum > 0) : ?>｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" />
                                                    <input name="delete" type="button" value="削除する  " class="submitxx" onclick="javascript:DeleteFileData()" /><?php endif; ?>
                                                    <div id="folder_list" style="position:absolute;left:250px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display: none;">
                                                        <ul style="padding:10px;">
                                                            <?php foreach ($albumListName as $key => $val) : ?>
                                                                <li style="padding:0;display:block;">
                                                                    <a href="javascript:;" onclick="javascript:RemoveFileData('<?php echo $key; ?>')" style="padding:0 0 5px 0;display:block;color:#00608D;">
                                                                        <?php echo h($val); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </td>
                                            <td class="txtRight BGColorGray">
                                                <div class="pagelistArea">
                                                        <?php if ($back) : ?>
                                                    <a href="/album/preview.html?aid=<?= $aid ?>&page=<?= $back ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>">≪ 前へ</a>
                                                        <?php endif; ?>
                                                        <?php foreach ($linkNum as $item) : ?>
                                                        <?php if($page == $item): ?><span class="now-page"><?php echo $item; ?></span>
                                                        <?php else : ?>
                                                    <span><a href="/album/preview.html?aid=<?php echo $aid; ?>&page=<?php echo $item; ?>&src=<?php echo $src; ?>&fromsrc=<?php echo $fromsrc; ?>&keyword=<?php echo $keyword64; ?>&sort=<?php echo $sort; ?>&<?php echo $cashe; ?>"><?php echo $item; ?></a></span>
                                                        <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if ($next) : ?>
                                                    <a href="/album/preview.html?aid=<?php echo $aid; ?>&page=<?php echo $next; ?>&src=<?php echo $src; ?>&fromsrc=<?php echo $fromsrc; ?>&keyword=<?php echo $keyword64; ?>&sort=<?php echo $sort; ?>&<?php echo $cashe; ?>">次へ ≫</a>
                                                        <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="bottom">
                                                <table class="bottomTable">
                                                    <tr>
                                                            <?php foreach ($data as $key => $val) : ?>
                                                            <?php if ($key > 0 && $key%5 == 0) : ?>
                                                    </tr>
                                                    <tr>
                                                            <?php endif; ?>
                                                        <td>
                                                            <div class="photo02" title="<?php echo h($val['pic_name']); ?>">
                                                                <a href="/album/picture/detail.html?pid=<?php echo $val['pic_id']; ?>&<?php echo $cashe; ?>"><img src="/album/picture/picture.html?pid=<?php echo $val['pic_id']; ?>&type=1" /></a>
                                                                <div class="txtXSmall"><input name="del[]" type="checkbox" class="chechBox02" value="<?php echo $val['pic_id']; ?>" />
                                                                    <br />
                                                                    <a href="/album/picture/detail.html?pid=<?php echo $val['pic_id']; ?>&<?php echo $cashe; ?>">
                                                                            <?php echo h($this->Common->limitWord($val['name'])); ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                            <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php else : ?>
                                    <?php if (!$keyword) : ?>
                                <div style="padding:10px 0 30px 20px;text-align:center;border:1px solid #d1d1d1;width:auto;margin:auto;" align="center">
                                    <p class="txtGray">写真が登録されていません。
                                        <br />「写真を登録する」のメニューより、登録してください。</p>
                                </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <input type="hidden" name="remove" value="" />
                                <input type="hidden" name="deletefile" value="" />
                                <input type="hidden" name="downloadfiles" value="" />
                                <input type="hidden" name="folder" value="" />
                                <input type="hidden" name="open" value="" />
                                <input type="hidden" name="picture" value="">
                                <input type="hidden" name="singledownload" value="" />
                                <input type="hidden" name="album" value="" />
                                <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
                                <input type="hidden" name="fromsrc" value="<?php echo $fromsrc; ?>" />
                            </div>    
                        </div>
                    </form>
                </div>

            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
        <div class="clear"></div>
    </body>
</html>
