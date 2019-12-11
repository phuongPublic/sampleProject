<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
        <script type="text/javascript" src="/contents/js/Lytebox/lytebox.js"></script>
        <link href="/contents/js/Lytebox/lytebox.css" rel="stylesheet" type="text/css" media="screen"/>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script language="javascript" type="text/javascript">
            var cross = 3;
            var Pic = new Array();
            var schedule_pic = new Array();
            var info_layer = new Array();
            var comment_layer = new Array();
            var movie_contents_id = new Array();
            var movie_folder_id = new Array();
            var movie_folder_name = new Array();
            var title = new Array();
            var open_status = new Array();
            var fid = new Array();
            var eid = new Array();
            var file_name = new Array();
            var thumb = new Array();
            var vWidth = new Array();
            var vHeight = new Array();
            var downloadAble = new Array();
            var encode_status = new Array();

            <?php foreach ($slide as $num => $list) : ?>
            Pic[<?= $num ?>]                  = '/movie/contents/picture.html?cid=<?= $list['movie_contents_id'] ?>&<?= $cashe ?>';
            info_layer[<?= $num ?>]       = '登録日：<?= $list['reg_date']->i18nFormat('YYYY-MM-dd') ?>　ファイルサイズ：<?= $this->Common->modifierMbyte($list['amount']) ?>　再生時間：<?= $this->Common->cutCommaSeconds($list['reproduction_time'])?>';
            comment_layer[<?= $num ?>]    = '<?= $this->Common->htmlEscape($list['movie_contents_comment']) ?>';
            movie_contents_id[<?= $num ?>]               = '<?= $list['movie_contents_id'] ?>';
            movie_folder_id[<?= $num ?>]               = '<?= $list['movie_folder_id'] ?>';
            title[<?= $num ?>]               = '<?= $this->Common->htmlEscape($list['name']) ?>';
            fid[<?= $num ?>]               = '<?= $list['file_id'] ?>';
            eid[<?= $num ?>]               = '<?= $list['encode_file_id_flv'] ?>';
            file_name[<?= $num ?>]               = '<?= $this->Common->htmlEscape($list['file_name']) ?>';
            thumb[<?= $num ?>]               = '<?= $list['thumb'] ?>';
            vWidth[<?= $num ?>]               = '<?= $list['video_width'] ?>';
            vHeight[<?= $num ?>]               = '<?= $list['video_height'] ?>';
            downloadAble[<?= $num ?>]               = '<?= $list['downloadAble'] ?>';
            encode_status[<?= $num ?>]               = '<?= $list['encode_status'] ?>';
            <?php endforeach; ?>

            var f;
            var t;
            var j = <?php if ($LoopStart == "") : ?>0<?php else : ?><?= $LoopStart ?><?php endif; ?>;
            var p = Pic.length;

            // 画像切り替え
            function switchImage(i) {
                if (f) {
                    clearTimeout(t);
                    f = 0;
                    --j;
                }
                j = j + i;

                if (j > (p - 1)) {
                    j = 0;
                } else if (j < 0) {
                    j = p - 1;
                }

                var newImgNum = j + 1;
                var prevstr = "";
                var nextstr = "";

                if (newImgNum != 1) {
                    prevstr = '<a href="javascript:switchImage(-1)" ><<前へ</a>';
                }
                if (newImgNum != p) {
                    nextstr = '<a href="javascript:switchImage(1)" >次へ>></a>';
                }

                if (encode_status[j] == 3) {
                    var html = '';
                    html = html + '<img src="/contents/images/movie_convert_fail480x360.jpg">';
                    var imgDownload = '<img src="/contents/images/icon_download12.gif" class="imgMovie" align="absmiddle" />';
                    var downloadMov = '<div id="downloadMov" class="txtXSmall" style="display: inline;">ダウンロード</div>';
                    document.getElementById('player').innerHTML = html;
                } else if(encode_status[j] == 0)  {
                    var html = '';
                    html = html + '<video width="' + vWidth[j] + '" height="' + vHeight[j] + '" controls controlsList="nodownload">';
                    html = html + '<source src="/movie/contents/play.html?cid=' + movie_contents_id[j] + '" type="video/mp4">';
                    html = html + "<?= h($UnsupportMes) ?>";
                    html = html + '</video>';
                    var imgDownload = '<img src="/contents/images/icon_download12.gif" class="imgMovie" align="absmiddle" />';
                    var downloadMov = '<div id="downloadMov" class="txtXSmall" style="display: inline;">ダウンロード</div>';
                    document.getElementById('dl_layer').innerHTML = '';
                } else {
                    var html = '';
                    html = html + '<video width="' + vWidth[j] + '" height="' + vHeight[j] + '" controls controlsList="nodownload">';
                    html = html + '<source src="/movie/contents/play.html?cid=' + movie_contents_id[j] + '" type="video/mp4">';
                    html = html + "<?= h($UnsupportMes) ?>";
                    html = html + '</video>';
                    var imgDownload = '<img src="/contents/images/icon_download12.gif" class="imgMovie" align="absmiddle" />';
                    var downloadMov = '<a id="downloadMov" href="/movie/download.html?cid=' + movie_contents_id[j] + '" class="txtXSmall">ダウンロード</a>';
                    document.getElementById('dl_layer').innerHTML = '';
                    if (downloadAble[j] == 0) {
                        var downloadMov = '<span id="downloadMov" class="txtXSmall">ダウンロード</span>';
                        document.getElementById('dl_layer').innerHTML = "<?= Configure::read('Common.DisableDownloadMovieFileMessage') ?>";
                    }
                }
                downloadMov = imgDownload + downloadMov;
                document.getElementById('player').innerHTML = html;
                document.getElementById('downloadContain').innerHTML = downloadMov;
                document.getElementById('Page').innerHTML = prevstr + newImgNum + ' / ' + p + nextstr;
                document.getElementById('info_layer').innerHTML = info_layer[j];
                document.getElementById('comment_layer').innerHTML = comment_layer[j];
                document.getElementById('title').innerHTML = title[j];

            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                initLytebox();
            });
        </script>
        <style type="text/css" media="screen">
            .imgMovie {
                padding: 2px !important;
                border: none !important;
                vertical-align: bottom;
            }
        </style>
    </head>
    <body>
        <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
        <div id="OpneContents">
            <div class="container">
                <h1 class="pagettl"><?= h($OpenData['nickname']) ?>さんの動画</h1>
                <div class="iconCon"><h1 class="txtBold" id="title" style="text-align: left;"><?= $this->Common->htmlEscapeNotQuote($data['name']) ?></h1></div>
                <?php if (isset($helpLinkUrl['OpenContents'])) : ?>
                <div class="floR openDetailHelpArea">
                <a class="iconHelp" href="<?php echo $helpLinkUrl['OpenContents'] ?>" target="_blank">ヘルプ</a>
                </div>
                <?php endif;?>
                <div style="clear:both;height:0;"></div>
                <div class="alubumItemsPic">
                    <span id="Page">
                        <?php if ($LoopStart+1 != 1) : ?>
                            <a href="javascript:switchImage(-1)"><<前へ</a>
                        <?php endif; ?>
                        <?= $LoopStart+1 ?> / <?= count($slide) ?>
                        <?php if ($LoopStart+1 != count($slide)) : ?>
                            <a href="javascript:switchImage(1)" onclick="">次へ≫</a>
                        <?php endif; ?>
                    </span>
                    <div style="clear:both;" class="space_1"></div>
                </div>
                <div style="margin-top:10px; margin-bottom:auto; text-align:center; vertical-align:middle;">
                    <div id="player">
                        <video width="<?= $video_width ?>" height="<?= $video_height ?>" controls controlsList="nodownload">
                            <source src="/movie/contents/play.html?cid=<?= $data['movie_contents_id'] ?>" type="video/mp4">
                            <?= h($UnsupportMes) ?>
                        </video>
                    </div>
                    <br />
                    <p id="comment_layer" class="dtCommentArea"><?= $this->Common->htmlEscapeNotQuote($data['movie_contents_comment']) ?></p>
                    <div  id="downloadContain">
                        <img src="/contents/images/icon_download12.gif" class="imgMovie" align="absmiddle" />
                        <?php if ($data['downloadAble'] == 1) : ?>
                            <a id="downloadMov" href="/movie/download.html?cid=<?= $data['movie_contents_id'] ?>" class="txtXSmall">ダウンロード</a>
                        <?php else : ?>
                            <span id="downloadMov" class="txtXSmall">ダウンロード</span>
                        <?php endif ; ?>
                    </div>
                    <br />
                    <p id="dl_layer" class="dtCommentArea">
                    <?php if ($data['downloadAble'] == 0) : ?>
                        <?= Configure::read('Common.DisableDownloadMovieFileMessage') ?>
                    <?php endif; ?>
                    </p>
                    <div class="picItemsBottom">
                        <div id="info_layer" class="floL">登録日：<?= $data['reg_date']->i18nFormat('YYYY-MM-dd') ?>　ファイルサイズ：<?= $this->Common->modifierMbyte($data['amount']) ?>　再生時間：<?= $this->Common->cutCommaSeconds($data['reproduction_time']) ?></div>
                        <span class="floR"><a style="float: right;" href="/open/movie.html?id=<?= $openid ?>&page=<?= $page ?>">&lt;&lt;動画一覧に戻る</a></span>
                        <br class="clear" />
                    </div>
                </div>
                <!--広告管理タグ-->
                <div class="adContents1">
                    <?php $this->Advertising->AdPublish(1,2);?>
                </div>
                <!--広告管理タグ-->
            </div>
        </div>

        <?php echo $this->element($this->Common->getIsp() . '/open/footer_' . $this->Common->getAspSetting() . '_open'); ?>
    </body>
</html>