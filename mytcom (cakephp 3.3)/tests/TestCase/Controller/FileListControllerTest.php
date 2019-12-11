<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\FileListController Test Case
 */
class FileListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Storage/File/Delete.html'; //削除遷移
    protected $redirectUrl2 = '/Storage/File/List.html'; //削除遷移
    protected $redirectUrl3 = '/Storage/Folder/List.html'; //削除遷移
    protected $redirectUrl4 = '/Storage/File/Open/Regist.html'; //削除遷移

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
     * covers FileListController::pc
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?src=old&keyword=x&search=x&sort=desc');
        $this->assertResponseCode(200);

        //fromsrc=1
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fromsrc=1&keyword=x&search=x');
        $this->assertResponseCode(200);

        //seting keyword limit = 10
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fid=1&keyword=12345678901');
        $this->assertResponseCode(200);

        //src=all fid exist
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fid=1&src=all');
        $this->assertResponseCode(200);

        //keyword post
        $this->switchDevice(1);
        $data = [
            'fromsrc' => 1,
            'keyword' => '123456789011',
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //pc delete method
        $this->switchDevice(1);
        $data = [
            'deletefile' => 1,
            'del' => 1,
            'fromsrc' => 1,
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?fromsrc=1&fid=1'); // リダイレクト先URLの確認

        //pc delete method del not exist
        $this->switchDevice(1);
        $data = [
            'deletefile' => 1,
            'folder' => 2,
            'fid' => 1,
            'del' => '',
            'fromsrc' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=1'); // リダイレクト先URLの確認

        //pc remove change folder
        $this->switchDevice(1);
        $data = [
            'remove' => 1,
            'fromsrc' => 1,
            'fid' => 2,
            'del' => 1,
            'folder' => 2,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=2'); // リダイレクト先URLの確認

        //pc open
        $this->switchDevice(1);
        $data = [
            'open' => 1,
            'fid' => 1,
            'del' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl4 . '?fid=1'); // リダイレクト先URLの確認

        /**
         * GET処理
         */
        //iphone
        $this->setSession();
        $this->switchDevice(2);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?src=all&keyword=x&search=x&sort=desc');
        $this->assertResponseCode(200);

        //fromsrc=1
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fromsrc=1&keyword=x&search=x');
        $this->assertResponseCode(200);

        //seting keyword limit = 10
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fid=1&keyword=12345678901');
        $this->assertResponseCode(200);

        //src=all fid exist
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fid=1&src=all');
        $this->assertResponseCode(200);

        //src=all fid exist
        $this->switchDevice(2);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?fid=1&src=all$fromsrc=1');
        $this->assertResponseCode(200);
        //keyword post
        $this->switchDevice(2);
        $data = [
            'fromsrc' => 1,
            'keyword' => '123456789011',
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        //iphone delete  fid not exist
        $this->switchDevice(2);
        $data = [
            'deletefile' => 1,
            'file_id' => '1,',
            'fid' => '',
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3); // リダイレクト先URLの確認

        //iphone delete  fid exist
        $this->switchDevice(2);
        $data = [
            'deletefile' => 1,
            'file_id' => 1,
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=1'); // リダイレクト先URLの確認

        //iphone delete  file_id not exist
        $this->switchDevice(2);
        $data = [
            'deletefile' => 1,
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=1'); // リダイレクト先URLの確認

        //keyword post
        $this->switchDevice(2);
        $data = [
            'fromsrc' => 1,
            'keyword' => '123456789011',
            'fid' => 1,
        ];
        //iphone open
        $this->switchDevice(2);
        $data = [
            'open' => 1,
            'fid' => 1,
            'file_id' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl4 . '?fid=1'); // リダイレクト先URLの確認

        //iphone remove change folder
        $this->switchDevice(2);
        $data = [
            'remove' => 1,
            'fromsrc' => 1,
            'fid' => 2,
            'folder' => 2,
            'del' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=2'); // リダイレクト先URLの確認

        //iphone remove = 2 change folder
        $this->switchDevice(2);
        $data = [
            'remove' => 2,
            'file_list' => 1,
            'folder' => 2,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=2'); // リダイレクト先URLの確認
/*
        //iphone remove = 2 change folder
        $this->switchDevice(2);
        $data = [
            'remove' => 2,
            'file_list' => [2,1],
            'folder' => 2,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=2'); // リダイレクト先URLの確認
*/
        //iphone delete  fid exist
        $this->switchDevice(2);
        $data = [
            'deletefile' => '1,',
            'file_id' => 1,
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?fid=1'); // リダイレクト先URLの確認

        //pc zipDownload del not exist
        $this->switchDevice(1);
        $data = [
            'downloadfiles' => 1,
            'del' => '',
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //pc zipDownload
        $this->switchDevice(1);
        $data = [
            'downloadfiles' => 1,
            'del' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //pc single download change file exist logic file
        $this->switchDevice(1);
        $data = [
            'singledownload' => 1,
            'file' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }
    /**
     * Test showMoreFile method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreFile()
    {
        //keyword post
        $this->switchDevice(2);
        $data = [
            'fromsrc' => 1,
            'keyword' => '123456789011',
            'fid' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl.'/showMoreFile', $data);
        $this->assertResponseCode(200);
        /**
         * GET処理
         */
        //
        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMoreFile?fid=1&page=1&fid=1&src=all');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMoreFile?fid=1&page=1&fid=1&src=all&sort=1&search=1&fromsrc=1');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMoreFile?fid=1&page=1$search=xx');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->get($this->testUrl.'/showMoreFile?fid=1&page=1$sort=old&keyword=xxx');
        $this->assertResponseCode(200);

    }
    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('message', 'message');
    }
}
