<?php

return [
    // 会員管理
    'AdminUser' => [
        //Unit Conver from byte to megabyte
        'sizeUnit' => 1048576,
    ],
    '3DESC' => [
        'key' => 'mytcom2007'
    ],
    'IspTitle' => 'My@T COM (マイアットティーコム）',
    'IspName' => 'My@T COM',
    'IspLogin' => '@T COM(アットティーコム)',
    'Common' => [
        'AdminModule' => [
            'Mainte' => [
                'FilePath' => [
                    // mainteのtemplate
                    'mainte_template'           => '/home/opt_tcom/personaltool/mainte/template/tcom/mainte_pc.tmpl',
                    'mainte_template_iphone'    => '/home/opt_tcom/personaltool/mainte/template/tcom/mainte_ip.tmpl',
                    'mainte_template_android'   => '/home/opt_tcom/personaltool/mainte/template/tcom/mainte_ad.tmpl',
                    // CakePHPのhtml
                    'mainte'         => '/home/opt_tcom/personaltool/webroot/mainte_pc.html',
                    'mainte_iphone'  => '/home/opt_tcom/personaltool/webroot/mainte_ip.html',
                    'mainte_android' => '/home/opt_tcom/personaltool/webroot/mainte_ad.html',
                    // CakePHPのhtaccess
                    'htaccess'        => '/home/opt_tcom/personaltool/webroot/.htaccess',
                    'htaccess_mainte' => '/home/opt_tcom/personaltool/webroot/.htaccess_mainte',
                    'htaccess_normal' => '/home/opt_tcom/personaltool/webroot/.htaccess_normal',
                    // Ethnaのhtml
                    'mainte_opt_pc' => '/home/mytcom/parsonaltool/www/maintenance.html',
                    'mainte_opt_ip' => '/home/mytcom/parsonaltool/www/iphone/mainte.html',
                    'mainte_opt_ad' => '/home/mytcom/parsonaltool/www/android/mainte.html',
                    // Ethnaのhtaccess
                    'htaccess_opt_pc'        => '/home/mytcom/parsonaltool/www/.htaccess',
                    'htaccess_mainte_opt_pc' => '/home/mytcom/parsonaltool/www/.htaccess_mainte',
                    'htaccess_normal_opt_pc' => '/home/mytcom/parsonaltool/www/.htaccess_normal',
                    'htaccess_opt_ip'        => '/home/mytcom/parsonaltool/www/iphone/.htaccess',
                    'htaccess_mainte_opt_ip' => '/home/mytcom/parsonaltool/www/iphone/.htaccess_mainte',
                    'htaccess_normal_opt_ip' => '/home/mytcom/parsonaltool/www/iphone/.htaccess_normal',
                    'htaccess_opt_ad'        => '/home/mytcom/parsonaltool/www/android/.htaccess',
                    'htaccess_mainte_opt_ad' => '/home/mytcom/parsonaltool/www/android/.htaccess_mainte',
                    'htaccess_normal_opt_ad' => '/home/mytcom/parsonaltool/www/android/.htaccess_normal',
                    // BBSのhtml
                    'mainte_bbs'    => '/home/bbs/tcom/mainte_pc.html',
                    'mainte_sp_bbs' => '/home/bbs/tcom/mainte_sp.html',
                    // BBSのhtaccess
                    'htaccess_bbs'        => '/home/bbs/tcom/.htaccess',
                    'htaccess_mainte_bbs' => '/home/bbs/tcom/.htaccess_mainte',
                    'htaccess_normal_bbs' => '/home/bbs/tcom/.htaccess_normal',
                    // KSOのhtml
                    'mainte_kso'                  => '/home/mytcom/api/htdocs/maintenance.html',
                    // KSOのhtaccess
                    'htaccess_kso'                => '/home/mytcom/api/htdocs/.htaccess',
                    'htaccess_kso_1'              => '/home/mytcom/api/htdocs/1/.htaccess',
                    'htaccess_kso_app'            => '/home/mytcom/api/htdocs/1/app/.htaccess',
                    'htaccess_kso_webroot'        => '/home/mytcom/api/htdocs/1/app/webroot/.htaccess',
                    'htaccess_mainte_kso'         => '/home/mytcom/api/htdocs/.htaccess_mainte',
                    'htaccess_mainte_kso_1'       => '/home/mytcom/api/htdocs/1/.htaccess_mainte',
                    'htaccess_mainte_kso_app'     => '/home/mytcom/api/htdocs/1/app/.htaccess_mainte',
                    'htaccess_mainte_kso_webroot' => '/home/mytcom/api/htdocs/1/app/webroot/.htaccess_mainte',
                    'htaccess_normal_kso'         => '/home/mytcom/api/htdocs/.htaccess_normal',
                    'htaccess_normal_kso_1'       => '/home/mytcom/api/htdocs/1/.htaccess_normal',
                    'htaccess_normal_kso_app'     => '/home/mytcom/api/htdocs/1/app/.htaccess_normal',
                    'htaccess_normal_kso_webroot' => '/home/mytcom/api/htdocs/1/app/webroot/.htaccess_normal',
                ],
            ]
        ]
    ]
];
