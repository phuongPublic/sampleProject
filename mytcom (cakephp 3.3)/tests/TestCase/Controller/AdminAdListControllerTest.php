<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminAdListController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminAdListControllerTest Test Case
 */
class AdminAdListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/admin/ad/list.html'; //通常遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.AdTbl'];
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('AdTbl');
        $this->controller = new AdminAdListController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_AALCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_index_001()
    {
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_AALCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_index_002()
    {
        $this->get($this->testUrl . '?adseq=1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?flg=delete&selectYear=&sort='); // リダイレクト先URLの確認
    }

    /**
     * Test Test_AALCtl_deleteData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_deleteData_001()
    {
        $adseq = 1;
        $result = $this->invokeMethod($this->controller, 'deleteData', array($adseq));
        $this->assertNotNull($result);
    }

    /**
     * Test Test_AALCtl_deleteData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_deleteData_002()
    {
        $adseq = 1;
        $this->controller->request->query = array('selectYear' => 2017, 'categoryId' => 1, 'sort' => 2);
        $result = $this->invokeMethod($this->controller, 'deleteData', array($adseq));
        $this->assertNotNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_001()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array();
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_002()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array('selectYear' => 2017);
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_003()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array('selectYear' => 2017, 'sort' => 1);
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_004()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array('flg' => 'regist');
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_005()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array('flg' => 'update');
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_loadData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_loadData_006()
    {
        $this->loadFixtures('AdTbl');
        $this->controller->request->query = array('flg' => 'delete');
        $result = $this->invokeMethod($this->controller, 'loadData', array());
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_updateAdStatus_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_updateAdStatus_001()
    {
        $list = array(
            [
                'adseq' => (int) 1,
                'title' => 'Test Ad 02',
                'contents' => 'test ad 02',
                'pub_flg' => (int) 1,
                'pos_flg' => (int) 1,
                'file_path' => null,
                'viewflg' => (int) 1,
                'timerflg' => (int) 1,
                'opendata' => '',
                'timerdata' => $this->makeTimeObj('2017-05-24 00:00:01', 'Asia/Tokyo'),
                'update' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
                'regdate' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
            ],
        );
        $result = $this->invokeMethod($this->controller, 'updateAdStatus', array($list));
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_updateAdStatus_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_updateAdStatus_002()
    {
        $list = array(
            [
                'adseq' => (int) 1,
                'title' => 'Test Ad 02',
                'contents' => 'test ad 02',
                'pub_flg' => (int) 1,
                'pos_flg' => (int) 1,
                'file_path' => null,
                'viewflg' => (int) 2,
                'timerflg' => (int) 1,
                'opendata' => '',
                'timerdata' => $this->makeTimeObj('2017-05-24 00:00:01', 'Asia/Tokyo'),
                'update' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
                'regdate' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
            ],
        );
        $result = $this->invokeMethod($this->controller, 'updateAdStatus', array($list));
        $this->assertNull($result);
    }

    /**
     * Test Test_AALCtl_updateAdStatus_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALCtl_updateAdStatus_003()
    {
        $list = array(
            [
                'adseq' => (int) 1,
                'title' => 'Test Ad 02',
                'contents' => 'test ad 02',
                'pub_flg' => (int) 1,
                'pos_flg' => (int) 1,
                'file_path' => null,
                'viewflg' => (int) 3,
                'timerflg' => (int) 1,
                'opendata' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
                'timerdata' => $this->makeTimeObj('2017-05-24 00:00:01', 'Asia/Tokyo'),
                'update' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
                'regdate' => $this->makeTimeObj('2017-05-24 00:00:00', 'Asia/Tokyo'),
            ],
        );
        $result = $this->invokeMethod($this->controller, 'updateAdStatus', array($list));
        $this->assertNull($result);
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

    protected function setSession()
    {
// ffidが1番のデータを削除対象とする
//parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }

}
