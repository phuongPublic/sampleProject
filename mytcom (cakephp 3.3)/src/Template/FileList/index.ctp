<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>

        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />

        <script>
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

            function RemoveFileData(id) {
                var flg;
                if (id == "" || id == null) {
                    alert('移動できません。');
                    return;
                }


                if (!document.form1.elements["del[]"]) {
                    alert('ファイルが存在しません。');
                } else {


                    if (document.form1.elements["del[]"].length > 1) {
                        for (var i = 0; i < document.form1.elements["del[]"].length; i++) {
                            if (document.form1.elements["del[]"][i].checked == true) {
                                flg = 1;
                            }
                        }

                        if (flg == 1) {
                            msg = "ファイルを移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            msg = "ファイルを移動してもよろしいですか？";
                            if (window.confirm(msg)) {
                                document.form1.elements["deletefile"].value = "";
                                document.form1.elements["folder"].value = id;
                                document.form1.elements["remove"].value = 1;
                                document.form1.submit();
                            }
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }

                    }

                }
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
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
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
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["open"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = 0;
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
            }


            function DownloadFileData() {
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
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }
                    } else {
                        if (document.form1.elements["del[]"].checked == true) {
                            document.form1.elements["deletefile"].value = "";
                            document.form1.elements["downloadfiles"].value = 1;
                            document.form1.submit();
                        } else {
                            msg = "ファイルが選択されていません。";
                            alert(msg);
                        }

                    }
                }
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["deletefile"].value = 0;
                document.form1.elements["downloadfiles"].value = 0;
                document.form1.elements["open"].value = "";
            }


            function SingleDownload(num) {
                document.form1.elements["deletefile"].value = "";
                document.form1.elements["file"].value = num;
                document.form1.elements["singledownload"].value = 1;
                document.form1.submit();
                document.form1.elements["singledownload"].value = "";
                document.form1.elements["downloadfiles"].value = 0;
            }


            function sort(sel) {
                mlink = sel.options[sel.selectedIndex].value;
                if (mlink != "-") {
                    location.href = mlink;
                }
            }

            function validatorLength() {
                if ($('#keyword').val().length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    document.form1.action = "";
                    return false;
                } else {
                    var url_action = '/storage/file/list.html?fromsrc=1<?php if (!$fid) : ?>&src=all&search=1<?php else : ?>&fid=<?php echo $fid ?>&search=1<?php endif; ?>&<?php echo $cashe ?>';
                    $('#form1').attr('action', url_action);
                    $('#form1').submit();
                }
            }

            function goToSorting(url) {
                window.location.href = url;
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var cbox = $("input.chechBox01:checkbox").val([]);
                cbox = false;
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
                // event enter
                $('#keyword').keypress(function(e) {
                    if(e.which == 13) {
                        validatorLength();
                    }
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
                *position:absolute !important;*left:9em;
                _position:absolute;_top:0px;_left:.5em;
            }
            .kmBox {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconFiles"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>
                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <form id="form1" name="form1" method="post" action="#">
                        <div class="contentsBox">
                            <div class="contentsTopGray">
                                <h3 class="contentsttl floL">
                                    フォルダ<?php if ((isset($keyword) && $keyword != "" ) || $fromsrc) { ?>の検索結果
                                    <?php } else { ?>詳細<?php } ?>
                                </h3>
                                <div class="searchArea floR">
                                    <input class="textArea01" type="text" value="" id="keyword" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>" />
                                    <input class="submit01" value="" name="search" onclick = "validatorLength();" readonly />
                                    <?php if (isset($helpLinkUrl['FileList'])) : ?>
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['FileList'] ?>" target="_blank">この機能のヘルプ</a>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="contentsMain">
                                <?php if (!isset($errorSearch)) { ?>
                                    <?php if ((isset($keyword) && $keyword != "" ) || $fromsrc) { ?>
                                        <div style="word-wrap: break-word; width:auto;">
                                            <p class="txtBold bdrbot">"<?= $this->Common->htmlEscapeNotQuote($keyword) ?>"の 該当件数：<?php echo $resultNum ?>件<br /></p></div>
                                    <?php } else { ?>
                                        <?php
                                            $width = '440px';
                                            $folder_name = '';
                                            $folder_comment = '';
                                            foreach ($folderList1 as $list) {
                                                if ($fid == $list['file_folder_id']) {
                                                    $folder_name     = $list['file_folder_name'];
                                                    $folder_comment  = $list['comment'];
                                                    if(mb_strlen($folder_comment) > 80) {
                                                        $width = '620px';
                                                    }
                                                }
                                            }
                                        ?>
                                        <div class="iconFiles" style="width: 410px;">
                                            <h1 class="txtBold" id="title" style="word-wrap: break-word; width: 410px;">
                                                <?php echo h($folder_name); ?>
                                            </h1>
                                            <div style="word-wrap: break-word; width: 410px;"><?php echo h($folder_comment); ?></div>
                                        </div>
                                        <?php if ($src != "all") { ?>
                                            <div class="kmBox">ファイル数：<span class="txtBold"><?php echo $resultNum; ?>(<?php echo $this->Common->modifierByte($datasize)?>)</span><br /><?php if ($openFlg != 1) : ?>非公開<?php else : ?>公開中[&nbsp;<a href="/storage/file/open/status.html?&ffid=all&fid=<?php echo $fid ?>&<?php echo $cashe ?>">公開状況を確認</a>&nbsp;]<?php endif; ?>
                                                <div class="kmBoxLT"></div>
                                                <div class="kmBoxRT"></div>
                                                <div class="kmBoxLB"></div>
                                                <div class="kmBoxRB"></div>
                                            </div>
                                            <div class="alubumItems space_5">
                                                <?php if ($message) : ?>
                                                    <p class="txtRed txtBold floL" style="margin-top:-3px;">
                                                        <?php echo $message ?>
                                                    </p>
                                                <?php endif; ?>

                                                <div class="floR">
                                                    <a href="/storage/file/open/regist.html?openflg=1&fid=<?php echo $fid ?>&<?php echo $cashe ?>" >友人に公開する</a> ｜
                                                    <a href="/storage/folder/edit.html?fid=<?php echo $fid ?>&<?php echo $cashe ?>">編集</a>
                                                    <?php if ($fid == "0001") : ?>
                                                    <?php else : ?>
                                                    ｜ <a href="/storage/folder/delete.html?del[]=<?php echo $fid ?>&<?php echo $cashe ?>">削除</a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <div class="clear"></div>
                                <?php if ((isset($keyword) && $keyword != "" ) || $fromsrc) : ?>
                                    <?php if ($resultNum == 0) : ?>
                                        <?php if (isset($errorSearch)) { ?>
                                            <p class="txtRed txtBold">検索キーワードには65536文字以内で入力してください。</p>
                                        <?php } else {?>
                                            <p class="txtRed txtBold">該当するファイルはありません。</p>
                                        <?php } ?>
                                    <?php else : ?>
                                    <p class="txtRight space_4">
                                    表示順変更：
                                    <select name="sortmenu" onChange="sort(this)">
                                            <option value="/storage/file/list.html?fid=<?php echo $fid ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=new&<?php echo $cashe; ?>"
                                                    <?php if ($sort == "new"  || $sort == "") : ?>
                                                    selected<?php endif; ?>>新しい順</option>
                                            <option value="/storage/file/list.html?fid=<?php echo $fid ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?> &sort=old&<?php echo $cashe; ?>"
                                                    <?php if ($sort == "old") : ?>
                                                    selected <?php endif; ?>>古い順</option>
                                    </select>
                                    </p>
                                    <?php endif; ?> 
                                <?php endif; ?> 

                                <?php if ($fileList) : ?>
                                <table cellpadding="0" cellspacing="0" class="tblFilesList">
                                    <?php if (!$keyword && $fromsrc == 0) : ?>
                                    <thead>
                                        <tr>
                                            <th class="bgBlueGra txtWhite" colspan="8">
                                                <div style="position:relative;">
                                                    <div style="float:left;">
                                                        <a href="/storage/file/regist.html?fid=<?php echo $fid ?>&<?php echo $src ?>">ファイルを登録する</a>｜
                                                    </div>
                                                    <div class="curBlcok">
                                                        <div style="white-space:nowrap;"><a href="javascript:" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="" align="absmiddle" /></a></div>
                                                        <div class="contextMenu" style="width:6em;">
                                                            <ul id="menulist" class="dropMenu" style="background-color:#fff;width:6em;_overflow:hidden;">
                                                                <?php foreach ($optsort as $key => $list) : ?>
                                                                <li class="BookmarkMenu">
                                                                    <a onclick="goToSorting('/storage/file/list.html?fid=<?php echo $fid ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $key ?>&<?php echo $src ?>');">
                                                                        <?php echo $list ?>
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
                                            <td class="BGColorGray" colspan="6" style="white-space:nowrap;">
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;&nbsp;
                                                    <?php if ($src != "all") : ?>
                                                    <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="OpenFileData();" /> ｜
                                                    <?php endif; ?>
                                                    <img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" />
                                                    <input id="download" name="download" type="button" value="ダウンロード" class="submitxx" onclick="DownloadFileData()" /> ｜
                                                    <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" id="dropbtn2">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />
                                                    <div id="folder_list2" style="position:absolute;left:260px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                                                        <ul style="padding:10px;">
                                                            <?php foreach ($folderList1 as $item) : ?>
                                                            <li style="padding:0;display:block;">
                                                                <a href="javascript:" onclick="RemoveFileData('<?= $item['file_folder_id'] ?>')" style="padding:0 0 5px 0;display:block;">
                                                                    <?= h($item['file_folder_name']); ?></a>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <?php if ($resultNum >0) : ?>
                                                    ｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" />
                                                    <input name="delete" type="button" value="削除する" class="submitxx" onclick="DeleteFileData()"/>
                                                    <?php endif; ?>
                                                </div>

                                            </td>
                                            <td class="txtRight BGColorGray" colspan="2" style="white-space:nowrap;">
                                                <div class="pagelistArea">
                                                    <?php if (isset($pagedata['back']) && $pagedata['back'] !="") : ?>
                                                        <span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $pagedata['back'] ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>">≪前へ</a></span>
                                                    <?php endif; ?>
                                                    <?php foreach ($pagedata['link_num'] as $list) : ?>
                                                        <?php if ($pagedata['page'] == $list) : ?><span class="now-page" ><?php echo $list ?></span>
                                                        <?php else : ?>
                                                            <span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $list ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>"><?php echo $list ?></a></span>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (isset($pagedata['next']) && $pagedata['next']!="") : ?>
                                                        <span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $pagedata['next'] ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>">次へ≫</a></span>
                                                    <?php endif; ?>
                                                     <!--ページング処理--> 
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td class="BGColorGray" colspan="6" style="white-space:nowrap;">
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;&nbsp;
                                                    <?php if ($src != "all") : ?>
                                                    <img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><input type="button" name="open_btn" value="友人に公開" class="submitxx" style="width:5.5em;" onclick="OpenFileData();"/> ｜
                                                    <?php endif; ?>
                                                    <img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" />
                                                    <input id="download" name="download" type="button" value="ダウンロード" class="submitxx" onclick="DownloadFileData()" /> ｜
                                                    <img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" />
                                                    <a href="javascript:void(0);" id="dropbtn1">移動する</a><img src="/contents/images/icon_arrow_down12.gif" alt="" />

                                                    <div id="folder_list" style="z-index:10;position:absolute;left:260px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                                                        <ul style="padding:10px;">
                                                            <?php foreach ($folderList1 as $item) : ?>
                                                            <li style="padding:0;display:block;">
                                                                <a href="javascript:" onclick="RemoveFileData('<?= $item['file_folder_id'] ?>')" style="padding:0 0 5px 0;display:block;">
                                                                    <?= h($item['file_folder_name']); ?>
                                                                </a>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <?php if ($resultNum >0) : ?>
                                                    ｜ <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" />
                                                    <input name="delete" type="button" value="削除する" class="submitxx" onclick="DeleteFileData()"/>
                                                    <?php endif; ?>

                                                </div>
                                            </td>
                                            <td class="txtRight BGColorGray" colspan="2" style="white-space:nowrap;">
                                                <div class="pagelistArea">                  
                                                    <?php if (isset($pagedata['back']) && $pagedata['back'] !="") : ?>
                                                        <span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $pagedata['back'] ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>">≪前へ</a></span>
                                                    <?php endif; ?>
                                                    <?php foreach ($pagedata['link_num'] as $list) : ?>
                                                    <?php if ($pagedata['page'] == $list) : ?><span class="now-page" ><?php echo $list ?></span><?php else : ?><span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $list ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>"><?php echo $list ?></a></span><?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (isset($pagedata['next']) && $pagedata['next']!="") : ?>
                                                        <span><a href="/storage/file/list.html?fid=<?php echo $fid ?>&page=<?php echo $pagedata['next'] ?>&src=<?php echo $src ?>&fromsrc=<?php echo $fromsrc ?>&keyword=<?php echo $keyword64 ?>&sort=<?php echo $sort ?>&<?php echo $cashe ?>">次へ≫</a></span>
                                                    <?php endif; ?>
                                                     <!--ページング処理-->   
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 8px;"></th>
                                            <th style="width: 120px;" class="txtSmaller">ファイル名</th>
                                            <th style="width: 155px;" class="txtSmaller">登録日</th>
                                            <th style="width: 31px;" class="txtSmaller">容量</th>
                                            <th style="width: 76px;" class="txtSmaller">フォルダ</th>
                                            <th style="width: 110px;">コメント</th>
                                            <th style="width: 63px;" class="txtSmaller" nowrap="nowrap">公開状態</th>
                                            <th style="width: 55px;" class="txtSmaller" nowrap="nowrap">編集/削除</th>
                                        </tr>
                                        <?php for ($i = (($pagedata['page'] - 1) * $pagedata['items']); $i < (($pagedata['page'] - 1) * $pagedata['items'] + $pagedata['items']) && $i < $pagedata['total']; $i++) : ?>       
                                        <tr class="<?php if ($i % 2 == 0) : ?>even<?php else : ?> odd<?php endif; ?>">
                                            <td style="width: 8px;">
                                                <input name="del[]" type="checkbox" class="chechBox01" value="<?php echo $fileList[$i]['file_id'] ?>" />
                                            </td>
                                            <td style="width: 120px; word-wrap: break-word;">
                                                <div style="width: 120px; word-wrap: break-word;">
                                                <a href="javascript:SingleDownload('<?php echo $fileList[$i]['file_id'] ?>');">
                                                    <?php echo $fileList[$i]['extension']!="" ? h($fileList[$i]['name'].".".$fileList[$i]['extension']) : h($fileList[$i]['name']) ?>
                                                </a>
                                                </div>
                                            </td>
                                            <td style="width: 92px;">
                                                <?php echo $fileList[$i]['reg_date']->i18nFormat('YYYY-MM-dd') ?>
                                            </td>
                                            <td style="width: 60px;">
                                                <?php echo $this->Common->modifierByte($fileList[$i]['amount']) ?>
                                           </td>
                                            <td style="width: 60px; word-wrap: break-word;">
                                                <div style="width: 60px; word-wrap: break-word;">
                                                <a href="/storage/file/list.html?fid=<?php echo $fileList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>" >
                                                    <?php echo isset($fileList[$i]['file_folder_name']) ? h($fileList[$i]['file_folder_name']) : ''; ?>
                                                </a>
                                                </div>
                                            </td>
                                            <td style="width:110px; word-wrap: break-word;">
                                                <div style="width:110px; word-wrap: break-word;">
                                                    <?php echo h($fileList[$i]['file_comment']); ?>
                                                </div>
                                            </td>
                                            <td style="width: 63px;" nowrap="nowrap">
                                                <?php if ($fileList[$i]['openFlg'] == 1) : ?>
                                                <a href="/storage/file/open/status.html?fid=<?php echo $fileList[$i]['file_folder_id'] ?>&ffid=<?php echo $fileList[$i]['file_id'] ?>&<?php echo $cashe; ?>" >公開中</a>&nbsp;<a href="/storage/file/open/regist.html?fid=<?php echo $fileList[$i]['file_folder_id'] ?>&ffid=<?php echo $fileList[$i]['file_id'] ?>&<?php echo $cashe; ?>'"><img src="/contents/images/icon_folder_add12.gif" alt="公開設定" /></a>
                                                <?php else : ?>
                                                非公開&nbsp;<a href="/storage/file/open/regist.html?fid=<?php echo $fileList[$i]['file_folder_id'] ?>&ffid=<?php echo $fileList[$i]['file_id'] ?>&<?php echo $cashe; ?>'"><img src="/contents/images/icon_folder_add12.gif" alt="公開設定" /></a>
                                                <?php endif; ?>
                                            </td>
                                            <td style="width: 55px;" nowrap="nowrap">
                                                <div  class="txtCneter">
                                                    <a href="/storage/file/edit.html?ffid=<?php echo $fileList[$i]['file_id'] ?>&<?php echo $cashe ?>">
                                                        <img src="/contents/images/icon_edit12a.gif" />
                                                    </a>

                                                    <a href="/storage/file/delete.html?fid=<?php echo $fid ?>&del[]=<?php echo $fileList[$i]['file_id'] ?>&fromsrc=<?php echo $fromsrc ?>&<?php echo $cashe ?>">
                                                        <img src="/contents/images/icon_delete12.gif" />
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                                <?php else : ?>
                                    <?php if (!$keyword) : ?> 
                                    <div style="padding:10px 0 30px 20px;text-align:center;border:1px solid #d1d1d1;width:auto;margin-top:5px;" align="center">
                                    <p class="txtGray">ファイルが登録されていません。<br />「ファイルを登録する」のメニューより、登録してください。</p>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <input type="hidden" name="folder" value=""/>
                                <input type="hidden" name="remove" value=""/>
                                <input type="hidden" name="file" value=""/>
                                <input type="hidden" name="open" value=""/>
                                <input type="hidden" name="deletefile" value="" />
                                <input type="hidden" name="downloadfiles" value="" />
                                <input type="hidden" name="singledownload" value="">
                                <input type="hidden" name="fid" value="<?php echo $fid ?>">
                                <input type="hidden" name="fromsrc" value="<?php echo $fromsrc ?>" />
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


