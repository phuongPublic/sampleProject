<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            $(function() {
                $('.pagination').click(function() {
                    var checkedAddress = $('input[name="checkedAddress[]"]:checked').length;
                    var checkedGroup = $('input[name="checkedGroup[]"]:checked').length;
                    if(checkedAddress > 0 || checkedGroup > 0) {
                        if(!confirm("ページを移動すると、チェックボックスの状態がリセットされます。よろしいですか？")) {
                            return false;
                        }
                    }
                });
            });
            $(function(){
                $('input.btnovr').hover(function() {
                    $(this).addClass('btnovrOn');
                },
                function() {
                    $(this).removeClass('btnovrOn');
                });
            });
            $(function(){
                $('input.btnLong').hover(function() {
                    $(this).addClass('btnlongOn');
                },
                function() {
                    $(this).removeClass('btnlongOn');
                });
            });
            $(function(){
                $('input.btnstd').hover(function() {
                    $(this).addClass('btnstdOn');
                },
                function() {
                    $(this).removeClass('btnstdOn');
                });
                $(function(){
                    var $targetElement = '.forceBreak a';
                    if (checkMsie()) {
                        $($targetElement).css('word-break', 'break-all');
                    } else {
                        $($targetElement).each(function(){
                            if (navigator.userAgent.indexOf('Firefox/2') != - 1) {
                                $(this).html($(this).text().split('').join('<wbr />'));
                            } else {
                                $(this).html($(this).text().split('').join(String.fromCharCode(8203)));
                            }
                        });
                    }});
                $('tblFilesList tr:even').css('background-color', '#efefef');
            });
        </script>
        <script type="text/javascript">
            var checkFlag = true;
            var deleteMessage = "アドレス／グループを削除します。よろしいですか？";
            function Conformation() {
                var TgElements = document.getElementsByName("checkedAddress[]");
                var checkFlagAddress = false;
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (TgElement.checked) {
                        checkFlagAddress = true;
                    }
                }
                var TgElements2 = document.getElementsByName("checkedGroup[]");
                var checkFlagGroup = false;
                for (i = 0; i < TgElements2.length; i++) {
                    TgElement2 = TgElements2[i];
                    if (TgElement2.checked) {
                        checkFlagGroup = true;
                    }
                }

                if (checkFlagAddress == true || checkFlagGroup == true) {
                    if (window.confirm(deleteMessage)) {
                        $("#triggerDelete").val(1);
                        $("#form1").submit();
                    }
                } else {
                    alert("削除するグループ、もしくはアドレスを選択してください。");
                }
            }

            function ConformationSingle(id) {
                if (window.confirm(deleteMessage)) {
                    location.href = "/address/delete.html?pg=<?= h($page['page']) ?>&org=&adrdata_seq=" + id + "";
                }
            }

            function ConformationSingleGroup(id) {
                if (window.confirm(deleteMessage)) {
                    location.href = "/address/group/delete.html?group_id=" + id + "";
                }
            }

            function moveExport() {
                var stringExport = "エクスポート";
                $("#triggerExport").val(stringExport);
                $("#form1").submit();
            }

            //チェックボックス
            function AllMailCheck() {
                var TgElements = document.getElementsByName("checkedAddress[]");
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (checkFlag) {
                        TgElement.checked = true;
                    } else {
                        TgElement.checked = false;
                    }
                }
                var TgElements = document.getElementsByName("checkedGroup[]");
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (checkFlag) {
                        TgElement.checked = true;
                    } else {
                        TgElement.checked = false;
                    }
                }
                var checkbtn = document.getElementById("addrcheck");
                var checkbtn1 = document.getElementById("addrcheck1");
                if (checkFlag) {
                    checkFlag = false;
                    checkbtn.style.background = "url('/contents/images/no_check_all.gif')";
                    checkbtn.alt = "選択されたメールを全て解除";
                    checkbtn1.style.background = "url('/contents/images/no_check_all.gif')";
                    checkbtn1.alt = "選択されたメールを全て解除";
                } else {
                    checkFlag = true;
                    checkbtn.style.background = "url('/contents/images/check_all.gif')";
                    checkbtn.alt = "メールを全て選択";
                    checkbtn1.style.background = "url('/contents/images/check_all.gif')";
                    checkbtn1.alt = "メールを全て選択";
                }
                return false;
            }
            function searchAll() {
                var keyword = document.formSearch.categoryKeyword.value;
                if (keyword.length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    document.formSearch.action = "";
                    return false;
                } else {
                    document.formSearch.action = "/address/listview.html?search=1&<?php echo $cashe; ?>";
                    document.formSearch.submit();
                }
            }
            // event enter
            $(document).ready(function () { 
                $('#categoryKeyword').keypress(function(e) {
                    if(e.which == 13) {
                        searchAll();
                    }
                });
            });
        </script>
        <style type="text/css">
            .tblFilesList td{ border-right:1px solid #A3B8CD !important; }
            .tblFilesList .borderNone{ border-right:none !important; }
            .tblFilesList th{ font-weight: normal;}
            .tblFilesList tbody td.BGColorGray{ padding: 5px 10px !important;}
            .separation{ color:#fff;}
            .forceBreak{max-width:40%;_width:35%;}
            .forceBreak{word-break:break-all;}
            .forceBreak a{word-break:break-word;}
            .imageBlock {display:inline-block; cursor:pointer;}
            .checkImage {background: url("/contents/images/check_all.gif"); cursor:pointer; width:13px; height:13px; }
            .exportImage {background: url("/contents/images/export_icon.png"); cursor:pointer; width:18px; height:18px; font-size:0}
            .deleteImage {background: url("/contents/images/m_addr_delete.gif"); cursor:pointer; width:13px; height:13px; margin:1px 0 0 3px;}
            .imageText {position:relative; top:2px; font-size: 12px; cursor:pointer; background-color:#e7e7e7;}
            .separator {position:relative; top:1px;}
            th.thEdit, .tblFilesList tbody td.tdEdit {
                padding: 0 5px !important;
                border-right: none !important;
                width: 80px;
                text-align: center !important;
                white-space: nowrap !important;
            }
            .submit01 {margin-right: 5px;}
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            
            <div id="mainContents">
                <div id="messageArea"><h1 class="iconAddress"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <div id="contentsLeft">
                    <div class="sideBox">
                        <div class="sideTopGray">
                            <h2><b>メニュー</b></h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?pg=<?= h($page['page']) ?>&<?= $cashe ?>">アドレスを登録</a></li>
                                <li class="bdr"><a href="/address/group/regist.html?<?= $cashe ?>">グループを追加</a></li>
                                <li class="bdr"><a href="/address/import.html?<?= $cashe ?>">インポート</a></li> 
                                <li><a href="/address/listview.html?<?= $cashe ?>">アドレス帳を見る</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h2 class="contentsttl floL">アドレス帳一覧</h2>
                            <div class="searchArea floR">
                                <form id="formSearch" name="formSearch" action="?search=1&<?= $cashe ?>" method="post" style="display:inline-block;">
                                    <select name="category">
                                        <option label="メールアドレス" value="1">メールアドレス</option>
                                        <option label="ニックネーム" value="2">ニックネーム</option>
                                    </select>&nbsp;&nbsp;
                                    <input type="text" id="categoryKeyword" name="categoryKeyword" value="" class="textArea01" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>" />&nbsp;
                                    <a class="submit01 btn" name="search" onclick="searchAll();"></a>

                                    <?php if (isset($helpLinkUrl['AddressListview'])) : ?>
                                        <a class="iconHelp" href="<?php echo $helpLinkUrl['AddressListview'] ?>" target="_blank">この機能のヘルプ</a>
                                    <?php endif; ?> 
                                </form>
                            </div>
                        </div>
                        <div class="contentsMain">
                            <div class="padArea">
                                <div class="txtRed txtBold space_5"><?= $message ?></div>
                                アドレスの登録や、登録したアドレスの編集・削除を行うことができます。
                            </div>
                            <form method="post" name="form1" id="form1" action="?search=1&<?= $cashe ?>">
                                <table cellpadding="0" cellspacing="0" class="tblFilesList">
                                    <thead>
                                        <tr>
                                            <th class="bgBlueGra txtWhite" colspan="6">
                                                <a href="/address/edit.html?<?= $cashe ?>">アドレスを登録</a><span class="separation">｜</span>
                                                <a href="/address/group/regist.html?<?= $cashe ?>">グループを追加</a><span class="separation">｜</span>
                                                <a href="/address/import.html?<?= $cashe ?>">インポート</a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <input type="hidden" id="triggerDelete" name="delete" value="" />
                                        <input type="hidden" id="triggerExport" name="export" value="" />
                                        <tr>
                                            <td class="BGColorGray" colspan="4" nowrap="nowrap" style="border-right:0 !important;">
                                                <div style="position:relative;">
                                                    <div class="imageBlock" onclick="return AllMailCheck();" >
                                                        <input type="button" class="checkImage" id="addrcheck"/>
                                                        <span class="imageText">すべて選択</span>
                                                    </div>
                                                    <div class="imageBlock" onclick="Conformation();" >
                                                        <input type="button" class="deleteImage" />
                                                        <span class="imageText">削除する</span>
                                                    </div>
                                                    <span class="separator">｜</span>
                                                    <div class="imageBlock" onclick="moveExport();" >
                                                        <input type="button" class="exportImage" />
                                                        <span class="imageText">エクスポート</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="BGColorGray borderNone" colspan="2" align="right" nowrap="nowrap" style="border-left:0 !important;text-align:right;">
                                                <?php if ($page['total'] == 0) : ?>
                                                    <?= h($page['total']) ?>件 <?php else : ?>
                                                    <?= h($page['total']) ?>件中&nbsp;<?= h($page['start']) ?>-<?= h($page['end']) ?>件 &nbsp;<?php endif; ?>
                                                <?php if ($page['page'] > 1) : ?>
                                                    <a class="pagination" href="/address/listview.html?pg=1<?= $searchKeyword ?>&<?= $cashe ?>">&nbsp;最初 </a>
                                                <?php else : ?>
                                                    <span class="txtGray"> 最初 </span><?php endif; ?>｜<?php if ($page['page'] > 1) : ?>
                                                    <a class="pagination" href="/address/listview.html?pg=<?= $page['back'] ?><?= $searchKeyword ?>&<?= $cashe ?>"><<前 </a>
                                                <?php else : ?>
                                                    <span class="txtGray"><<前 </span><?php endif; ?>｜<?php if (!empty($page['next'])) : ?><a class="pagination" href="/address/listview.html?pg=<?= $page['next'] ?><?= $searchKeyword ?>&<?= $cashe ?>">次>></a>
                                                <?php else : ?><span class="txtGray">次>></span>
                                                <?php endif; ?>｜<?php if (!empty($page['next'])) : ?><a class="pagination" href="/address/listview.html?pg=<?= $page['total_page'] ?><?= $searchKeyword ?>&<?= $cashe ?>">最後</a><?php else : ?><span class="txtGray">最後</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td class="BGColorGray" colspan="4" style="border-right:0 !important;" nowrap="nowrap">
                                                <div style="position:relative;">
                                                    <div class="imageBlock" onclick="return AllMailCheck();" >
                                                        <input type="button" class="checkImage" id="addrcheck1"/>
                                                        <span class="imageText">すべて選択</span>
                                                    </div>
                                                    <div class="imageBlock" onclick="Conformation();" >
                                                        <input type="button" class="deleteImage" />
                                                        <span class="imageText">削除する</span>
                                                    </div>
                                                    <span class="separator">｜</span>
                                                    <div class="imageBlock" onclick="moveExport();" >
                                                        <input type="button" class="exportImage" />
                                                        <span class="imageText">エクスポート</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="BGColorGray borderNone" colspan="2" align="right" style="border-left:0 !important;text-align:right;">
                                                <?php if ($page['total'] == 0) : ?>
                                                    <?= h($page['total']) ?>件 <?php else : ?>
                                                    <?= h($page['total']) ?>件中&nbsp;<?= h($page['start']) ?>-<?= h($page['end']) ?>件 &nbsp;<?php endif; ?>
                                                <?php if ($page['page'] > 1) : ?>
                                                    <a class="pagination" href="/address/listview.html?pg=1<?= $searchKeyword ?>&<?= $cashe ?>">&nbsp;最初 </a>
                                                <?php else : ?>
                                                    <span class="txtGray"> 最初 </span><?php endif; ?>｜<?php if ($page['page'] > 1) : ?>
                                                    <a class="pagination" href="/address/listview.html?pg=<?= $page['back'] ?><?= $searchKeyword ?>&<?= $cashe ?>"><<前 </a>
                                                <?php else : ?>
                                                    <span class="txtGray"><<前 </span><?php endif; ?>｜<?php if (!empty($page['next'])) : ?><a class="pagination" href="/address/listview.html?pg=<?= $page['next'] ?><?= $searchKeyword ?>&<?= $cashe ?>">次>></a>
                                                <?php else : ?><span class="txtGray">次>></span>
                                                <?php endif; ?>｜<?php if (!empty($page['next'])) : ?><a class="pagination" href="/address/listview.html?pg=<?= $page['total_page'] ?><?= $searchKeyword ?>&<?= $cashe ?>">最後</a><?php else : ?><span class="txtGray">最後</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="padding:0 !important;">
                                                <table class="tblFilesList" style="margin-top:0;border:none;">
                                                    <?php if (!empty($addressDataList)) : ?>
                                                        <tr>
                                                            <th class="xshort"></th>
                                                            <th class="xshort"></th>
                                                            <th class="txtSmaller">ニックネーム/グループ名</th>
                                                            <th class="txtSmaller" style="min-width:102px">メールアドレス</th>
                                                            <th class="txtSmaller" style="width: 120px;">電話番号</th>
                                                            <th class="thEdit borderNone txtSmaller">編集 / 削除</th>
                                                        </tr>
                                                        <?php foreach ($addressDataList as $address) : ?>
                                                            <?php if (empty($address['email'])) : ?>
                                                                <tr>
                                                                    <td class="txtCneter xshort"><input type="checkbox" name="checkedGroup[]" value="<?= h($address['group_id']) ?>"></td>
                                                                    <td class="txtCneter xshort"><img src="/contents/images/icon_group12.gif" /></td>
                                                                    <td class="forceBreak"><div>
                                                                        <?php if (!empty($address['group_name'])) : ?>
                                                                            <?= h($address['group_name']) ?>
                                                                        <?php else : ?>
                                                                            未設定
                                                                        <?php endif; ?></div></td>
                                                                    <td class="forceBreak">
                                                                        <?php if (empty($address['num'])) : ?>
                                                                            <a href="/address/group/list.html?group_id=<?= h($address['group_id']) ?>&pg=<?= h($page['page']) ?>&<?= $cashe ?>" style="text-decoration: underline;font-weight:bold;">(0件のアドレス)</a>
                                                                        <?php else : ?>
                                                                            <a href="/address/group/list.html?group_id=<?= h($address['group_id']) ?>&pg=<?= h($page['page']) ?>&<?= $cashe ?>" style="text-decoration: underline;font-weight:bold;">(<?= $address['num'] ?>件のアドレス)</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>&nbsp;</td>
                                                                    <td class="tdEdit borderNone"><a href="/address/group/edit.html?group_id=<?= h($address['group_id']) ?>&<?= $cashe ?>"><img src="/contents/images/icon_edit12a.gif" alt="編集"></a>&nbsp;&nbsp;
                                                                        <a href="javascript:ConformationSingleGroup('<?= h($address['group_id']) ?>')"><img src="/contents/images/icon_delete12.gif" alt="削除"></a>
                                                                    </td>
                                                                </tr>
                                                            <?php else : ?>
                                                                <tr>
                                                                <td class="txtCneter xshort"><input type="checkbox" name="checkedAddress[]" value="<?= h($address['adrdata_seq']) ?>"></td>
                                                                <td class="txtCneter xshort">&nbsp;</td>
                                                                <td class="forceBreak">
                                                                    <?php if (!empty($address['nickname'])) : ?>
                                                                        <a href="/address/detailview.html?adrdata_seq=<?= h($address['adrdata_seq']) ?>&pg=<?= h($page['page']) ?>&<?= $cashe ?>" style="text-decoration: underline;"><?= h($address['nickname']) ?></a>
                                                                    <?php else : ?>
                                                                        なし
                                                                    <?php endif; ?></td>
                                                                <td class="forceBreak"><?= h($address['email']) ?></td>
                                                                <?php if (!empty($address['work_tel'])) : ?>
                                                                    <td class="forceBreak"><?= h($address['work_tel']) ?></td>
                                                                <?php elseif (!empty($address['home_tel'])) : ?>
                                                                    <td class="forceBreak"><?= h($address['home_tel']) ?></td>
                                                                <?php else : ?>
                                                                    <td>なし</td>
                                                                <?php endif; ?>
                                                                <td class="tdEdit borderNone"><a href="/address/edit.html?adrdata_seq=<?= h($address['adrdata_seq']) ?>&<?= $cashe ?>"><img src="/contents/images/icon_edit12a.gif" alt="編集"></a>&nbsp;&nbsp;
                                                                    <a href="javascript:ConformationSingle('<?= h($address['adrdata_seq']) ?>')"><img src="/contents/images/icon_delete12.gif" alt="削除"></a>
                                                                </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="6" class="txtRed borderNone" style="cursor:default;"><div style="background:#fff;">登録されているアドレスはありません。</div></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="pg" value="<?= h($page['page']) ?>">
                            </form>
                        </div><!---contentsMain-->
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?= $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>

