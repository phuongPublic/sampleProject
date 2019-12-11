<!DOCTYPE html>
<html>

<head>
    <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
    <link href="/contents/js/jquery.uploadify-v1.6.2.mit/uploadify.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/contents/js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" media="screen" />
    <script language="JavaScript">
        function ChangeVisible(id, id2) {
            document.getElementById(id).style.visibility ="visible";
            document.getElementById(id).style.display ="inline";
            document.getElementById(id2).src = "/contents/images/mark_arrow01_under.gif";
        }
    </script>
    <script type="text/javascript">
        $(function(){
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
    </style>
</head>

<body>
    <div id="wrapper">
        <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>

            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconAlbum"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1></div>

                <?php echo $this->element('album/menu_' . $this->Common->getAspSetting()); ?>

                    <div id="contentsRight">
                        <div class="contentsBox">
                            <div class="contentsTopGray">
                                <h3 class="contentsttl floL">写真を登録する</h3>
                                <?php if ($helpLinkUrl['PictureRegist']) : ?>
                                    <div class="searchAreaN floR">
                                    <a class="iconHelp" href="<?php echo $helpLinkUrl['PictureRegist'] ?>" target="_blank">この機能のヘルプ</a>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div class="contentsMain">
                                <div class="bdrbot padArea">
                                    <?php if (isset($message)) : ?>
                                    <span class="txtRed">
                                        <?= $message ?></span>
                                    <?php endif; ?>
                                    <h3>以下の手順で登録する写真を選択してください。</h3>
                                    <ol>
                                        <li>1) 登録先のフォルダを選択します。</li>
                                        <li>2) [ファイル選択]ボタンをクリックしてファイルを選択します。</li>
                                    </ol>
                                </div>
                                <p class="txtSmall">※<span style="color : red">*</span>印のついている項目は、入力必須項目となります。</p>
                                <form id="form" name="form1" method="post" action="/album/picture/regist.html?<?= $cashe ?>" enctype="multipart/form-data" onsubmit="return false;">
                                    <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                        <tr>
                                            <th>登録先アルバム</th>
                                            <td>
                                                <select id="album_id" name="album_id" class="selectArea00">
                                                    <?php foreach ($albumListName as $id => $name) : ?>
                                                        <?php if ($id == $aid) : ?>
                                                            <option label="<?= $name ?>" value="<?= $id ?>" selected><?= h($name) ?></option>
                                                        <?php else : ?>
                                                            <option label="<?= $name ?>" value="<?= $id ?>"><?= h($name) ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">写真の選択<span style="color : red">*</span></th>
                                            <td style="border-bottom:none;">
                                                <p class="txtSmall tblReadTxt">
                                                    [ファイル選択]ボタンをクリックして登録するファイルを選択します。
                                                    <br />ファイルをまとめてアップロードする場合は、ファイルを複数選択して[開く]押してください。
                                                </p>
                                                <div class="txtRed tblReadTxt">
                                                    <?php if (isset($sub_message)) : ?>
                                                        <?= $sub_message ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="uploadBox">
                                                    <div id="upload">
                                                        <div class="uploadBtn">
                                                            <div class="uploadHelp"><a class="iconHelp txtOrange" href="/fileuploads.html" target="_blank">ファイルを一括アップロードするには</a></div>
                                                            <input id="pickfiles" name="pickfiles" class="defaultRegist" type="button" />
                                                        </div>
                                                        <div style="clear:both;"></div>

                                                        <div id="filelist" style="margin-top: 9px;">
        
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-top:none;">
                                                <div style="clear:both;">
                                                    <ul class="txtSmall">
                                                        <li>※アップロードできる画像形式はgif、jpg、pngとなります。</li>
                                                        <li>※一度にアップロードできるファイル数は10個までとなります。</li>
                                                        <li>※一度にアップロードできるファイル容量は合計<?= $uploadMaxStr ?>までとなります。</li>
                                                        <li>※アップロードするファイルのピクセル数（画素数）が10Mピクセル（1000万ピクセル）を超える場合は、アップロード完了まで多少時間がかかります。</li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <p align="center">
                                        <input type="button" id="uploadfiles" class="btnovr" onclick="javascript:uploadFiles();" value="登録する" />
                                        <input type="submit" id="weblog_regist" name="weblog_regist" style="display:none" />
                                        <input name="back" type="button" class="btnovr" value="戻る" onclick="location.href='<?= $previousUrl ?>'" />
                                    </p>
                                </form>
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
    url : "/common/upload.html",
    filters : {
        mime_types : [
            { title : "Image files", extensions : "jpg,gif,png" },
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
                    $("#upload :first").before('<div class="txtRed space_5">※ファイルを選択してください。</div>');
                    isValidated = false;
                }
                if (uploader.files.length > 10) {
                    $("#upload :first").before('<div class="txtRed space_5">※一度にアップロードできるファイル数は10までとなります。</div>');
                    isValidated = false;
                }
                for (var i = 0; i < uploader.files.length; i++) {
                    var str = $("#"+ uploader.files[i].id + " .picTitle").val();
                    if (str.length > 125) {
                        $("#upload :first").before('<div class="txtRed space_5">※タイトルには125文字以内で入力してください。</div>');
                        isValidated = false;
                    }
                    if (str.length > 0 && str.trim().length == 0) {
                        $("#upload :first").before('<div class="txtRed space_5">※半角スペースのみの登録はできません。</div>');
                        isValidated = false;
                    }

                    if ($("#"+ uploader.files[i].id + " .picComment").val().replace(/\r?\n/g, '').length > 1000) {
                        $("#upload :first").before('<div class="txtRed space_5">※コメントには1000文字以内で入力してください。</div>');
                        isValidated = false;
                    }
                    var matches = str.match(/(\.\.\/|\/|\.\.\\\\)/);
                    if (matches) {
                        $("#upload :first").before('<div class="txtRed space_5">※ファイル名が不正です。</div>');
                        isValidated = false;
                    }
                }
                for (i = 0; i < uploader.files.length; i++) {
                    var mineType = uploader.files[i].type;
                    if (mineType != 'image/gif' && mineType != 'image/jpeg' && mineType != 'image/png') {
                        $("#upload :first").before('<div class="txtRed space_5">※GIF,JPEG,PNG以外はアップロードできません。</div>');
                        isValidated = false;
                    }
                }
                for (i = 0; i < uploader.files.length; i++) {
                    if (uploader.files[i].name.length > 125) {
                        $("#upload :first").before('<div class="txtRed space_5">※ファイル名には125文字以内で入力してください。</div>');
                        isValidated = false;
                        break;
                    }
                }
                var uploadSize = 0;
                for (i = 0; i < uploader.files.length; i++) {
                    if(typeof uploader.files[i].size !== "undefined") {
                        uploadSize += uploader.files[i].size;
                    } else {
                        uploadSize += 0;
                    }
                }
                if (uploadSize > <?= $uploadMax ?>) {
                    $("#upload :first").before('<div class="txtRed space_5">※一度にアップロード可能な写真は合計<?= $uploadMaxStr ?>までとなります。</div>');
                    isValidated = false;
                } else {
                    for (i = 0; i < uploader.files.length; i++) {
                        if (uploader.files[i].size > <?= $UploadMaxPicture ?>) {
                            $("#upload :first").before('<div class="txtRed space_5">※1ファイルあたりのファイルサイズは<?= $UploadMaxPictureStr ?>以下にしてください。</div>');
                            isValidated = false;
                            break;
                        }
                    }
                }
                if (uploadSize + <?= $userDataSize ?> > <?= $diskSize ?>) {
                    $("#upload :first").before('<div class="txtRed space_5">※使用量の合計が<?= $diskSizeStr ?>を超えるため登録できません。</div>');
                    isValidated = false;
                }
                if (isValidated){
                    uploader.start();
                } else {
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    $("#uploadfiles").prop('disabled', false);
                }
            };
        },
        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                var fileName = file.name;
                if (fileName.length > 20) {
                    fileName = fileName.substr(0, 20) + '...';
                }
                var html = '<div id="'+ file.id +'" class="fileUploadQueueItem">';
                html += '<div class="imageTitle"><span class="fileName">'+ fileName + ' (' + plupload.formatSize(file.size) + ')</span><span id="percent'+file.id+'" class="percentage"></span></div>';
                html += '<div class="cancel" style="height: 32px;"><a href="javascript:cancelFile('+file.id+');"><img src="/contents/images/cancel.png" border="0"></a></div>';
                html += '<div id="progress'+file.id+'" class="fileUploadProgress" style="width: 100%;">';
                html += '<div class="fileUploadProgressBar" style="width: 0%; height: 3px;"></div></div>';
                html += '<div class="imageInfo">';
                html += '<div class="space_4"> <span class="txtTitle">タイトル：</span>';
                html += '<input type="input" class="picTitle" id="title[]" name="title[]" value="" style="ime-mode: active;"  maxlength="125">';
                html += '<div style="clear:both"></div> <span>※125文字以内</span> </div>';
                html += '<div><span class="txtComment">コメント：</span>';
                html += '<textarea class="picComment" id="description[]" name="description[]" value="" rows="4" style="ime-mode: active;"></textarea>';
                html += '<div style="clear:both"></div> <span>※1000文字以内</span>';
                html += '<br> <span>※改行は無効となります。</span></div>';
                html += '<input name="fileName[]" type ="hidden" value="'+file.name+'" >';
                html += '<input name="fileId[]" type ="hidden" value="'+file.id+'" >'
                html += '</div>';
                $('#filelist').append(html);
            });
        },
        UploadProgress: function(up, file) {
            var progressId = 'progress' + file.id;
            var percentId = 'percent' + file.id;
            if (file.percent == 100) {
                document.getElementById(percentId).innerHTML = '<span> - Completed</span>';
            } else {
                document.getElementById(percentId).innerHTML = '<span> - '+ file.percent + ' %</span>';
            }
            document.getElementById(progressId).innerHTML = '<div class="fileUploadProgressBar" style="width: '+file.percent+'%; height: 3px;"></div>';

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
    up.settings.multipart_params = {"fileId": file.id, "saveto": "album"};
});

function cancelFile(file) {
    uploader.removeFile(file);
    $('#'+file.id).remove();
}
</script>
</body>

</html>