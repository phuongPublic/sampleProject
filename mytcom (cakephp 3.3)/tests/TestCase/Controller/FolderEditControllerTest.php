<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\FolderEditController Test Case
 */
class FolderEditControllerTest extends NoptIntegrationTestCase
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
        'app.UserMst',
        'app.OpenStatus',
    ];

    /**
     * Test index method for PC
     * covers FolderEditController::pc
     * @test
     * @return void
     */
    public function index()
    {
        $folderTbl = TableRegistry::get('FileFolderTbl');        

        /**
         * GET処理
         */
        // folder = null
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl');        
        $this->get($this->testUrl. '?fid=1');
        $this->assertResponseCode(200);
        
        // post case
        $this->switchDevice(1);
        $data = [
            'file_folder_name' => 'folder name pc update ',
            'comment' => 'folder comment pc update',
            'commit' => 1,
            'file_folder_id' => 1,            
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);


        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 1);

        $this->assertEquals('folder name pc update ', $result[0]['file_folder_name']);
        $this->assertEquals('folder comment pc update', $result[0]['comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1'); // リダイレクト先URLの確認

        // post case error
        $this->switchDevice(1);
        $data = [
            'file_folder_name' => 'folder name pc update xxxxxxxxxxxxxxxxxxx ',
            'comment' => 'folder comment pc update',
            'commit' => 1,
            'file_folder_id' => 1,
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // post case commit not exist
        $this->switchDevice(1);
        $data = [
            'file_folder_name' => 'folder name pc update',
            'comment' => 'folder comment pc update',
            'file_folder_id' => 1,
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        /**
         * GET処理
         */
        //iphone
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl');         
        $this->get($this->testUrl. '?fid=1');
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);
        $data = [
            'file_folder_name' => 'folder name update iphone',
            'comment' => 'folder comment update iphone',
            'commit' => 1,
            'file_folder_id' => 1,            
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);


        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 1);

        $this->assertEquals('folder name update iphone', $result[0]['file_folder_name']);
        $this->assertEquals('folder comment update iphone', $result[0]['comment']);               
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1'); // リダイレクト先URLの確認   
        
        //android
        $this->switchDevice(3);
        $this->loadFixtures('FileFolderTbl');         
        $this->get($this->testUrl. '?fid=1');
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);
        $data = [
            'file_folder_name' => 'folder name update and',
            'comment' => 'folder comment update and',
            'commit' => 1,
            'file_folder_id' => 1,            
        ];
        $this->loadFixtures('FileFolderTbl');
        $this->post($this->testUrl, $data);

        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 1);

        $this->assertEquals('folder name update and', $result[0]['file_folder_name']);
        $this->assertEquals('folder comment update and', $result[0]['comment']);
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
