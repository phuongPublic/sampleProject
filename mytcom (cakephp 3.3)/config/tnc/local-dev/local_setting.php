<?php

return [
    //
    // このファイルは、開発者環境（$_SERVER['NOPT_ENVIRONMENT']が'local-dev'のときに必要な設定を記載する）
    // local-devの環境のみで必要なファイル
    // 更新時は、tcomとtncのファイルで配列のvalue以外の差分がでないことを確認すること
    'localDev' => [
        // ユーザ情報
        'UserData' => [
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'user_address' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'user_name' => 'Test',
        ],
    ],
    'Common' => [
        // 写真ファイルのサムネイル生成に関する設定
        'ThumbnailGenerate' => [
            // Windows : ' > nul', Linux : ' > /dev/null &'
            'NullDevice' => ' > nul',
        ],
    ],
];
