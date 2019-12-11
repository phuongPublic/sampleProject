<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Aura\Intl\Exception;
use Cake\Network\Exception\NotFoundException;

/**
 * App\Controller\PictureZoomController Test Case
 */
class PictureZoomControllerTest extends NoptIntegrationTestCase
{
    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);

        // android
        $this->switchDevice(3);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
    }
    protected function setSession(){
        //
    }
}