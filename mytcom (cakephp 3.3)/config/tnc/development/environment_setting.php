<?php

return [
    //
    // システム共通設定
    //
    'Common' => [
        // システムが動作するドメイン名
        'Domain' => 'test3.pocket.tnc.ne.jp',
        'CheckDomain' => 'check-test3.pocket.tnc.ne.jp',
        'DomainMain' => 'www.tnc.ne.jp',
        // iPhone版、Android版の画面を表示するUser-Agentに含まれる文字を定義する。
        'UserAgentList' => [
            'Iphone' => array('iPhone', 'iPod', 'iPad'),
            'Android' => array('Android')
        ],
        // ヘッダフッタ表示設定
        'AspSettingFlag' => '00',
        // 契約者最大使用可能容量
        'DiskSize' => 10000000000,
        'DiskSizeStr' => '10GB',
        // 写真、ファイルアップロード上限
        'UploadMax' => 30000000,
        'UploadMaxStr' => '30MB',
        //写真１枚のアップロード上限
        'UploadMaxPicture' => 40000000,
        'UploadMaxPictureStr' => '40MB',
        // 動画アップロード上限
        'UploadMaxMovie' => 200000000,
        'UploadMaxMovieStr' => '200MB',
        // ファイルアップロード領域
        'Upload' => '/home/opt_tnc/personaltool/storage/',
        'Base' => '00001/',
        'BaseMovie' => '00002/',
        'fpath' => '/home/opt_tnc/personaltool/storage/',
        // ISP差分のある文字列
        'SiteSetting' => [
            'InfoPolicyUrl' => 'http://www.tnc.ne.jp/about/',
            'InfoPolicyName' => 'サイトのご利用について',
            'PolicyUrl' => 'http://www.tnc.ne.jp/policy.html',
            'PolicyName' => '個人情報保護',
            'KEY' => 'ascwqae0934trnsmkasdfasfasfasfsafasfdnfv89a5sd23re0', // 32文字以上必須
            'SALT' => 'dfq345t34trqewtf3452qtq3rtgeqrtg3q45tgyq354tg364363' // 32文字以上必須
        ],
        'IspName' => '【TNCポケット】',
    ],
    //
    // アルバム管理機能
    //
    'Album' => [
        // アルバム詳細画面で1ページあたり表示する件数
        'PCPictureLimit' => 25,
        //スマートフォンのアルバム一覧で表示する件数
        'SPAlbumLimit' => 10,
        //スマートフォンのアルバム詳細で表示する件数
        'SPPictureLimit' => 30,
    ],
    //
    // 動画管理機能
    //
    'Movie' => [
        // 動画管理機能で1ページあたり表示する件数
        'PCMovieLimit' => 25,
        //スマートフォンのアルバム一覧で表示する件数
        'SPMovieFolderLimit' => 10,
        //スマートフォンのアルバム詳細で表示する件数
        'SPMovieLimit' => 30,
        //Movie unsupport message'
        'UnsupporMes' => 'お使いのOS ・プラウザには対応しておりません。<br>TNCポケットは<a href="http://www.tnc.ne.jp/pocket/pt_01.html">推奨環境</a>でご利用ください。',
        //support extension
        'SupportExt' => 'avi|mpg|mpeg|m2p|mpe|ts|m2t|m2ts|mts|vob|mp4|m4v|hdmov|m4p|mov|3gp|3gpp|amc|3g2|3gp2|flv|f4v|wmv|asf|swf|ogg|ogx|ogv|mkv|mks|mk3d|rm|rmvb|divx',
    ],
    //
    // ファイル管理機能
    //
    'Storage' => [
        // ファイル一覧画面で1ページあたり表示する件数
        'PCFolderLimit' => 20,
        // ファイル詳細画面で1ページあたり表示する件数
        'PCFileLimit' => 20,
        //スマートフォンのフォルダ一覧で表示する件数
        'SPFolderLimit' => 10,
        //スマートフォンのフォルダ詳細で表示する件数
        'SPFileLimit' => 30,
    ],
    'KeywordSearch' => [
        'KeywordLimit' => 65535
    ],
    //
    // アドレス帳機能
    //
    'Address' => [
        // アドレス帳機能で1ページあたり表示する件数
        'PageLimit' => 15,
        // グループ登録上限件数
        'GroupQuota' => 200,
        // アドレス登録上限件数
        'AddressQuota' => 20000,
        // インポート可能上限数
        'LimitImport' => 1000,
    ],
    //
    // PC用機能のヘルプリンクURL
    // ISP差分で、ヘルプリンクを表示しない場合は、値を空（''）にする
    //
    'HelpLinkUrl' => [
        'AddressEdit' => 'http://qa.tnc.ne.jp/category/show/440',
        'AddressExport' => 'http://qa.tnc.ne.jp/category/show/440',
        'AddressImport' => 'http://qa.tnc.ne.jp/category/show/440',
        'AlbumDelete' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumEdit' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumList' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumOpenRegist' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumOpenStatus' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumPreview' => 'http://qa.tnc.ne.jp/category/show/443',
        'AlbumRegist' => 'http://qa.tnc.ne.jp/category/show/443',
        'FileDelete' => 'http://qa.tnc.ne.jp/category/show/441',
        'FileEdit' => 'http://qa.tnc.ne.jp/category/show/441',
        'FileOpenRegist' => 'http://qa.tnc.ne.jp/category/show/441',
        'FileOpenStatus' => 'http://qa.tnc.ne.jp/category/show/441',
        'FileRegist' => 'http://qa.tnc.ne.jp/category/show/441',
        'FolderDelete' => 'http://qa.tnc.ne.jp/category/show/441',
        'FolderEdit' => 'http://qa.tnc.ne.jp/category/show/441',
        'FolderRegist' => 'http://qa.tnc.ne.jp/category/show/441',
        'MFolderDelete' => 'http://qa.tnc.ne.jp/category/show/626',
        'MFolderEdit' => 'http://qa.tnc.ne.jp/category/show/626',
        'MFolderList' => 'http://qa.tnc.ne.jp/category/show/626',
        'MFolderPreview' => 'http://qa.tnc.ne.jp/category/show/626',
        'MFolderRegist' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieDelete' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieDetail' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieEdit' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieOpenRegist' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieOpenStatus' => 'http://qa.tnc.ne.jp/category/show/626',
        'MovieRegist' => 'http://qa.tnc.ne.jp/category/show/626',
        'OpenAlbum' => 'http://qa.tnc.ne.jp/category/show/443',
        'OpenContents' => 'http://qa.tnc.ne.jp/category/show/626',
        'OpenMovie' => 'http://qa.tnc.ne.jp/category/show/626',
        'OpenPicture' => 'http://qa.tnc.ne.jp/category/show/443',
        'OpenStorage' => 'http://qa.tnc.ne.jp/category/show/441',
        'PictureDelete' => 'http://qa.tnc.ne.jp/category/show/443',
        'PictureDetail' => 'http://qa.tnc.ne.jp/category/show/443',
        'PictureEdit' => 'http://qa.tnc.ne.jp/category/show/443',
        'PictureRegist' => 'http://qa.tnc.ne.jp/category/show/443',
    ],
    //
    // 広告機能
    //
    'Advertising' => [
        // 掲載サイト。1＝PC／2＝携帯
        'pubFl_list' => [1, 2],
        // 表示位置
        'position_list' => [1, 2, 3, 4, 5, 6, 7],
        // 画像ファイルの保存先
        'file_path' => '/home/pocket_tnc/parsonaltool/storage/00001/',
        // WEB表示用置き換えパス
        'replace_path' => '/images/'
    ],
    'Admin' => [
        'FilePath' => [
            'upload' => '/home/pocket_tnc/parsonaltool/storage/00001/admin/banner/',
            'display' => '/images/admin/banner/'
        ],
    ],
];
