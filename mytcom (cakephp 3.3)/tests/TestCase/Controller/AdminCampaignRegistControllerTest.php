<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminCampaignRegistController;
use Cake\I18n\Time;

/**
 * App\Controller\AdminCampaignRegistControllerTest Test Case
 */
class AdminCampaignRegistControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminCampaignRegistController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_ACRCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_001()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125));
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test Test_ACRCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_index_002()
    {
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_ACRCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_loadForm_001()
    {
        $this->loadFixtures('TopicsTbl');
        $this->controller->request->query = array();
        $result = $this->invokeMethod($this->controller, "loadForm", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ACRCtl_registForm_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_registForm_001()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125));
        $this->controller->request->data = $data;
        $result = $this->invokeMethod($this->controller, "registForm", array());
        $this->assertEquals(302, $result->statusCode());
    }

    /**
     * Test Test_ACRCtl_registForm_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_registForm_002()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => array(
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '15',
                'minute' => '59'),
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => '',
                'type' => '',
                'tmp_name' => '',
                'error' => 4,
                'size' => 0));
        $this->controller->request->data = $data;
        $result = $this->invokeMethod($this->controller, "registForm", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ACRCtl_registForm_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_registForm_003()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => array(
                'year' => '2017',
                'month' => '02',
                'day' => '30',
                'hour' => '15',
                'minute' => '59'
            ),
            'timerFlg' => '1',
            'timerData' => array(
              'year' => '2018',
              'month' => '05',
              'day' => '18',
              'hour' => '15',
              'minute' => '59'
            ),
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125));
        $this->controller->request->data = $data;
        $result = $this->invokeMethod($this->controller, "registForm", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ACRCtl_registForm_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_registForm_004()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.jpeg',
                'error' => 0,
                'size' => 8125));
        $this->controller->request->data = $data;
        $result = $this->invokeMethod($this->controller, "registForm", array());
        $this->assertNull($result);
    }

    /**
     * Test Test_ACRCtl_validateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_validateData_001()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125));
        $result = $this->invokeMethod($this->controller, "validateData", array($data));
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACRCtl_validateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_validateData_002()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => '',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125));
        $result = $this->invokeMethod($this->controller, "validateData", array($data));
        $this->assertFalse($result);
    }

    /**
     * Test Test_ACRCtl_insertData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_ACRCtl_insertData_001()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'windowFlg' => '1',
            'filePath1' => '',
            'banner' => array(
                'name' => 'test.jpeg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\php8D05.tmp',
                'error' => 0,
                'size' => 8125),
            'data' => 'regist');
        $result = $this->invokeMethod($this->controller, "insertData", array($data));
        $this->assertTrue($result);
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
