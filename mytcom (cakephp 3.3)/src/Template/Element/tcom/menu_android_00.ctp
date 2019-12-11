<ul title="メニュー" id="menuForm" name="menuForm" class="dialog">
<script language="javascript" type="text/javascript">
function moveWebmail(){
	if(window.confirm("Webmailへ移動しますが、よろしいですか？")){
		var w=window.open('','_blank');
		if(w == undefined){
			location.href = '/external/webmail.html?<?php echo $cashe; ?>';
		}else{
			w.location.href = '/external/webmail.html?<?php echo $cashe; ?>';
		}
	}
}
</script>
<style type="text/css">
img .menu_icon {width:30px; height:30px;}
</style>

  <div id="menu">
		<div id="close" onclick="document.getElementById('menuForm').removeAttribute('selected');"></div>
    <div id="menuTitle">メニュー</div>
    <ul>
      <li><a href="/android/calender/monthly.html?<?php echo $cashe; ?>" target="_self"><img class="menu_icon" src="/contents/android/images/icon_schedule.png" width="30px" height="30px" />スケジュール</a></li>
      <li><a href="/android/album/list.html?<?php echo $cashe; ?>" target="_self"><img class="menu_icon" src="/contents/android/images/icon_album.png" width="30px" height="30px" />アルバム</a></li>
      <li><a href="/android/movie/list.html?<?php echo $cashe; ?>" target="_self"><img class="menu_icon" src="/contents/android/images/icon_movie.png" width="30px" height="30px" />動画</a></li>
      <li><a href="/android/storage/folder/list.html?<?php echo $cashe; ?>" target="_self"><img class="menu_icon" src="/contents/android/images/icon_file.png" width="30px" height="30px" />ファイル管理</a></li>
      <li><a href="javascript:moveWebmail();" target="_self"><img class="menu_icon" src="/contents/android/images/icon_mail.png" width="30px" height="30px" />メール</a></li>
      <li><a href="/bbs/redirect.html" target="_self"><img src="/contents/android/images/icon_bbs.png" alt="家族掲示板" width="30px" height="30px" />家族掲示板</a></li>
    </ul>
    <ul class="mini">
      <li class="center"><a href="/android/index.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/android/images/icon_home.png" />ホーム</a></li>
    </ul>
  </div>
  <div class="spinner"></div>
</ul>
