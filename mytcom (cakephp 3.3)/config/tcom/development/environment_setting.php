<?php

return [
    //
    // システム共通設定
    //
    'Common' => [
        // システムが動作するドメイン名
        'Domain' => 'test3.mytcom.t-com.ne.jp',
        'CheckDomain' => 'check-test3.mytcom.t-com.ne.jp',
        'DomainMain' => 'www.t-com.ne.jp',
        // iPhone版、Android版の画面を表示するUser-Agentに含まれる文字を定義する。
        'UserAgentList' => [
            'Iphone' => array('iPhone', 'iPod', 'iPad'),
            'Android' => array('Android')
        ],
        // ヘッダフッタ表示設定
        'AspSettingFlag' => '00',
        // 契約者最大使用可能容量
        'DiskSize' => 53687091200,
        'DiskSizeStr' => '50GB',
        // 写真、ファイルアップロード上限
        'UploadMax' => 104857600,
        'UploadMaxStr' => '100MB',
        //写真１枚のアップロード上限
        'UploadMaxPicture' => 41943040,
        'UploadMaxPictureStr' => '40MB',
        // 動画アップロード上限
        'UploadMaxMovie' => 204800000,
        'UploadMaxMovieStr' => '200MB',
        // ファイルアップロード領域
        'Upload' => '/home/opt_tcom/personaltool/storage/',
        'Base' => '00001/',
        'BaseMovie' => '00002/',
        // ISP差分のある文字列
        'SiteSetting' => [
            'InfoPolicyUrl' => 'http://www.t-com.ne.jp/infopolicy/',
            'InfoPolicyName' => '情報セキュリティ基本方針',
            'PolicyUrl' => 'http://www.t-com.ne.jp/policy/',
            'PolicyName' => '個人情報保護ポリシー',
            'KEY' => 'ascwqae0934trnsmkasdfasfasfasfsafasfdnfv89a5sd23re0', // 32文字以上必須
            'SALT' => 'dfq345t34trqewtf3452qtq3rtgeqrtg3q45tgyq354tg364363' // 32文字以上必須
        ],
        'IspName' => '【My@T COM】',
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
        'UnsupporMes' => 'お使いのOS ・プラウザには対応しておりません。<br>My@T COMは<a href="http://service.t-com.ne.jp/mytcom/attention/">推奨環境</a>でご利用ください。',
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
        'AddressEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_address01',
        'AddressExport' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_address03',
        'AddressImport' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_address04',
        'AddressListview' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_address05',
        'AlbumDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album09',
        'AlbumEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album08',
        'AlbumList' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album02',
        'AlbumOpenRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album10',
        'AlbumOpenStatus' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album11',
        'AlbumPreview' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album02',
        'AlbumRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album07',
        'FileDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file05',
        'FileEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file04',
        'FileOpenRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file10',
        'FileOpenStatus' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file11',
        'FileRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file01',
        'FolderDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file09',
        'FolderEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file08',
        'FolderRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file07',
        'MFolderDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie07',
        'MFolderEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie06',
        'MFolderList' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie02',
        'MFolderPreview' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie02',
        'MFolderRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie05',
        'MovieDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie03',
        'MovieDetail' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie02',
        'MovieEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie02',
        'MovieOpenRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie08',
        'MovieOpenStatus' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie09',
        'MovieRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie01',
        'OpenAlbum' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album12',
        'OpenContents' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie10',
        'OpenMovie' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_movie10',
        'OpenPicture' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album12',
        'OpenStorage' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_file12',
        'PictureDelete' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album05',
        'PictureDetail' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album02',
        'PictureEdit' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album02',
        'PictureRegist' => 'http://service.t-com.ne.jp/mytcom/help/pc/h_album01',
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
        'file_path' => '/home/mytcom/parsonaltool/storage/00001/',
        // WEB表示用置き換えパス
        'replace_path' => '/images/'
    ],
    'Admin' => [
        'FilePath' => [
            'upload' => '/home/mytcom/parsonaltool/storage/00001/admin/banner/',
            'display' => '/images/admin/banner/'
        ],
    ],
];
