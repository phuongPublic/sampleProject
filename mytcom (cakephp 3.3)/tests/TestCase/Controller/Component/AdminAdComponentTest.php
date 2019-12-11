<?php

namespace App\Test\TestCase\Controller;

use App\Controller\Component\AdminAdComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use App\Validation\NoptBaseValidator;
use Cake\I18n\Time;

/**
 * App\Controller\Component\AdminAdComponentTest Test Case
 */
class AdminAdComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = ['app.AdTbl'];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AdminAdComponent($registry);
    }

    /**
     * Test Test_AACpn_registAd_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_001()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 1',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '1',
            'timerFlg' => '2',
            'contents' => 'Test ad content 1',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:41',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_registAd_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_002()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 2',
            'pub_flg' => '1',
            'pos_flg' => '2', // コンテンツ内1
            'viewFlg' => '2', // 下書き
            'timerFlg' => '2',
            'contents' => 'Test ad content 2',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:42',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_registAd_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_003()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 3',
            'pub_flg' => '1',
            'pos_flg' => '3', //コンテンツ内2
            'viewFlg' => '3', //予約
            'openData' => '2017-09-09 09:09:00',
            'timerFlg' => '2',
            'contents' => 'Test ad content 3',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_registAd_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_004()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 4',
            'pub_flg' => '1',
            'pos_flg' => '4', // コンテンツ内3
            'viewFlg' => '4', // 公開終了
            'timerFlg' => '2',
            'contents' => 'Test ad content 4',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:44',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_registAd_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_005()
    {
        $this->loadFixtures('AdTbl');
        // case: title: 半角150文字
        $adData = array(
            'title' => 'Test ad title 5. Unit testcase title with english max length 150 characters. Test ad title unit testcase title with english max length 150 characters.',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '3',
            'openData' => '2017-06-01 12:00:00',
            'timerFlg' => '1',
            'timerData' => '2017-06-02 13:00:00',
            'contents' => 'Test ad content 5',
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => 0,
                'size' => 1000
            ],
            'checkTime' => array(
                'openData' => '2017-06-01 12:00:00',
                'timerData' => '2017-06-02 13:00:00'
            ),
            'file_path' => '\home\personaltool2\tests\TestData\imageTest.jpg'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_registAd_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_registAd_006()
    {
        $this->loadFixtures('AdTbl');
        // case: title: 全角50文字
        $adData = array(
            'title' => 'サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。データテスト',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '3',
            'openData' => '2017-06-01 12:00:00',
            'timerFlg' => '1',
            'timerData' => '2017-06-02 13:00:00',
            'contents' => 'Test ad content 5',
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => 0,
                'size' => 1000
            ],
            'checkTime' => array(
                'openData' => '2017-06-01 12:00:00',
                'timerData' => '2017-06-02 13:00:00'
            ),
            'file_path' => '\home\personaltool2\tests\TestData\imageTest.jpg'
        );
        $result = $this->component->registAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_001()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 1',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '1',
            'timerFlg' => '2',
            'contents' => 'Test ad content 1',
            'adseq' => '1',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:41',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_002()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 2',
            'pub_flg' => '1',
            'pos_flg' => '2', // コンテンツ内1
            'viewFlg' => '2', // 下書き
            'timerFlg' => '2',
            'contents' => 'Test ad content 2',
            'adseq' => '1',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:42',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_003()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 3',
            'pub_flg' => '1',
            'pos_flg' => '3', //コンテンツ内2
            'viewFlg' => '3', //予約
            'openData' => '2017-09-09 09:09:00',
            'timerFlg' => '2',
            'contents' => 'Test ad content 3',
            'adseq' => '1',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_004()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adData has normal value
        $adData = array(
            'title' => 'Test ad title 4',
            'pub_flg' => '1',
            'pos_flg' => '4', // コンテンツ内3
            'viewFlg' => '4', // 公開終了
            'timerFlg' => '2',
            'contents' => 'Test ad content 4',
            'adseq' => '1',
            'adImage' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'file_path' => null,
            'openData' => '2017-06-01 11:45:44',
            'timerData' => '0000-00-00 00:00:00'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_005()
    {
        $this->loadFixtures('AdTbl');
        // case: title: 半角150文字
        $adData = array(
            'title' => 'Test ad title 5. Unit testcase title with english max length 150 characters. Test ad title unit testcase title with english max length 150 characters.',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '3',
            'openData' => '2017-06-01 12:00:00',
            'timerFlg' => '1',
            'timerData' => '2017-06-02 13:00:00',
            'contents' => 'Test ad content 5',
            'adseq' => '1',
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => 0,
                'size' => 1000
            ],
            'checkTime' => array(
                'openData' => '2017-06-01 12:00:00',
                'timerData' => '2017-06-02 13:00:00'
            ),
            'file_path' => '\home\personaltool2\tests\TestData\imageTest.jpg'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAd_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAd_006()
    {
        $this->loadFixtures('AdTbl');
        // case: title: 全角50文字
        $adData = array(
            'title' => 'サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。データテスト',
            'pub_flg' => '1',
            'pos_flg' => '1',
            'viewFlg' => '3',
            'openData' => '2017-06-01 12:00:00',
            'timerFlg' => '1',
            'timerData' => '2017-06-02 13:00:00',
            'contents' => 'Test ad content 5',
            'adseq' => '1',
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => 0,
                'size' => 1000
            ],
            'checkTime' => array(
                'openData' => '2017-06-01 12:00:00',
                'timerData' => '2017-06-02 13:00:00'
            ),
            'file_path' => '\home\personaltool2\tests\TestData\imageTest.jpg'
        );
        $result = $this->component->updateAd($adData);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_deleteAd_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_deleteAd_001()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adSeq has normal value
        $adSeq = 1;
        $result = $this->component->deleteAd($adSeq);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_deleteAd_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_deleteAd_002()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $adSeq has normal value
        $adSeq = null;
        $result = $this->component->deleteAd($adSeq);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAdStatus_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAdStatus_001()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $viewFlag, $adSeq has normal value
        $viewFlag = 1;
        $adSeq = 1;
        $result = $this->component->updateAdStatus($viewFlag, $adSeq);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_updateAdStatus_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_updateAdStatus_002()
    {
        $this->loadFixtures('AdTbl');
        // case 1 parameter $viewFlag, $adSeq has normal value
        $viewFlag = 4;
        $adSeq = 1;
        $result = $this->component->updateAdStatus($viewFlag, $adSeq);
        $this->assertTrue($result);
    }

    /**
     * Test Test_AACpn_resetData_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_resetData_001()
    {
        // case 1 parameter $data has normal value
        $data = array(
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '09',
                'minute' => '23',
                'second' => '00'
            ],
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '10',
                'minute' => '33',
                'second' => '00'
            ]
        );

        $openData = new Time('2017-05-23 09:23:00');
        $timerData = new Time('2017-05-23 10:33:00');
        $equalsResult = [
            'openData' => $openData,
            'timerData' => $timerData
        ];

        $result = $this->component->resetData($data);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_AACpn_resetData_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_resetData_002()
    {
        // case 1 parameter $data has normal value
        $data = array(
            'openData' => '',
            'timerData' => ''
        );

        $openData = new Time(date('Y-m-d H:i:s'));
        $timerData = new Time(date('Y-m-d H:i:s'));
        $equalsResult = [
            'openData' => $openData,
            'timerData' => $timerData
        ];

        $result = $this->component->resetData($data);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_AACpn_removeUndefinedDate_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_removeUndefinedDate_001()
    {
        // case 1 parameter $adData has normal value
        $adData = array('file_path' => 'file_path_test');

        $result = $this->component->removeUndefinedDate($adData);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_001()
    {
        $adData = array(
            'title' => 'Title test ad 001'
        );
        $adData['bypass'] = ['title' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_002()
    {
        $adData = array(
            'title' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        );
        $adData['bypass'] = ['title' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'title' => [
                'checkLength' => 'タイトルは全角50文字（半角150文字）以内で入力してください。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_003()
    {
        $adData = array(
            'contents' => 'Contents test ad 003'
        );
        $adData['bypass'] = ['contents' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_004()
    {
        $adData = array(
            'contents' => ''
        );
        $adData['bypass'] = ['contents' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'contents' => [
                'noValue' => 'HTMLタグ、もしくはURLを入力してください。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_005()
    {
        $adData = array(
            'adImage' => [
                'name' => 'testImage.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '',
                'error' => 0,
                'size' => 0
            ]
        );
        $adData['bypass'] = ['adImage' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_006()
    {
        $adData = array(
            'adImage' => [
                'name' => 'testImage.bmp',
                'type' => 'image/bmp',
                'tmp_name' => '',
                'error' => 0,
                'size' => 0
            ]
        );
        $adData['bypass'] = ['adImage' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'adImage' => [
                'extension' => 'gif、jpg、png形式以外はアップロードできません。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_007 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_007()
    {
        $adData = array(
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '18',
                'hour' => '17',
                'minute' => '55'
            ]
        );
        $adData['bypass'] = ['openData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_008 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_008()
    {
        $adData = array(
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '17',
                'minute' => '55'
            ]
        );
        $adData['bypass'] = ['openData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'openData' => [
                'checkOpenDataDate' => '正しい公開日時を選択してください。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_009 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_009()
    {
        $adData = array(
            'timerData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '18',
                'hour' => '17',
                'minute' => '55'
            ]
        );
        $adData['bypass'] = ['timerData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_010 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_010()
    {
        $adData = array(
            'timerData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '17',
                'minute' => '55'
            ]
        );
        $adData['bypass'] = ['timerData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'timerData' => [
                'checkTimerDataDate' => '正しい公開終了日時を選択してください。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_011 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_011()
    {
        $adData = array(
            'checkTime' => [
                'openData' => '2017-05-23 15:22:00',
                'timerData' => '2017-05-23 15:33:00'
            ]
        );
        $adData['bypass'] = ['openData' => true, 'timerData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_012 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_012()
    {
        $adData = array(
            'checkTime' => [
                'openData' => '2017-05-23 15:22:00',
                'timerData' => '2017-05-23 15:11:00'
            ]
        );
        $adData['bypass'] = ['openData' => true, 'timerData' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'checkTime' => [
                'compareDate' => '公開終了日時が予約開始日時より前になっています。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_013 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_013()
    {
        $adData = array(
            'title' => 'サンプルデータテスト。'
        );
        $adData['bypass'] = ['title' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_AACpn_validationAdvertisement_014 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AACpn_validationAdvertisement_014()
    {
        $adData = array(
            'title' => 'サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。データテスト。'
        );
        $adData['bypass'] = ['title' => true];
        $validator = $this->component->validationAdvertisement(new NoptBaseValidator());
        $errors = $validator->errors($adData);
        $expect = [
            'title' => [
                'checkLength' => 'タイトルは全角50文字（半角150文字）以内で入力してください。'
            ]
        ];
        $this->assertEquals($expect, $errors);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

}
