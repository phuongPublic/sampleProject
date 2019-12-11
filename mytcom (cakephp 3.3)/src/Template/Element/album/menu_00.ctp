<div id="contentsLeft">
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>メニュー</h2>
        </div>
        <div class="sideMenuMain">
            <ul class="sideMenuList">
                <?php if (isset($aid) && $aid != "") : ?>
                <li class="bdr"><a href="/album/picture/regist.html?aid=<?= $aid ?>&<?= $cashe ?>">写真を登録する</a></li>
                <?php else : ?>
                <li class="bdr"><a href="/album/picture/regist.html?<?= $cashe ?>">写真を登録する</a></li>
                <?php endif; ?>
                <li class="bdr"><a href="/album/list.html?<?= $cashe ?>">アルバム一覧を見る</a></li>
                <li><a href="/album/regist.html?<?= $cashe ?>">アルバムを追加する</a></li>
            </ul>
        </div>
    </div>
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>アルバム一覧</h2>
        </div>
        <div class="sideMenuMain">
            <?php foreach ($albumList as $album) : ?>
                <?php if (isset($aid) && $aid == $album['album_id']) : ?>
                <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolderOpen txtBold" href="/album/preview.html?aid=<?= h($album['album_id']) ?>&<?= $cashe ?>"><?= h($album['album_name']) ?>(<?= h($album['count']) ?>)</a></h3>
                <?php else : ?>
                <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolder" href="/album/preview.html?aid=<?= h($album['album_id']) ?>&<?= $cashe ?>"><?= h($album['album_name']) ?>(<?= h($album['count']) ?>)</a></h3>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>