<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminMainteRegistController;

/**
 * App\Controller\AdminTopicsListControllerTest Test Case
 */
class AdminMainteRegistControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminMainteRegistController();

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
        $postData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2019',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test'
        ];
        $this->post($this->testUrl, $postData);
        $this->assertRedirectContains($this->redirectUrl1 . '?flg=regist&Year=2017');
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
        $result = $this->invokeMethod($this->controller, "loadData", array());
        $this->assertResponseCode(200);
    }

    /**
     * Test_AMRCtl_insertData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insertData_001()
    {
        $this->_request = $this->controller->request;
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test'
        ];
        $this->invokeMethod($this->controller, "insertData", array($inputData));
        $this->assertResponseCode(200);
        $this->assertNoRedirect($this->redirectUrl1 . '?flg=regist&Year=2017');
    }

    /**
     * Test_AMRCtl_insertData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insertData_002()
    {
        $this->_request = $this->controller->request;
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => ''
        ];
        $this->invokeMethod($this->controller, "insertData", array($inputData));
        $this->assertResponseCode(200);
        $this->assertNoRedirect($this->redirectUrl1 . '?flg=regist&Year=2017');
    }

    /**
     * Test_AMRCtl_insertData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insertData_003()
    {
        $this->_request = $this->controller->request;
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test'
        ];
        $this->invokeMethod($this->controller, "insertData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=regist&Year=2017');
    }

    /**
     * Test_AMRCtl_insertData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insertData_004()
    {
        $this->_request = $this->controller->request;
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_status' => '4',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test'
        ];
        $result = $this->invokeMethod($this->controller, "insertData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=regist&Year=2017');
    }

    /**
     * Test_AMRCtl_insertData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insertData_005()
    {
        $this->_request = $this->controller->request;
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_status' => '2',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test'
        ];
        $this->invokeMethod($this->controller, "insertData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=regist&Year=2017');
    }

    /**
     * Test_AMRCtl_validateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_001()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
        ];
        $this->assertTrue($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_002()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => '',
        ];
        $this->assertFalse($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_005()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2020',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
        ];
        $this->assertFalse($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_006()
    {
        $inputData = [
            'mainte_status' => '1',
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
        ];
        $this->assertTrue($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_007
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_007()
    {
        $inputData = [
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test',
        ];
        $this->assertTrue($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_008
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_008()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
        ];
        $this->assertFalse($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_validateData_009
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_009()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
        ];
        $this->assertFalse($this->invokeMethod($this->controller, "validateData", array($inputData)));
    }

    /**
     * Test_AMRCtl_resetData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_resetData_001()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test'
        ];
        $this->assertNull($this->invokeMethod($this->controller, "resetData", array($inputData)));
    }

    /**
     * Test_AMRCtl_insert_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_insert_001()
    {
        $inputData = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->invokeMethod($this->controller, "insert", array($inputData)));
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
