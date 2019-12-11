<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminUserSearchController;

/**
 * App\Controller\AdminTopicsListControllerTest Test Case
 */
class AdminUserSearchControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.UserMst'];
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('UserMst');
        $this->controller = new AdminUserSearchController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_index_001()
    {
        $data = [
            'searchType' => '1',
            'searchKeyword' => 'aabbcc',
            'searchStatus' => '0',
            'searchClass' => '99',
            'searchStartTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '25',
                'hour' => '00',
                'minute' => '00'
            ],
            'searchEndTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '25',
                'hour' => '00',
                'minute' => '00'
            ],
            '_search' => '検索'
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
    public function Test_AUSCtl_index_002()
    {
        $this->get($this->testUrl . "?page=1");
        $this->assertResponseCode(200);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_index_003()
    {
        $this->get($this->testUrl . "?page=2&type=csv");
        $this->assertResponseCode(200);
    }

    /**
     * Test searchProcess method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_searchProcess_001()
    {
        $reqPost = [
            'searchType' => '1',
            'searchKeyword' => '',
            'searchStatus' => '0',
            'searchClass' => '99',
            'matchType' => '1',
            'searchStartTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ],
            'searchEndTime' => [
                'year' => '2018',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "searchProcess", [$reqPost]);
        $this->assertNull($actualResult);
    }

    /**
     * Test pageProcess method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_pageProcess_001()
    {
        $reqGet = [
            'page' => '1'
        ];
        $searchInfo = [
            'searchType' => '1',
            'searchKeyword' => '',
            'searchStatus' => '0',
            'searchClass' => '99',
            'matchType' => '1',
            'searchStartTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ],
            'searchEndTime' => [
                'year' => '2018',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ]
        ];
        $this->controller->request->session()->write('searchInfo', $searchInfo);
        $actualResult = $this->invokeMethod($this->controller, "pageProcess", [$reqGet]);
        $expectedResult = $searchInfo;
        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * Test searchCsvProcess method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_searchCsvProcess_001()
    {
        $reqGet = [
            'page' => '1'
        ];
        ob_start();
        $actualResult = $this->invokeMethod($this->controller, "searchCsvProcess", [$reqGet]);
        ob_end_clean();
        $this->assertNull($actualResult);
    }

    /**
     * Test setDataForView method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUSCtl_setDataForView_001()
    {
        $searchData = [
            'data' => [
                'page' => 1,
                'next' => 2,
                'back' => '',
                'show_data' => [],
                'link_num' => [
                    0 => 1,
                    1 => 2
                ]
            ],
            'searchCount' => 31
        ];
        $searchInfo = [
            'searchType' => '1',
            'searchKeyword' => '',
            'searchStatus' => '0',
            'searchClass' => '99',
            'matchType' => '1',
            'searchStartTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ],
            'searchEndTime' => [
                'year' => '2018',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ]
        ];
        $actualResult = $this->invokeMethod($this->controller, "setDataForView", [$searchData, $searchInfo]);
        $this->assertNull($actualResult);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('searchInfo', [
            'searchType' => '1',
            'searchKeyword' => '',
            'searchStatus' => '0',
            'searchClass' => '99',
            'matchType' => '1',
            'searchStartTime' => [
                'year' => '2017',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ],
            'searchEndTime' => [
                'year' => '2018',
                'month' => '05',
                'day' => '18',
                'hour' => '00',
                'minute' => '00'
            ]
                ]
        );
    }

}
