<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminCampaignListController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminCampaignListControllerTest Testcase
 */
class AdminCampaignListControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminCampaignListController();
        
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }
    
    /**
     * Test_ACRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_002()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = array('topicsSeq' => 50);
        $this->_request = $this->controller->request;
        $this->controller->index();
        $this->assertResponseCode(302);
    }
    
    /**
     * Test_ATRCtl_deleteData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ATRCtl_deleteData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['selectYear' => 2017, 'sort' => 2];
        $this->_request = $this->controller->request;
        $topicsSeq = 50;
        $this->invokeMethod($this->controller, "deleteData", array($topicsSeq));
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?flg=delete&selectYear=2017&sort=2');
    }
    
    /**
     * Test_ATRCtl_deleteData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
//    public function Test_ATRCtl_deleteData_002()
//    {
//        $this->loadFixtures('TopicsTbl');
//        $this->_response = $this->controller->response;
//        $this->controller->request->query = ['selectYear' => 2017, 'sort' => 2];
//        $this->_request = $this->controller->request;
//        $topicsSeq = null;
//        
//        $this->invokeMethod($this->controller, "deleteData", array($topicsSeq));
//        $this->assertNoRedirect($this->redirectUrl1 . '?selectYear=2017&sort=2');
//    }
    
    /**
     * Test_ACRCtl_updateCampaignStatus_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateCampaignStatus_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['selectYear' => 2017, 'sort' => 2];
        $this->_request = $this->controller->request;
        $topicsArray = [
            1 => [
                'topicsseq' => 60,
                'categoryid' => 4,
                'title' => 'testUpdate',
                'contents' => 'members',
                'file_path1' => '',
                'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
                'viewflg' => 1,
                'dateviewflg' => null,
                'windowflg' => 1,
                'timerflg' => 1,
                'opendata' => $this->makeTimeObj('2016-05-18 17:03:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-18 17:03:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'update' => '2017-05-18 08:03:16',
                'reguser' => 'admin',
                'regdate' => '2017-05-18 17:03:16',
            ],
        ];
        $result = $this->invokeMethod($this->controller, "updateCampaignStatus", array($topicsArray));
        $this->assertNull($result);
    }
    
    /**
     * Test_ACRCtl_updateCampaignStatus_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateCampaignStatus_002()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['selectYear' => 2017, 'sort' => 2];
        $this->_request = $this->controller->request;
        $topicsArray = [
            1 => [
                'topicsseq' => 61,
                'categoryid' => 4,
                'title' => '',
                'contents' => 'members',
                'file_path1' => '',
                'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
                'viewflg' => 3,
                'dateviewflg' => null,
                'windowflg' => 1,
                'timerflg' => 1,
                'opendata' => $this->makeTimeObj('2016-05-18 17:03:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2019-05-18 17:03:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'update' => '2017-05-18 08:03:16',
                'reguser' => 'admin',
                'regdate' => '2017-05-18 17:03:16',
            ],
        ];
        $result = $this->invokeMethod($this->controller, "updateCampaignStatus", array($topicsArray));
        $this->assertNull($result);
    }
    
    /**
     * Test_ACRCtl_updateCampaignStatus_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_updateCampaignStatus_003()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['selectYear' => 2017, 'sort' => 2];
        $this->_request = $this->controller->request;
        $topicsArray = [
            1 => [
                'topicsseq' => 62,
                'categoryid' => 4,
                'title' => '',
                'contents' => 'members',
                'file_path1' => '',
                'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
                'viewflg' => 2,
                'dateviewflg' => null,
                'windowflg' => 1,
                'timerflg' => 1,
                'opendata' => $this->makeTimeObj('2016-05-18 17:03:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2019-05-18 17:03:00', 'Asia/Tokyo'),
                'updateuser' => 'admin',
                'update' => '2017-05-18 08:03:16',
                'reguser' => 'admin',
                'regdate' => '2017-05-18 17:03:16',
            ],
        ];
        $result = $this->invokeMethod($this->controller, "updateCampaignStatus", array($topicsArray));
        $this->assertNull($result);
    }

    /**
     * Test_ACRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_002()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['selectYear' => 2015];
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_003()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['sort' => 1];
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_004()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['sort' => 1, 'flg' => 'regist'];
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_005()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['sort' => 1, 'flg' => 'update'];
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }
    
    /**
     * Test_ACRCtl_loadData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadData_006()
    {
        $this->loadFixtures('TopicsTbl');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['sort' => 1, 'flg' => 'delete'];
        $this->_request = $this->controller->request;
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
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
    
    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        //parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }

}
