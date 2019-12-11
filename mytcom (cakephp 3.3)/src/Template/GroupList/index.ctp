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
            $(function() {
                $('input.btnovr').hover(function() {
                        $(this).addClass('btnovrOn');
                    },
                    function() {
                        $(this).removeClass('btnovrOn');
                    });
            });
            $(function() {
                $('input.btnLong').hover(function() {
                        $(this).addClass('btnlongOn');
                    },
                    function() {
                        $(this).removeClass('btnlongOn');
                    });
            });
            $(function() {
                $('input.btnstd').hover(function() {
                        $(this).addClass('btnstdOn');
                    },
                    function() {
                        $(this).removeClass('btnstdOn');
                    });
                $(function() {
                    var $targetElement = '.forceBreak a';
                    if (checkMsie()) {
                        $($targetElement).css('word-break', 'break-all');
                    } else {
                        $($targetElement).each(function() {
                            if (navigator.userAgent.indexOf('Firefox/2') != -1) {
                                $(this).html($(this).text().split('').join('<wbr />'));
                            } else {
                                $(this).html($(this).text().split('').join(String.fromCharCode(8203)));
                            }
                        });
                    }
                });
            });
        </script>
        <script type="text/javascript">
            var check_flg = true;

            function Conformation() {
                var TgElements = document.getElementsByName("checkedAddress[]");
                check_flg1 = false;
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (TgElement.checked) {
                        check_flg1 = true;
                    } else {
                        //	check_flg =false;
                    }
                }
                if (check_flg1 == true) {
                    msg = "アドレスを削除します。よろしいですか？";
                    if (window.confirm(msg)) {
                        $("#triggerDelete").val(1);
                        $("#form1").submit();
                    }
                } else {
                    alert("削除するアドレスを選択してください。");
                }
            }

            function ConformationSingle(id) {
                msg = "アドレスを削除します。よろしいですか？";
                if (window.confirm(msg)) {
                    location.href = "/address/delete.html?pg=<?= h($link['pageNow']) ?>&org=<?= h($group_id) ?>&adrdata_seq=" + id + "";
                }
            }

            function ConformationSingleGroup(id) {
                msg = "グループを削除します。よろしいですか？\n（登録されているアドレスは削除されません)";
                if (window.confirm(msg)) {
                    location.href = "/address/group/delete.html?group_id=" + id + "";
                }
            }


            function change(obj) {
                document.form1.elements["select_all"].checked = obj.checked;
                if (document.form1.elements["checkedAddress[]"]) {
                    document.form1.elements["checkedAddress[]"].checked = obj.checked;
                    for (var i = 0; i < document.form1.elements["checkedAddress[]"].length; i++) {
                        document.form1.elements["checkedAddress[]"][i].checked = obj.checked;
                    }
                }
            }
            var click_flg = true;
            var check_flg = true;
            //チェックボックス
            function AllMailCheck() {
                var TgElements = document.getElementsByName("checkedAddress[]");
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (check_flg) {
                        TgElement.checked = true;
                    } else {
                        TgElement.checked = false;
                    }
                }
                var TgElements = document.getElementsByName("checkedGroup[]");
                for (i = 0; i < TgElements.length; i++) {
                    TgElement = TgElements[i];
                    if (check_flg) {
                        TgElement.checked = true;
                    } else {
                        TgElement.checked = false;
                    }
                }
                var checkbtn = document.getElementById("addrcheck");
                var checkbtn1 = document.getElementById("addrcheck1");
                if (check_flg) {
                    check_flg = false;
                    checkbtn.style.background = "url('/contents/images/no_check_all.gif')";
                    checkbtn.alt = "選択されたメールを全て解除";
                    checkbtn1.style.background = "url('/contents/images/no_check_all.gif')";
                    checkbtn1.alt = "選択されたメールを全て解除";
                } else {
                    check_flg = true;
                    checkbtn.style.background = "url('/contents/images/check_all.gif')";
                    checkbtn.alt = "メールを全て選択";
                    checkbtn1.style.background = "url('/contents/images/check_all.gif')";
                    checkbtn1.alt = "メールを全て選択";
                }
                return false;
            }
        </script>
        <script>
            function validatorLength() {
                if ($('#keyword').val().length > <?php echo Configure::read('KeywordSearch.KeywordLimit');?>) {
                    alert('検索キーワードには' + <?php echo Configure::read('KeywordSearch.KeywordLimit');?> + '文字以内で入力してください。');
                    $('#formSearch').attr('action', '');
                    return false;
                } else {
                    var url_action = '/address/group/list.html?group_id=<?= h($group_id) ?>&<?= $cashe ?>';
                    $('#formSearch').attr('action', url_action);
                    $('#formSearch').submit();
                }
            }
        </script>
        <style type="text/css">
            .tblFilesList td {
                border-right: 1px solid #A3B8CD !important;
            }

            .tblFilesList .borderNone {
                border-right: none !important;
            }

            .forceBreak {
                max-width: 40%;
                _width: 35%;
            }

            .forceBreak,
            .forceBreak a {
                word-break: break-word;
            }
            .tblFilesList th{ font-weight: normal;}
            .tblFilesList tbody td.BGColorGray{ padding: 5px 10px !important;}
            .tdEdit{ text-align:center !important;}
            .imageBlock {display:inline-block;}
            .checkImage {background: url("/contents/images/check_all.gif"); cursor:pointer; width:13px; height:13px; }
            .deleteImage {background: url("/contents/images/m_addr_delete.gif"); cursor:pointer; width:13px; height:13px; margin:1px 0 0 3px;}
            .imageText {position:relative; top:2px;font-size: 12px; cursor:pointer; background-color:#e7e7e7;}
            .separator {position:relative; top:1px;}
            th.thEdit, .tblFilesList tbody td.tdEdit {
                padding: 0 5px !important;
                border-right: none !important;
                width: 80px;
                text-align: center !important;
                white-space: nowrap !important;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea"><h1 class="iconAddress"><?= $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>

                <div id="contentsLeft">
                    <div class="sideBox">
                        <div class="sideTopGray">
                            <h2>メニュー</h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?&<?= $cashe ?>">アドレスを登録</a></li>
                                <li class="bdr"><a href="/address/group/regist.html?&<?= $cashe ?>">グループを追加</a></li>
                                <li class="bdr"><a href="/address/import.html?<?= $cashe ?>">インポート</a></li> 
                                <li><a href="/address/listview.html?<?= $cashe ?>">アドレス帳を見る</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h2 class="contentsttl floL">グループの詳細</h2>
                            <div class="searchArea floR">
                                <form method="post" id="formSearch" action="">
                                    <select name="category">
                                        <option label="メールアドレス" value="1">メールアドレス</option>
                                        <option label="ニックネーム" value="2">ニックネーム</option>
                                    </select>&nbsp;&nbsp;
                                    <input type="text" id="keyword" name="categoryKeyword" class="textArea01" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>"/>
                                    <input type="hidden" name="group_id" value="<?= h($group_id) ?>">
                                    <input type="button" name="search_x" value="" class="submit01" onclick="validatorLength();"/>
                                </form>
                            </div>
                        </div>
                        <div class="contentsMain">
                            <div class="iconGroup">
                                <h1 class="txtBold txtLarge">
                                    <?php if (!empty($group_name)) : ?>
                                        <?= h($group_name) ?>
                                    <?php else : ?>
                                        未設定
                                    <?php endif; ?>
                                </h1>
                            </div>
                            <div class="padArea bdrbot" style="margin-bottom:10px;">
                                <br class="clear" />
                            </div>
                            <div class="addresItems space_5">
                                <div class="txtRed txtBold space_5"><?= h($message) ?></div>
                                <div class="floL">このグループに登録されているアドレスの一覧です。</div>
                                <div class="floR">
                                    <a href="/address/group/edit.html?group_id=<?= h($group_id) ?>&<?= $cashe ?>">グループの編集</a> ｜
                                    <a href="javascript:ConformationSingleGroup('<?= h($group_id) ?>');">グループの削除</a>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <form method="POST" name="form1" id="form1" action="/address/listview.html?<?= $cashe ?>">
                                <table cellpadding="0" cellspacing="0" class="tblFilesList">
                                    <thead>
                                        <tr>
                                            <th class="bgBlueGra txtWhite" colspan="5">
                                                <a href="/address/edit.html?group_id=<?= h($group_id) ?>&<?= $cashe ?>">アドレスを追加</a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <input type="hidden" id="triggerDelete" name="delete" value="" />
                                        <tr>
                                            <td class="BGColorGray" colspan="2" style="border-right:none !important;" nowrap="nowrap">
                                                <div style="position:relative;">
                                                    <div class="imageBlock" onclick="return AllMailCheck();" >
                                                        <input type="button" class="checkImage" id="addrcheck"/>
                                                        <span class="imageText">すべて選択</span>
                                                    </div>
                                                    <div class="imageBlock" onclick="Conformation();" >
                                                        <input type="button" class="deleteImage" />
                                                        <span class="imageText">削除する</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="BGColorGray txtRight" colspan="3" align="right" nowrap="nowrap">
                                                <?php if ($link['pageTotal'] == 0) : ?>
                                                    <?= h($link['pageTotal']) ?>件&nbsp;
                                                <?php else : ?>
                                                    <?= h($link['pageTotal']) ?>件中&nbsp;<?= h($link['pageStart']) ?>-<?= h($link['pageEnd']) ?>件&nbsp;&nbsp;
                                                <?php endif;?>
                                                <?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=1&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">最初</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最初</span>
                                                <?php endif; ?>
                                                ｜<?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pagePrev']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">&lt;&lt;前</a>
                                                <?php else : ?>
                                                    <span class="txtGray">&lt;&lt;前</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pageNext']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">次&gt;&gt;</a>
                                                <?php else : ?>
                                                    <span class="txtGray">次&gt;&gt;</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?><a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pageLast']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">最後</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最後</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td class="BGColorGray" colspan="2" style="border-right:none !important;" nowrap="nowrap">
                                                <div style="position:relative;">
                                                    <div class="imageBlock" onclick="return AllMailCheck();" >
                                                        <input type="button" class="checkImage" id="addrcheck1"/>
                                                        <span class="imageText">すべて選択</span>
                                                    </div>
                                                    <div class="imageBlock" onclick="Conformation();" >
                                                        <input type="button" class="deleteImage" />
                                                        <span class="imageText">削除する</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="BGColorGray txtRight" colspan="3" align="right" nowrap="nowrap">
                                                <?php if ($link['pageTotal'] == 0) : ?>
                                                <?= h($link['pageTotal']) ?>件&nbsp;
                                                <?php else : ?>
                                                <?= h($link['pageTotal']) ?>件中&nbsp;<?= h($link['pageStart']) ?>-<?=  h($link['pageEnd']) ?>件&nbsp;&nbsp;
                                                <?php endif; ?>
                                                <?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=1&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">最初</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最初</span>
                                                <?php endif; ?>
                                                ｜<?php if ($link['pageNow'] > 1) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pagePrev']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">&lt;&lt;前</a>
                                                <?php else : ?>
                                                    <span class="txtGray">&lt;&lt;前</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pageNext']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">次&gt;&gt;</a>
                                                <?php else : ?>
                                                    <span class="txtGray">次&gt;&gt;</span>
                                                <?php endif; ?>
                                                ｜<?php if (!empty($link['pageNext'])) : ?>
                                                    <a class="pagination" href="/address/group/list.html?group_id=<?= h($group_id) ?>&pg=<?= h($link['pageLast']) ?>&q=<?= h($link['categoryKeyword']) ?>&category=<?= h($link['category']) ?>&<?= $cashe ?>">最後</a>
                                                <?php else : ?>
                                                    <span class="txtGray">最後</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr><td colspan="6" style="padding:0 !important;">
                                                <table class="tblFilesList" style="margin-top:0;border:none;">
                                                    <?php if (!empty($addressDataList)) : ?>
                                                        <tr>
                                                            <th class="xshort"></th>
                                                            <th>ニックネーム</th>
                                                            <th>メールアドレス</th>
                                                            <th style="width: 120px;">電話番号</th>
                                                            <th class="thEdit borderNone">編集 / 削除</th>
                                                        </tr>
                                                        <?php foreach ($addressDataList as $address) : ?>
                                                            <?php if (!empty($address['group_id'])) : ?>
                                                                <tr>
                                                                    <td class="txtCneter xshort"><input type="checkbox" name="checkedAddress[]" value="<?= h($address['adrdata_seq']) ?>"></td>
                                                                    <td class="forceBreak">
                                                                        <?php if (!empty($address['nickname'])) : ?>
                                                                            <a href="/address/detailview.html?adrdata_seq=<?= h($address['adrdata_seq']) ?>&pg=<?= h($link['pageNow']) ?>&<?= $cashe ?>" style="text-decoration: underline;"><?= h($address['nickname']) ?></a>
                                                                        <?php else : ?>
                                                                            なし
                                                                        <?php endif; ?>
                                                                    </td>
                                                                        <td class="forceBreak"><?= h($address['email']) ?></td>
                                                                    <?php if (!empty($address['work_tel'])) : ?>
                                                                        <td class="forceBreak"><?= h($address['work_tel']) ?></td>
                                                                    <?php elseif (!empty($address['home_tel'])) : ?>
                                                                        <td class="forceBreak"><?= h($address['home_tel']) ?></td>
                                                                    <?php else : ?>
                                                                        <td>なし</td>
                                                                    <?php endif; ?>
                                                                    <td class="tdEdit borderNone">
                                                                        <a href="/address/edit.html?adrdata_seq=<?= h($address['adrdata_seq']) ?>&<?= $cashe ?>"><img src="/contents/images/icon_edit12a.gif" alt="編集" /></a>&nbsp;&nbsp;
                                                                        <a href="javascript:ConformationSingle('<?= h($address['adrdata_seq']) ?>')"><img src="/contents/images/icon_delete12.gif" alt="削除" /></a>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                    <tr>
                                                        <td colspan="5" class="txtRed borderNone" style="background:none;cursor:default;"><div style="background:#fff;">登録されているアドレスはありません。</div></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </table></td></tr>
                                    </tbody>
                                </table>
                            </form>
                        </div><!---contentsMain--->
                    </div>
                </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
        </div>
        <?= $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    </body>
</html>
