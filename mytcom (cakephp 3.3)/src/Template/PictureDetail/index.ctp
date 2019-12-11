<!DOCTYPE html>
<html>
<head>
<?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
<script language="javascript" type="text/javascript">
var speed = 4000;
var cross = 3;
var Pic = new Array();
var schedule_pic = new Array();
var pic_name_layer = new Array();
var pic_comment_layer = new Array();
var pic_id = new Array();
var album_id = new Array();
var album_name = new Array();
var pic_title = new Array();
var open_status = new Array();

<?php foreach ($slide as $key => $list) { 
    $log_date = isset($blogArray[$list['pic_id']][0]['log_date']) ? $blogArray[$list['pic_id']][0]['log_date'] : '';
    $log_date = $this->Common->date_format($log_date, "%Y-%m-%d");
?>
Pic[<?= $key ?>]                  = '/album/picture/picture.html?pid=<?= $list['pic_id'] ?>&type=3&<?= $cashe ?>';
schedule_pic[<?= $key ?>]         = '<?php if($blogArray[$list['pic_id']][0]) { ?> 関連：<span class="link-txt-diary"><a href="/weblog/days.html?target=<?= $log_date ?>&<?= $cashe ?>"><?= $this->Common->htmlEscape($blogArray[$list['pic_id']][0]['weblog_title']) ?></a></span><?php } ?>';
pic_name_layer[<?= $key ?>]       = '登録日：<?= $list['reg_date'] ?> ファイルサイズ：<?= $this->Common->modifierKbyte($list['amount']) ?>';
pic_comment_layer[<?= $key ?>]    = '<?= $this->Common->htmlEscape($list['pic_comment']) ?>';
pic_id[<?= $key ?>]               = '<?= $list['pic_id'] ?>';
album_id[<?= $key ?>]               = '<?= $list['album_id'] ?>';
album_name[<?= $key ?>]               = '<?= $this->Common->htmlEscape($list['album_name']) ?>';
pic_title[<?= $key ?>]               = '<?= $this->Common->htmlEscape($list['name']) ?>';
open_status[<?= $key ?>]               = '<?= $list['open_status'] ?>';
<?php } ?>
var f;
var t;
var j = <?= $LoopStart ?>;
var p = Pic.length;
var preLoad = new Array();
for (i = 0; i < p; i++){
    preLoad[i] = Pic[i];
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
    document.images.slide.src = preLoad[j];
    if(document.all){
        document.images.slide.filters.blendTrans.Play();
    }
    document.getElementById('Page').innerHTML = (j+1) + ' / ' + p;
    document.getElementById('schedule_pic').innerHTML         = schedule_pic[j];
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
    if(j > (p-1)){
        j=0;
    }else if(j < 0){
        j = p - 1;
    }
    var newImgNum = j+1;
    var prevstr = "";
    var nextstr = "";
    var status = "";
    var albumLink = "";
    if(newImgNum != 1){
        prevstr = '<a href="javascript:switchImage(-1)" >≪前へ</a>';
    }
    if(newImgNum != p){
        nextstr = '<a href="javascript:switchImage(1)" >次へ≫</a>';
    }
    if(open_status[j] == 0){
        status = '<span class="open_status" style="color:#666666;">非公開</span>&nbsp;';
    }else{
        status = '公開中 [&nbsp;<a href="/album/open/status.html?pid=all&aid='+album_id[j]+'&<?= $cashe ?>\'" class="open_status">公開状況を確認</a>&nbsp;]';
    }
    albumLink = 'アルバム:<a href="/album/preview.html?aid='+ album_id[j] +'&<?= $cashe ?>">'+ album_name[j] +'</a>';
    $("[class*=txtRed]",$("[class*=contentsMain]")).remove();
    if(i == 1){    //go to next
        $("#slideList a:first").appendTo($("#slideList"));
    }else if(i == -1){    //go to previous
        $("#slideList a:last").prependTo($("#slideList"));
    }
    $("#slideList a").hide();
    $("#slideList a:first").css("display", "block");
    document.images.slide.src = preLoad[j];
    document.getElementById('Page').innerHTML = prevstr + newImgNum + ' / ' + p + nextstr;
    document.getElementById('schedule_pic').innerHTML         = schedule_pic[j];
    document.getElementById('pic_name_layer').innerHTML       = pic_name_layer[j];
    document.getElementById('pic_comment_layer').innerHTML    = pic_comment_layer[j];
    document.getElementById('title').innerHTML    = pic_title[j];
    document.getElementById('status').innerHTML    = status;
    document.getElementById('albumLink').innerHTML    = albumLink;
}
function RemoveFileData(id){
    msg = "画像を移動してもよろしいですか？";
    if(window.confirm(msg)){
        document.form1.action = "/album/preview.html?aid="+ id +"&<?= $cashe ?>";
        document.form1.elements["folder"].value = id;
        document.form1.elements["remove"].value = 1;
        document.form1.submit();
    }
}
function DeleteFileData(){

    if(f==1){
        location.href='./delete.html?<?= $cashe ?>&pid='+pic_id[j-1];
    }else{
        location.href='./delete.html?<?= $cashe ?>&pid='+pic_id[j];
    }
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
        window.open("/album/picture/picture.html?pid="+pic_id[j-1]+"&type=2&<?= $cashe ?>");
    }else{
        window.open("/album/picture/picture.html?pid="+pic_id[j]+"&type=2&<?= $cashe ?>");
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
function openPic(aid){
    if(f==1){
        document.form1.action = "/album/open/regist.html?aid=<?= $album_id ?>&openflg=3&del[]=" + pic_id[j-1];
    }else{
        document.form1.action = "/album/open/regist.html?aid=<?= $album_id ?>&openflg=3&del[]=" + pic_id[j];
    }
    document.form1.submit();
}
function BookMarkMenu(id){
    if(document.getElementById(id).style.display == "none"){
        document.getElementById(id).style.display = "block";
    }else{
        document.getElementById(id).style.display = "none";
    }
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('a#dropbtn1').click(function () {
      $("div#folder_list").slideToggle("fast");
    });
    $('a#dropbtn1').blur(function () {
        setTimeout(function() {
            $("div#folder_list").slideUp();
        }, 200);
    });
    // init LyteBox
    initLytebox();
});
</script>
</head>
<body>
    <?php if ($auto) { ?>
        onload="runSlideShow();"
    <?php } ?>
    <div id="wrapper">
        <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
        <form id="form" name="form1" method="post" action="/album/picture/detail.html?<?= $cashe ?>">
            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">写真の詳細</h3>
                            <?php if ($helpLinkUrl['PictureDetail']) : ?>
                                <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['PictureDetail'] ?>" target="_blank">この機能のヘルプ</a>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="contentsMain">
                            <?php if ($message) { ?>
                            <div class="txtRed txtBold" style="margin-bottom: -5px; padding-top: 10px;">
                                <?= $message ?>
                            </div>
                            <?php } ?>
                            <div class="iconPic">
                                <?php
                                    $pic = $data['name'];
                                    $width = '500px';
                                    if ($this->Common->getStrLength($pic) > 80) {
                                        $width = '670px';
                                    }
                                ?>
                                <h1 class="txtBold" id="title" style="word-wrap: break-word; width: <?php echo $width; ?>;">
                                    <?= h($data['origin_name']) ?>
                                </h1>
                            </div>
                            <div class="itemFiles" id="status">
                                <?php if ($open_status == 0) { ?>
                                <span class="open_status" style="color: #666666;">非公開</span>&nbsp;
                                <?php } else {?>
                                公開中 [&nbsp;<a href="/album/open/status.html?pid=all&aid=<?= $album_id ?>&<?= $cashe ?>" class="open_status">公開状況を確認</a>&nbsp;]
                                <?php } ?>
                            </div>
                            <div class="alubumItemsPic">
                                <div style="float: left; position: relative; font-size: 12px;">
                                    <img src="/contents/images/icon_edit12.gif" alt="" align="absmiddle" /><a href="javascript:jump();">情報の編集</a>｜<img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><a href="javascript:openPic();">友人に公開</a>｜<img src="/contents/images/icon_pic12.gif" alt="" align="absmiddle" /><a  href="javascript:openWindowOrg();">元画像表示</a>｜<img src="/contents/images/icon_download12.gif" alt="" align="absmiddle" /><a href="javascript:downloadPic();">ダウンロード</a>｜<img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" id="dropbtn1">移動する<img alt="" src="/contents/images/icon_arrow_down12.gif" style="width: 12px; height: 12px;" /></a>｜<img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><a href="javascript:DeleteFileData()">削除する</a>
                                    <div id="folder_list"
                                        style="position: absolute; left: 380px; top: 25px; border: solid 1px #00608D; background-color: #f8f8f8; display: none;">
                                        <ul style="padding: 10px;">
                                            <?php foreach ($folder2 as $key => $label) { ?>
                                            <li style="color: #999999; padding: 0; display: block;">
                                            <a href="javascript:RemoveFileData('<?= $key ?>')" style="white-space: nowrap;" onclick="">
                                                    <?= h($label) ?>
                                            </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>

                                </div>
                                <span id="Page">
                                    <?php if($LoopStart+1 != 1){ ?> <a href="javascript:switchImage(-1)" onclick="">≪前へ</a> <?php } ?>
                                    <?= $LoopStart+1 ?> / <?= count($slide) ?>
                                    <?php if($LoopStart+1 != count($slide)) { ?> <a href="javascript:switchImage(1)" onclick="">次へ≫</a> <?php } ?>
                                </span>
                                <div style="clear: both;" class="space_1"></div>
                            </div>
                            <div style="margin: 0 auto; clear: both; text-align: center;">
                                <a href="javascript:openWindowOrg();"><img
                                    src="/album/picture/picture.html?pid=<?= $data['pic_id'] ?>&type=3&<?= $cashe ?>"
                                    name="slide" id="slide" alt="写真"
                                    style="vertical-align: middle;" /></a> <br />
                                <p class="dtCommentArea" id="pic_comment_layer">
                                    <?= $this->Common->htmlEscapeNotQuote($data['pic_comment']); ?>
                                </p>
                                <p id="slideList" class="slideshowB">
                                    <a href="/album/picture/picture.html?pid=<?= $picStart['pic_id'] ?>&type=2&<?= $cashe ?>" rel="lyteshow[vacation]" style="" title="スライドショー" alt="<?= $this->Common->htmlEscapeNotQuote($picStart['name']) ?><br /><?= $this->Common->htmlEscapeNotQuote($picStart['pic_comment'])?>">スライドショー</a>
                                    <?php foreach ($slide as $num => $list): ?>
                                        <?php if ($num != $LoopStart): ?>
                                            <a href="/album/picture/picture.html?pid=<?= $list['pic_id'] ?>&type=2&<?= $cashe ?>" rel="lyteshow[vacation]" style="
                                            display:none" title="スライドショー" alt="<?= $this->Common->htmlEscapeNotQuote($list['name']) ?><br /><?= $this->Common->htmlEscapeNotQuote($list['pic_comment'])?>">スライドショー</a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                            <div class="picItemsBottom" id="picItemsBottom">
                                <h2 id="pic_name_layer" style="float: left;">
                                    登録日：<?= $this->Common->date_format($data['reg_date'], "%Y-%m-%d") ?>&nbsp;&nbsp;ファイルサイズ：<?= $this->Common->modifierKbyte($data['amount']) ?>
                                </h2>
                                <span class="floR" id="albumLink"><a
                                    href="/album/preview.html?aid=<?= $album_id ?>&<?= $cashe ?>">
                                        <?= h($album['album_name']) ?>
                                </a></span>
                                <div style="clear: both;" class="space_5"></div>
                                <div id="schedule_pic">
                                    <?php if($blog) { ?>
                                    <p style="padding: 0;">
                                        関連：<span class="link-txt-diary"><a href="/weblog/days.html?target=<?= $this->Common->date_format($blog['log_date'],'%Y-%m-%d') ?>&<?= $cashe ?>"><?= $this->Common->htmlEscapeNotQuote(h($blog['weblog_title'])) ?></a></span>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <br class="clear" />
                            <input type="hidden" name="picture" value="<?= $data['pic_id'] ?>" />
                            <input type="hidden" name="remove" value="">
                            <input type="hidden" name="folder" value="">
                            <input type="hidden" name="delete" value="">
                            <input type="hidden" name="del[]" value="<?= $data['pic_id'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="goTop"><a href="#top">▲ページトップへ</a></div>
    </div>
    <?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
</body>
</html>
