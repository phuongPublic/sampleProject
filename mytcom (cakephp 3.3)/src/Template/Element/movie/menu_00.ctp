<div id="contentsLeft">
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>メニュー</h2>
        </div>
        <div class="sideMenuMain">
            <ul class="sideMenuList">
                <?php if (isset($mid) && $mid != "") : ?>
                <li class="bdr"><a href="/movie/contents/regist.html?mid=<?= $mid ?>&<?= $cashe ?>">動画を登録する</a></li>
                <?php else: ?>
                <li class="bdr"><a href="/movie/contents/regist.html?<?= $cashe ?>">動画を登録する</a></li>
                <?php endif;?>
                <li class="bdr"><a href="/movie/list.html?<?= $cashe ?>">動画一覧を見る</a></li>
                <li><a href="/movie/regist.html?<?= $cashe ?>">フォルダを追加する</a></li>
            </ul>
        </div>
    </div>
    <div class="sideBox">
        <div class="sideTopGray">
            <h2>動画フォルダ一覧</h2>
        </div>
        <div class="sideMenuMain">
            <?php foreach ($movieFolderList as $item): ?>
            <?php if (isset($mid) && $mid == $item['movie_folder_id']) : ?>
            <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolder txtBold" href="/movie/preview.html?mid=<?= $item['movie_folder_id'] ?>&<?= $cashe ?>"><?= h($item['movie_folder_name']) ?>（<?= $item['movie_count'] ?>）</a></h3>
            <?php else: ?>
            <h3 style="word-wrap: break-word; width: auto;"><a class="iconFolder" href="/movie/preview.html?mid=<?= $item['movie_folder_id'] ?>&<?= $cashe ?>"><?= h($item['movie_folder_name']) ?>（<?= $item['movie_count'] ?>）</a></h3>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>