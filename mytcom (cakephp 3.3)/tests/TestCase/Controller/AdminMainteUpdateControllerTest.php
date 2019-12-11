<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminMainteUpdateController;

/**
 * App\Controller\AdminMainteUpdateControllerTest Test Case
 */
class AdminMainteUpdateControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminMainteUpdateController();

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
        $this->loadFixtures('Mainte');
        $this->get($this->testUrl . '?mainte_id=1&mainte_year=2017&sort=');
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
        $postData = [
            'mainte_id' => 1,
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '20',
                'hour' => '00',
                'minute' => '00'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '20',
                'hour' => '00',
                'minute' => '00'
            ],
            'mainte_body' => 'test',
            'mainte_year' => '2017',
            'sort' => '',
        ];
        $this->post($this->testUrl . '?mainte_id=1&mainte_year=2017&sort=', $postData);
        $this->assertResponseCode(302);
    }

    /**
     * Test_AMRCtl_resetData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_resetData_001()
    {
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
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
        $this->invokeMethod($this->controller, "resetData", array($inputData));
        $this->assertResponseCode(200);
        $this->assertNoRedirect();
    }

    /**
     * Test_AMRCtl_update_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_update_001()
    {
        $this->loadFixtures('Mainte');
        $inputData = [
            'mainte_id' => 1,
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
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->invokeMethod($this->controller, "update", array($inputData)));
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
            'mainte_id' => 1,
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
            'mainte_id' => 1,
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
                'year' => '2015',
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
     * Test_AMRCtl_validateData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_005()
    {
        $inputData = [
            'mainte_id' => 1,
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2010',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2015',
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
     * Test_AMRCtl_validateData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_006()
    {
        $inputData = [
            'mainte_id' => 1,
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2010',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '2',
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
            'mainte_id' => 1,
            'mainte_status' => '1',
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2015',
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
     * Test_AMRCtl_validateData_008
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_validateData_008()
    {
        $inputData = [
            'mainte_id' => 1,
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
            'mainte_id' => 1,
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
     * Test_AMRCtl_updateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_updateData_001()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
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
            'mainte_body' => 'test',
            'mainte_year' => 2017,
            'sort' => 2,
        ];

        $this->invokeMethod($this->controller, "updateData", array($inputData));
        $this->assertResponseCode(200);
        $this->assertNoRedirect($this->redirectUrl1 . '?flg=update&Year=2017&sort=2');
    }

    /**
     * Test_AMRCtl_updateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_updateData_002()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
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
            'mainte_body' => '',
            'mainte_year' => 2017,
            'sort' => 2
        ];

        $this->invokeMethod($this->controller, "updateData", array($inputData));
        $this->assertResponseCode(200);
        $this->assertNoRedirect($this->redirectUrl1 . '?flg=update&Year=2017&sort=2');
    }

    /**
     * Test_AMRCtl_updateData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_updateData_003()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test',
            'mainte_year' => 2017,
            'sort' => 2
        ];

        $this->invokeMethod($this->controller, "updateData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=update&Year=2017&sort=2');
    }

    /**
     * Test_AMRCtl_updateData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_updateData_004()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
            'mainte_status' => '4',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test',
            'mainte_year' => 2017,
            'sort' => 2
        ];

        $this->invokeMethod($this->controller, "updateData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=update&Year=2017&sort=2');
    }

    /**
     * Test_AMRCtl_updateData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_updateData_005()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $inputData = [
            'mainte_id' => 1,
            'mainte_status' => '2',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test',
            'mainte_year' => 2017,
            'sort' => 2
        ];

        $this->invokeMethod($this->controller, "updateData", array($inputData));
        $this->assertResponseCode(302);
        $this->assertRedirect($this->redirectUrl1 . '?flg=update&Year=2017&sort=2');
    }

    /**
     * Test_AMRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_001()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $mainteId = 1;
        $this->invokeMethod($this->controller, "loadData", array($mainteId));
        $this->assertResponseCode(200);
    }

    /**
     * Test_AMRCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AMRCtl_loadData_002()
    {
        $this->loadFixtures('Mainte');
        $this->_response = $this->controller->response;
        $mainteId = 'fakeId';
        $this->invokeMethod($this->controller, "loadData", array($mainteId));
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        
    }

}
