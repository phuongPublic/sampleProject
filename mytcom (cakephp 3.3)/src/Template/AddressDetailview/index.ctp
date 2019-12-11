<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?= $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
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
            });
            function ConformationSingle(id){
                msg = "アドレスを削除します。よろしいですか？";
                if (window.confirm(msg)){
                    location.href = "/address/delete.html?pg=&org=&adrdata_seq=" + id + "";
                }
            }
            function ReturnProcess(){
            $('#edit_submit').val('2');
                document.form1.submit();
            }
        </script>
        <script type="text/javascript">
            function procNextCtrl(e){
                var c = e.keyCode;
                if (c == 13) {
                    document.all.item("submit").focus();
                    document.form1.submit();
                }
            }
        </script>
        <style type="text/css">
            .contentaddress{
                width:170px;
                padding-left:0 !important;
            }
            table table tr {
                border-bottom: 2px solid white;
            }
            .tblForm td {
                padding-right:0;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconAddress">
                        <?= $this->Header->getTitleStr($menu_now_flg) ?>
                    </h1>
                </div>

                <div id="contentsLeft">
                    <div class="sideBox">
                        <div class="sideTopGray">
                            <h2>メニュー</h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?<?= $cashe ?>">アドレスを登録</a></li>
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
                            <h2 class="contentsttl floL">アドレスの詳細</h2>
                        </div>
                        <div class="contentsMain">
                            <p>アドレスの詳細内容です。</p>

                            <form method="post" name="form1" id="form1" class="submitForm" action="?<?= $cashe ?>">
                                <input type="hidden" name="adrdata_seq" value="<?= h($addressData['adrdata_seq']) ?>">
                                    <table class="tblForm fontLtable">
                                        <tbody>
                                            <tr>
                                                <th>グループ</th>
                                                <td valign="middle"><?= h($group_name) ?></td>
                                            </tr>
                                            <tr>
                                                <th>名前</th>
                                                <td valign="middle">
                                                    <div style="word-wrap: break-word; width: 500px; line-height: 150%;">
                                                        <?= h($addressData['name_l']) ?>&nbsp;<?= h($addressData['name_f']) ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ニックネーム</th>
                                                <td  valign="middle"><?= h($addressData['nickname']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>メールアドレス</th>
                                                <td valign="middle">
                                                    <div style="word-wrap: break-word; width: 500px; line-height: 150%;">
                                                        <?= h($addressData['email']) ?>
                                                    </div></td>
                                            </tr>
                                            <tr>
                                                <th>会社</th>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>会社名：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                    <?= h($addressData['org_name']) ?>
                                                                </div>
                                                            </td>
                                                            <td>所属：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                    <?= h($addressData['org_post']) ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>国：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['work_countory']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>郵便番号：</td>
                                                            <td colspan = "3" class="contentaddress">〒<?= h($addressData['work_postcode']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>都道府県：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['work_pref']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>市区町村：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['work_adr1']) ?>
                                                                </div></td>
                                                            <td>番地：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['work_adr2']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TEL：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['work_tel']) ?>
                                                                </div></td>
                                                            <td>FAX：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['work_fax']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>URL：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['work_url']) ?>
                                                                </div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>自宅</th>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>国：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['home_countory']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>郵便番号：</td>
                                                            <td colspan = "3" class="contentaddress">〒<?= h($addressData['home_postcode']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>都道府県：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['home_pref']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>市区町村：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['home_adr1']) ?>
                                                                </div></td>
                                                            <td>番地：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['home_adr2']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>携帯：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['home_cell']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TEL：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['home_tel']) ?>
                                                                </div></td>
                                                            <td>FAX：</td>
                                                            <td class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 170px; line-height: 150%;">
                                                                <?= h($addressData['home_fax']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>URL：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['home_url']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>誕生日：</td>
                                                            <td colspan = "3" class="contentaddress">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['birthday']) ?>
                                                                </div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>メモ：</td>
                                                            <td colspan = "3" class="contentaddress" style="word-break: break-all;">
                                                                <div style="word-wrap: break-word; width: 390px; line-height: 150%;">
                                                                <?= h($addressData['note']) ?>
                                                                </div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p align="center" class="txtCneter">
                                        <input type="hidden" id="edit_submit" name="editSubmit" value="1"/>
                                        <input type="submit" class="btnovr" name="submit_edit" value="編集する" />
                                        <input type="button" onclick="return ConformationSingle('<?= $addressData['adrdata_seq'] ?>');" style="text-align:center" class="btnovr" name="submit_del" value="削除する" />
                                        <input type="button" class="btnovr"  name="return" value="戻る" onclick="return ReturnProcess();" />
                                    </p>
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
