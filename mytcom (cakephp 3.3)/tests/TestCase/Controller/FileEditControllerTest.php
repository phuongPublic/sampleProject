<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FileEditController Test Case
 */
class FileEditControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/Storage/File/List.html'; //通常遷移    
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
            'app.TargetUser'
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
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?ffid=1');
        $this->assertResponseCode(200);
        // post case
        $this->switchDevice(1);
        $data = [
            'file_id' => '1',
            'commit' => 1,
            'file_folder_id' => 1,
            'extension' => 'jpg',
            'name' => 'file name pc update',            
            'file_comment' => 'file comment pc update'                
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals('file name pc update', $result[0]['name']);
        $this->assertEquals('file comment pc update', $result[0]['file_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1'); // リダイレクト先URLの確認

        //case invalid input
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?ffid=1');
        $this->assertResponseCode(200);
        // post case
        $this->switchDevice(1);
        $data = [
            'file_id' => '1',
            'commit' => 1,
            'file_folder_id' => 1,
            'extension' => 'jpg',
            'name' => 'file name pc update 12345678901234567890',
            'file_comment' => 'file comment pc update'
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //case pic_id null
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        //iphone
        $this->switchDevice(2);
        $this->get($this->testUrl. '?ffid=1');
        $this->assertResponseCode(200);
        // post case
        $this->switchDevice(2);
        $data = [
            'file_id' => '1',
            'commit' => 1,
            'file_folder_id' => 1,
            'extension' => 'jpg',
            'name' => 'file name iphone update',            
            'file_comment' => 'file comment iphone update'                
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);

        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals('file name iphone update', $result[0]['name']);
        $this->assertEquals('file comment iphone update', $result[0]['file_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1'); // リダイレクト先URLの確認

        //android
        $this->switchDevice(3);
        $this->get($this->testUrl. '?ffid=1');
        $this->assertResponseCode(200);
        // post case
        $this->switchDevice(3);
        $data = [
            'file_id' => '1',
            'commit' => 1,
            'file_folder_id' => 1,
            'extension' => 'jpg',
            'name' => 'file name android update',            
            'file_comment' => 'file comment android update'                
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);

        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals('file name android update', $result[0]['name']);
        $this->assertEquals('file comment android update', $result[0]['file_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1'); // リダイレクト先URLの確認
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
