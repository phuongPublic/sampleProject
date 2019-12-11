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
        <div id="messageArea">
            <h1 class="iconMovie">動画</h1>
        </div>
        <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>

        <div id="contentsRight">
            <div class="contentsBox">
                <div class="contentsTopGray">
                    <h3 class="contentsttl floL">動画を削除する</h3>
                    <?php if ($helpLinkUrl['MovieDelete']) : ?>
                    <div class="searchAreaN floR">
                        <a class="iconHelp" href="<?php echo $helpLinkUrl['MovieDelete'] ?>" target="_blank">この機能のヘルプ</a>
                    </div>
                    <?php endif;?>
                </div>
                <div class="contentsMain">
                    <div class="bdrbot padArea">
                    <?php if (isset($message)) : ?><span class="txtRed"><?= $message; ?></span>
                    <?php endif; ?>
                    <h3>以下の動画を削除します。</h3>
                    <div class="space_5">内容を確認の上、問題がなければ[ 削除する ]ボタンをクリックしてください。<br />
                削除を中止する場合は[ 戻る ]ボタンをクリックしてください。</div>
                    </div>
                <div class="space_5"></div>
                    <form id="form" name="form1" method="post" action="/movie/contents/delete.html?<?=$cashe?>">
                        <table align="center" cellpadding="0" cellspacing="0" class="tblPicList">
                            <tr>
                                <th>サムネイル画像</th>
                                <th>名前</th>
                                <th>登録日</th>
                                <th>容量</th>
                                <th>フォルダ</th>
                                <th>公開状態</th>
                            </tr>
                            <?php foreach ($data as $key => $list) : ?>
                            <tr>
                                <td style="text-align:center;"><img src="/movie/contents/picture.html?cid=<?=$list['movie_contents_id']?>&type=1&<?=$cashe?>" width="100" height="75"/></td>
                                <td>
                                    <div style="word-wrap: break-word; width: 180px;"><?= h($list['movie_contents_name']) ?></div>
                                </td>
                                <td><?= $this->Common->date_format($list['reg_date'], "%Y-%m-%d") ?></td>
                                <td><?php echo $this->Common->modifierKbyte($list['amount']) ?></td>
                                <td><div style="word-wrap: break-word; width: 140px;"><?= h($list['movie_folder_name']) ?></div></td>
                                <td>
                                        <?php if ($list['openstatus'] == 0) { ?>
                                        非公開
                                        <?php } else { ?>
                                        公開中
                                        <?php } ?>
                                </td>
                            </tr>
                            <input type="hidden" name="del[]" value="<?=$list['movie_contents_id']?>">
                            <?php endforeach;?>
                        </table>
                        <p align="center"><img src="/contents/images/arrow_bot.gif" alt="▼" /></p>
                        <p align="center" class="space_4">動画を削除しますがよろしいですか？</p>
                        <p align="center">
                            <input type="hidden" name="mid" value="<?=$mid?>">
                            <input name="commit" type="submit" class="btnovr" value="削除する" />
                            <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href='<?=$prev_Url?>'" />
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
