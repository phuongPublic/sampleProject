<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>広告バナープレビュー画面</title>
    <link rel="stylesheet" type="text/css" href="/contents/js/yui/fonts/fonts-min.css" />
    <link href="/contents/css/<?= $this->Common->getIsp() ?>/open_common.css" rel="stylesheet" type="text/css" />
    <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
</head>
<body>
    <div id="header">
        <div class="container">
            <div id="logo"><img src="/contents/images/<?= $this->Common->getIsp(); ?>/logo.gif" alt="" /></div>
            <?php if (isset($adData) && $adData['pos_flg'] == 1) : ?>
                <div id="top_baner">
                    <?php if ($adData['file_path'] != "") : ?>
                        <a href="<?= h($adData['contents']) ?>" /><img src="<?= $adData['file_path'] ?>" /></a>
                    <?php else : ?>
                        <?= h($adData['contents']) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <br class="clear" />
        </div>
    </div>
    <div id="OpneContents" style="margin-bottom:70px;">
        <div class="container">
            <h1 class="pagettl">TESTさんのファイル</h1>
            <table id="open_storage_status" class="tblForm">
                <tr>
                    <th nowrap>送信者</th>
                    <td width="100%">TEST &lt; <a href="#">xxxx@xxxxx.xx.xx</a> &gt;</td>
                </tr>
                <tr>
                    <th nowrap>公開期間</th>
                    <td width="100%">2010年01月14日(木)まで</td>
                </tr>
                <tr>
                    <th nowrap>メッセージ</th>
                    <td width="100%">プレビューです。<br /></td>
                </tr>
            </table>
            <?php if (isset($adData) && $adData['pos_flg'] == 4) : ?>
            <div class="adContents2">
                <?php if ($adData['file_path'] != "") : ?>
                    <a href="<?= h($adData['contents']) ?>" /><img src="<?= $adData['file_path'] ?>" /></a>
                <?php else : ?>
                    <?= h($adData['contents']) ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="padArea" style="padding-left:10px;">※チェックボックスにチェックを入れてダウンロードするとファイルはzip圧縮されます。<br />
              解凍ソフトをお持ちでない方は、あらかじめソフトをインストールしてからダウンロードしてください。 </div>
            <div class="openHelpArea"><a class="iconHelp" href="#">ヘルプ</a></div>
            <div style="clear:both;"></div>
            <form id="form1" name="form1" method="post" action="#">
                <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                    <thead>
                        <tr>
                            <th class="bgBlueGra txtWhite" colspan="5">
                                <div style="position:relative;height:1.5em;">
                                    <div class="curBlcok">
                                        <a href="javascript:;" id="sort_menu" class="editbk">表示順変更<img src="/contents/images/icon_arrow_down.gif" alt="古い順" align="absmiddle" /></a>
                                        <div class="contextMenu" style="width:7em;">
                                            <ul id="menulist" class="dropMenu" style="background-color:#fff;width:7em;_overflow:hidden;">
                                                <li class="BookmarkMenu"><a href="#" >新しい順</a></li>
                                                <li class="BookmarkMenu"><a href="#" >古い順</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <input name="checkbox" type="checkbox" class="chechBox01" onClick="change(this)" /><span>すべて選択</span>&nbsp;
                                <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" /><input name="download" type="#" value="ダウンロード" class="submitxx downloadMenu" style="font-size:11px;" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td class="BGColorGray" colspan="5">
                                <input name="checkbox" type="checkbox" class="chechBox01" onclick="change(this)" /><span>すべて選択</span>&nbsp;
                                <img src="/contents/images/icon_download12.gif" alt="d" align="absmiddle" /><input name="download" type="#" value="ダウンロード" class="submitxx downloadMenu" style="font-size:11px;" />
                            </td>
                        </tr>
                        <tr class="openttl">
                            <th></th>
                            <th>ファイル名 </th>
                            <th>容量</th>
                            <th>コメント</th>
                            <th>公開状態</th>
                        </tr>
                        <tr class="even">
                            <td width="12" style="vertical-align:middle;">
                                <input name="del[]" type="checkbox" class="chechBox01" value="0000000106" />
                            </td>
                            <td width="177" style="vertical-align:middle;"><a href="#" class="underLine">xxxx1.jpg</a></td>
                            <td width="40" align="right" style="vertical-align:middle;">4KB</td>
                            <td width="180" style="vertical-align:middle;"></td>
                            <td width="50" align="center" style="vertical-align:middle;">公開中</td>
                        </tr>
                        <tr class="odd">
                            <td width="12" style="vertical-align:middle;">
                                <input name="del[]" type="checkbox" class="chechBox01" value="0000000094" />
                            </td>
                            <td width="177" style="vertical-align:middle;"><a href="#" class="underLine">xxxx2.mpg</a></td>
                            <td width="40" align="right" style="vertical-align:middle;">8051KB</td>
                            <td width="180" style="vertical-align:middle;"></td>
                            <td width="50" align="center" style="vertical-align:middle;">公開中</td>
                        </tr>
                        <tr class="even">
                            <td width="12" style="vertical-align:middle;">
                                <input name="del[]" type="checkbox" class="chechBox01" value="0000000085" />
                            </td>
                            <td width="177" style="vertical-align:middle;"><a href="#" class="underLine">xxxx3.jpg</a></td>
                            <td width="40" align="right" style="vertical-align:middle;">42KB</td>
                            <td width="180" style="vertical-align:middle;">プレビューです。</td>
                            <td width="50" align="center" style="vertical-align:middle;">公開中</td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="file" value="">
                <input type="hidden" name="singledownload" value="">
                <input type="hidden" name="fid" value="0002">
            </form>
        </div>
        <?php if (isset($adData) && $adData['pos_flg'] == 2) : ?>
        <div class="adContents1">
            <?php if ($adData['file_path'] != "") : ?>
                <a href="<?= h($adData['contents']) ?>" /><img src="<?= $adData['file_path'] ?>" /></a>
            <?php else : ?>
                <?= h($adData['contents']) ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->element($this->Common->getIsp() . '/admin/footer_00_open'); ?>
</body>
</html>