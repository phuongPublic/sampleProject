<?php

return [
    //
    // システム共通設定
    //
    'Common' => [
                'language' => ['vn'=>1,'jp'=>2],
                'max_size_upload' => 2097152,
                'job_status' => [
                    'popularity' => 1,
                    'fast_job' => 2
                ],
                'page_limit' => 2,
                'customer_confirm_mail' => false,
                'default_password' => '******',
                'default_country_id' => '392',
                'user_agent_list' => [
                    'iphone' => array('iPhone', 'iPod', 'iPad'),
                    'android' => array('Android')
                ],
                'currency' => [
                    1 => '￥',
                    2 => '$'
                        ],
                'temp_mail_id' => [
                    'apply' => 1,
                    'regist' => 2
                ],
                'page_item' => 10,
                    'page_display_num' => 7,
                'domain' => [
                    'jp_url' => 'http://xampp.hyperion-job.com',
                    'vn_url' => 'http://xampp.vn.hyperion-job.com',
                    'sp_url' => 'http://xampp.sp.hyperion-job.com',
                ],
    ],
    ];
