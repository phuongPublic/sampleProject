<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>

<head>
    <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
    <link href="/contents/js/jquery.uploadify-v1.6.2.mit/uploadify.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/contents/js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" media="screen" />
    <script language="JavaScript">
        function ChangeVisible(id, id2) {
            document.getElementById(id).style.visibility = "visible";
            document.getElementById(id).style.display = "inline";
            document.getElementById(id2).src = "/images/mark_arrow01_under.gif";
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.textArea01').focus(function() {
                $(this).css('background-image', 'none');
            });
        });

        $(function() {
            $('input.btnovr').hover(function() {
                    $(this).addClass('btnovrOn');
                },
                function() {
                    $(this).removeClass('btnovrOn');
                });
        });
    </script>
    <style type="text/css" media="screen">
        .fileUploadProgress {
            background-color: #FFFFFF;
            border-top: 1px solid #808080;
            border-left: 1px solid #808080;
            border-right: 1px solid #C5C5C5;
            border-bottom: 1px solid #C5C5C5;
            margin-top: 10px;
            clear:both;
            width: 100%;
        }
        .defaultRegist{
            width: 131px;
            height: 29px;
            background: transparent url(/contents/images/btn_registDefault.jpg) no-repeat center center !important;
            border: none !important;
            cursor: pointer;
        }
        .defaultRegist:hover{
            width: 131px;
            height: 29px;
            background: transparent url(/contents/images/btn_registDefault_ovr.jpg) no-repeat center center !important;
            border: none !important;
        }
        .defaultCancel{
            width: 131px;
            height: 29px;
            background: transparent url(/contents/images/btn_cancelDefault.jpg) no-repeat center center !important;
            border: none !important;
            cursor: pointer;
            margin-left: 150px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
    <div id="mainContents">
        <div id="messageArea">
            <h1 class="iconMovie">動画</h1></div>
        <?php echo $this->element('movie/menu_' . $this->Common->getAspSetting()); ?>
        <div id="contentsRight">
            <div class="contentsBox">
                <div class="contentsTopGray">
                    <h3 class="contentsttl floL">動画を登録する</h3>
                    <div class="searchAreaN floR"><a class="iconHelp" href="<?php echo $helpLinkUrl['MovieRegist'] ?>" target="_blank">この機能のヘルプ</a></div>
                </div>
                <div class="contentsMain">
                    <div class="bdrbot padArea">
                        <?php if (isset($message)): ?><span class="txtRed"> <?= $message ?></span>
                        <br />
                        <?php endif; ?>
                        <h3>動画を登録します。</h3>
                        <div class="space_5">必要事項を入力し、[登録する]ボタンをクリックしてください。</div>
                    </div>
                    <p class="txtSmall">※<span style="color:red">*</span>印のついている項目は、入力必須項目となります。</p>
                    <form id="form" name="form1" method="post" action="/movie/contents/regist.html?<?= $cashe ?>" enctype="multipart/form-data">
                        <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                            <tr>
                                <th>動画タイトル<span style="color:red">*</span></th>
                                <td>
                                    <div id="errorTitle" class="space_5">
                                    </div>
                                    <div class="space_5">
                                        <input id="movieTitle" class="inputName" type="text" name="title" value="<?php if (isset($formData)):?><?= $formData['title'] ?><?php endif; ?>" maxlength="125">
                                    </div>
                                    <div class="txtSmall">※125文字以内</div>
                                </td>
                            </tr>
                            <tr>
                                <th>登録先フォルダ<span style="color:red">*</span></th>
                                <td>
                                    <p class="tblReadTxt txtSmall" style="margin-top:0;">動画を登録するフォルダを選択してください。</p>
                                    <select id="movie_folder_id" name="movie_folder_id" class="selectArea00">
                                        <?php foreach($folderNameList as $id => $name): ?>
                                        <?php if ($id == $mid) : ?>
                                        <option label="<?= $name ?>" value="<?= $id ?>" selected><?= h($name) ?></option>
                                        <?php else : ?>
                                        <option label="<?= $name ?>" value="<?= $id ?>"><?= h($name) ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>コメント</th>
                                <td>
                                    <div id="errorComment" class="space_5">
                                    </div>
                                    <textarea id="movieComment" name="description" rows="4" cols="45" class="inputDoga"><?php if (isset($formData)):?><?= $formData['description'] ?><?php endif; ?></textarea>
                                    <p class="tblReadTxt txtSmall">※1000文字以内
                                        <br />※改行は無効となります。</p>
                                </td>
                            </tr>
                            <tr>
                                <th>動画ファイル<span style="color:red">*</span></th>
                                <td>
                                    <p class="tblReadTxt txtSmall" style="margin-top:0;">[ファイル選択]ボタンをクリックしてアップロードする動画ファイルを選択してください。</p>
                                    <div class="uploadBox">
                                        <div id="uploadContents" class="uploadBtn" style="height:28px;">
                                            <div id="upload" class="upload">
                                                <input id="pickfiles" name="pickfiles" class="defaultRegist" type="button"/>
                                            </div>
                                        </div>
                                        <div id="filelist" style="margin-top: 9px;">

                                        </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <p class="tblReadTxt txtSmall" style="*margin-top:-17px;">※対応形式は、avi, flv, mov, mpeg2, mpeg4, mts, m2ts, wmvです。
                                        <br /> ※一度にアップロード可能なファイル容量は<?= Configure::read('Common.UploadMaxMovieStr') ?>までとなります。</p>
                                </td>
                            </tr>
                        </table>
                        <p align="center">
                            <input type="button" id="uploadfiles" class="btnovr" value="登録する" />
                            <input type="submit" id="movie_contents_regist" name="movie_contents_regist" style="display:none" />
                            <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href='<?= $previousUrl ?>'" />
                        </p>
                        <div id="progresBarArea"></div>
                    </form>
                    <br class="clear" />
                </div>
            </div>
        </div>
    </div>
    <div id="goTop"><a href="#top">▲ページトップへ</a></div>
</div>
<?php echo $this->element($this->Common->getIsp() . '/footer_' . $this->Common->getAspSetting()); ?>
<script type="text/javascript" src="/contents/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
    // setting for uploader
    var uploader = new plupload.Uploader({
        runtimes : 'html5,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('upload'), // ... or DOM Element itself
        url : "/Common/Upload.html",
        multi_selection: false,
        filters : {
            mime_types : [
                { title : "Video files", extensions : "avi,mpg,mpeg,m2p,mpe,ts,m2t,m2ts,mts,vob,mp4,m4v,hdmov,m4p,mov,3gp,3gpp,amc,3g2,3gp2,flv,f4v,wmv,asf,swf,ogg,ogx,ogv,mkv,mks,mk3d,rm,rmvb,divx" },
            ],
            prevent_duplicates: true
        },
        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';

                document.getElementById('uploadfiles').onclick = function() {
                    $("#uploadfiles").prop('disabled', true);
                    $('.txtRed').remove();
                    var isValidated = true;
                    if (uploader.files.length == 0) {
                        $("#uploadContents").before('<div class="txtRed space_5">※ファイルを選択してください。</div>');
                        isValidated = false;
                    }
                    if ($("#movieTitle").val().length == 0) {
                        $("#errorTitle").html('<div class="txtRed space_5">※タイトルを入力してください。</div>');
                        isValidated = false;
                    }
                    if ($("#movieTitle").val().length > 125) {
                        $("#errorTitle").html('<div class="txtRed space_5">※タイトルには125文字以内で入力してください。</div>');
                        isValidated = false;
                    }
                    var str = $("#movieTitle").val();
                    if (str.length > 0 && str.trim().length == 0) {
                        $("#errorTitle").html('<div class="txtRed space_5">※半角スペースのみの登録はできません。</div>');
                        isValidated = false;
                    }
                    var matches = str.match(/(\.\.\/|\/|\.\.\\\\)/);
                    if (matches) {
                        $("#errorTitle").html('<div class="txtRed space_5">※ファイル名が不正です。</div>');
                        isValidated = false;
                    }
                    if ($('#movieComment').val().replace(/\r?\n/g, '').length > 1000) {
                        $("#errorComment").html('<div class="txtRed space_5">※コメントには1000文字以内で入力してください。</div>');
                        isValidated = false;
                    }
                    var uploadSize = 0;
                    var fileID = $("#queueID").val();
                    for (i = 0; i < uploader.files.length; i++) {
                        if(typeof uploader.files[i].size !== "undefined" && uploader.files[i].id == fileID) {
                            uploadSize += uploader.files[i].size;
                        } else {
                            uploadSize += 0;
                        }
                    }
                    if (uploadSize > <?= Configure::read('Common.UploadMaxMovie') ?>) {
                        $("#uploadContents").before('<div class="txtRed space_5">※一度にアップロード可能な動画ファイルは<?= Configure::read('Common.UploadMaxMovieStr') ?>までとなります。</div>');
                        isValidated = false;
                    }
                    if (uploadSize + <?= $userDataSize ?> > <?= Configure::read('Common.DiskSize') ?>) {
                        $("#uploadContents").before('<div class="txtRed space_5">※使用量の合計が<?= Configure::read('Common.DiskSizeStr') ?>を超えるため登録できません。</div>');
                        isValidated = false;
                    }
                    if (isValidated) {
                        uploader.start();
                        $(".fileUploadProgress").show();
                        $.blockUI({
                            message: $(".fileUploadProgress"),
                            fadeOut: 0
                        });
                    } else {
                        $('html, body').animate({ scrollTop: 0 }, 'fast');
                        $("#uploadfiles").prop('disabled', false);
                    }
                };
            },
            FilesAdded: function(up, files) {

                if ($('#fileInputQueue').length != 0) {
                    var file = $('#fileInputQueue').children('div').attr("id");
                    uploader.removeFile(file);
                    $('#'+file.id).remove();
                    $('#fileInputQueue').remove();
                }
                $('#fileInputQueue').remove();
                plupload.each(files, function(file) {
                    var fileName = file.name;
                    if (fileName.length > 20) {
                        fileName = fileName.substr(0, 20) + '...';
                    }

                    var html = '<div id="fileInputQueue" class="fileUploadQueue">';
                    html += '<div id="'+ file.id +'" class="fileUploadQueueItem">';
                    html += '<div class="cancel">';
                    html += '<a href="javascript:cancelFile('+file.id+');"><img src="/contents/images/cancel.png" class="cancelBtn" border="0"></a>';
                    html += '</div> <span class="txtBold fileName">'+ fileName + ' (' + plupload.formatSize(file.size) + ')</span><span class="percentage">&nbsp;</span>';
                    html += '<div class="fileUploadProgress" style="width: 100%; display:none">';
                    html += '<div id="fileUploadProgressBar" class="fileUploadProgressBar" style="width: 50%; height: 100%;"></div>';
                    html += '<div style="margin-top:5px;color:#fff;text-align:center">動画をアップロード中です。このまましばらくお待ちください。</div>';
                    html += '<input id="cancelButton" name="cancelButton" onclick="javascript:stopUpload('+file.id+');" class="defaultCancel" type="button" style="margin-left: 35%" />';
                    html += '</div>';
                    html += '<input type="hidden" id="queueID" name="fileId" value="'+ file.id +'">';
                    html += '<input type="hidden" id="fileName" name="fileName" value="'+ file.name +'"></div></div>';
                    $('#filelist').append(html);
                });
            },
            UploadProgress: function(up, file) {
                var percentProgress = file.percent + '%';
                $('#fileUploadProgressBar').css({"width": percentProgress, "height": "100%"});
            },
            Error: function(up, err) {
            },
            'UploadComplete': function(up, files) {
                document.getElementById("form").submit();
            }
        }
    });
    uploader.init();
    uploader.bind('BeforeUpload', function(up, file) {
        up.settings.multipart_params = {"fileId": file.id, "saveto": "movie"};
    });

    function cancelFile(file) {
        uploader.removeFile(file);
        $('#'+file.id).remove();
        $('#fileInputQueue').remove();
    }
    function stopUpload(file) {
        $.unblockUI();
        $("#uploadfiles").prop('disabled', false);
        uploader.stop();
        cancelFile(file);
    }
</script>
</body>

</html>