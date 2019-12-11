<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <script type="text/javascript" src="/contents/js/address.validate.js"></script>
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
            function procNextCtrl(e){
                var c = e.keyCode;
                if (c == 13){
                    document.all.item("submit").focus();
                    document.form1.submit();
                }
            }
            function onlyNumber(str) {
                var pattern = /^\d+$/;
                return pattern.test(str);
            }

            // page did load
            $(document).ready(function() {
                Address.init();
            });
        </script>
        <style type="text/css">
            html[xmlns*=""] body:last-child .msWidth {
                width:140px;
            }
            table th {
                text-align:left;
            }
            .msWidth {
                width:140px;
            }
            .msWidthT {
                margin-left:-4px;
            }
            .adrsdFromS {
                margin-left: 30px;
                width:43px;
            }
            /* webkit(safari chrome) */
            @media screen and (-webkit-min-device-pixel-ratio:0){
                .msWidth{width:140px;}
                .msWidthL{
                    width:22em !important;
                }
                .msWidthM{
                    width:11.7em !important;
                }
                .msWidthS4{
                    width:2.7em !important;
                }
                .msWidthS3{
                    width:2.2em !important;
                }
                .msWidthT{
                    width:22em !important;
                }
                span.inputf{
                    width:190px !important;
                }
            }
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
                            <h2>メニュー</h2>
                        </div>
                        <div class="sideMenuMain">
                            <ul class="sideMenuList">
                                <li class="bdr"><a href="/address/edit.html?<?= $cashe ?>">アドレスを登録</a></li>
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
                            <h2 class="contentsttl floL"><?= h($screen['title']) ?></h2>
                            <?php if (isset($helpLinkUrl['AddressExport'])) : ?>
                                <div class="searchAreaN floR">
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['AddressEdit'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?> 
                        </div>
                        <div class="contentsMain">
                            <div class="padArea bdrbot">
                                <?php if (!empty($quota_error)) : ?>
                                    <p class="txtRed txtBold space_5"><?= $quota_error ?></p>
                                <?php endif; ?>
                                <?= $screen['details'] ?>
                                <?php if (!empty($message)) : ?>
                                    <p class="txtRed txtBold space_5"><?= h($message) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($ErrorMsg)) : ?>
                                    <p class="txtRed txtBold space_5"><?= h($ErrorMsg) ?></p>
                                <?php endif; ?>
                            </div>
                            <p>
                                <?php if (!empty($screen['limit_address'])) : ?>
                                    <span class="txtSmall">※<?= h($screen['limit_address']) ?></span></br>
                                <?php endif; ?>
                                <span class="txtSmall">※<span class="txtRed">*</span>印のついている項目は、入力必須項目となります。</span>
                            </p>
                            <form method="post" id="form" name="form1" action="/address/edit.html?<?= $cashe ?>" onsubmit="return false;">
                                <input type="hidden" name="adrdata_seq" value="<?php echo isset($addressData['adrdata_seq']) ? $addressData['adrdata_seq'] : ''; ?>">
                                    <table class="tblForm fontLtable">
                                        <tbody>
                                            <tr>
                                                <th>グループ</th>
                                                <td>
                                                    <div class="space_5 txtSmall">グループに登録する場合は選択してください。</div>
                                                    <select name="group_id">
                                                        <option value="">設定しない</option>
                                                        <?php foreach ($groupName as $key => $value) { ?>
                                                            <?php
                                                                $selected = '';
                                                                if (!empty($addressData['group_id']) && $addressData['group_id'] == $key) {
                                                                    $selected = "selected='selected'";
                                                                }
                                                            ?>
                                                            <option label="<?= h($value) ?>" value="<?= h($key) ?>" <?php echo $selected;?> >
                                                                <?= h($value) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>名前</th>
                                                <td>
                                                    <?php if (!empty($Error['name_l'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['name_l'])) ?></div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($Error['name_f'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['name_f'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="err_name_l"></div>
                                                    <div class="err_name_f"></div>
                                                    姓：<input type="text" name="name_l" size="28" class="msWidth" maxlength="255"
                                                             value="<?php echo isset($addressData['name_l']) ? h($addressData['name_l']) : '';?>"/>&nbsp;
                                                    名：<input type="text" name="name_f" size="28" class="msWidth" maxlength="255"
                                                             value="<?php echo isset($addressData['name_f']) ? h($addressData['name_f']) : ''; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ニックネーム<span class="txtRed">*</span></th>
                                                <td valign="middle">
                                                    <?php if (!empty($Error['nickname'])) : ?>
                                                        <div class="space_5 txtRed"><?= h(implode($Error['nickname'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="err_nickname"></div>
                                                    <div class="space_5"><input type="text" name="nickname" size="40" maxlength="25"
                                                           value="<?php echo isset($addressData['nickname']) ? h($addressData['nickname']) : ''; ?>" class="msWidthL" required /></div>
                                                    <div class="txtSmall">※25文字以内</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    メールアドレス<span class="txtRed">*</span>
                                                </th>
                                                <td valign="middle">
                                                    <?php if (!empty($Error['email'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['email'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="err_email"></div>
                                                    <div class="space_5"><input type="text" name="email" size="40" maxlength="256"
                                                           value="<?php echo isset($addressData['email']) ? h($addressData['email']) : '';?>" style="ime-mode:disabled" class="msWidthL" required /></div>
                                                    <div class="txtSmall">※256文字以内。メールアドレス形式。</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>会社</th>
                                                <td>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['org_name'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['org_name'])) ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($Error['org_post'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['org_post'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_org_name"></div>
                                                        <div class="err_org_post"></div>
                                                        <label class="adrsdFrom">会社名：</label>
                                                        <input type="text" name="org_name" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['org_name']) ? h($addressData['org_name']) : '';?>" class="msWidth" />
                                                        <label class="adrsdFromS">所属：</label>
                                                        <input type="text" name="org_post" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['org_post']) ? h($addressData['org_post']) : ''; ?>" class="msWidth" />
                                                    </div>

                                                    <?php if (!empty($Error['work_countory'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['work_countory'])) ?></div>
                                                    <?php endif; ?>

                                                    <div class="space_5">
                                                        <div class="err_work_countory"></div>
                                                        <label class="adrsdFrom">国：</label>
                                                        <input type="text" name="work_countory" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['work_countory']) ? h($addressData['work_countory']) : ''; ?>" class="msWidth" >
                                                    </div>

                                                    <div class="space_5">
                                                        <?php if (!empty($Error['work_postcode'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h($Error['work_postcode']) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_work_postcode err_work_postcode2"></div>
                                                        <label class="adrsdFrom">郵便番号：</label>〒
                                                        <input type="text" id="work_postcode" name="work_postcode" size="3"
                                                               value="<?php echo isset($addressData['work_postcode']) ? h($addressData['work_postcode']) : '';?>"
                                                               style="ime-mode:disabled" maxlength="3" class="msWidthS3" />
                                                        －<input type="text" id="work_postcode2" name="work_postcode2" size="4"
                                                                value="<?php echo isset($addressData['work_postcode2']) ? h($addressData['work_postcode2']) : ''; ?>"
                                                                style="ime-mode:disabled" maxlength="4" class="msWidthS4" />
                                                    </div>

                                                    <?php if (!empty($Error['work_pref'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['work_pref'])) ?></div>
                                                    <?php endif; ?>

                                                    <div class="space_5">
                                                        <div class="err_work_pref"></div>
                                                        <label class="adrsdFrom">都道府県：</label>
                                                        <input type="text" name="work_pref" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['work_pref']) ? h($addressData['work_pref']) : '';?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['work_adr1'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['work_adr1'])) ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($Error['work_adr2'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['work_adr2'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_work_adr1"></div>
                                                        <div class="err_work_adr2"></div>
                                                        <label class="adrsdFrom">市区町村：</label>
                                                        <span class="inputf">
                                                            <input type="text" name="work_adr1" size="28" maxlength="255"
                                                                   value="<?php echo isset($addressData['work_adr1']) ? h($addressData['work_adr1']) : ''; ?>" class="msWidth" />
                                                        </span>
                                                        <label class="adrsdFromS">番地：</label>
                                                        <input type="text" name="work_adr2" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['work_adr2']) ? h($addressData['work_adr2']) : ''; ?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['work_tel'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['work_tel'])) ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($Error['work_fax'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['work_fax'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_work_tel"></div>
                                                        <div class="err_work_fax"></div>
                                                        <label class="adrsdFrom">TEL：</label>
                                                        <span class="inputf">
                                                            <input type="text" name="work_tel" size="4" maxlength="50"
                                                                   value="<?php echo isset($addressData['work_tel']) ? h($addressData['work_tel']) : ''; ?>" class="msWidth" />
                                                        </span>
                                                        <label class="adrsdFromS">FAX：</label>
                                                        <input type="text" name="work_fax" size="4" maxlength="50"
                                                               value="<?php echo isset($addressData['work_fax']) ? h($addressData['work_fax']) : '';?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['work_url'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['work_url'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_work_url"></div>
                                                        <label class="adrsdFrom">URL：</label>
                                                        <input type="text" name="work_url" size="40" maxlength="2083"
                                                               value="<?php echo isset($addressData['work_url']) ? h($addressData['work_url']) : ''; ?>" class="msWidthL" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>自宅</th>
                                                <td>
                                                    <?php if (!empty($Error['home_countory'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['home_countory'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="space_5">
                                                        <div class="err_home_countory"></div>
                                                        <label class="adrsdFrom">国：</label>
                                                        <input type="text" name="home_countory" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['home_countory']) ? h($addressData['home_countory']) : ''; ?>" class="msWidth">
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['home_postcode'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h($Error['home_postcode']) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_home_postcode err_home_postcode2"></div>
                                                        <label class="adrsdFrom">郵便番号：</label>〒
                                                        <input type="text" id="home_postcode" name="home_postcode" size="3"
                                                               value="<?php echo isset($addressData['home_postcode']) ? h($addressData['home_postcode']) : ''; ?>" style="ime-mode:disabled" maxlength="3" class="msWidthS3" />
                                                        －<input type="text" id="home_postcode2" name="home_postcode2" size="4"
                                                                value="<?php echo isset($addressData['home_postcode2']) ? h($addressData['home_postcode2']) : ''; ?>" style="ime-mode:disabled" maxlength="4" class="msWidthS4" />
                                                    </div>

                                                    <?php if (!empty($Error['home_pref'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['home_pref'])) ?></div>
                                                    <?php endif; ?>

                                                    <div class="space_5">
                                                        <div class="err_home_pref"></div>
                                                        <label class="adrsdFrom">都道府県：</label>
                                                        <input type="text" name="home_pref" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['home_pref']) ? h($addressData['home_pref']) : ''; ?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['home_adr1'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['home_adr1'])) ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($Error['home_adr2'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['home_adr2'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_home_adr1"></div>
                                                        <div class="err_home_adr2"></div>
                                                        <label class="adrsdFrom">市区町村：</label>
                                                        <span class="inputf">
                                                            <input type="text" name="home_adr1" size="28" maxlength="255"
                                                                   value="<?php echo isset($addressData['home_adr1']) ? h($addressData['home_adr1']) : '';?>" class="msWidth" />
                                                        </span>
                                                        <label class="adrsdFromS">番地：</label>
                                                        <input type="text" name="home_adr2" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['home_adr2']) ? h($addressData['home_adr2']) : ''; ?>" class="msWidth" />
                                                    </div>

                                                    <?php if (!empty($Error['home_cell'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['home_cell'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="space_5">
                                                        <div class="err_home_cell"></div>
                                                        <label class="adrsdFrom">携帯：</label>
                                                        <input type="text" name="home_cell" size="28" maxlength="50"
                                                               value="<?php echo isset($addressData['home_cell']) ? h($addressData['home_cell']) : ''; ?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['home_tel'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['home_tel'])) ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($Error['home_fax'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['home_fax'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_home_tel"></div>
                                                        <div class="err_home_fax"></div>
                                                        <label class="adrsdFrom">TEL：</label>
                                                        <span class="inputf">
                                                            <input type="text" name="home_tel" size="4" maxlength="50"
                                                                   value="<?php echo isset($addressData['home_tel']) ? h($addressData['home_tel']) : '';?>" class="msWidth" />
                                                        </span>
                                                        <label class="adrsdFromS">FAX：</label>
                                                        <input type="text" name="home_fax" size="4" maxlength="50"
                                                               value="<?php echo isset($addressData['home_fax']) ? h($addressData['home_fax']) : ''; ?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['home_url'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['home_url'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_home_url"></div>
                                                        <label class="adrsdFrom">URL：</label>
                                                        <input type="text" name="home_url" size="28" maxlength="2083"
                                                               value="<?php echo isset($addressData['home_url']) ? h($addressData['home_url']) : ''; ?>" class="msWidth" />
                                                    </div>

                                                    <?php if (!empty($Error['birthday'])) : ?>
                                                        <div class="tblReadTxt txtRed"><?= h(implode($Error['birthday'])) ?></div>
                                                    <?php endif; ?>
                                                    <div class="space_5">
                                                        <div class="err_birthday"></div>
                                                        <label class="adrsdFrom">誕生日：</label>
                                                        <input type="text" name="birthday" size="28" maxlength="255"
                                                               value="<?php echo isset($addressData['birthday']) ? h($addressData['birthday']) : ''; ?>" class="msWidth" />
                                                    </div>
                                                    <div class="space_5">
                                                        <?php if (!empty($Error['note'])) : ?>
                                                            <div class="tblReadTxt txtRed"><?= h(implode($Error['note'])) ?></div>
                                                        <?php endif; ?>
                                                        <div class="err_note"></div>
                                                        <label class="adrsdFrom" style="vertical-align:top">メモ：</label>
                                                        <textarea name="note" cols="49" rows="5" maxlength="200" class="msWidthT"><?php echo isset($addressData['note']) ? h($addressData['note']) : ''; ?></textarea><br />
                                                        <label class="adrsdFrom">&nbsp;</label>
                                                        <span class="txtSmall">※200文字以内</span><br />
                                                        <label class="adrsdFrom">&nbsp;</label>
                                                        <span class="txtSmall">※改行は無効となります。</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p align="center" class="txtCneter">
                                        <input type="hidden" name="editSubmit" value="1" />
                                        <input type="submit" id="tongleSubmit" class="btnovr" value="<?= h($screen['button']) ?>" />
                                        <input type="button" name="return" class="btnovr" value="戻る" onclick="location.href = '<?= $previousUrl ?>'"/>
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
