<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>動画カット編集</title>
        <link rel="stylesheet" href="/contents/css/movieCutEdit.css" />
        <link rel="stylesheet" href="/contents/css/movieCutEditPreview.css" />
        <link rel="stylesheet" href="/contents/css/jquery-ui-1.12.1.min.css" />
        <script src="/contents/js/jquery-3.1.1.min.js"></script>
        <script src="/contents/js/jquery-ui-1.12.1.min.js"></script>
        <script src="/contents/js/jquery.plainoverlay.min.js"></script>
        
    </head>

    <body>
        <div id ="message">
            <div id ="border">
                <div id="top">
                    <?php if($this->Common->getIsp() == "tcom"): ?>
                    <a href="javascript:void(0)" onclick='openLink("http://service.t-com.ne.jp/mytcom/help/pc/h_movie11")' id="help">
                            <img id="helpIcon" src="/contents/images/icon_help16.png" alt=""/>
                            この機能のヘルプ
                        </a>
                    <?php elseif($this->Common->getIsp() == "tnc"): ?>
                        <a href="javascript:void(0)" onClick='openLink("http://qa.tnc.ne.jp/category/show/626")' id="help">
                            <img id="helpIcon" src="/contents/images/icon_help16.png" alt=""/>
                            この機能のヘルプ
                        </a>
                    <?php endif;?>
                </div>

                <div id="main">            
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
                    <div id="movieTimeBorder">
                        <ul>
                            <div id="movieTime">
                                <label id="current">00:00.00</label> 
                                / 
                                <label id="duration">00:00.00</label>
                            </div>
                            <div id="movieCutTime">
                                <img class="redScissors" src="/contents/images/movie_cut_thumbnail_edit/red_scissors_left.png" alt="">&nbsp;<label id="cutStartTime">00:00.00</label>
                                -
                                <img class="blueScissors" src="/contents/images/movie_cut_thumbnail_edit/blue_scissors_right.png" alt="">&nbsp;<label id="cutEndTime">00:00.00</label>
                            </div>
                            <div id="movieCutTotalTime">
                                <label id="totalTimeArea">カット後再生時間：</label><label id="totalTime">00:00.00</label>
                            </div>
                        </ul>
                    </div>
                    <div id="movieSeekBarBorder" class="seekBar">
                        <div id="movieCutEditBar"></div>
                        <div id="movieSeekBar"></div>
                        <div id="seekBarWrapper"></div>
                    </div>
                    <div id="movieButtonBorder" align="center">
                            <div id="movieControllerBorder">
                                <button id="toStartButton" class="button01" onclick="toStart()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_to_start.png" alt=""></button>                    
                                <button id="turnBackButton" class="button04" onclick="turnBack()" onmousedown="startTurnBack()" onmouseup="stopTurnBack()" onmouseout="stopTurnBack()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_turn_back.png" alt=""></button>
                                <button id="playButton" class="button04" onclick="play()" ><img id="playIcon" src="/contents/images/movie_cut_thumbnail_edit/movie_play.png" alt=""></button>
                                <button id="advanceButton" class="button04" onclick="advance()" onmousedown="startAdvance()" onmouseup="stopAdvance()" onmouseout="stopAdvance()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_advance.png" alt=""></button>
                                <button id="toEndButton" class="button01" onclick="toEnd()"><img src="/contents/images/movie_cut_thumbnail_edit/movie_to_end.png" alt=""></button>
                            </div>
                            <div id="volumeControllerBorder">
                                <button id="volumeButton" onclick="volume()"><img id="volumeIcon" src="/contents/images/movie_cut_thumbnail_edit/movie_volume_on.png" alt=""> </button>
                                <div id="volumeBar"></div>
                            </div>
                    </div>
                    <div id="textPrintArea">
                        <div id="movieCutModeText">編集モード：
                        </div>
                        <div id="cutPointText">編集点：
                        </div>
                    </div>
                    <div id="cutButtonBorder" align="center">
                        <div id="movieCutMode">
                            <button id="zengoModeButton" class="button02" onclick="toZengoCutMode()" disabled="">前後をカットする</button>
                            <button id="totyuModeButton" class="button02" onclick="toTotyuCutMode()">途中をカットする</button>
                        </div>

                        <div id="cutPoint">
                            <button id="cutStartPointButton" class="button05" onclick="cutStartPoint()"><img class="redScissors" src="/contents/images/movie_cut_thumbnail_edit/red_scissors_left.png" alt=""></button>
                            <button id="cutEndPointButton" class="button05" onclick="cutEndPoint()"><img class="blueScissors" src="/contents/images/movie_cut_thumbnail_edit/blue_scissors_right.png" alt=""></button>
                        </div>

                        <div id="preview">
                            <button id="previewButton" class="previewButton" onclick="preview(<?=$movieContentId?>)">プレビューする</button>
                        </div>
                    </div>
                </div>

                <div id="bottom">
                        <button id="submitButton" class="button03" onclick="submit(<?=$movieContentId?>)">決 定</button>
                        <button id="closeButton" class="button03" onclick="closeWindow()">閉じる</button>
                </div>

                <input type="hidden" id="reproductionTime" value="<?=$reproductionTime?>">
                <input type="hidden" id="movieContentId" value="<?=$movieContentId?>">           
            </div>
        </div>
        
        <script src="/contents/js/movieCutEdit.js"></script>
        <?= $this->element($this->Common->getIsp() . '/google_analytics'); ?>
    </body>
</html>

