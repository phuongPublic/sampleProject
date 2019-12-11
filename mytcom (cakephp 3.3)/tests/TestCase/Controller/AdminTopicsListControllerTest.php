<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminTopicsListController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminTopicsListControllerTest Test Case
 */
class AdminTopicsListControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminTopicsListController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_ATLCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_index_001()
    {
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_ATLCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_index_002()
    {
        $test = $this->get($this->testUrl . '?topicsSeq=2');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?flg=delete&selectYear=&categoryId=&sort='); // リダイレクト先URLの確認
    }

    /**
     * Test Test_ATLCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_002()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('selectYear' => 2020, 'sort' => '1');
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_003()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('categoryId' => 2);
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_004()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('sort' => 2);
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_005()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('flg' => 'regist');
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_006()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('flg' => 'update');
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_loadData_007
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_loadData_007()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array('flg' => 'delete');
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_deleteData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_deleteData_001()
    {
        $topicId = 2;
        $this->controller->request->query = array('selectYear' => 2016, 'categoryId' => 2, 'sort' => 2);
        $result = $this->invokeMethod($this->controller, "deleteData", [$topicId]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATLCtl_deleteData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_deleteData_003()
    {
        $topicId = 2;
        $result = $this->invokeMethod($this->controller, "deleteData", [$topicId]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATLCtl_deleteData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_deleteData_002()
    {
        $topicId = null;
        $result = $this->invokeMethod($this->controller, "deleteData", [$topicId]);
        $this->assertNotNull($result);
    }

    /**
     * Test Test_ATLCtl_updateTopicsStatus_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_updateTopicsStatus_001()
    {
        $topicData = array(
            array(
                'topicsseq' => '2',
                'categoryId' => '1',
                'title' => 'title',
                'contents' => 'contents',
                'filepath1' => 'www.bip.com.vn',
                'viewflg' => '1',
                'dateviewflg' => '',
                'windowflg' => '1',
                'timerflg' => '1',
                'opendata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'reguser' => 'admin',
            ),
        );
        $result = $this->invokeMethod($this->controller, 'updateTopicsStatus', [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_updateTopicsStatus_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_updateTopicsStatus_002()
    {
        $topicData = array(
            array(
                'topicsseq' => '3',
                'categoryId' => '1',
                'title' => 'title',
                'contents' => 'contents',
                'filepath1' => 'www.bip.com.vn',
                'viewflg' => '1',
                'dateviewflg' => '',
                'windowflg' => '1',
                'timerflg' => '3',
                'opendata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'reguser' => 'admin',
            ),
        );
        $result = $this->invokeMethod($this->controller, 'updateTopicsStatus', [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_updateTopicsStatus_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_updateTopicsStatus_003()
    {
        $topicData = array(
            array(
                'topicsseq' => '4',
                'categoryId' => '1',
                'title' => 'title',
                'contents' => 'contents',
                'filepath1' => 'www.bip.com.vn',
                'viewflg' => '3',
                'dateviewflg' => '',
                'windowflg' => '1',
                'timerflg' => '3',
                'opendata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'reguser' => 'admin',
            ),
        );
        $result = $this->invokeMethod($this->controller, 'updateTopicsStatus', [$topicData]);
        $this->assertNull($result);
    }

    /**
     * Test Test_ATLCtl_updateTopicsStatus_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATLCtl_updateTopicsStatus_004()
    {
        $topicData = array(
            array(
                'topicsseq' => '5',
                'categoryId' => '1',
                'title' => 'title',
                'contents' => 'contents',
                'filepath1' => 'www.bip.com.vn',
                'viewflg' => '2',
                'dateviewflg' => '',
                'windowflg' => '1',
                'timerflg' => '2',
                'opendata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-12 00:00:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'reguser' => 'admin',
            ),
        );
        $result = $this->invokeMethod($this->controller, 'updateTopicsStatus', [$topicData]);
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
