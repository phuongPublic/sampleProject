<?php

return [
    //
    // システム共通設定
    //
    'Common' => [
        // 機能番号の定義（画面のタイトル文字列としても使用）
        'PageTitle' => [
            '1' => '家族掲示板',
            '2' => 'スケジュール',
            '3' => '日記',
            '4' => '家計簿',
            '5' => 'アルバム',
            '6' => '動画',
            '7' => 'ファイル管理',
            '8' => 'メール',
            '9' => 'アドレス帳',
            '10' => '設定',
        ],
        // 共通メッセージ
        'update' => '%sの編集が完了しました。',
        'regist' => '%sの登録が完了しました。',
        'delete' => '%sの削除が完了しました。',
        'move' => '%sの移動が完了しました。',
        // 写真ファイルのサムネイル生成に関する設定
        'ThumbnailGenerate' => [
            'Shell' => BIN . 'cake ThumbnailGenerator execute ',
            'NullDevice' => ' > /dev/null &',
        ],
        // 動画ファイル参照判定用UserAgent文字列
        'UserAgent' => [
            'OS' => ['Windows7' => 'NT 6.1'],
            'Browser' => ['IE11' => 'Trident/7.0']
        ],
        // OPTフレームワーク更改と動画変換サーバのリリース日
        // リリース日以前に登録した動画ファイルはダウンロードできない判断をするための設定
        'MovieFileDownloadableDate' => '2017-05-15',
        'DisableDownloadMovieFileMessage' => '※2017年05月15日以前に登録した動画はダウンロードすることができません。',
        'AdminModule' => [
            //Common
            'OrderSort' => [
                'ASC' => 2,
                'DESC' => 1,
            ],
            'User' => [
                'UpdateUser' => 'admin',
                'RegUser' => 'admin',
            ],
            'ViewFlag' => [
                'Public' => 1,
                'Draft' => 2,
                'Reserve' => 3,
                'FinishPublic' => 4,
                'OnlyListPublic' => 5,
            ],
            'TimerFlag' => [
                'Setting' => 1,
                'NoSetting' => 2,
                'HideTop' => 3,
            ],
            'Datetime' => [
                'Min' => '0000-00-00 00:00:00',
                'DefaultSelected' => [
                    'Year' => '2005',
                    'Month' => '01',
                    'Day' => '01',
                    'Hour' => '00',
                    'Minute' => '00'
                ],
            ],
            'Category' => [
                'Topic' => 1,
                'ImportantTopic' => 2,
                'Campaign' => 4,
            ],
            'URLMaxLength' => [
                'UTF8' => 255,
            ],
            'DraftYear' => [
                'Key' => 99,
                'Value' => '下書き',
            ],
            //Admin User Search Region
            //Maintain  Region
            'Mainte' => [
                // メンテナンスステータス
                'AdminMainteStatus' => [
                    '1' => '公開',
                    '2' => '下書き',
                    '3' => '予約',
                    '4' => '公開終了'
                ],
                // タイマー設定
                'TimerFlags' => [
                    '1' => '設定する',
                    '2' => '設定しない'
                ],
                // ethna版の使用可否フラグ falseなら、Ethnaを使用しない。trueならEthnaを使用する。
                'EthnaUsingFlag' => true,
                // メンテナンスステータス
                'Status' => [
                    'Open' => '1',
                    'Reservation' => '3',
                    'Close' => '4',
                    'Draft' => '2'
                ],
            ],
            //Topic Region
            //管理側トピックス設定
            'Topics' => [
                //カテゴリ設定
                'Category' => [
                    '1' => 'お知らせ',
                    '2' => '重要なお知らせ'
                ],
                //カテゴリ設定
                'CategoryBackEnd' => [
                    'Topics' => '1',
                    'ImportantTopics' => '2'
                ],
                'CategoryList' => [
                    '99' => '全て',
                    '2' => '重要なお知らせ',
                    '1' => 'お知らせ',
                ],
                //カテゴリ設定
                'CategoryListBackEnd' => [
                    'All' => '99',
                    'ImportantTopics' => '2',
                    'Topics' => '1',
                ],
                //公開ステータス 切り替え方法
                'ViewFlags' => [
                    '1' => '両方公開',
                    '2' => '下書き',
                    '3' => '予約',
                    '4' => '公開終了',
                    '5' => '一覧のみ公開'
                ],
                //公開ステータス
                'ViewFlagsBackEnd' => [
                    'Public' => 1,
                    'Draft' => 2,
                    'Reserve' => 3,
                    'FinishPublic' => 4,
                    'OnlyListPublic' => 5,
                ],
                //日付の有無
                'DateViewFlags' => [
                    '1' => '日付を表示',
                    '2' => '日付を非表示'
                ],
                //日付の有無
                'DateViewFlagsBackEnd' => [
                    'Display' => '1',
                    'Hide' => '2'
                ],
                //ウインドウ設定
                'WindowFlags' => [
                    '1' => '別ウィンドウで開く',
                    '2' => '同じウィンドウで開く'
                ],
                //ウインドウ設定
                'WindowFlagsBackEnd' => [
                    'OtherWindow' => '1',
                    'SameWindow' => '2'
                ],
                //タイマー設定
                'TimerFlags' => [
                    '1' => '全て終了する',
                    '2' => '設定しない',
                    '3' => 'トップを非表示にする',
                ],
                //タイマー設定
                'TimerFlagsBackEnd' => [
                    'Setting' => 1,
                    'NoSetting' => 2,
                    'HideTop' => 3,
                ],
                //タイトル MAX Length (byte)
                'TitleMaxLength' => 255,
                //本文 MAX Length (byte)
                'ContentsMaxLength' => 65535,
                //Min year for select box
                'MinYearSelect' => 2005,
            ],
            //Campain Region
            'Campaign' => [
                'Status' => [
                    '1' => '公開',
                    '2' => '下書き',
                    '3' => '予約',
                    '4' => '公開終了'
                ],
                'ViewFlags' => [
                    '1' => '両方公開',
                    '5' => '一覧のみ公開',
                    '2' => '下書き',
                    '3' => '予約',
                    '4' => '公開終了'
                ],
                'TimerFlags' => [
                    '1' => '設定する',
                    '2' => '設定しない'
                ],
                'WindowFlags' => [
                    '1' => '別ウィンドウで開く',
                    '2' => '同じウィンドウで開く'
                ],
                'WindowFlagsKey' => [
                    'OtherWindow' => 1,
                    'SameWindow' => 2
                ],
                'DateviewFlg' => [
                    'Default' => '',
                ],
                'Contents' => [
                    'Members' => 'members',
                ],
            ],
            //Advertistment Region
            'Advertisement' => [
                'ViewFlags' => [
                    '1' => '公開',
                    '2' => '下書き',
                    '3' => '予約',
                    '4' => '公開終了'
                ],
                'TimerFlags' => [
                    '1' => '設定する',
                    '2' => '設定しない'
                ],
                //タイトル MAX Length
                'TitleMaxLength' => 150,
                'PosFlg' => [
                    1 => 'ヘッダー',
                    2 => 'コンテンツ内1',
                    3 => 'コンテンツ内2',
                    4 => 'コンテンツ内3',
                ],
                'PubFlg' => [
                    1 => 'PCサイト',
                ]
            ],
            //User Manage Region
            'AdminUser' => [
                'SearchStatusBackEnd' => [
                    'All' => '99',
                    'Continue' => '0',
                    'Cancel' => '9'
                ],
                'SearchStatus' => [
                    '99' => '全て',
                    '0' => '継続',
                    '9' => '解約'
                ],
                'SearchClass' => [
                    '99' => '期間指定なし',
                    '1' => '初回ログイン日 or 解約日',
                    '2' => '最終ログイン日'
                ],
                'SearchClassBackEnd' => [
                    'AnyTime' => '99',
                    'UpdateDate' => '1',
                    'LastLoginDate' => '2'
                ],
                'SearchType' => [
                    '1' => 'メールアドレス',
                    '2' => 'POPアカウント'
                ],
                'SearchTypeBackEnd' => [
                    'MailAddress' => '1',
                    'POPAcount' => '2'
                ],
                // 会員検索機能で1ページあたり表示する件数
                'SearchPageLimit' => 20,
            ],
        ],
    ],
];
