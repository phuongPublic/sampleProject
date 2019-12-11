<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FolderRegistController Test Case
 */
class FolderRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Storage/File/List.html'; //通常遷移
    protected $redirectUrl2 = '/Storage/Folder/List.html'; //通常遷移
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.UserMst',
        'app.OpenStatus'
    ];

    /**
     * Test index method for all method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->switchDevice(1);
        /**
         * GET処理
         */
        //PC
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // post case
        $data = [
            'file_folder_name' => 'folder3',
            'comment' => 'folder comment3',
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=3'); // リダイレクト先URLの確認

        //case input invalid
        $this->switchDevice(1);
        $data = [
            'file_folder_name' => 'folder invalid 12345678901234567890',
            'comment' => 'folder comment',
            'commit' => 1,
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //Android
        $this->switchDevice(2);
        /**
         * GET処理
         */
        // 確認画面処理結果確認
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // post case
        $this->switchDevice(2);
        $data = [
            'file_folder_name' => 'folder3',
            'comment' => 'folder album_comment3',
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 ); // リダイレクト先URLの確認

        //Iphone
        $this->switchDevice(3);
        /**
         * GET処理
         */
        // 確認画面処理結果確認
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // post case
        $this->switchDevice(3);
        $data = [
            'file_folder_name' => 'folder4',
            'comment' => 'folder album_comment4',
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認        
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
