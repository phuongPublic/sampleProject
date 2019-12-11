<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\MFolderListControllerTest Case
 */
class MFolderListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
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
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $movieFolderTbl->deleteAll([
            'user_seq' => $this->testUserSeq
        ]);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        /**
         * GET処理
         */
        // pc data
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // iphone data
        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // android
        $this->switchDevice(3);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // android data
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);        
    }

    /**
     * Test showMoreMovieFolder method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreMovieFolder()
    {
        
        $this->switchDevice(2);
        /**
         * GET処理
         */
        $this->get($this->testUrl.'/showMoreMovieFolder?page=1');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->get($this->testUrl.'/showMoreMovieFolder');
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
