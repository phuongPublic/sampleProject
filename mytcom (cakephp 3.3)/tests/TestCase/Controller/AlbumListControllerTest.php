<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AlbumListController Test Case
 */
class AlbumListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.OpenStatus',
        'app.UserMst'
    ];

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        /**
         * GET処理
         */
        // pc data
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // iphone data
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // adnroid
        $this->switchDevice(3);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // android data
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);        
    }

    /**
     * Test showMoreAlbum method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreAlbum()
    {
        
        $this->switchDevice(2);
        /**
         * GET処理
         */
        $this->get($this->testUrl.'/showMoreAlbum?page=1');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->get($this->testUrl.'/showMoreAlbum');
        $this->assertResponseCode(200);  

    }
    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('', array());
    }
}
