<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
    <script type="text/javascript"> 
        $(document).ready(function(){
         $('input.textArea01').focus(function () {
          $(this).css('background-image','none');
        });
        });
        $(function(){
        $('input.btnovr').click(function(){
        });
        $('input.btnovr').hover(function() {
        $(this).addClass('btnovrOn');
        },
        function() {
        $(this).removeClass('btnovrOn');
        });
        });   
    </script>
</head>
<body>

<div id="wrapper">


       <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

<div id="mainContents">
    <div id="messageArea"><h1 class="iconMovie">動画</h1></div>
 
    <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
 
<div id="contentsRight">
<div class="contentsBox">
    <div class="contentsTopGray">
        <h3 class="contentsttl floL">動画フォルダを削除する</h3>
        <?php if ($helpLinkUrl['MFolderDelete']) : ?>
        <div class="searchAreaN floR">
            <a class="iconHelp" href="<?php echo $helpLinkUrl['MFolderDelete'] ?>" target="_blank">この機能のヘルプ</a>
        </div>
        <?php endif;?>
    </div>
    <div class="contentsMain">
        <div class="bdrbot padArea">
        <?php if (isset($message)) : ?><span class="txtRed"><?= $message; ?></span>
        <?php endif; ?>
        <h3>以下の動画フォルダを削除します。</h3>
        <div class="space_5">内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。<br />
    削除を中止する場合は[ 戻る ]ボタンをクリックしてください。</div>
        </div>
        <form id="form" name="form1" method="post" action="/movie/delete.html?<?= $cashe; ?>">
            <?php foreach ($data as $list) : ?>
            <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                <tr>
                    <th>動画フォルダ名</th>
                    <td><?php echo h($list['movie_folder_name']);?></td>
                </tr>
                <tr>
                    <th>コメント</th>
                    <td><div style="word-wrap: break-word; width: 450px;"><?php echo h($list['movie_folder_comment']);?></div></td>
                </tr>
        <tr>
                    <th>容量</th>
                    <td><?=$this->Common->modifierKbyte($amount)?></td>
                </tr>
            </table>
            <input type="hidden" name="del[]" value="<?php echo $list['movie_folder_id'];?>">
            <?php endforeach; ?>
            <p align="center"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
            <p align="center"class="txtRed" class="space_4">このフォルダとフォルダに含まれる全てのデータが<br />
削除されますがよろしいですか？</p>
            <p align="center">
                <input name="commit" type="submit" class="btnovr" value="削除する" />
                <input name="back" type="button" class="btnovr" value="戻る"  onclick="location.href='<?= $previousUrl ?>'"/>
            </p>
        </form>
    </div>
</div>
</div>
</div>
<div id="goTop"><a href="#top">▲ページトップへ</a></div>
</div>
<?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
</body>
</html>
