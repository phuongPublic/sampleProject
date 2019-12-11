<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
<script language="javascript" type="text/javascript">
var oid = "<?=$data['movie_contents_id']?>";
//グローバル変数。画面の初回表示かどうか判断する。メッセージのremoveするかどうかの判断に使用する。
var isInitial = true;
function openThumbnailer(){
    var param   = "?cid="+oid;
    window.open("/movie/thumbnailedit.html"+param, "window_name", "width=860,height=730,scrollbars=yes");

}
function openCutter(){
    var param = "?cid="+oid;
    window.open("/movie/cutedit.html"+param, "window_name", "width=860,height=730,scrollbars=yes");

}

var cross = 3;
var Pic = new Array();
var schedule_pic = new Array();
var info_layer = new Array();
var comment_layer = new Array();
var movie_contents_id = new Array();
var movie_folder_id = new Array();
var movie_folder_name = new Array();
var movie_full_path = new Array();
var movie_title = new Array();
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
Pic[<?=$num?>]                  = '/album/picture/picture.html?movie_contents_id=<?=$list['movie_contents_id']?>&type=3&<?=$cashe?>';
schedule_pic[<?=$num?>]         = '';
info_layer[<?=$num?>]       = '登録日：<?= $list['reg_date']->i18nFormat('YYYY-MM-dd') ?>　ファイルサイズ：<?=$this->Common->modifierMbyte($list['amount'])?>　再生時間：<?= $this->Common->cutCommaSeconds($list['reproduction_time'])?>';
comment_layer[<?=$num?>]    = '<?= $this->Common->htmlEscape($list['movie_contents_comment']) ?>';
movie_contents_id[<?=$num?>]               = '<?=$list['movie_contents_id']?>';
movie_folder_id[<?=$num?>]               = '<?=$list['movie_folder_id']?>';
movie_folder_name[<?=$num?>]               = '<?= $this->Common->htmlEscape($app['movie_folder_name']) ?>';
movie_full_path[<?=$num?>]               = '';
movie_title[<?=$num?>]               = '<?= $this->Common->htmlEscape($list['name']) ?>';
open_status[<?=$num?>]               = <?=$list['open_status']?>;
fid[<?=$num?>]               = '<?=$list['file_id']?>';
eid[<?=$num?>]               = '<?=$list['encode_file_id_flv']?>';
file_name[<?=$num?>]               = '<?= $this->Common->htmlEscape($list['movie_contents_name']) ?>';
thumb[<?=$num?>]               = '';
vWidth[<?=$num?>]               = '';
vHeight[<?=$num?>]               = '';
downloadAble[<?=$num?>] = <?=$list['downloadAble']?>;
encode_status[<?=$num?>] = <?=$list['encode_status']?>;
<?php endforeach;?>

var f;
var t;
var j = <?=$LoopStart?>;
var p = Pic.length;
var movieId = <?=$data['movie_contents_id']?>;
var preLoad = new Array();

for (i = 0; i < p; i++){
   preLoad[i] = new Image();
   preLoad[i].src = Pic[i];
}


function downloadMov(){
    document.form1.movieId.value = movie_contents_id[j];
    document.form1.submit();
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
    var movLink = "";
    var download_link = "";
 
    if(newImgNum != 1){
        prevstr = '<a href="javascript:switchImage(-1)" >≪前へ</a>&nbsp;';
    }
    if(newImgNum != p){
        nextstr = '&nbsp;<a href="javascript:switchImage(1)" >次へ≫</a>';
    }
 
    if(open_status[j] == 0){
        status = '<span class="open_status" style="color:#666666;">非公開</span>&nbsp;';
    }else{
        status = '公開中 [&nbsp;<a href="/movie/open/status.html?cid=all&mid='+movie_folder_id[j]+'&<?=$cashe?>\'" class="open_status">公開状況を確認</a>&nbsp;]';
 
    }

    if(encode_status[j] == 2 && downloadAble[j] == 1){
        download_link = '<a id="downloadLink" href="javascript:downloadMov();">ダウンロード</a>';
    }else{
        download_link = '<div id="downloadLink" style="display: inline;">ダウンロード</div>';
    }
    movLink = 'フォルダ:<a href="/movie/preview.html?mid='+ movie_folder_id[j] +'&<?=$cashe?>">'+ movie_folder_name[j] +'</a>';
    if(isInitial){
        isInitial = false;
    }else{
        $("[class*=txtRed]",$("[class*=contentsMain]")).remove();
    }

    oid = movie_contents_id[j];

    document.getElementById('Page').innerHTML = prevstr + newImgNum + ' / ' + p + nextstr;
    document.getElementById('info_layer').innerHTML       = info_layer[j];
    document.getElementById('comment_layer').innerHTML    = comment_layer[j];
    document.getElementById('title').innerHTML    = movie_title[j];
    document.getElementById('status').innerHTML    = status;
    document.getElementById('movLink').innerHTML    = movLink;
    document.form1.elements["del[]"].value    = movie_contents_id[j];

     if (encode_status[j] == 3) {
         var html = '';
         html = html + '<img src="/contents/images/movie_convert_fail480x360.jpg">';
         document.getElementById('player').innerHTML = html;
         document.getElementById('downloadLink').outerHTML    = download_link;
         document.getElementById('noticeMes').innerHTML = '';
     } else {
         var html = '';
         html = html + '<video width="<?=$app['video_width']?>" height="<?=$app['video_height']?>" controls controlsList="nodownload">';
         html = html + '<source src="/movie/contents/play.html?cid=' + movie_contents_id[j] + '" type="video/mp4">';
         html = html + '<?=$messageUnsupport?>';
         html = html + '</video>';
         document.getElementById('player').innerHTML = html;
         document.getElementById('downloadLink').outerHTML = download_link;
         document.getElementById('noticeMes').innerHTML = '';
     }

    if (downloadAble[j] != 1) {
        document.getElementById('noticeMes').innerHTML = "<?= Configure::read('Common.DisableDownloadMovieFileMessage') ?>";
    }
}

 
 
function RemoveFileData(id){
    msg = "動画を移動してもよろしいですか？";
    if(window.confirm(msg)){
        document.form1.action = "/movie/preview.html?mid="+ id +"&<?=$cashe?>";
        document.form1.elements["folder"].value = id;
        document.form1.elements["remove"].value = 1;
        document.form1.elements["deletefile"].value = 0;
        document.form1.submit();
    }
 
}

function DeleteFileData(id){

    document.form1.action = "/movie/contents/delete.html";
    document.form1.elements["folder"].value = id;
    document.form1.elements["remove"].value = 0;
    document.form1.elements["deletefile"].value = 1;
    document.form1.elements["del[]"].value  = movie_contents_id[j];
    //document.form1.submit();
    location.href="/movie/contents/delete.html?cid=" + id + "&<?=$cashe?>";
}

function DeleteMovieFile(){

    if(f==1){
        location.href='./delete.html?<?= $cashe ?>&cid='+movie_contents_id[j-1];
    }else{
        location.href='./delete.html?<?= $cashe ?>&cid='+movie_contents_id[j];
    }
}

function jump(){
    
    if(f==1){
        location.href='./edit.html?<?=$cashe?>&movie_contents_id='+movie_contents_id[j-1];
    }else{
        location.href='./edit.html?<?=$cashe?>&movie_contents_id='+movie_contents_id[j];
    }
    
}

function openPic(){
    
    if(f==1){
        document.form1.action = "/movie/open/regist.html?mid=<?=$data['movie_folder_id']?>&openflg=5&del[]=" + movie_contents_id[j-1];
    }else{
        document.form1.action = "/movie/open/regist.html?mid=<?=$data['movie_folder_id']?>&openflg=5&del[]=" + movie_contents_id[j];
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
 
$(document).ready(function(){
    $('input.textArea01').focus(function () {
        $(this).css('background-image','none');
    });
    $('a#dropbtn1').click(function () {
        $("div#folder_list").slideToggle("fast");
    });
    $('a#dropbtn1').blur(function () {
        setTimeout(function() {
            $("div#folder_list").slideUp();
        }, 200);
    });
    switchImage(0);
});


</script>

</head>
<body>
<div id="wrapper">

<?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

<form id="form" name="form1" method="post" action="/movie/contents/detail.html?cid=<?=$data['movie_contents_id']?>&<?=$cashe?>">
<div id="mainContents">
  <div id="messageArea">
    <h1 class="iconMovie">動画</h1>
  </div>
    <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
  <div id="contentsRight">
    <div class="contentsBox">
      <div class="contentsTopGray">
        <h3 class="contentsttl floL">動画の詳細</h3>
        <?php if ($helpLinkUrl['MovieDetail']) : ?>
        <div class="searchAreaN floR">
            <a class="iconHelp" href="<?php echo $helpLinkUrl['MovieDetail'] ?>" target="_blank">この機能のヘルプ</a>
        </div>
        <?php endif;?>
      </div>
      <div class="contentsMain">
      <?php if ($message) :?><div class="txtRed txtBold" style="margin-bottom:-5px;padding-top:10px;"><?=$message?></div><?php endif;?>
          <div class="iconCon">
              <?php
                                    $width = '500px';
                                    if ($this->Common->getStrLength($data['name']) > 80) {
              $width = '670px';
              }
              ?>
              <h1 class="txtBold" id="title" style="word-wrap: break-word; width: <?php echo $width; ?>;">
                  <?= h($data['name']) ?>
              </h1>
          </div>
        <div class="itemFiles">
            <div id="status">
            <?php if ($open_status == 0) :?>
            <span class="open_status" style="color:#666666;">非公開</span>&nbsp;
            <?php else :?>
            公開中 [&nbsp;<a href="/movie/open/status.html?cid=all&mid=<?=$data['movie_folder_id']?>&<?=$cashe?>" class="open_status">公開状況を確認</a>&nbsp;]
            <?php endif;?>
            </div>
        </div>
        <div class="alubumItemsPic">
        <div style="position:relative;">
<img src="/contents/images/icon_edit12.gif" alt="" align="absmiddle" /><a href="javascript:jump();">基本情報編集</a>｜<img src="/contents/images/icon_cut12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" onClick="openCutter();">カット編集</a>｜<img src="/contents/images/icon_pic12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" onClick="openThumbnailer();">画像変更</a>｜<img src="/contents/images/icon_download12.gif" alt="" align="absmiddle"><div id="downloadLink" style="display: inline;">ダウンロード</div>｜<img src="/contents/images/icon_open12.gif" alt="" align="absmiddle" /><a href="javascript:openPic();">友人に公開</a>｜<img src="/contents/images/icon_move12.gif" alt="" align="absmiddle" /><a href="javascript:void(0);" id="dropbtn1">移動する<img alt="" src="/contents/images/icon_arrow_down12.gif" /></a>｜<div id="folder_list" style="z-index:999;position:absolute;left:465px;top:25px;border:solid 1px #00608D;background-color:#f8f8f8;display:none;">
                <ul style="padding:10px;">
                    <?php foreach ($folderNameList as $key => $val) : ?>
                    <li style="padding:0;display:block;z-index:999;">
                        <a href="javascript:;" onclick="javascript:RemoveFileData('<?php echo $key; ?>')" style="padding:0 0 5px 0;display:block;color:#00608D;">
                            <?php echo h($val); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div><img src="/contents/images/icon_trash12.gif" alt="" align="absmiddle" /><a href="javascript:DeleteMovieFile()">削除する</a>
        </div>
        <div id="pageNumb" style="display:inline-block; width:100%;margin-top: 10px;">
            <div id="noticeMes" style="float:left;">
                <?php if (!$downloadAble) :?>
                <?= Configure::read('Common.DisableDownloadMovieFileMessage') ?>
                <?php endif;?>
            </div>
            <div style="float:right;">
                <h5 id="Page">
                <span class="pic-number">
                <?php if ($LoopStart+1 != 1) : ?>
                <a href="javascript:switchImage(-1)" onclick="">≪前へ</a>&nbsp;
                <?php endif;?>
                <?=$LoopStart+1?> / <?=$total?>
                <?php if ($LoopStart+1 != $total) : ?>
                &nbsp;<a href="javascript:switchImage(1)" onclick="">次へ≫</a>
                <?php endif;?>
                </span>
                </h5>
            </div>
        </div>
        </div>
        <div style="margin-bottom:auto; text-align:center; vertical-align:middle;">
        <div id="player">
        <video width="<?=$app['video_width']?>" height="<?=$app['video_height']?>" controls controlsList="nodownload">
              <source src="/movie/contents/play.html?cid=<?= $cid ?>" type="video/mp4">
              <?=$messageUnsupport?>
         </video>
        </div>

          <br />
          <p id="comment_layer" class="dtCommentArea"  style="word-wrap: break-word; width: 670px"><?= $this->Common->htmlEscapeNotQuote($data['movie_contents_comment']); ?></p>
          <br />
          <div class="picItemsBottom">
            <h2 id="info_layer" style="float:left;">登録日：<?= $data['reg_date']->i18nFormat('YYYY-MM-dd') ?>　ファイルサイズ：<?=$this->Common->modifierMbyte($data['amount'])?>　再生時間：<?= $this->Common->cutCommaSeconds($data['reproduction_time']) ?></h2>
            <span id="movLink" class="floR">フォルダ名： <a href="/movie/preview.html?mid=<?=$data['movie_folder_id']?>&<?=$cashe?>"><?= h($app['movie_folder_name']) ?></a></span>
            </div>
            <div class="space_2" style="clear:both;"></div>
            <div class="movieLinks"> <a href="javascript:jump();" class="movieLink_1"><img src="/contents/images/spacer.gif" alt="基本情報の編集" /></a>
                <a href="javascript:openCutter();" class="movieLink_2"><img src="/contents/images/spacer.gif" alt="カット編集" /></a>
                <a href="javascript:openThumbnailer();" class="movieLink_3"><img src="/contents/images/spacer.gif" alt="画像変更・キャプチャ" /></a>
                <br style="clear:both;" />
          </div>
          <div class="space_2" style="clear:both;"></div>
            <input type="hidden" name="movieId" id="movie_contents_id" value="<?=$data['movie_contents_id']?>" />
            <input type="hidden" name="prev_page" value="<?=$app['prev_page']?>" />
            <input type="hidden" name="remove" value="">
            <input type="hidden" name="folder" value="">
            <input type="hidden" name="deletefile" value="">
            <input type="hidden" name="del[]" value="<?=$data['movie_contents_id']?>">
            <input type="hidden" name="open" value="">
            <input type="hidden" name="movie_folder_id" value="<?=$data['movie_folder_id']?>">
        </div>
      </div>
    </div>
  </div>
</div>
</form>
</div>
<div id="goTop"><a href="#top">▲ページトップへ</a></div>
<?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
</body>
</html>
