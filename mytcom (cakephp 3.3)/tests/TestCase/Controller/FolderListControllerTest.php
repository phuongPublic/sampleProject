<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\FolderListController Test Case
 */
class FolderListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Storage/Folder/List.html'; //通常遷移
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
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
        $this->setSession();
        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');
        $this->get($this->testUrl.'?sort=new');
        $this->assertResponseCode(200);
                
        /**
         * GET処理
         */
        //android
        $this->switchDevice(2);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        //android
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        //iphone
        $this->switchDevice(3);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        //iphone
        $this->switchDevice(3);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');          
        $this->get($this->testUrl);
        $this->assertResponseCode(200);         
    }

    /**
     * Test showMoreFolder method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreFolder()
    {

        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMoreFolder?page=1&sort=new');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->get($this->testUrl.'/showMoreFolder');
        $this->assertResponseCode(200);

    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('folderDelete', array(1));
    }
}
