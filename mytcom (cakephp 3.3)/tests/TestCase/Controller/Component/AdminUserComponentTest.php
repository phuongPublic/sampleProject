<?php

namespace App\Test\TestCase\Controller;

use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\AdminUserComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\AdminUserComponent Test Case
 */
class AdminUserComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = [
        'app.UserMst',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AdminUserComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getUserDetailInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_getUserDetailInfo_001()
    {
        $userSeq = "385cd85a14bb90c754897fd0366ff266";
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->getUserDetailInfo($userSeq);
        $this->assertEquals($actualResult[0]['fileAllSize'], '60000B');
        $this->assertEquals($actualResult[0]['picAllSize'], '70000B');
        $this->assertEquals($actualResult[0]['movieAllSize'], '80000B');
        $this->assertEquals($actualResult[0]['totalSize'], '210000B');
        $this->assertEquals($actualResult[0]['status'], '継続');
    }

    /**
     * Test getUserDetailInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_getUserDetailInfo_002()
    {
        $userSeq = "ffffffedb67918403c2ceced8a25aa8a";
        $expectedResult = 0;
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->getUserDetailInfo($userSeq);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test getUserDetailInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_getUserDetailInfo_003()
    {
        $userSeq = null;
        $expectedResult = 0;
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->getUserDetailInfo($userSeq);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test searchUser method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_searchUser_001()
    {
        $searchInfo = [
            'timeStart' => '2016-06-03 00:00',
            'timeEnd' => '2017-06-03 00:00',
            'matchType' => 0,
            'searchKeyword' => 'user@gmail.com',
            'searchType' => 1,
            'searchStatus' => 0,
            'searchClass' => 2
        ];
        $type = 'dataForView';
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->searchUser($searchInfo, $type);
        $actualResult['data']['show_data'][0]['up_date'] = $actualResult['data']['show_data'][0]['up_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['reg_date'] = $actualResult['data']['show_data'][0]['reg_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['log_date'] = $actualResult['data']['show_data'][0]['log_date']->i18nFormat('yyyy-MM-dd HH:mm:ss');

        $data = [
            'page' => 1,
            'total' => 1,
            'total_page' => 1,
            'start' => 1,
            'end' => 1,
            'next' => "",
            'back' => "",
            'show_data' => [
                '0' => [
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'user_address' => 'user@gmail.com',
                    'user_name' => 'テスト 太郎',
                    'reg_flg' => '1',
                    'del_flg' => '0',
                    'up_date' => '2016-09-13',
                    'reg_date' => '2016-09-13',
                    'user_id' => 'xyz',
                    'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
                    'base' => '00001/',
                    'mobile_id' => 'Lorem ipsum dolor sit amet',
                    'mail_seq' => 'fd041c3eab',
                    'file_size' => 60000,
                    'album_size' => 70000,
                    'reminder_pc' => 'remider_pc@gmail.com',
                    'reminder_mobile' => 'remider_mobile@gmail.com',
                    'reminder_mobile_flg' => 1,
                    'reminder_pc_flg' => 1,
                    'reminder_time' => 1,
                    'movie_size' => 80000,
                    'log_date' => '2016-09-13 07:52:22',
                    'google_token' => 'test_token',
                    'status' => '継続',
                    'totalSize' => '210000B',
                    'fileAllSize' => '60000B',
                    'picAllSize' => '70000B',
                    'movieAllSize' => '80000B',
                ]
            ],
            'link_num' => [
                '0' => 1
            ],
            'items' => 20
        ];
        $this->assertEquals($actualResult['data'], $data);
        $this->assertEquals($actualResult['searchCount'], 1);
    }

    /**
     * Test searchUser method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_searchUser_002()
    {
        $searchInfo = [
            'timeStart' => '2016-06-03 00:00',
            'timeEnd' => '2017-06-03 00:00',
            'matchType' => 1,
            'searchKeyword' => 'ne910027',
            'searchType' => 2,
            'searchStatus' => 99,
            'searchClass' => 2
        ];
        $type = 'downloadCsv';
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->searchUser($searchInfo, $type);
        $actualResult['data']['show_data'][0]['up_date'] = $actualResult['data']['show_data'][0]['up_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['reg_date'] = $actualResult['data']['show_data'][0]['reg_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['log_date'] = $actualResult['data']['show_data'][0]['log_date']->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $actualResult['data']['show_data'][1]['up_date'] = $actualResult['data']['show_data'][1]['up_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][1]['reg_date'] = $actualResult['data']['show_data'][1]['reg_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][1]['log_date'] = $actualResult['data']['show_data'][1]['log_date']->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $data = [
            'show_data' => [
                '0' => [
                    'user_seq' => '385cd85a14bb90c754897fd0366ff267',
                    'user_address' => 'bipsv@gmail.com',
                    'user_name' => 'テスト 太郎',
                    'reg_flg' => '1',
                    'del_flg' => '0',
                    'up_date' => '2016-09-13',
                    'reg_date' => '2016-09-13',
                    'user_id' => 'ne910027',
                    'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
                    'base' => '00001/',
                    'mobile_id' => 'Lorem ipsum dolor sit amet',
                    'mail_seq' => 'fd041c3eab',
                    'file_size' => 60000,
                    'album_size' => 70000,
                    'reminder_pc' => 'remider_pc@gmail.com',
                    'reminder_mobile' => 'remider_mobile@gmail.com',
                    'reminder_mobile_flg' => 1,
                    'reminder_pc_flg' => 1,
                    'reminder_time' => 1,
                    'movie_size' => 80000,
                    'log_date' => '2016-09-13 07:52:22',
                    'google_token' => 'test_token',
                    'status' => '継続',
                    'totalSize' => '210000B',
                    'fileAllSize' => '60000B',
                    'picAllSize' => '70000B',
                    'movieAllSize' => '80000B',
                ],
                '1' => [
                    'user_seq' => '385cd85a14bb90c754897fd0366ff268',
                    'user_address' => 'bipsv1@gmail.com',
                    'user_name' => 'テスト 太郎',
                    'reg_flg' => '1',
                    'del_flg' => '1',
                    'up_date' => '2016-09-13',
                    'reg_date' => '2016-09-13',
                    'user_id' => 'ne910027',
                    'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
                    'base' => '00001/',
                    'mobile_id' => 'Lorem ipsum dolor sit amet',
                    'mail_seq' => 'fd041c3eab',
                    'file_size' => 60000,
                    'album_size' => 70000,
                    'reminder_pc' => 'remider_pc@gmail.com',
                    'reminder_mobile' => 'remider_mobile@gmail.com',
                    'reminder_mobile_flg' => 1,
                    'reminder_pc_flg' => 1,
                    'reminder_time' => 1,
                    'movie_size' => 80000,
                    'log_date' => '2016-09-13 07:52:22',
                    'google_token' => 'test_token',
                    'status' => '',
                    'totalSize' => '210000B',
                    'fileAllSize' => '60000B',
                    'picAllSize' => '70000B',
                    'movieAllSize' => '80000B',
                ]
            ],
            'link_num' => [
                '0' => 1
            ],
        ];
        $this->assertEquals($actualResult['data'], $data);
        $this->assertEquals($actualResult['searchCount'], 2);
    }

    /**
     * Test searchUser method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_searchUser_003()
    {
        $searchInfo = [
            'timeStart' => '2016-06-03 00:00',
            'timeEnd' => '2017-06-03 00:00',
            'matchType' => 1,
            'searchKeyword' => 'ne910028',
            'searchType' => 2,
            'searchStatus' => 1,
            'searchClass' => 99
        ];
        $type = '';
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->searchUser($searchInfo, $type);
        $actualResult['data']['show_data'][0]['up_date'] = $actualResult['data']['show_data'][0]['up_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['reg_date'] = $actualResult['data']['show_data'][0]['reg_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['log_date'] = $actualResult['data']['show_data'][0]['log_date']->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $data = [
            'show_data' => [
                '0' => [
                    'user_seq' => '385cd85a14bb90c754897fd0366ff269',
                    'user_address' => 'bipsv2@gmail.com',
                    'user_name' => 'テスト 太郎',
                    'reg_flg' => '1',
                    'del_flg' => '1',
                    'up_date' => '2016-09-13',
                    'reg_date' => '2016-09-13',
                    'user_id' => 'ne910028',
                    'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
                    'base' => '00001/',
                    'mobile_id' => 'Lorem ipsum dolor sit amet',
                    'mail_seq' => 'fd041c3eab',
                    'file_size' => 60000,
                    'album_size' => 70000,
                    'reminder_pc' => 'remider_pc@gmail.com',
                    'reminder_mobile' => 'remider_mobile@gmail.com',
                    'reminder_mobile_flg' => 1,
                    'reminder_pc_flg' => 1,
                    'reminder_time' => 1,
                    'movie_size' => 80000,
                    'log_date' => '2016-09-13 07:52:22',
                    'google_token' => 'test_token',
                    'status' => '',
                    'totalSize' => '210000B',
                    'fileAllSize' => '60000B',
                    'picAllSize' => '70000B',
                    'movieAllSize' => '80000B',
                ]
            ],
            'link_num' => [
                '0' => 1
            ],
        ];
        $this->assertEquals($actualResult['data'], $data);
        $this->assertEquals($actualResult['searchCount'], 1);
    }

    /**
     * Test searchUser method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_searchUser_004()
    {
        $searchInfo = [
            'timeStart' => '2016-06-03 00:00',
            'timeEnd' => '2017-06-03 00:00',
            'matchType' => 1,
            'searchKeyword' => 'ne910029',
            'searchType' => 2,
            'searchStatus' => 9,
            'searchClass' => 2
        ];
        $type = '';
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->searchUser($searchInfo, $type);
        $actualResult['data']['show_data'][0]['up_date'] = $actualResult['data']['show_data'][0]['up_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['reg_date'] = $actualResult['data']['show_data'][0]['reg_date']->i18nFormat('yyyy-MM-dd');
        $actualResult['data']['show_data'][0]['log_date'] = $actualResult['data']['show_data'][0]['log_date']->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $data = [
            'show_data' => [
                '0' => [
                    'user_seq' => '385cd85a14bb90c754897fd0366ff270',
                    'user_address' => 'bipsv3@gmail.com',
                    'user_name' => 'テスト 太郎',
                    'reg_flg' => '1',
                    'del_flg' => '9',
                    'up_date' => '2016-09-13',
                    'reg_date' => '2016-09-13',
                    'user_id' => 'ne910029',
                    'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
                    'base' => '00001/',
                    'mobile_id' => 'Lorem ipsum dolor sit amet',
                    'mail_seq' => 'fd041c3eab',
                    'file_size' => 60000,
                    'album_size' => 70000,
                    'reminder_pc' => 'remider_pc@gmail.com',
                    'reminder_mobile' => 'remider_mobile@gmail.com',
                    'reminder_mobile_flg' => 1,
                    'reminder_pc_flg' => 1,
                    'reminder_time' => 1,
                    'movie_size' => 80000,
                    'log_date' => '2016-09-13 07:52:22',
                    'google_token' => 'test_token',
                    'status' => '解約',
                    'totalSize' => '210000B',
                    'fileAllSize' => '60000B',
                    'picAllSize' => '70000B',
                    'movieAllSize' => '80000B',
                ]
            ],
            'link_num' => [
                '0' => 1
            ],
        ];
        $this->assertEquals($actualResult['data'], $data);
        $this->assertEquals($actualResult['searchCount'], 1);
    }

    /**
     * Test searchUser method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_searchUser_005()
    {
        $searchInfo = [
            'timeStart' => '2016-06-03 00:00',
            'timeEnd' => '2017-06-03 00:00',
            'matchType' => 1,
            'searchKeyword' => 'ne910030',
            'searchType' => 2,
            'searchStatus' => 9,
            'searchClass' => 2
        ];
        $type = '';
        $this->loadFixtures('UserMst');
        $actualResult = $this->component->searchUser($searchInfo, $type);
        $data = [
            'show_data' => [],
            'link_num' => [
                '0' => 1
            ],
        ];
        $this->assertEquals($actualResult['data'], $data);
        $this->assertEquals($actualResult['searchCount'], 0);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_001()
    {
        $amount = 2048576;
        $expectedResult = '1.95MB';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_003()
    {
        $amount = 500;
        $expectedResult = '500B';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_004()
    {
        $amount = null;
        $expectedResult = 'B';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_005()
    {
        $amount = 53687091200;
        $expectedResult = '51200MB';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_006()
    {
        $amount = 1048577;
        $expectedResult = '1MB';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_007()
    {
        $amount = 1048575;
        $expectedResult = '1048575B';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatAmount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatAmount_008()
    {
        $amount = 0;
        $expectedResult = '0B';
        $actualResult = $this->invokeMethod($this->component, "formatAmount", [$amount]);
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test formatDataForUserInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatDataForUserInfo_001()
    {
        $data = [
            'del_flg' => 0,
            'file_size' => 350000,
            'album_size' => 350000,
            'movie_size' => 350000
        ];
        $expectedResult = [
            'status' => '継続',
            'totalSize' => '1MB'
        ];
        $actualResult = $this->invokeMethod($this->component, "formatDataForUserInfo", [$data]);
        $this->assertEquals($actualResult['status'], $expectedResult['status']);
        $this->assertEquals($actualResult['totalSize'], $expectedResult['totalSize']);
    }

    /**
     * Test formatDataForUserInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatDataForUserInfo_002()
    {
        $data = [
            'del_flg' => 1,
            'file_size' => 60000,
            'album_size' => 70000,
            'movie_size' => 80000
        ];
        $expectedResult = [
            'status' => '',
            'totalSize' => '210000B'
        ];
        $actualResult = $this->invokeMethod($this->component, "formatDataForUserInfo", [$data]);
        $this->assertEquals($actualResult['status'], $expectedResult['status']);
        $this->assertEquals($actualResult['totalSize'], $expectedResult['totalSize']);
    }

    /**
     * Test formatDataForUserInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_formatDataForUserInfo_003()
    {
        $data = [
            'del_flg' => 9,
            'file_size' => 60000,
            'album_size' => 70000,
            'movie_size' => 80000
        ];
        $expectedResult = [
            'status' => '解約',
            'totalSize' => '210000B'
        ];
        $actualResult = $this->invokeMethod($this->component, "formatDataForUserInfo", [$data]);
        $this->assertEquals($actualResult['status'], $expectedResult['status']);
        $this->assertEquals($actualResult['totalSize'], $expectedResult['totalSize']);
    }

    /**
     * Test downloadCSV method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_downloadCSV_001()
    {
        ob_start();
        $inputParam = [
            'data' => [
                'show_data' => [
                    '0' => [
                        'user_address' => 'user01@gmail.com',
                        'user_id' => 'ne910027',
                        'user_name' => 'テスト 太郎',
                        'status' => '継続',
                        'up_date' => '2016-09-13',
                        'log_date' => '2016-09-13 07:52:22',
                        'totalSize' => '210000B',
                        'fileAllSize' => '60000B',
                        'picAllSize' => '70000B',
                        'movieAllSize' => '80000B',
                    ],
                    '1' => [
                        'user_address' => 'user02@gmail.com',
                        'user_id' => 'ne910027',
                        'user_name' => 'テスト 太郎',
                        'status' => '継続',
                        'up_date' => '2016-09-13',
                        'log_date' => '2016-09-13 07:52:22',
                        'totalSize' => '420000B',
                        'fileAllSize' => '120000B',
                        'picAllSize' => '140000B',
                        'movieAllSize' => '160000B',
                    ],
                ],
            ],
            'link_num' => [
                '0' => 1
            ],
        ];

        $this->component->downloadCSV($inputParam);
        $actualOutput = ob_get_clean();
        $expectedOutput = mb_convert_encoding("メールアドレス, POPID, ニックネーム, ステータス, 初回ログイン日 or 解約日, 最終ログイン, 使用量\r\n", 'SJIS', 'UTF-8') .
                mb_convert_encoding("user01@gmail.com, ne910027, テスト 太郎, 継続, 2016/09/13, 2016/09/13 07:52, 210000B (ファイル：60000B  アルバム：70000B  動画：80000B ) \r\n", 'SJIS', 'UTF-8') .
                mb_convert_encoding("user02@gmail.com, ne910027, テスト 太郎, 継続, 2016/09/13, 2016/09/13 07:52, 420000B (ファイル：120000B  アルバム：140000B  動画：160000B ) \r\n", 'SJIS', 'UTF-8');

        $this->assertEquals($actualOutput, $expectedOutput);
    }

    /**
     * Test getSearchCondition method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_getSearchCondition_001()
    {
        $inputParam = [
            'matchType' => 1,
            'searchStartTime' => [
                'year' => 2017,
                'month' => 10,
                'day' => 25,
                'hour' => 10,
                'minute' => 20,
                'second' => 30
            ],
            'searchEndTime' => [
                'year' => 2018,
                'month' => 11,
                'day' => 26,
                'hour' => 11,
                'minute' => 12,
                'second' => 13
            ]
        ];

        $actualOutput = $this->component->getSearchCondition($inputParam);
        $expectedOutput = [
            'matchType' => 1,
            'searchStartTime' => [
                'year' => 2017,
                'month' => 10,
                'day' => 25,
                'hour' => 10,
                'minute' => 20,
                'second' => 30
            ],
            'searchEndTime' => [
                'year' => 2018,
                'month' => 11,
                'day' => 26,
                'hour' => 11,
                'minute' => 12,
                'second' => 13
            ],
            'timeStart' => '2017-10-25 10:20:00',
            'timeEnd' => '2018-11-26 11:12:00'
        ];

        $this->assertEquals($actualOutput, $expectedOutput);
    }

    /**
     * Test getSearchCondition method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AUCpn_getSearchCondition_003()
    {
        $inputParam = [
            'matchType' => null,
            'searchStartTime' => [
                'year' => 2017,
                'month' => 10,
                'day' => 25,
                'hour' => 10,
                'minute' => 20,
                'second' => 30
            ],
            'searchEndTime' => [
                'year' => 2018,
                'month' => 11,
                'day' => 26,
                'hour' => 11,
                'minute' => 12,
                'second' => 13
            ]
        ];

        $actualOutput = $this->component->getSearchCondition($inputParam);
        $expectedOutput = [
            'matchType' => 0,
            'searchStartTime' => [
                'year' => 2017,
                'month' => 10,
                'day' => 25,
                'hour' => 10,
                'minute' => 20,
                'second' => 30
            ],
            'searchEndTime' => [
                'year' => 2018,
                'month' => 11,
                'day' => 26,
                'hour' => 11,
                'minute' => 12,
                'second' => 13
            ],
            'timeStart' => '2017-10-25 10:20:00',
            'timeEnd' => '2018-11-26 11:12:00'
        ];

        $this->assertEquals($actualOutput, $expectedOutput);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

}
