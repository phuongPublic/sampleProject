<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>動画サムネイル編集</title>
        <link rel="stylesheet" href="/contents/css/movieThumbnailEdit.css" />
        <link rel="stylesheet" href="/contents/css/jquery-ui-1.12.1.min.css" />
        <script src="/contents/js/jquery-3.1.1.min.js"></script>
        <script src="/contents/js/jquery-ui-1.12.1.min.js"></script>
        <script src="/contents/js/jquery.plainoverlay.min.js"></script>
    </head>

    <body>
        <div id ="border">
            <div id="top">
                <?php if($this->Common->getIsp() == "tcom"): ?>
                    <a href="javascript:void(0)" onclick='openLink("http://service.t-com.ne.jp/mytcom/help/pc/h_movie12")' id="help">
                        <img id="helpIcon" src="/contents/images/icon_help16.png" alt=""/>
                        この機能のヘルプ
                    </a>
                <?php elseif($this->Common->getIsp() == "tnc"): ?>
                    <a href="javascript:void(0)" onclick='openLink("http://qa.tnc.ne.jp/category/show/626")' id="help">
                        <img id="helpIcon" src="/contents/images/icon_help16.png" alt=""/>
                        この機能のヘルプ
                    </a>
                <?php endif;?>
            </div>

            <div id="main">
                <div id="contents">
                    <div id="movieBlock" class="contentsBlock">
                        <div id="movitTitleBorder" class="contentsTitleBorder">
                            <div id="movieTitle" class="contentsTitle">▼元の動画</div>
                        </div>

                        <div id="movieBorder" class="contentsBorder">
                            <video id="movieContents">
                                <source src="/movie/contents/play.html?cid=<?=$movieContentId?>" type="video/mp4">
                                <p id="deprecated">
                                    <?php if($this->Common->getIsp() == "tcom"): ?>
                                        お使いのOS・ブラウザには対応しておりません。<br>MY@TCOMは<a href="javascript:void(0)" onclick='openLink("http://service.t-com.ne.jp/mytcom/attention/")'>推奨環境</a>でご利用ください。
                                    <?php elseif($this->Common->getIsp() == "tnc"): ?>
                                        お使いのOS・ブラウザには対応しておりません。<br>TNCポケットは<a href="javascript:void(0)" onclick='openLink("http://www.tnc.ne.jp/pocket/pt_01.html")'>推奨環境</a>でご利用ください。
                                    <?php endif;?>
                                </p>
                            </video>
                        </div>

                        <div id="movieParts">
                            <div id="movieTimeBorder">
                                <div id="movieTime">
                                    <label id="current">00:00.00</label> 
                                    / 
                                    <label id="duration">00:00.00</label>
                                </div>
                            </div>

                            <div id="movieSeekBarBorder" class="seekBar">
                                <div id="movieSeekBar"></div>
                            </div>

                            <div id="movieButtonBorder" align="center">
                                <div id="movieControllerBorder">
                                    <button id="toStartButton" class="button01" onclick="toStart()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_to_start.png" alt=""></button>                    
                                    <button id="turnBackButton" class="button01" onclick="turnBack()" onmousedown="startTurnBack()" onmouseup="stopTurnBack()" onmouseout="stopTurnBack()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_turn_back.png" alt=""></button>
                                    <button id="playButton" class="button01" onclick="play()" ><img id="playIcon" src="/contents/images/movie_cut_thumbnail_edit/movie_play.png" alt=""></button>
                                    <button id="advanceButton" class="button01" onclick="advance()" onmousedown="startAdvance()" onmouseup="stopAdvance()" onmouseout="stopAdvance()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_advance.png" alt=""></button>
                                    <button id="toEndButton" class="button01" onclick="toEnd()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_to_end.png" alt=""></button>
                                </div>
                                <div id="volumeControllerBorder">
                                    <button id="volumeButton" onclick="volume()"><img id="volumeIcon" src="/contents/images/movie_cut_thumbnail_edit/movie_volume_on.png" alt=""> </button>
                                    <div id="volumeBar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="thumbnailBlock" class="contentsBlock">

                        <div id="thumbnailTitleBorder" class="contentsTitleBorder">
                            <div id="thumbnailTitle" class="contentsTitle">▼キャプチャー画像プレビュー</div>
                        </div>
                        <div id="thumbnailBorder" class="contentsBorder">
                            <canvas id="thumbnailContents" ></canvas>
                        </div>

                        <div id="thumbnailParts">
                            <div id="thumbnailButtonBorder1" class="thumbnailButtonBorder">
                                <button id="captureButton" class="button02" onclick="capture()">キャプチャーを撮る</button>
                            </div>
                            <div id="thumbnailButtonBorder2" class="thumbnailButtonBorder" align="center">
                                <button id="changeButton" class="button03" disabled onclick="submit(<?=$movieContentId?>)"><img id="changeIcon" src="/contents/images/movie_cut_thumbnail_edit/thumbnail_change.png" alt="">&nbsp;&nbsp;&nbsp;画像変更</button>
                                <button id="downloadButton" class="button03" disabled onclick="download()"><img id="downloadIcon" src="/contents/images/movie_cut_thumbnail_edit/thumbnail_download.png" alt="">&nbsp;&nbsp;&nbsp;画像ダウンロード</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="bottom">
                <button id="button03" class="button03" onclick="closeWindow()">閉じる</button>
            </div>
            
            <input type="hidden" id="reproductionTime" value="<?=$reproductionTime?>">
            
        </div>

        <script src="/contents/js/movieThumbnailEdit.js"></script>
        <?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
    </body>
</html>
