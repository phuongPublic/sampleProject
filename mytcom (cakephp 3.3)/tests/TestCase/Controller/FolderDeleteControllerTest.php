<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FolderDeleteController Test Case
 */
class FolderDeleteControllerTest extends NoptIntegrationTestCase
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
        'app.TargetUser'
    ];

    /**
     * Test index method for PC
     * @test
     * @return void
     */
    public function index()
    {
        $folderTbl = TableRegistry::get('FileFolderTbl');
        $this->setSession();
        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->get($this->testUrl. '?del[]=3');
        $this->assertResponseCode(200);

        //post case from folder list
        $this->switchDevice(1);
        $data = [
            'keyword' => '',
            'sort_menu' => '',
            'checkbox' => 'on',
            'delete' => 'フォルダの削除',
            'del' => [
                0 => '2',
                1 => '3'
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //no folder selected
        $this->switchDevice(1);
        $data = [
            'keyword' => '',
            'sort_menu' => '',
            'checkbox' => 'on',
            'delete' => 'フォルダの削除',
            'del' => [],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //case folder id = 0001
        $this->switchDevice(1);
        $this->get($this->testUrl. '?del[]=0001');
        $this->assertResponseCode(200);

        // post case
        $this->switchDevice(1);
        $data = [
            'commit' => '削除する',
            'del' => [0 => ''
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 2);
        $flag = false;
        if (empty($result)) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        /**
         * GET処理
         */
        //iphone
        $this->switchDevice(2);
        $this->get($this->testUrl. '?del[]=2');
        $this->assertResponseCode(200);

        // post case
        $this->switchDevice(2);
        $data = [
            'commit' => '削除する',
            'del' => [0 => ''
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 2);
        $flag = false;
        if (empty($result)) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //android
        $this->switchDevice(3);
        $this->get($this->testUrl. '?del[]=2');
        $this->assertResponseCode(200);

        // post case
        $data = [
            'commit' => '削除する',
            'del' => [0 => ''
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $folderTbl->getSingleFolderdata($this->testUserSeq, 2);
        $flag = false;
        if (empty($result)) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('folderDelete', array(2));
    }
}
