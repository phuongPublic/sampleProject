<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminTopicsRegistController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminTopicsRegistControllerTest Test Case
 */
class AdminTopicsRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/admin/topics/list.html'; //通常遷移

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
        $this->controller = new AdminTopicsRegistController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_ATRCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_index_001()
    {
        $data = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '02',
                'day' => '26',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test Test_ATRCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_index_002()
    {

        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_ATRCtl_insertData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_insertData_001()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2018',
                'month' => '02',
                'day' => '26',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "insertData", [$topicData]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATRCtl_insertData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_insertData_002()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '26',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "insertData", [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATRCtl_insertData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_insertData_003()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '2',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '26',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "insertData", [$topicData]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATRCtl_validateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_validateData_001()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '26',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "validateData", [$topicData]);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ATRCtl_validateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_validateData_002()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "validateData", [$topicData]);
        $this->assertFalse($result);
    }

    /**
     * Test Test_ATRCtl_insertDB_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_insertDB_001()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "insertDB", [$topicData]);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ATRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_loadData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATRCtl_resetDataForm_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_resetDataForm_001()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '12',
                'minute' => '57'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2015',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATRCtl_resetDataForm_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_resetDataForm_002()
    {
        $this->controller->request->query = array();
        $topicData = [
            'categoryId' => '1',
            'viewFlg' => '1',
            'timerFlg' => '2',
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => ''
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATRCtl_loadBaseData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_loadBaseData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $result = $this->invokeMethod($this->controller, "loadBaseData", array());
        $this->assertNull($result);
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
