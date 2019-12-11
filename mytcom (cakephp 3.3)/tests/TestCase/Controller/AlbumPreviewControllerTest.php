<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\AlbumPreviewController Test Case
 */
class AlbumPreviewControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = true;
    protected $redirectUrl1 = '/Album/Picture/Delete.html'; //通常遷移
    protected $redirectUrl2 = '/Album/Preview.html'; //検索遷移
    protected $redirectUrl3 = '/Album/Open/Regist.html'; //検索遷移
    

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.OpenStatus',
        'app.TargetUser',        
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     *
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
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?aid=0001');
        $this->assertResponseCode(200);

        //get sort, keyword
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?aid=1&sort=new&keyword=shjfsbfs&src=all&page=1');
        $this->assertResponseCode(200);

          //get sort, keyword
          $this->switchDevice(3);
          $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
          $this->get($this->testUrl . '?aid=1');
          $this->assertResponseCode(200);

        //get sort, keyword
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?aid=1&search=1&fromsrc=1&src=1');
        $this->assertResponseCode(200);

        //keyword too long (65535)
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $keyword = '';
        for ($i = 0; $i <= 65560; $i++) {
            $keyword .= 'a';
        }
        $this->get($this->testUrl . '?keyword=' . $keyword);
        $this->assertResponseCode(302);

        //get from all
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?src=all');
        $this->assertResponseCode(200);

        //search params
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?fromsrc=1');
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $keyword = '';
        for ($i = 0; $i <= 65560; $i++) {
            $keyword .= 'a';
        }
        $data = [
            'keyword' => $keyword
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        $this->setSession();
        //delete file
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => 1,
        ];

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'aid' => 1,
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => 1,
            'open' => 1
        ];

        // a du
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'fromsrc' => 1,
            'open' => 1,
            'aid' => 1
        ];

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //delete file
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => null,
        ];

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // pc open case
        $data = [
            'aid' => '1',
            'fromsrc' => 1,
            'open' => 1,
            'del' => [
                0 => 1,
                1 =>2
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3); // リダイレクト先URLの確認

        $this->switchDevice(1);
        // pc move case
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'remove' => 1,
            'del' => [],
            'album' => '0002',
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?aid=0001');

        //case move picture to another album
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'remove' => 1,
            'del' => [
                0 => 1,
                1 => 2,
            ],
            'folder' => 2,
            'album' => 1,
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?aid=2');

        // android
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?aid=0001&keyword=fjsfjksfjk&src=all&sort=new');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?page=1');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?aid=0001&keyword=fjsfjksfjk&src=all&sort=new');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?page=1');
        $this->assertResponseCode(200);

        // android post
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $data = [
            'sort' => 'old',
            'keyword' => 'picture',
            'aid' => 1,
            'search' => '1',
            'fromsrc' => '1',
            'src' => '1'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //iphone post
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $data = [
            'sort' => 'old',
            'keyword' => 'picture',
            'aid' => 1,
            'search' => '1',
            'fromsrc' => '1',
            'src' => 'all'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        // pc single case
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'singledownload' => 1,
            'picture' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        // pc zipload case
        $this->switchDevice(1);
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'downloadfiles' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        $this->switchDevice(1);
        $data = [
            'aid' => '0001',
            'del' => [1,2],
            'downloadfiles' => 1
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'del' => 1,
            'downloadfiles' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'del' => '',
            'downloadfiles' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?aid=0001');
        $this->assertResponseCode(200);

        // android
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->get($this->testUrl . '?aid=0001');
        $this->assertResponseCode(200);
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'del' => 1,
            'open' => 1
        ];

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // a du
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'fromsrc' => 1,
            'open' => 1,
            'aid' => 1
        ];

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        $this->switchDevice(1);
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'downloadfiles' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // download file
        $this->switchDevice(1);
        $data = [
            'aid' => '0001',
            'fromsrc' => 1,
            'del' => [1,2],
            'downloadfiles' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMorePicture()
    {
        /**
         * GET処理
         */
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMorePicture?page=1');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->get($this->testUrl.'/showMorePicture');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMorePicture?page=1&sort=new');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMorePicture?page=1&sort=new&keyword=ruwfjds');
        $this->assertResponseCode(200);

        //post keyword
        $this->switchDevice(2);
        $data = [
            'keyword' => 'ruwfjds'
        ];
        $this->post($this->testUrl.'/showMorePicture', $data);
        $this->assertResponseCode(200);

        //key aid
        $this->switchDevice(2);
        $this->get($this->testUrl.'/showMorePicture?aid=1&src=all');
        $this->assertResponseCode(200);

        //post aid
        $this->switchDevice(2);
        $data = [
            'aid' => 1,
            'src' => 'all',
            'search' => 'pic'
        ];
        $this->post($this->testUrl.'/showMorePicture', $data);
        $this->assertResponseCode(200);
    }
    
    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('deletefile', array('1'));
    }  

}
