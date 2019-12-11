<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminUserDetailController;

/**
 * App\Controller\AdminTopicsListControllerTest Test Case
 */
class AdminUserDetailControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminUserDetailController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUDCtl_index_001()
    {
        $this->get($this->testUrl . "?userSeq=385cd85a14bb90c754897fd0366ff266");
        $this->assertResponseCode(200);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AUDCtl_index_002()
    {
        $this->get($this->testUrl . "?userSeq=100008d2cb4ee7be892842109e891e71");
        $this->assertResponseCode(200);
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
