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
  <div id="menu">
		<div id="close" onclick="document.getElementById('menuForm').removeAttribute('selected');"></div>
    <div id="menuTitle">メニュー</div>
    <ul>
      <li><a href="/iphone/calender/monthly.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/iphone/images/icon_schedule.png" />スケジュール</a></li>
      <li><a href="/iphone/album/list.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/iphone/images/icon_album.png" />アルバム</a></li>
      <li><a href="/iphone/movie/list.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/iphone/images/icon_movie.png" />動画</a></li>
      <li><a href="/iphone/storage/folder/list.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/iphone/images/icon_file.png" />ファイル管理</a></li>
      <li><a href="javascript:moveWebmail();" target="_self"><img src="/contents/iphone/images/icon_mail.png">メール</a></li>
						<li><a href="/bbs/redirect.html" target="_self"><img src="/contents/iphone/images/icon_bbs.png" alt="家族掲示板" style="width:30px;line-height:30px;vertical-align:bottom;" />家族掲示板</a></li>
    </ul>
    <ul class="mini">
      <li class="center"><a href="/iphone/index.html?<?php echo $cashe; ?>" target="_self"><img src="/contents/iphone/images/icon_home.png" />ホーム</a></li>
    </ul>
  </div>
  <div class="spinner"></div>
</ul>
