<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminCampaignUpdateController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminCampaignUpdateControllerTest Test Case
 */
class AdminCampaignUpdateControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/admin/campaign/list.html'; //通常遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.TopicsTbl'];
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('TopicsTbl');
        $this->controller = new AdminCampaignUpdateController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_001()
    {
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'topicsSeq' => '2',
            'categoryId' => '4',
            'filePath2' => 'D:\home\personaltool2\storage\00001\admin\banner1495785948_117386_pc.jpg',
            'banner' => [
                'name' => '117386_pc.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'D:\xampp\tmp\php8EEB.tmp',
                'error' => 0,
                'size' => 127836
            ]
        ];

        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_002()
    {
        $this->get($this->testUrl . "?topicsSeq=50&selectYear=2017&selectCategory=1");
        $this->assertResponseCode(200);
    }

    /**
     * Test loadForm method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadForm_001()
    {
        $topicsSeq = 50;
        $actualResult = $this->invokeMethod($this->controller, "loadForm", [$topicsSeq]);
        $this->assertNull($actualResult);
    }

    /**
     * Test updateForm method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateForm_001()
    {
        $postData = [
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'topicsSeq' => '1',
            'categoryId' => '4',
            'filePath2' => 'D:\home\personaltool2\storage\00001\admin\banner1495785948_117386_pc.jpg',
            'banner' => [
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => 4,
                'size' => 0
            ],
            'action' => 'update'
        ];
        $this->controller->request->data = $postData;
        $actualResult = $this->invokeMethod($this->controller, "updateForm", []);
        $this->assertEquals($actualResult->StatusCode(), 302);
    }

    /**
     * Test updateForm method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateForm_002()
    {
        $postData = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '31',
                'hour' => '16',
                'minute' => '25'
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
        $this->controller->request->data = $postData;
        $actualResult = $this->invokeMethod($this->controller, "updateForm", []);
        $this->assertNull($actualResult);
    }

    /**
     * Test updateForm method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateForm_003()
    {
        $postData = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '14',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
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
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-14 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $this->controller->request->data = $postData;
        $actualResult = $this->invokeMethod($this->controller, "updateForm", []);
        $this->assertEquals($actualResult->StatusCode(), 302);
    }

    /**
     * Test updateForm method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateForm_004()
    {
        $postData = [
            'viewFlg' => '1',
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
        $this->controller->request->data = $postData;
        $actualResult = $this->invokeMethod($this->controller, "updateForm", []);
        $this->assertEquals($actualResult->StatusCode(), 302);
    }

    /**
     * Test validateData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_validateData_001()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
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
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-30 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "validateData", [$data]);
        $this->assertEquals($actualResult, false);
    }

    /**
     * Test validateData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_validateData_002()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '15',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
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
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-15 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "validateData", [$data]);
        $this->assertEquals($actualResult, true);
    }

    /**
     * Test updateData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateData_001()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '15',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
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
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-15 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "updateData", [$data]);
        $this->assertEquals($actualResult, true);
    }

    /**
     * Test updateData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateData_002()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '15',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
            'windowFlg' => '1',
            'filePath1' => '',
            'topicsSeq' => '1',
            'categoryId' => '4',
            'filePath2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495010159_test2.png',
            'banner' => [
                'name' => 'test',
                'type' => '',
                'tmp_name' => '',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-15 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "updateData", [$data]);
        $this->assertEquals($actualResult, false);
    }

    /**
     * Test updateData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateData_003()
    {
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '02',
                'day' => '15',
                'hour' => '16',
                'minute' => '25'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '01',
                'day' => '01',
                'hour' => '09',
                'minute' => '00'
            ],
            'windowFlg' => '1',
            'filePath1' => '',
            'topicsSeq' => '1',
            'categoryId' => '4',
            'filePath2' => '/home/AdminCustomSource/storage/00001/admin/banner/',
            'banner' => [
                'name' => 'test',
                'type' => '',
                'tmp_name' => '/home/temp.png',
                'error' => (int) 4,
                'size' => (int) 0
            ],
            'action' => 'update',
            'checkTime' => [
                'openData' => '2017-02-15 16:25:00',
                'timerData' => '2018-01-01 09:00:00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "updateData", [$data]);
        $this->assertEquals($actualResult, true);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        //parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }

    /**
     * Create time object
     * @return object
     */
    protected function makeTimeObj($time, $timeZone)
    {
        $timeInfo = new Time($time, $timeZone);
        return $timeInfo;
    }

}
