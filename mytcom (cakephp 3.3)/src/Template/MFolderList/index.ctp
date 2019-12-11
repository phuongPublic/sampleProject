<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
        <script type="text/javascript" src="/contents/js/jquery.mcdropdown.js"></script>
        <link type="text/css" href="/contents/css/jquery.mcdropdown.css" rel="stylesheet" media="all" />
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
                    var url_action = '/movie/preview.html?ml=1&src=all&fromsrc=1&search=1&<?php echo $cashe; ?>';
                    $('#form1').attr('action', url_action);
                    $('#form1').submit();
                }
            }
        </script>
        <style>
            .crop {
                width: 100px;
                height: 75px;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea"><h1 class="iconMovie"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>

                <div id="contentsRight">
                    <form action="/movie/preview.html?src=all&fromsrc=1&?<?= $cashe ?>" method="post" name="form1" id="form1">
                        <div class="contentsBox">
                            <div class="contentsTopGray">
                                <h3 class="contentsttl floL">動画フォルダ一覧</h3>
                                <div class="searchArea floR">
                                    <input class="textArea01" type="text" value="" size="15" id="keyword" name="keyword" maxlength="<?php echo Configure::read('KeywordSearch.KeywordLimit');?>"/>
                                    <a class="submit01 btn" onclick = "validatorLength();" style="margin-right: 4px; margin-left: 1px;"></a>
                                    <?php if ($helpLinkUrl['MFolderList']) : ?>
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['MFolderList'] ?>" target="_blank">この機能のヘルプ</a>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="contentsMain">
                                <?php if (!empty($message)) : ?><p class="txtRed txtBold"><?= $message ?></p><?php endif; ?>
                                <p class="space_2">動画名をクリックすると詳細を見ることができます。</p>
                                <?php foreach ($movieFolderList as $item): ?>
                                <div class="space_2">
                                    <table cellpadding="0" cellspacing="0" class="tblAlbumList">
                                        <thead>
                                            <tr>
                                                <th class="BGColorSkyColor"><h2 class="iconMovieMenu"><a href="/movie/preview.html?mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>"><?php echo h($item['movie_folder_name']); ?></a></h2></th>
                                                <th class="txtRight BGColorSkyColor">ファイル数:<?php echo $item['movie_count']; ?> | 
                                                    <?php if ($item['open_status'] == true ): ?>公開中 [ 
                                                    <a href="/movie/open/status.html?cid=all&mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>">公開状況を確認</a> ]
                                                    <?php else: ?>
                                                    <span style="color:#666666;">非公開</span>
                                                    <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="txtRight">
                                                    <a href="/movie/preview.html?mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>" >詳細を見る</a> | 
                                                    <a href="/movie/contents/regist.html?mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>" >動画を登録</a> | 
                                                    <a href="/movie/open/regist.html?openflg=4&mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>" >友人に公開する</a> | 
                                                    <a href="/movie/edit.html?mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>">編集</a> 
                                                    <?php if ($item['movie_folder_id'] != 1): ?>
                                                    | <a href="/movie/delete.html?mid=<?php echo $item['movie_folder_id']; ?>&<?php echo $cashe; ?>">削除</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <th colspan="2" class="BGColorSkyGray">
                                                    <div style="word-wrap: break-word; width: 660px;">
                                                    <?php echo h($item['movie_folder_comment']); ?>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="vertical-align:bottom;">
                                                    <?php if ($item['movie_count'] == 0): ?> 
                                                    <table class="bottomTable">
                                                        <tr>
                                                            <td style="padding:10px 0 30px 20px;">
                                                                <p class="txtGray">動画が登録されていません。<br />「動画を登録」のメニューより、動画を登録してください。</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php else: ?>
                                                    <table class="bottomTable">
                                                        <tr>
                                                            <?php foreach($contents[$item['movie_folder_id']]['movie'] as $itemPreview): ?>
                                                            <td>
                                                                <div class="movie01" title="<?php echo h($itemPreview['name']); ?>">

                                                                    <div class="space_5">
                                                                         <?php if ($itemPreview['encode_status'] == 2): ?>
                                                                        <a href="/movie/contents/detail.html?cid=<?php echo $itemPreview['movie_contents_id'] ?>&<?php echo $cashe; ?>">
                                                                            <img data-original="/movie/contents/picture.html?cid=<?php echo $itemPreview['movie_contents_id'] ?>&type=1&<?php echo $cashe; ?>" width="100" class="lazy crop"/>
                                                                        </a>
                                                                        <?php else: ?>
                                                                        <img data-original="/movie/contents/picture.html?cid=<?php echo $itemPreview['movie_contents_id'] ?>&type=1&<?php echo $cashe; ?>" width="100" class="lazy crop"/>
                                                                        <?php endif; ?>   
                                                                    </div>
                                                                    <div class="txtXSmall" style="margin:0 auto;width:112px;text-align:left;">
                                                                        <?php if ($itemPreview['encode_status'] == 2): ?>
                                                                        <a class="space_5" href="/movie/contents/detail.html?cid=<?php echo $itemPreview['movie_contents_id'] ?>&<?php echo $cashe; ?>">
                                                                            <?= h($this->Common->limitWord($itemPreview['name'])) ?>
                                                                        </a>
                                                                        <?php else: ?>
                                                                            <?= h($this->Common->limitWord($itemPreview['name'])) ?>
                                                                        <?php endif; ?>  
                                                                        <ul>
                                                                            <li>・再生時間：<?php echo $this->Common->cutCommaSeconds($itemPreview['reproduction_time']) ?></li>
                                                                            <li>・サイズ：<?php echo $this->Common->modifierMbyte($itemPreview['amount'])?></li>
                                                                            <li>・登録：<?= $this->Common->date_format($itemPreview['reg_date'], "%Y-%m-%d") ?></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    </table>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tbody>
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
