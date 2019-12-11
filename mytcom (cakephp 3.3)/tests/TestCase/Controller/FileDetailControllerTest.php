<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FileDetailController Test Case
 */
class FileDetailControllerTest extends NoptIntegrationTestCase
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
        'app.UserMst',
    ];

    /**
     * Test index method for PC
     * covers FileDetailController::index
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // iphone data sort = old
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');        
        $this->get($this->testUrl . '?ffid=1&sort=old');
        $this->assertResponseCode(200);

        // iphone data sort not exist
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');
        $this->get($this->testUrl . '?ffid=1&sort=');
        $this->assertResponseCode(200);
        /**
         * GET処理
         */
        // android
        $this->switchDevice(3);
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // android data sort = old
        $this->switchDevice(3);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');
        $this->get($this->testUrl . '?ffid=1&sort=old');
        $this->assertResponseCode(200);

        // android data sort not exist
        $this->switchDevice(3);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst');
        $this->get($this->testUrl . '?ffid=1&sort=');
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
