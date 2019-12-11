<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MovieOpenRegistController Test Case
 */
class MovieOpenRegistControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/Address/List.html?'; //通常遷移
    protected $redirectUrl2 = '/Movie/Preview.html?'; //検索遷移
    protected $redirectUrl3 = 'iphone/Movie/Preview.html?';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieContents',
        'app.MovieFolder',
        'app.OpenStatus',
        'app.TargetUser'
    ];

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser');
        $this->switchDevice(1);
        /**
         * GET処理
         */
        $this->setSessionData('mfile_open', array(1, 2));
        $this->get($this->testUrl . '?openflg=4&mid=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        $this->get($this->testUrl . '?mid=100&openflg=5&del[]=1');
        $this->assertResponseCode(302);

        $this->get($this->testUrl . '?mid=1&openflg=5&del[]=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?mid=1&openflg=5&del[]=100');
        $this->assertResponseCode(302);

        //return from addresslist screen
        $this->setOpenDataSession("AddressList");
        $this->get($this->testUrl . '?return=1&mid=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        //return from addresslist screen
        $this->setOpenDataSession("inputdata");
        $this->get($this->testUrl . '?return=1&mid=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        //return when validate fail
        $this->setOpenDataSession("inputdata");
        $this->get($this->testUrl . '?return=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        /**
         * POST処理
         */
        // change to address list screen (non get mail)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_type' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'selection' => 'selection'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        // change to address list screen ( get mail)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_type' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'selection' => 'selection',
            'mail' => array(
                'addr11<addr11@bip.com.vn>',
                'addr12<addr12@bip.com.vn>')
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //click button Open regist for MovieFolder   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '5',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->setSessionData('mfile_open', array(1, 2));
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        $this->_session = [];

        //click button Open regist for movie folder   (validate nickname empty )
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate nickname over max 25 char )
        $data = [
            'nickname' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate message over max 125 char )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' =>
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
             aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate message empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => '',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate close_date empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('unittest@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate mail empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array(),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate mail wrong format )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('mail_wrong'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for movie folder   (validate mail over 10  )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('test1@bip.com.vn', 'test2@bip.com.vn', 'test3@bip.com.vn',
                'test4@bip.com.vn', 'test5@bip.com.vn', 'test6@bip.com.vn',
                'test7@bip.com.vn', 'test8@bip.com.vn', 'test9@bip.com.vn',
                'test10@bip.com.vn', 'test11@bip.com.vn', 'test12@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button back in confirm screen
        $data = [
            'back_confirm' => '戻る',
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('test1@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button commit in confirm screen
        $data = [
            'open_commit' => 'commit',
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => array('test1@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認
    }

    /**
     * Test index method for SP
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexSP()
    {
        $this->switchDevice(2);
        $this->get($this->testUrl . '?mid=1&openflg=5&cid=1');
        $this->assertResponseCode(302);

        //get with data
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser');
        $this->switchDevice(2);
        $this->get($this->testUrl . '?openflg=4&mid=1');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl . '?mid=100&openflg=5&cid=1');
        $this->assertResponseCode(302);

        $this->switchDevice(2);
        $this->get($this->testUrl . '?mid=1&openflg=5&cid=100');
        $this->assertResponseCode(302);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser');
        $this->switchDevice(2);
        $this->setSessionData('mFileId', 1);
        $this->get($this->testUrl . '?openflg=5&mid=1');
        $this->assertResponseCode(200);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser');
        $this->switchDevice(2);
        $this->get($this->testUrl . '?openflg=5&mid=1&cid=1');
        $this->assertResponseCode(200);

         /**
         * POST処理
         */
          $this->switchDevice(2);
        //click button Open regist for movie folder   (validate nickname empty )
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => 'unittest@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        $this->switchDevice(2);
        //click button Open regist for MovieFolder   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => 'unittest@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => '確認画面へ進む'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        $this->switchDevice(2);
        //click button back in confirm screen
        $data = [
            'open_back' => '戻る',
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => 'test1@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

         $this->switchDevice(2);
        //click button commit in confirm screen
        $data = [
            'open_reg' => 'commit',
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '4',
            'movie_folder_id' => '1',
            'mail' => 'test1@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('inputdata', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '4',
                'movie_folder_id' => '1',
                'mail' => 'unittest@bip.com.vn,addr8<addr8@bip.com.vn>',
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
    }

    public function setOpenDataSession($beforeScr = "AddressList")
    {
        // ffidが1番のデータを削除対象とする
        if ($beforeScr == "AddressList") {
            parent::setSessionData('MovieOpenSetting', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '4',
                'movie_folder_id' => '1',
                'mail' => array('unittest@bip.com.vn', 'addr8<addr8@bip.com.vn>', 'addr9<addr9@bip.com.vn>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        } else {
            parent::setSessionData('inputdata', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '4',
                'movie_folder_id' => '1',
                'mail' => array('unittest@bip.com.vn', 'addr8<addr8@bip.com.vn>', 'addr9<addr9@bip.com.vn>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        }
    }
}
