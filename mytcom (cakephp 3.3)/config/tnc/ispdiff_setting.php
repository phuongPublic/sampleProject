<?php

return [
    // 会員管理
    'AdminUser' => [
        //Unit Conver from byte to megabyte
        'sizeUnit' => 1000000,
    ],
    '3DESC' => [
        'key' => 'mytcom2007'
    ],
    'IspTitle' => 'TNCポケット',
    'IspName' => 'TNCポケット',
    'IspLogin' => 'TNCトップ',
    'Common' => [
        'AdminModule' => [
            'Mainte' => [
                'FilePath' => [
                    // mainteのtemplate
                    'mainte_template'         => '/home/opt_tnc/personaltool/mainte/template/tnc/mainte_pc.tmpl',
                    'mainte_template_iphone'  => '/home/opt_tnc/personaltool/mainte/template/tnc/mainte_ip.tmpl',
                    'mainte_template_android' => '/home/opt_tnc/personaltool/mainte/template/tnc/mainte_ad.tmpl',
                    // CakePHPのhtml
                    'mainte'         => '/home/opt_tnc/personaltool/webroot/mainte_pc.html',
                    'mainte_iphone'  => '/home/opt_tnc/personaltool/webroot/mainte_ip.html',
                    'mainte_android' => '/home/opt_tnc/personaltool/webroot/mainte_ad.html',
                    // CakePHPのhtaccess
                    'htaccess'        => '/home/opt_tnc/personaltool/webroot/.htaccess',
                    'htaccess_mainte' => '/home/opt_tnc/personaltool/webroot/.htaccess_mainte',
                    'htaccess_normal' => '/home/opt_tnc/personaltool/webroot/.htaccess_normal',
                    // Ethnaのhtml
                    'mainte_opt_pc' => '/home/pocket_tnc/parsonaltool/www/maintenance.html',
                    'mainte_opt_ip' => '/home/pocket_tnc/parsonaltool/www/iphone/mainte.html',
                    'mainte_opt_ad' => '/home/pocket_tnc/parsonaltool/www/android/mainte.html',
                    // Ethnaのhtaccess
                    'htaccess_opt_pc'        => '/home/pocket_tnc/parsonaltool/www/.htaccess',
                    'htaccess_mainte_opt_pc' => '/home/pocket_tnc/parsonaltool/www/.htaccess_mainte',
                    'htaccess_normal_opt_pc' => '/home/pocket_tnc/parsonaltool/www/.htaccess_normal',
                    'htaccess_opt_ip'        => '/home/pocket_tnc/parsonaltool/www/iphone/.htaccess',
                    'htaccess_mainte_opt_ip' => '/home/pocket_tnc/parsonaltool/www/iphone/.htaccess_mainte',
                    'htaccess_normal_opt_ip' => '/home/pocket_tnc/parsonaltool/www/iphone/.htaccess_normal',
                    'htaccess_opt_ad'        => '/home/pocket_tnc/parsonaltool/www/android/.htaccess',
                    'htaccess_mainte_opt_ad' => '/home/pocket_tnc/parsonaltool/www/android/.htaccess_mainte',
                    'htaccess_normal_opt_ad' => '/home/pocket_tnc/parsonaltool/www/android/.htaccess_normal',
                    // BBSのhtml
                    'mainte_bbs'    => '/home/bbs/tnc/mainte_pc.html',
                    'mainte_sp_bbs' => '/home/bbs/tnc/mainte_sp.html',
                    // BBSのhtaccess
                    'htaccess_bbs'        => '/home/bbs/tnc/.htaccess',
                    'htaccess_mainte_bbs' => '/home/bbs/tnc/.htaccess_mainte',
                    'htaccess_normal_bbs' => '/home/bbs/tnc/.htaccess_normal',
                ],
            ]
        ]
    ]
];
