<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
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
                        if (document.form1.elements["del[]"][i].value != "1") {
                            document.form1.elements["del[]"][i].checked = obj.checked;
                        }
                    }
                }
            }         
            function searchAll() {
                var keyword = document.form1.keyword.value;
                if (keyword.length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    document.form1.action = "";
                    return false;
                } else {
                    document.form1.action = '/storage/file/list.html?src=all&fromsrc=1&search=1&<?php echo $cashe ?>';
                    document.form1.submit();
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
                // event enter
                $('#textArea01').keypress(function(e) { 
                    if(e.which == 13) { 
                        searchAll();
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
                *position:absolute !important;*left:15em;
                _position:absolute;_top:0px;_left:.5em;
            }
            .searchArea {
                margin-right: 3px;
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
                    <form id="form1" name="form1" method="post" action="/storage/folder/delete.html?<?php echo $cashe ?>">
                        <div class="contentsBox">
                            <div class="contentsTopGray">
                                <h3 class="contentsttl floL">フォルダ一覧</h3>
                                <div class="searchArea floR">
                                    <input class="textArea01" id="textArea01" type="text" value="" size="15" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>" style="margin-right: 1px;"/>
                                    <a class="submit01 btn" name="search" onclick="searchAll();"></a>
                                </div>
                            </div>
                            <div class="contentsMain">
                                <div class="padArea">
                                    <?php if ($message) : ?><div class="txtRed txtBold space_5"><?= $message ?></div> <?php endif; ?>
                                    <h3>フォルダ名をクリックすると詳細を見ることができます。</h3>
                                </div>
                                <table cellpadding="0" cellspacing="0" class="tblFilesList">
                                    <thead>
                                        <tr>
                                            <th class="bgBlueGra txtWhite" colspan="6">
                                                <div style="position:relative;">
                                                    <div style="float:left;">
                                                        <a href="/storage/file/regist.html?<?php echo $cashe ?>">ファイルを登録</a>｜
                                                        <a href="/storage/folder/regist.html?<?php echo $cashe ?>">フォルダを追加</a>｜
                                                    </div>
                                                    <div class="curBlcok">
                                                        <div style="white-space:nowrap;">
                                                            <a href="javascript:;" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="古い順" align="absmiddle" /></a>
                                                        </div>
                                                        <div class="contextMenu" style="width:6em;">
                                                            <ul id="menulist" class="dropMenu" style="background-color:#fff;width:6em;_overflow:hidden;">
                                                                <?php foreach ($optsort as $key => $label) : ?>
                                                                    <li class="BookmarkMenu">
                                                                        <a onclick="goToSorting('/storage/folder/list.html?fid=&src=&fromsrc=0&keyword=&sort=<?php echo $key ?>&<?php echo $cashe ?>');">
                                                                            <?php echo h($label) ?>
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
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="BGColorGray" style="white-space:nowrap;">
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onClick="change(this)"/><span>すべて選択</span>
                                                    <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><input name="delete" type="button" onclick="submit()" value="フォルダの削除"  class="submitxx" />
                                                </div>
                                            </td>
                                            <td colspan="3" class="BGColorGray txtRight" style="white-space:nowrap;">
                                                <div class="pagelistArea">
                                                    <?php if (isset($pageData['back']) && $pageData['back'] !="") : ?>
                                                        <span><a href="/storage/folder/list.html?fid=&page=<?php echo $pageData['back'] ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>">≪前へ</a></span>
                                                    <?php endif; ?>
                                                    <?php foreach ($pageData['link_num'] as $list) : ?>
                                                        <?php if ($pageData['page'] == $list) : ?><span class="now-page" ><?php echo $list ?></span><?php else: ?><span><a href="/storage/folder/list.html?fid=&page=<?php echo $list ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>"><?php echo $list ?></a></span><?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (isset($pageData['next']) && $pageData['next']!="") : ?>
                                                        <span><a href="/storage/folder/list.html?fid=&page=<?php echo $pageData['next'] ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>">次へ≫</a></span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="BGColorGray" style="white-space:nowrap;">
                                                <div class="pageMenuArea">
                                                    <input name="checkbox" type="checkbox" class="chechBox01" onClick="change(this)"/><span>すべて選択</span>
                                                    <img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><input name="delete" type="button" onclick="submit()" value="フォルダの削除"  class="submitxx" />
                                                </div>
                                            </td>
                                            <td colspan="3" class="BGColorGray txtRight" style="white-space:nowrap;">
                                                <div class="pagelistArea">
                                                    <?php if (isset($pageData['back']) && $pageData['back'] !="") : ?>
                                                        <span><a href="/storage/folder/list.html?fid=&page=<?php echo $pageData['back'] ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>">≪前へ</a></span>
                                                    <?php endif; ?>
                                                    <?php foreach ($pageData['link_num'] as $list) : ?>
                                                        <?php if ($pageData['page'] == $list): ?><span class="now-page" ><?php echo $list ?></span><?php else: ?><span><a href="/storage/folder/list.html?fid=&page=<?php echo $list ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>"><?php echo $list ?></a></span><?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if (isset($pageData['next']) && $pageData['next']!="") : ?>
                                                        <span><a href="/storage/folder/list.html?fid=&page=<?php echo $pageData['next'] ?>&src=&fromsrc=0&keyword=&sort=<?php echo $sort ?>&<?php echo $cashe ?>">次へ≫</a></span>
                                                    <?php endif; ?>
                                                    <!--ページング処理-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="txtSmaller" style="width: 174px;">フォルダ名</th>
                                            <th class="txtSmaller" style="width: 38px;"><div align="center">ファイル</div></th>
                                            <th class="txtSmaller" style="width: 35px;">容量</th>
                                            <th class="txtSmaller" style="width: 140px;">コメント</th>
                                            <th class="txtSmaller" nowrap="nowrap" style="width: 55px;">公開状態</th>
                                            <th class="txtSmaller" nowrap="nowrap" style="width: 53px;">編集/削除</th>
                                        </tr>

                                        <?php for ($i = (($pageData['page'] - 1) * $pageData['items']) ; $i < (($pageData['page'] - 1) * $pageData['items'] + $pageData['items']) && $i < $pageData['total']; $i++) : ?>
                                            <tr class="<?php if ($i % 2 == 0): ?>even<?php else: ?>odd<?php endif; ?>">
                                                <td>
                                                    <div style="width: 10%; float: left;">
                                                    <input type="checkbox" name="del[]" class="chechBox01" value="<?php echo $folderList[$i]['file_folder_id'] ?>" <?php if ($folderList[$i]['file_folder_id'] == "1") : ?> disabled="true" <?php endif; ?> />
                                                    </div>
                                                    <div style="width: 90%; float: right;">
                                                    <a href="/storage/file/list.html?fid=<?php echo $folderList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>" class="iconFolder" style="word-wrap: break-word; width: 145px;"><?php echo h($folderList[$i]['file_folder_name']); ?></a>
                                                    </div>
                                                </td>
                                                <td><?php echo $folderList[$i]['count'] ?></td>
                                                <td>
                                                    <?php echo $this->Common->modifierByte($folderList[$i]['amount']) ?>
                                                </td>
                                                <td>
                                                    <div style="word-wrap: break-word; width:140px;"><?php echo h($folderList[$i]['comment']); ?></div>
                                                </td>
                                                <td nowrap="nowrap">
                                                    <?php if ($folderList[$i]['openstatus'] == 0) : ?>
                                                        <span class="open_status" style="line-height:100%;">非公開</span>&nbsp;
                                                    <?php else : ?>
                                                        <a href="/storage/file/open/status.html?ffid=all&fid=<?php echo $folderList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>" style="line-height:100%;">公開中</a>&nbsp;
                                                    <?php endif; ?>
                                                    <a href="/storage/file/open/regist.html?fid=<?php echo $folderList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>';"><img src="/contents/images/icon_folder_add12.gif" alt="公開設定" /></a>
                                                </td>
                                                <td nowrap="nowrap">
                                                    <div  class="txtCneter">
                                                        <a href="/storage/folder/edit.html?fid=<?php echo $folderList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>"><img src="/contents/images/icon_edit12a.gif" /></a>
                                                        <?php if ($folderList[$i]['file_folder_id'] == "1") : ?>
                                                        <?php else : ?>
                                                            <a href="/storage/folder/delete.html?del[]=<?php echo $folderList[$i]['file_folder_id'] ?>&<?php echo $cashe ?>"><img src="/contents/images/icon_delete12.gif" /></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>


