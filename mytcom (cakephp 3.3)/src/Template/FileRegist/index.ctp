<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->element($this->Common->getIsp() . '/HtmlHeaderCommon'); ?>
    <link href="/contents/js/jquery.uploadify-v1.6.2.mit/uploadify.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/contents/js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" media="screen" />
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
    <script type="text/javascript">
        $(function(){
            $('input.btnovr').hover(function() {
                $(this).addClass('btnovrOn');
            },
            function() {
                $(this).removeClass('btnovrOn');
            });
        });
        $(function(){
            $('input.btnstd').hover(function() {
                $(this).addClass('btnstdOn');
            },
            function() {
                $(this).removeClass('btnstdOn');
            });
        });
    </script>
</head>
    <body>
        <div id="wrapper">
            <?php echo $this->element($this->Common->getIsp() . '/header_' . $this->Common->getAspSetting()); ?>
            <div id="mainContents">
                <div id="messageArea">
                    <h1 class="iconFiles"><?php echo $this->Header->getTitleStr($menu_now_flg) ?></h1>
                </div>
                <?php echo $this->element('storage/menu_' . $this->Common->getAspSetting()); ?>
                <div id="contentsRight">
                    <div class="contentsBox">
                        <div class="contentsTopGray">
                            <h3 class="contentsttl floL">ファイルを登録する</h3>
                            <div class="searchAreaN floR">
                                <a class="iconHelp" href="<?php echo $helpLinkUrl['FileRegist'] ?>" target="_blank">この機能のヘルプ</a>
                            </div>
                        </div>
                        <div class="contentsMain">
                            <div class="bdrbot padArea">
                                <h3>以下の手順で登録するファイルを選択してください。</h3>
                                <ol>
                                    <li>1) 登録先のフォルダを選択します。</li>
                                    <li>2) [ファイル選択]ボタンをクリックしてファイルを選択します。</li>
                                </ol>
                                <?php if ($message) : ?>
                                    <span class="txtRed">
                                    <?= $message ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="txtSmall">※<span style="color : red">*</span>印のついている項目は、入力必須項目となります。</p>
                            <form id="form" name="form1" method="post" action="/storage/file/regist.html?<?= $cashe ?>" enctype="multipart/form-data" onsubmit="return false;">
                                <table align="center" cellpadding="0" cellspacing="0" class="tblForm">
                                    <tr>
                                        <th>登録先フォルダ</th>
                                        <td>
                                            <select id="folder_id" name="folder_id" class="selectArea00">
                                                <?php foreach ($folderName as $list) : ?>
                                                    <option  value="<?= $list['file_folder_id'] ?>"
                                                        <?php if (isset($fid)) : ?>
                                                            <?php if ($fid == $list['file_folder_id']) : ?>
                                                                selected<?php endif; ?>
                                                        <?php endif; ?> > <?= h($list['file_folder_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">ファイル選択<span style="color : red">*</span></th>
                                        <td style="border-bottom:none;">
                                            <p class="txtSmall tblReadTxt"> [ファイル選択]ボタンをクリックして登録するファイルを選択します。<br />ファイルをまとめてアップロードする場合は、ファイルを複数選択して[開く]押してください。</p>
                                            <div class="uploadBox">
                                                <div id="upload" >
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
                                                    <li>※一度にアップロードできるファイル数は10個までとなります。</li>
                                                    <li>※一度にアップロードできるファイル容量は合計<?= $uploadMaxStr ?>までとなります。</li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <p align="center">
                                    <input name="file_upload"  id="uploadfiles" type="button" class="btnovr" value="追加する" onclick="javascript:uploadFiles();"/>
                                    <input type="submit" id="file_regist" name="weblog_regist" style="display:none"/>
                                    <input name="Submit" type="button" class="btnovr" value="戻る" onclick="location.href='<?php echo $previousUrl; ?>'"/>
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
        var fid = $('#folder_id').val();
        var uploader = new plupload.Uploader({
            runtimes : 'html5,html4',
            browse_button : 'pickfiles', // you can pass in id...
            container: document.getElementById('upload'), // ... or DOM Element itself
            url : "/common/upload.html",
            filters : {
                prevent_duplicates: true
            },
        // Silverlight settings
    silverlight_xap_url : '/contents/js/plupload/Moxie.xap',
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
                    if (uploader.files[i].name.length > 125) {
                        $("#upload :first").before('<div class="txtRed space_5">※ファイル名には125文字以内で入力してください。</div>');
                        isValidated = false;
                        break;
                    }
                }
                for (i = 0; i < uploader.files.length; i++) { 
                    if (typeof(uploader.files[i].size) == "undefined") {
                        $("#upload :first").before('<div class="txtRed space_5">※0バイトのファイルは登録できません。</div>');
                        isValidated = false;
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
                    $("#upload :first").before('<div class="txtRed space_5">※一度にアップロード可能なファイルは合計<?= $uploadMaxStr ?>までとなります。</div>');
                    isValidated = false;
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
                var html = '<div id="'+ file.id +'" class="fileUploadQueueItem">'
                html += '<div class="imageTitle"><span class="fileName">'+ fileName + ' (' + plupload.formatSize(file.size) + ')</span><span id="percent'+file.id+'" class="percentage"></span></div>';
                html += '<input type="hidden" name="fileSize[]" value='+ file.size +'>';
                html += '<div class="cancel" style="height: 32px;"><a href="javascript:cancelFile('+file.id+');"><img src="/contents/images/cancel.png" border="0"></a></div>';
                html += '<div id="progress'+file.id+'" class="fileUploadProgress" style="width: 100%;">';
                html += '<div class="fileUploadProgressBar" style="width: 0%; height: 3px;"></div></div>';
                html += '<div class="imageInfo">';
                html += '<div class="space_4"> <span class="txtTitle">タイトル：</span>';
                html += '<input type="input" class="picTitle" id="title[]" name="title[]" value="" style="ime-mode: active;" maxlength="125">';
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
    up.settings.multipart_params = {"fileId": file.id, "saveto": "file"};
});

function cancelFile(file) {
    uploader.removeFile(file);
    $('#'+file.id).remove();
}
        </script>
    </body>
</html>
