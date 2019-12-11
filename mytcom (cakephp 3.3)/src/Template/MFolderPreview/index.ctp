<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            $(document).ready(function () {
                $('#keyword').keypress(function(e) {
                    if(e.which == 13) {
                        validatorLength();
                    }
                });
            });

            function validatorLength() {
                if ($('#keyword').val().length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    return false;
                } else {
                    var url_action = '/movie/preview.html?mid=<?php echo $mid; ?>&fromsrc=1<?php if (!$mid): ?>&src=all<?php endif; ?>&search=1&<?php echo $cashe; ?>';
                    $('#form1').attr('action', url_action);
                    $('#form1').submit();
                }
            }
            function change(obj) {
                document.form1.elements["checkbox"][0].checked = obj.checked;
                document.form1.elements["checkbox"][1].checked = obj.checked;
                if (document.form1.elements["del[]"]) {
                    document.form1.elements["del[]"].checked = obj.checked;
                    for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                        document.form1.elements["del[]"][i].checked = obj.checked;
                    }
                }
            }

            function goToSorting(url) {
                window.location.href = url;
            }
            function RemoveFileData(id) {
                var flg;
                if (id == "" || id == null) {
                    alert('移動できません。');
                    return;
                }

                var selected = document.getElementsByName("del[]");

                if (selected.length == 0) {
                    alert('ファイルが存在しません。');
                } else {

                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            msg = "動画を移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            msg = "動画を移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["open"].value = "";

            }

            function DeleteFileData() {
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
                            document.form1.elements["open"].value = "";
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["open"].value = "";
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }

                    }
                }

            }

            function OpenFileData() {
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
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["open"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "動画が選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = 0;
                document.form1.elements["open"].value = "";
            }

            function BookMarkMenu(id) {
                if (document.getElementById(id).style.display == "none") {
                    document.getElementById(id).style.display = "block";
                } else {
                    document.getElementById(id).style.display = "none";
                }
            }

            function sort(sel) {
                mlink = sel.options[sel.selectedIndex].value;
                if (mlink != "-") {
                    location.href = mlink;
                }
            }

        </script>
        <script type="text/javascript">
            $(document).ready(function () {
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
                *position:absolute !important;*left:7em;
                _position:absolute;_top:0px;_left:.5em;
            }
            .crop {
                width: 100px;
                height: 75px;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
    <div id="wrapper">

        <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

        <div id="mainContents">

            <div id="messageArea">
                <h1 class="iconMovie">動画</h1></div>
            <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
            <div id="contentsRight">
                <form action="preview.html?mid=<?= $mid ?>&fromsrc=1<?php if (!$mid): ?>&src=all<?php endif; ?>&<?= $cashe ?>" method="post" name="form1" id="form1">

                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">動画フォルダの<?php if ((isset($keyword) && $keyword != "") || $fromsrc): ?>検索結果<?php else: ?>詳細<?php endif; ?></h3>
                            <div class="searchArea floR"  style="margin-top: 9px;">
                                <input class="textArea01" id="keyword" type="text" value="" size="15" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>"/>
                                <input class="submit01" onclick = "validatorLength();" style="margin-right: 4px; margin-left: 1px;"/>
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['MFolderPreview'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                        </div>
                        <div class="contentsMain">
                            <?php if ((isset($keyword) && $keyword != '') || $fromsrc): ?>
                            <p class="txtBold bdrbot space_4">
                                "<?= $this->Common->htmlEscapeNotQuote($keyword) ?>"の 該当件数：<?= $resultNum ?>件</p>
                            <?php else: ?>
                            <div class="iconMovie">
                                <?php foreach ($movieFolderList as $folder): ?>
                                <?php if ($mid == $folder['movie_folder_id']): ?>
                                <h1 class="txtBold"><?= h($folder['movie_folder_name']) ?></h1>
                                <div style="word-wrap: break-word; width: 410px;"><?php echo h($folder['movie_folder_comment']); ?></div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($src != 'all'): ?>
                            <div class="kmBox">ファイル数:<span class="txtBold"><?= $resultNum ?>(<?php echo $this->Common->modifierByte($dataSize)?>)</span>
                                <br />
                                <?php if($openStatus == 0 && $openFlg == 0): ?>
                                非公開
                                <?php else: ?>
                                公開中 [
                                <a href="/movie/open/status.html?cid=all&mid=<?= $mid ?>&<?= $cashe ?>" class="open_status" style="white-space:nowrap;">公開状況を確認</a>&nbsp;]
                                <?php endif; ?>
                                <div class="kmBoxLT"></div>
                                <div class="kmBoxRT"></div>
                                <div class="kmBoxLB"></div>
                                <div class="kmBoxRB"></div>
                            </div>
                            <?php endif; ?>
                            <div class="clear space_4"></div>
                            <?php if (!$keyword): ?>
                            <div class="alubumItems space_4">
                                <?php if (isset($message)): ?>
                                <p class="txtRed txtBold floL" style="margin-top:-8px;">
                                    <?= $message ?>
                                </p>
                                <?php endif; ?>
                                <div class="floR">
                                    <a href="/movie/open/regist.html?openflg=4&mid=<?= $mid ?>&<?= $cashe ?>">友人に公開する</a> ｜
                                    <a href="/movie/edit.html?mid=<?= $mid ?>&<?= $cashe ?>">編集</a>
                                    <?php if ($mid != 1): ?>
                                    ｜ <a href="/movie/delete.html?mid=<?= $mid ?>&<?= $cashe ?>">削除</a>
                                    <?php endif; ?>
                                </div>
                                <div style="clear:both;"></div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if ((isset($keyword) && $keyword != '') || $fromsrc): ?>
                            <?php if($resultNum == 0): ?>
                            <p class="txtRed txtBold">該当する動画はありません。</p>
                            <?php else: ?>
                            <p class="txtRight space_4">
                                表示順変更：
                            <select name="sortmenu" onChange="sort(this)">
                            <?php if (isset($mid)): ?>
                            <option value="/movie/preview.html?mid=<?= $mid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=new&<?= $cashe ?>" <?php if ($sort=="new" || $sort=="") : ?>selected
                            <?php endif; ?>>新しい順</option>
                            <option value="/movie/preview.html?mid=<?= $mid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=old&<?= $cashe ?>" <?php if ($sort=="old") : ?>selected
                            <?php endif; ?>>古い順</option>
                            <?php else: ?>
                            <option value="/movie/preview.html?mid=&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=new&<?= $cashe ?>" <?php if ($sort=="new" || $sort=="") : ?>selected
                            <?php endif; ?>>新しい順</option>
                            <option value="/movie/preview.html?mid=&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=old&<?= $cashe ?>" <?php if ($sort=="old") : ?>selected
                            <?php endif; ?>>古い順</option>
                            <?php endif; ?>
                            </select>
                            </p>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php if($data): ?>
                            <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                                <?php if(!$keyword && $fromsrc == 0): ?>
                                <thead>
                                <tr>
                                    <th class="bgBlueGra txtWhite" colspan="2">
                                        <div style="position:relative;">
                                            <div style="float:left;">
                                                <a href="/movie/contents/regist.html?&mid=<?= $mid ?>&<?= $cashe ?>">動画を登録</a> ｜
                                            </div>
                                            <div class="curBlcok">
                                                <div style="white-space:nowrap"><a href="javascript:;" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="" align="absmiddle" /></a></div>
                                                <div class="contextMenu" style="width:6em;">
                                                    <ul id="menulist" class="dropMenu" style="background-color:#fff;width:6em;_overflow:hidden;">
                                                        <?php foreach ($optsort as $key => $val) : ?>
                                                        <li class="BookmarkMenu">
                                                            <a onclick="goToSorting('/movie/preview.html?mid=<?= $mid ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $key ?>&<?= $cashe ?>')">
                                                                <?= $val ?>
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
                                            <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>
                                            <?php if($src != 'all'): ?>
                                            <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="javascript:OpenFileData();" /> ｜
                                            <?php endif; ?>
                                            <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" id="dropbtn2">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />

                                            <div id="folder_list2" style="position:absolute;left:160px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                                                <ul style="padding:10px;">
                                                    <?php foreach ($folderNameList as $key => $val) : ?>
                                                    <li style="padding:0;display:block;">
                                                        <a href="javascript:;" onclick="javascript:RemoveFileData('<?php echo $key; ?>')" style="padding:0 0 5px 0;display:block;color:#00608D;">
                                                            <?php echo h($val); ?>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <?php if ($resultNum): ?>
                                            ｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><input name="delete" type="button" value="削除する" class="submitxx" onclick="javascript:DeleteFileData()" />
                                            <?php endif; ?>

                                        </div>

                                    </td>
                                    <td class="txtRight BGColorGray">
                                        <div class="pagelistArea">
                                            <?php if($pageData['back']): ?>
                                            <a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $pageData['back'] ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>">≪前へ</a>

                                            <?php endif; ?>
                                            <?php foreach($pageData['link_num'] as $link): ?>
                                            <?php if ($pageData['page'] == $link): ?><span class="now-page"><?= $link ?></span>
                                            <?php else: ?><span><a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $link ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>"><?= $link ?></a></span>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if($pageData['next']): ?>
                                            <a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $pageData['next'] ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>">次へ≫</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                                <tbody>
                                <tr>
                                    <td class="BGColorGray">
                                        <div class="pageMenuArea">
                                            <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;&nbsp;
                                            <?php if ($src != 'all'): ?>
                                            <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="javascript:OpenFileData();" /> ｜
                                            <?php endif; ?>
                                            <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" id="dropbtn1">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />

                                            <div id="folder_list" style="position:absolute;left:160px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                                                <ul style="padding:10px;">
                                                    <?php foreach ($folderNameList as $key => $val) : ?>
                                                    <li style="padding:0;display:block;">
                                                        <a href="javascript:;" onclick="javascript:RemoveFileData('<?php echo $key; ?>')" style="padding:0 0 5px 0;display:block;color:#00608D;">
                                                            <?php echo h($val); ?>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <?php if ($resultNum): ?>
                                            ｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><input name="delete" type="button" value="削除する" class="submitxx" onclick="javascript:DeleteFileData()" />
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="txtRight BGColorGray">
                                        <div class="pagelistArea">
                                            <?php if($pageData['back']): ?>
                                            <a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $pageData['back'] ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>">≪前へ</a>

                                            <?php endif; ?>
                                            <?php foreach($pageData['link_num'] as $link): ?>
                                            <?php if ($pageData['page'] == $link): ?><span class="now-page"><?= $link ?></span>
                                            <?php else: ?><span><a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $link ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>"><?= $link ?></a></span>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if($pageData['next']): ?>
                                            <a href="/movie/preview.html?mid=<?= $mid ?>&page=<?= $pageData['next'] ?>&src=<?= $src ?>&fromsrc=<?= $fromsrc ?>&keyword=<?= $keyword64 ?>&sort=<?= $sort ?>&<?= $cashe ?>">次へ≫</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" valign="bottom">
                                        <table class="bottomTable">
                                            <tr>
                                                <?php foreach ($data as $key => $movie): ?>
                                                <?php if ($key > 0 && $key%5 == 0): ?>
                                            </tr>
                                            <tr>
                                                <?php endif; ?>
                                                <td>

                                                    <div class="movie01" title="<?= h($movie['movie_contents_name']) ?>">
                                                        <div class="space_5">
                                                            <?php if ($movie['encode_status'] == 2): ?>
                                                            <a href="/movie/contents/detail.html?cid=<?= $movie['movie_contents_id'] ?>&<?= $cashe ?>">
                                                                <img src="/movie/contents/picture.html?cid=<?= $movie['movie_contents_id'] ?>&type=1" width="100" class="crop"/>
                                                            </a>
                                                            <?php else: ?>
                                                            <img src="/movie/contents/picture.html?cid=<?= $movie['movie_contents_id'] ?>&type=1" width="100" class="crop"/>
                                                            <?php endif; ?>
                                                        </div>
                                                        <input name="del[]" type="checkbox" class="chechBox02" value="<?= $movie['movie_contents_id'] ?>" />
                                                        <br />
                                                        <div class="txtXSmall" style="margin:0 auto;width:112px;text-align:left;">

                                                            <?php if ($movie['encode_status'] == 2): ?>
                                                            <a href="/movie/contents/detail.html?cid=<?= $movie['movie_contents_id'] ?>&<?= $cashe ?>">
                                                                <?php echo h($this->Common->limitWord($movie['name'])); ?>
                                                            </a>
                                                            <?php else: ?>
                                                            <?php echo h($this->Common->limitWord($movie['name'])); ?>
                                                            <?php endif; ?>

                                                            <ul>
                                                                <li>・再生時間：<?= $this->Common->cutCommaSeconds($movie['reproduction_time']) ?></li>
                                                                <li>・サイズ：<?php echo $this->Common->modifierMbyte($movie['amount'])?></li>
                                                                <li>・登録：<?= $this->Common->date_format($movie['reg_date'], "%Y-%m-%d") ?></li>
                                                            </ul>
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
                            <?php else: ?>
                            <?php if ($resultNum == 0): ?>
                            <div style="padding:10px 0 30px 20px;text-align:center;border:1px solid #d1d1d1;width:auto;margin:auto;" align="center">
                                <p class="txtGray">動画が登録されていません。
                                    <br />「動画を登録する」のメニューより、登録してください。</p>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <input type="hidden" name="remove" value="" />
                            <input type="hidden" name="folder" value="" />
                            <input type="hidden" name="deletefile" value="" />
                            <input type="hidden" name="open" value="" />
                            <input type="hidden" name="picture" value="" />
                            <input type="hidden" name="singledownload" value="" />
                            <input type="hidden" name="album" value="" />
                            <input type="hidden" name="mid" value="<?= $mid ?>" />
                            <input type="hidden" name="delete_from_src" value="<?= $this->Common->htmlEscapeNotQuote($keyword) ?>" />
                            <input type="hidden" name="fromsrc" value="<?= $fromsrc ?>" />
                            <input type="hidden" name="mlscr" value="<?= $mlscr ?>" />
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
