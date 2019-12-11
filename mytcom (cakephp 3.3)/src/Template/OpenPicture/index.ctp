<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/open/HtmlHeaderOpen'); ?>
        <script type="text/javascript" src="/contents/js/Lytebox/lytebox.js"></script>
        <link href="/contents/js/Lytebox/lytebox.css" rel="stylesheet" type="text/css" media="screen"/>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
        <script language="javascript" type="text/javascript">
            var speed = 4000;
            var cross = 3;
            var Pic = new Array();
            var schedule_pic = new Array();
            var pic_name_layer = new Array();
            var pic_comment_layer = new Array();
            var pic_id = new Array();
            var title = new Array();

            <?php foreach ($slide as $num => $list) : ?>
            Pic[<?= $num ?>]               = '/album/open/display.html?pid=<?= $list['pic_id'] ?>&type=3&<?= $cashe ?>';
            pic_name_layer[<?= $num ?>]    = '登録日：<?= $list['reg_date']->i18nFormat('YYYY-MM-dd') ?> ファイルサイズ：<?= $this->Common->modifierKbyte($list['amount']) ?>';
            pic_comment_layer[<?= $num ?>] = '<?= $this->Common->htmlEscape(substr(h($list['pic_comment']), 0, 120)) ?>';
            pic_id[<?= $num ?>]            = '<?= $list['pic_id'] ?>';
            title[<?= $num ?>]             = '<?= $this->Common->htmlEscape($list['name']) ?>';
            <?php endforeach; ?>

            var f;
            var t;
            var j = <?php if ($loopstart == "") : ?>0<?php else : ?><?= $loopstart ?><?php endif; ?>;
            var p = Pic.length;
            var preLoad = new Array();
            for (i = 0; i < p; i++){
               preLoad[i] = new Image();
               preLoad[i].src = Pic[i];
            }

            // スライドショーの開始
            function runSlideShow(){
                clearTimeout(t);
                SlideThread();
            }
            function SlideThread(){
                f = 1;
                if(j > (p-1)) j=0;
                if(document.all){
                    document.images.slide.style.filter = 'blendTrans(duration=2)';
                    document.images.slide.style.filter = 'blendTrans(duration=cross)';
                    document.images.slide.filters.blendTrans.Apply();
                }

                document.images.slide.src = preLoad[j].src;
                if(document.all){
                    document.images.slide.filters.blendTrans.Play();
                }
                document.getElementById('Page').innerHTML = (j+1) + ' / ' + p;
                document.getElementById('pic_name_layer').innerHTML       = pic_name_layer[j];
                document.getElementById('pic_comment_layer').innerHTML    = pic_comment_layer[j];
                j = j + 1;
                t = setTimeout('SlideThread()', speed);
            }
            // スライドショーの停止
            function stopSlideShow(){
                clearTimeout(t);
            }
            // 画像切り替え
            function switchImage(i){
                if(f){ clearTimeout(t); f =0; --j; }
                j = j + i;
                if(j > (p-1)){ j=0; }else if(j < 0){ j = p - 1; }

                var newImgNum = j+1;
                var prevstr = "";
                var nextstr = "";
                if(newImgNum != 1){
                        prevstr = '<a href="javascript:switchImage(-1)" >≪前へ</a>';
                }
                if(newImgNum != p){
                        nextstr = '<a href="javascript:switchImage(1)" >次へ≫</a>';
                }

                if(i == 1){//go to next
                        $("#slideList a:first").appendTo($("#slideList"));
                }else if(i == -1){//go to previous
                        $("#slideList a:last").prependTo($("#slideList"));
                }

                $("#slideList a").hide();
                $("#slideList a:first").css("display", "block");

                document.images.slide.src = preLoad[j].src;
                document.getElementById('Page').innerHTML = prevstr + newImgNum + ' / ' + p + nextstr;
                document.getElementById('pic_name_layer').innerHTML       = pic_name_layer[j];
                document.getElementById('pic_comment_layer').innerHTML    = pic_comment_layer[j];
                document.getElementById('title').innerHTML    = title[j];

            }

            function jump(){
                if(f==1){
                    location.href='./edit.html?<?= $cashe ?>&pid='+pic_id[j-1];
                }else{
                    location.href='./edit.html?<?= $cashe ?>&pid='+pic_id[j];
                }
            }

            function openWindowOrg(){
                if(f==1){
                    window.open("/album/open/display.html?pid="+pic_id[j-1]+"&type=2&<?= $cashe ?>");
                }else{
                    window.open("/album/open/display.html?pid="+pic_id[j]+"&type=2&<?= $cashe ?>");
                }
            }

            function downloadPic(){

                if(f==1){
                    document.form1.picture.value = pic_id[j-1];
                }else{
                    document.form1.picture.value = pic_id[j];
                }
                  document.form1.submit();
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                initLytebox();
            });
        </script>
    </head>
    <body>
        <?php echo $this->element($this->Common->getIsp() . '/open/header_' . $this->Common->getAspSetting() . '_open'); ?>
        <form id="form" name="form1" method="post" action="/open/picture.html?id=<?= $openid ?>&pid=<?= $picid ?>&id=<?= $openid ?>&<?= $cashe ?>">
            <div id="OpneContents">
                <div class="container">
                    <h1 class="pagettl"><?= h($opendata['nickname']) ?>さんのアルバム</h1>
                    <div class="iconPic"><h1 class="txtBold" id="title" style="text-align: left;"><?= $this->Common->htmlEscapeNotQuote($data['name']) ?></h1></div>
                    <?php if (isset($helpLinkUrl['OpenPicture'])) : ?>
                        <div class="floR openDetailHelpArea">
                        <a class="iconHelp" href="<?php echo $helpLinkUrl['OpenPicture'] ?>" target="_blank">ヘルプ</a>
                        </div>
                    <?php endif;?>
                    <div style="clear:both;height:0;"></div>
                    <div class="alubumItemsPic">
                        <div class="floL">
                            <img src="/contents/images/icon_pic12.gif" alt="" align="absmiddle" /><a href="javascript:openWindowOrg();">元画像表示</a> ｜ 
                            <img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" /><a href="javascript:downloadPic();">ダウンロード</a> ｜ 
                        </div>
                        <span id="Page">
                            <?php if ($loopstart+1 != 1) : ?>
                                <a href="javascript:switchImage(-1)" onclick="">≪前へ</a>
                            <?php endif; ?>
                            <?= $loopstart+1 ?> / <?= count($slide) ?>
                            <?php if ($loopstart+1 != count($slide)) : ?>
                                <a href="javascript:switchImage(1)" onclick="">次へ≫</a>
                            <?php endif; ?>
                        </span>
                        <div style="clear:both;" class="space_1"></div>
                    </div>
                    <div style="margin:0 auto;clear:both;text-align:center;">
                        <div class="space_3"><a href="javascript:openWindowOrg();"><img src="/album/open/display.html?id=<?= $openid ?>&pid=<?= $data['pic_id'] ?>&type=3&<?= $cashe ?>" name="slide" id="slide" alt="写真" style="vertical-align:middle;" /></a></div>
                        <p class="dtCommentArea space_3" id="pic_comment_layer"><?= $this->Common->htmlEscapeNotQuote($data['pic_comment']) ?></p>

                        <p id="slideList" class="slideshowB">
                            <?php foreach ($slide as $num => $list) : ?>
                            <?php if ($num >= $loopstart) : ?>
                            <a href="/album/open/display.html?id=<?= $openid ?>&pid=<?= $list['pic_id'] ?>&type=2&<?= $cashe ?>" rel="lyteshow[vacation]" style="<?php if ($num != $loopstart) : ?>display:none<?php endif; ?>" title="スライドショー" alt="<?= h($list['name']) ?><br /><?= h($list['pic_comment']) ?>">スライドショー</a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($slide as $num => $list) : ?>
                            <?php if ($num < $loopstart) : ?>
                            <a href="/album/open/display.html?id=<?= $openid ?>&pid=<?= $list['pic_id'] ?>&type=2&<?= $cashe ?>" rel="lyteshow[vacation]" style="display:none" title="スライドショー" alt="<?= h($list['name']) ?><br /><?= h($list['pic_comment']) ?>">スライドショー</a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </p>

                        <div class="picItemsBottom">
                            <div id="pic_name_layer" style="float:left;">登録日：<?= $data['reg_date']->i18nFormat('YYYY-MM-dd') ?> ファイルサイズ：<?= $this->Common->modifierKbyte($data['amount']) ?></div>
                            <span class="floR"><a href="/open/album.html?id=<?= $openid ?>&page=<?= $page ?>">&lt;&lt;写真一覧に戻る</a></span>
                            <div style="clear:both;" class="space_5"></div>
                        </div>
                    </div>
                    <!--広告管理タグ-->
                    <div class="adContents1">
                        <?php $this->Advertising->AdPublish(1,2);?>
                    </div>
                    <!--広告管理タグ-->
                </div>
                <input type="hidden" name="picture" value="" />
        </form>

        <?php echo $this->element($this->Common->getIsp() . '/open/footer_' . $this->Common->getAspSetting() . '_open'); ?>
    </body>
</html>