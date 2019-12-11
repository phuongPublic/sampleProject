<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\I18n\Time;

/**
 * App\Controller\OpenErrorControllerTest Test Case
 */
class OpenErrorControllerTest extends NoptIntegrationTestCase
{
    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        //normal case
        $this->setSession();
        $this->get($this->testUrl . '?code=1');
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData('openid', 1);
    }
}
