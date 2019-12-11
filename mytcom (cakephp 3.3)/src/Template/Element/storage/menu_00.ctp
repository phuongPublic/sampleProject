<div id="contentsLeft">
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>メニュー</h2>
        </div>
        <div class="sideMenuMain">
            <ul class="sideMenuList">
            <?php if (isset($fid) && $fid != "") : ?>
                <li class="bdr"><a href="/storage/file/regist.html?fid=<?= $fid ?>&<?= $cashe ?>">ファイルを登録する</a></li>
            <?php else : ?>
                <li class="bdr"><a href="/storage/file/regist.html?<?= $cashe ?>">ファイルを登録する</a></li>
            <?php endif; ?>
                <li class="bdr"><a href="/storage/folder/list.html?<?= $cashe ?>">フォルダ一覧を見る</a></li>
                <li><a href="/storage/folder/regist.html?<?= $cashe ?>">フォルダを追加する</a></li>
            </ul>
        </div>
    </div>
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>フォルダ一覧</h2>
        </div>
        <div class="sideMenuMain">
            <?php foreach ($sideFolderList as $key => $folder) : ?>
                <?php if (isset($fid) && $fid == $folder['file_folder_id']) : ?>
                <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolderOpen txtBold" href="/storage/file/list.html?fid=<?= h($folder['file_folder_id']) ?>&<?= $cashe ?>"><?= h($folder['file_folder_name']) ?>(<?= h($folder['count']) ?>)</a></h3>
                <?php else : ?>
                <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolder" href="/storage/file/list.html?fid=<?= h($folder['file_folder_id']) ?>&<?= $cashe ?>"><?= h($folder['file_folder_name']) ?>(<?= h($folder['count']) ?>)</a></h3>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

