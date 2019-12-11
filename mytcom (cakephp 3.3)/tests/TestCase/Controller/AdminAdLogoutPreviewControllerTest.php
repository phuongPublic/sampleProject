<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminAdLogoutPreviewController;

/**
 * App\Controller\AdminAdLogoutPreviewControllerTest Test Case
 */
class AdminAdLogoutPreviewControllerTest extends NoptIntegrationTestCase
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
        $this->controller = new AdminAdLogoutPreviewController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_AALPCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALPCtl_index_001()
    {
        $this->get($this->testUrl . '?adseq=1');
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_AALPCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AALPCtl_index_002()
    {
        $this->get($this->testUrl . '?adseq=');
        $this->assertResponseCode(200);
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
