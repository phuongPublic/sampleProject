<?php

namespace App\Test\TestCase\Controller;

use App\Controller\Component\AdminCampaignComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Validation\NoptBaseValidator;

/**
 * App\Controller\Component\AdminCampaignComponent Test Case
 */
class AdminCampaignComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = [
        'app.TopicsTbl'
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AdminCampaignComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_001()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'openData' => '2017-05-17 17:16:14',
            'timerData' => '2050-01-01 00:00:00'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_003()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '2',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'openData' => '2017-06-01 13:00:53',
            'timerData' => '0000-00-00 00:00:00'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_004()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '3',
            'openData' => '2017-06-01 12:54:00',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'timerData' => '0000-00-00 00:00:00'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_005()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '4',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'openData' => '2017-06-01 13:04:46',
            'timerData' => '0000-00-00 00:00:00'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_006()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '1',
            'timerData' => '2017-06-01 12:46:00',
            'windowFlg' => '1',
            'filePath1' => '',
            'openData' => '2017-06-01 13:13:15'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_insertCampaignData_007 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_insertCampaignData_007()
    {
        //case all input parameters has normal value
        $filePath2 = ROOT . DS . 'storage/00001/admin/banner/1496288781_test2.png';
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '2',
            'filePath1' => '',
            'openData' => '2017-06-01 13:32:51',
            'timerData' => '0000-00-00 00:00:00'
        ];
        $result = $this->component->insertCampaignData($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_updateCampaignStatus_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_updateCampaignStatus_001()
    {
        $this->loadFixtures('TopicsTbl');
        $viewFlg = 1;
        $topicsSeq = 50;
        $result = $this->component->updateCampaignStatus($topicsSeq, $viewFlg);
        $this->assertTrue($result);
    }
    /**
     * Test Test_ACCpn_updateCampaignStatus_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_updateCampaignStatus_003()
    {
        $this->loadFixtures('TopicsTbl');
        $viewFlg = 2;
        $topicsSeq = 50;
        $result = $this->component->updateCampaignStatus($topicsSeq, $viewFlg);
        $this->assertTrue($result);
    }
    
    /**
     * Test Test_ACCpn_updateCampaignStatus_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_updateCampaignStatus_004()
    {
        $this->loadFixtures('TopicsTbl');
        $viewFlg = 3;
        $topicsSeq = 50;
        $result = $this->component->updateCampaignStatus($topicsSeq, $viewFlg);
        $this->assertTrue($result);
    }
    
    /**
     * Test Test_ACCpn_updateCampaignStatus_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_updateCampaignStatus_005()
    {
        $this->loadFixtures('TopicsTbl');
        $viewFlg = 4;
        $topicsSeq = 50;
        $result = $this->component->updateCampaignStatus($topicsSeq, $viewFlg);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_updateCampaign_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_updateCampaign_001()
    {
        $this->loadFixtures('TopicsTbl');
        $filePath2 = '/home/AdminCustomSource/storage/00001/admin/banner/';
        $data = [
            'categoryId' => '4',
            'topicsSeq' => '50',
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'openData' => '2017-05-17 17:16:14',
            'timerData' => '2050-01-01 00:00:00'
        ];
        $result = $this->component->updateCampaign($filePath2, $data);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_deleteCampaign_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_deleteCampaign_001()
    {
        $this->loadFixtures('TopicsTbl');
        $result = $this->component->deleteCampaign(50);
        $this->assertTrue($result);
    }

    /**
     * Test AdminCampainComponent function prepareListData No.001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_prepareListData_001()
    {
        $campaignArray = array(0 => array('file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495435954_test1.png'));
        $result = $this->component->prepareListData($campaignArray);
        $campaignObj = array(0 => array('file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495435954_test1.png',
                'img_width' => 1600));
        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_prepareListData_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_prepareListData_002()
    {
        $campaignArray = array(0 => array('file_path2' => ''));
        $result = $this->component->prepareListData($campaignArray);
        $campaignObj = array(0 => array('file_path2' => ''));

        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_resetData_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_resetData_001()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '36'
            ],
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'topicsSeq' => '1',
            'categoryId' => '4',
            'filePath2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495010159_test2.png',
            'banner' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'update'
        ];
        $action = 'update';
        $result = $this->component->resetData($data, $action);

        $campaignObj = [
            'file_path1' => '',
            'viewflg' => '3',
            'windowflg' => '1',
            'timerflg' => '2',
            'opendata' => '2017-02-31 12:36:00',
            'timerdata' => date("Y-m-d H:i:s"),
            'topicsseq' => '1',
            'categoryid' => '4',
            'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495010159_test2.png'
        ];

        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_resetData_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_resetData_002()
    {
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'regist'
        ];
        $action = 'regist';
        $result = $this->component->resetData($data, $action);

        $campaignObj = [
            'file_path1' => '',
            'viewflg' => '1',
            'windowflg' => '1',
            'timerflg' => '2',
            'opendata' => date("Y-m-d H:i:s"),
            'timerdata' => date("Y-m-d H:i:s")
        ];

        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_resetData_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_resetData_003()
    {
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'regist'
        ];
        $action = 'regist';
        $result = $this->component->resetData($data, $action);

        $campaignObj = [
            'file_path1' => '',
            'viewflg' => '1',
            'windowflg' => '1',
            'timerflg' => '2',
            'opendata' => date("Y-m-d H:i:s"),
            'timerdata' => date("Y-m-d H:i:s")
        ];

        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_resetData_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_resetData_004()
    {
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '43'
            ],
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'regist'
        ];
        $action = 'regist';
        $result = $this->component->resetData($data, $action);

        $campaignObj = [
            'file_path1' => '',
            'viewflg' => '1',
            'windowflg' => '1',
            'timerflg' => '1',
            'opendata' => date("Y-m-d H:i:s"),
            'timerdata' => '2017-05-18 12:43:00'
        ];

        $this->assertEquals($campaignObj, $result);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_001()
    {
        $data = array(
            'banner' => array('name' => '')
        );
        $data['bypass'] = ['banner' => true, 'openData' => true, 'timerData' => true];
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($data);
        $expect = ['banner' => [
                'noValue' => '画像を選択してください。'
        ]];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_002()
    {
        $Data = array(
            'banner' => array('name' => 'test1.png',
                'type' => 'image/png',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_003()
    {
        $Data = array(
            'banner' => array('name' => 'test1.psd',
                'type' => 'image/aaaa',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = ['banner' => [
                'imgType' => 'gif、jpg、png形式以外はアップロードできません。'
        ]];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_004()
    {
        $Data = array('checkTime' => [
                'openData' => '2017-02-20 13:52:00',
                'timerData' => '2018-02-20 13:52:00'
        ]);
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_005()
    {
        $Data = array('checkTime' => [
                'openData' => '2018-05-18 12:50:00',
                'timerData' => '2017-05-18 12:50:00'
        ]);
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = ['checkTime' => [
                'validTime' => 'タイマー設定が予約開始日以前になっています。'
        ]];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_006()
    {
        $Data = array(
            'openData' => array(
                'year' => '2017',
                'month' => '02',
                'day' => '20',
                'hour' => '13',
                'minute' => '52'
            )
        );
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_007 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_007()
    {
        $Data = array('openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '13',
                'minute' => '52'
        ]);
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = ['openData' => [
                'checkOpenDataDate' => '正しい公開日時を選択してください。'
        ]];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_008 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_008()
    {
        $Data = array('timerData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '20',
                'hour' => '13',
                'minute' => '52'
        ]);
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_009 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_009()
    {
        $Data = array('timerData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '31',
                'hour' => '13',
                'minute' => '52'
        ]);
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = ['timerData' => [
                'checkTimerDataDate' => '正しい公開終了日時を選択してください。'
        ]];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_010 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_010()
    {
        $Data = array(
            'banner' => array('name' => 'test1.gif',
                'type' => 'image/gif',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_011 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_011()
    {
        $Data = array(
            'banner' => array('name' => 'test1.jpeg',
                'type' => 'image/jpeg',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_012 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_012()
    {
        $Data = array(
            'banner' => array('name' => 'test1.pjpeg',
                'type' => 'image/pjpeg',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    /**
     * Test Test_ACCpn_validationDefaultCampaign_013 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_validationDefaultCampaign_013()
    {
        $Data = array(
            'banner' => array('name' => 'test1.x-png',
                'type' => 'image/x-png',
        ));
        $validator = $this->component->validationDefaultCampaign(new NoptBaseValidator(), 'regist');
        $errors = $validator->errors($Data);
        $expect = [];
        $this->assertEquals($expect, $errors);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

}
