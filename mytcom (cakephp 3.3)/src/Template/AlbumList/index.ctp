<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
    <script>
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
                $('#form1').attr('action', '');
                return false;
            } else {
                var url_action = '/album/preview.html?src=all&fromsrc=1&search=1&<?php echo $cashe; ?>';
                $('#form1').attr('action', url_action);
                $('#form1').submit();
            }
        }
    </script>
</head>

<body>
    <div id="wrapper">
        <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>

                    <div id="contentsRight">
                        <form action="/album/preview.html?src=all&fromsrc=1&<?=$cashe?>" method="post" name="form1" id="form1">
                            <div class="contentsBox">
                                <div class="contentsTopGray">
                                    <h3 class="contentsttl floL">アルバム一覧</h3>
                                    <div class="searchArea floR">
                                        <input type="text" value="" class="textArea01" size="15" id="keyword" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>" />
                                        <a class="submit01 btn" onclick = "validatorLength();"></a>
                                        <?php if ($helpLinkUrl['AlbumList']) : ?>
                                        <a class="iconHelp" href="<?php echo $helpLinkUrl['AlbumList'] ?>" target="_blank">この機能のヘルプ</a>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="contentsMain">
                                    <?php if (isset($message)): ?>
                                        <p class="txtRed txtBold">
                                            <?= $message ?>
                                        </p>
                                    <?php endif; ?>
                                        <p class="space_2">アルバム名をクリックすると詳細を見ることができます。</p>
                                        <?php foreach ($albumList as $item): ?>
                                            <div class="space_2">
                                                <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                                                    <thead>
                                                        <tr>
                                                            <th class="BGColorSkyColor">
                                                                <h2 class="iconAlbumMenu">
                                                                <a href="/album/preview.html?aid=<?= $item['album_id'] ?>&<?= $cashe ?>">
                                                                    <?= h($item['album_name']) ?>
                                                                </a>
                                                                </h2>
                                                            </th>
                                                            <th class="txtRight BGColorSkyColor">
                                                                ファイル数:<?php if ($item['count']) : ?><?= h($item['count']) ?><?php else: ?>0<?php endif; ?> |
                                                                <?php if ($item['openstatus'] == 1) : ?>
                                                                公開中 [
                                                                <a href="/album/open/status.html?pid=all&aid=<?php echo $item['album_id']; ?>&<?php echo $cashe; ?>">公開状況を確認</a> ]
                                                                <?php else : ?>
                                                                <span style="color:#666666;">非公開</span>
                                                                <?php endif ; ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="2" class="BGColorSkyGray">
                                                                <div style="word-wrap: break-word; width: 660px;">
                                                                    <?= h($item['album_comment']) ?>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="vertical-align:bottom;">
                                                                <?php foreach ($listPicsPreview as $key => $value) : ?>
                                                                <?php if ($item['album_id'] == $key) : ?>
                                                                <?php if (!$value) : ?>
                                                                <table class="bottomTable">
                                                                    <tr>
                                                                        <td style="padding:10px 0 30px 20px;">
                                                                            <p class="txtGray">写真が登録されていません。
                                                                                <br />「写真を登録する」のメニューより登録してください。</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <?php endif; ?>
                                                                <table class="bottomTable">
                                                                    <tr>
                                                                        <?php foreach($value as $pic): ?>
                                                                        <td>
                                                                            <div class="photo02" title="<?= h($pic->pic_name) ?>">
                                                                                <div class="space_5">
                                                                                    <a href="/album/picture/detail.html?pid=<?= $pic->pic_id ?>&<?= $cashe ?>">
                                                                                        <img data-original="/album/picture/picture.html?pid=<?= $pic->pic_id ?>&type=1&<?= $cashe ?>" class="lazy" />
                                                                                    </a>
                                                                                </div>
                                                                                <div class="txtXSmall">
                                                                                    <a href="/album/picture/detail.html?pid=<?= $pic->pic_id ?>&<?= $cashe ?>">
                                                                                        <?= h($this->Common->limitWord($pic->name)) ?>
                                                                                    </a>
                                                                                    <br class="clear" />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                </table>
                                                                <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="txtRight">
                                                                <a href="/album/preview.html?aid=<?= $item['album_id']; ?>&<?= $cashe; ?>" >詳細を見る</a> |
                                                                <a href="/album/picture/regist.html?aid=<?= $item['album_id']; ?>&<?= $cashe; ?>" >写真を登録</a> |
                                                                <a href="/album/open/regist.html?openflg=1&aid=<?= $item['album_id']; ?>&<?= $cashe; ?>" >友人に公開する</a> |
                                                                <a href="/album/edit.html?aid=<?= $item['album_id']; ?>&<?= $cashe; ?>">編集</a>
                                                                <?php if($item['album_id'] != 1): ?>
                                                                <a href="/album/delete.html?aid=<?= $item['album_id']; ?>&<?= $cashe; ?>"> | 削除</a>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php endforeach; ?>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
            <div id="goTop"><a href="#top">▲ページトップへ</a></div>
    </div>
    <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
    <script>
        $(function() {
            $('img.lazy').lazyload();
        });
    </script>
</body>

</html>