<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminTopicsUpdateController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminTopicsUpdateControllerTest Test Case
 */
class AdminTopicsUpdateControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminTopicsUpdateController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_ATUCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_index_001()
    {
        $data = [
            'topicsSeq' => '2',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test Test_ATUCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_index_002()
    {

        $this->get($this->testUrl . '?topicsSeq=2');
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_ATUCtl_index_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_index_003()
    {

        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_ATUCtl_updateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_updateData_001()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "updateData", [$data]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATUCtl_insertData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_updateData_002()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
                'day' => '30',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "updateData", [$data]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_validateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_validateData_001()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "validateData", [$data]);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ATUCtl_validateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_validateData_002()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
                'day' => '30',
                'hour' => '12',
                'minute' => '57'
            ],
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "validateData", [$data]);
        $this->assertFalse($result);
    }

    /**
     * Test Test_ATUCtl_updateDB_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_updateDB_001()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "updateDB", [$data]);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ATUCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_loadData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $topicId = 2;
        $result = $this->invokeMethod($this->controller, "loadData", [$topicId]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_loadData_002()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $topicId = null;
        $result = $this->invokeMethod($this->controller, "loadData", [$topicId]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_resetDataForm_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_resetDataForm_001()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$data]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_resetDataForm_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_resetDataForm_002()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
            'categoryId' => '1',
            'viewFlg' => '1',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$data]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_resetDataForm_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_resetDataForm_003()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
            'categoryId' => '1',
            'viewFlg' => '1',
            'timerFlg' => '3',
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
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$data]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_resetDataForm_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_resetDataForm_004()
    {
        $this->controller->request->query = array();
        $data = [
            'topicsSeq' => '2',
            'categoryId' => '1',
            'viewFlg' => '1',
            'timerFlg' => '2',
            'dateViewFlg' => '1',
            'title' => 'fa',
            'contents' => '',
            'windowFlg' => '1',
            'filePath1' => '',
            'selectYear' => '2017',
            'sort' => '2',
        ];
        $result = $this->invokeMethod($this->controller, "resetDataForm", [$data]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATUCtl_loadBaseData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATUCtl_loadBaseData_001()
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
