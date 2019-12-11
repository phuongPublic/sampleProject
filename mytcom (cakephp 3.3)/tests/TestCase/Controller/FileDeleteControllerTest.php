<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FileDeleteController Test Case
 */
class FileDeleteControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Storage/File/List.html'; //通常遷移
    protected $redirectUrl2 = '/Storage/Folder/List.html'; //検索遷移

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
     * covers FileDeleteController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->setSession();
        $picTbl = TableRegistry::get('PicTbl');
        /**
         * GET処理
         */
        // 確認画面処理結果確認(存在しない
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?del[]=0&fid=1&fromsrc=0');
        $this->assertResponseCode(200);
        // 確認画面処理結果確認(存在
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?del[]=1&fid=1&fromsrc=0');
        $this->assertResponseCode(200);

        //case fromsrc=1
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?del[]=1&fid=1&fromsrc=1');
        $this->assertResponseCode(200);

        //case missing query del
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?fid=1&fromsrc=1');
        $this->assertResponseCode(200);

        //case missing fromsrc
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);

        //case missing fid
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?del[]=1&fromsrc=0');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */
        $this->setSession();
        // 処理後結果確認
        $data = [
            'fid' => '0001',
            'fromsrc' => 1,
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        // ※こちらはComponentのdeleteFileData関数をFileComponentTestのテストにて確認出来たなら作成の必要なし 12/06時点で削除できず
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);


        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);
        //case fromsrc  0
        $data = [
            'fid' => '0001',
            'fromsrc' => 0,
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        // ※こちらはComponentのdeleteFileData関数をFileComponentTestのテストにて確認出来たなら作成の必要なし 12/06時点で削除できず
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);


        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //iphone
        $this->switchDevice(2);
        $data = [
            'fid' => '0001',
            'fromsrc' => 0,
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        // ※こちらはComponentのdeleteFileData関数をFileComponentTestのテストにて確認出来たなら作成の必要なし 12/06時点で削除できず
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);


        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //android
        $this->switchDevice(2);
        $data = [
            'fid' => '0001',
            'fromsrc' => 1,
            'commit' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        // ※こちらはComponentのdeleteFileData関数をFileComponentTestのテストにて確認出来たなら作成の必要なし 12/06時点で削除できず
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);


        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('fileDelete', array(1));
    }

}
