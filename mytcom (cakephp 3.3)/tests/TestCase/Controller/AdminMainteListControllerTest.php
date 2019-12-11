<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminMainteListController;

/**
 * App\Controller\AdminTopicsListControllerTest Test Case
 */
class AdminMainteListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/admin/mainte/list.html'; //通常遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.Mainte'];
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new AdminMainteListController();
        
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test_AMRCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_index_001()
    {
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test_AMRCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_index_002()
    {
        $this->loadFixtures('Mainte');
        $mainteId = 1;
        $selectYear = 2017;
        $sort = 2;
        $this->get($this->testUrl . '?mainte_id=' . $mainteId . '&mainte_year=' . $selectYear . '&sort=' . $sort);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/mainte/list.html?flg=delete&Year=' . $selectYear . '&sort=' . $sort);
    }
    
    /**
     * Test_AMRCtl_deleteData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_deleteData_001()
    {
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['mainte_year' => 2017, 'sort' => 2];
        $mainteId = 1;
        $this->invokeMethod($this->controller, "deleteData", array($mainteId));
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/mainte/list.html?flg=delete&Year=2017&sort=2');
    }
    
    /**
     * Test_AMRCtl_deleteData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_deleteData_002()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['mainte_year' => 2017, 'sort' => 2];
        $mainteId = 4;
        $this->invokeMethod($this->controller, "deleteData", array($mainteId));
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/mainte/list.html?flg=delete&Year=2017&sort=2');
    }
    
    /**
     * Test_AMRCtl_deleteData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_deleteData_003()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $mainteId = 1;
        $this->invokeMethod($this->controller, "deleteData", array($mainteId));
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/admin/mainte/list.html?flg=delete&Year=&sort=');
    }
    
    /**
     * Test_AMRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_001()
    {
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['mainte_year' => 2017, 'sort' => ''];
            
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }
    
    /**
     * Test_AMRCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_002()
    {
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['mainte_year' => '', 'sort' => 2];
            
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }
    
    /**
     * Test_AMRCtl_loadData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_003()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['mainte_year' => '2017', 'sort' => ''];
            
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }
    
    /**
     * Test_AMRCtl_loadData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_004()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['flg' => 'regist', 'mainte_year' => '2017', 'sort' => ''];
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }
    
    /**
     * Test_AMRCtl_loadData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_005()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['flg' => 'update', 'mainte_year' => '2017', 'sort' => ''];
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }
    
    /**
     * Test_AMRCtl_loadData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_006()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $this->controller->request->query = ['flg' => 'delete', 'mainte_year' => '2017', 'sort' => ''];
        $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
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
