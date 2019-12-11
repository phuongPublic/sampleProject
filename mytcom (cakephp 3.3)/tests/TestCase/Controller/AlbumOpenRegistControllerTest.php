<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AlbumOpenRegistController Test Case
 */
class AlbumOpenRegistControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/Address/List.html?'; //通常遷移
    protected $redirectUrl2 = '/Album/Preview.html?'; //検索遷移
    protected $redirectUrl3 = 'iphone/Album/Preview.html?';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.OpenStatus',
        'app.TargetUser'
    ];

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexPc()
    {
        $this->switchDevice(1);
        /**
         * GET処理
         */
        //
        $this->get($this->testUrl . '?openflg=1&aid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3&del[]=1');
        $this->assertResponseCode(200);

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser');
        $this->get($this->testUrl . '?openflg=1&aid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3&del[]=1');
        $this->assertResponseCode(200);

        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser');
        $this->setSessionData('pic_open', array(1, 2));

        $this->get($this->testUrl . '?openflg=1&aid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3&del[]=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        //return from addresslist screen
        $this->setOpenDataSession("AddressList");
        $this->get($this->testUrl . '?return=1&aid=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        //return from addresslist screen
        $this->setOpenDataSession("inputdata");
        $this->get($this->testUrl . '?return=1&aid=1');
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
            'open_flg' => '1',
            'album_id' => '1',
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
            'open_flg' => '1',
            'album_id' => '1',
            'selection' => 'selection',
            'mail' => array(
                'addr11<addr11@test.co.jp>',
                'addr12<addr12@test.co.jp>')
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        //click button Open regist for Album   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for picture   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '3',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->setSessionData('pic_open', array(1, 2));
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        $this->_session = [];

        //click button Open regist for album   (validate nickname empty )
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate nickname over max 25 char )
        $data = [
            'nickname' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate message over max 125 char )
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
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate message empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => '',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate close_date empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate close_date # [1,4] )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '5',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('phuongtx@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate mail empty )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array(),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate mail wrong format )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('mail_wrong'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //click button Open regist for album   (validate mail over 10  )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '1',
            'message' => 'message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('test1@bip.com.vn', 'test2@bip.com.vn', 'test3@bip.com.vn',
                'test4@bip.com.vn', 'test5@bip.com.vn', 'test6@bip.com.vn',
                'test7@bip.com.vn', 'test8@bip.com.vn', 'test9@bip.com.vn',
                'test10@bip.com.vn', 'test11@bip.com.vn', 'test12@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('test1@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => array('test1@bip.com.vn'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
         //click button Open regist for picture  session (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '3',
            'album_id' => '1',
            'mail' => 'phuongtx@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => '確認画面へ進む'
        ];
        $this->setSessionData('picID', 1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        $this->_session = [];
        
        $this->switchDevice(2);
        /**
         * GET処理
         */
        //get with non data
        //return from confirm screen
        $this->setSessionData('inputdata', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '3',
                'album_id' => '1',
                'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>',
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        
        $this->setSessionData('picID', 1);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        $this->_session = [];
        
        $this->switchDevice(2);
        $this->get($this->testUrl . '?aid=1&openflg=3&pid=1');
        $this->assertResponseCode(200);
        
        $this->get($this->testUrl . '?openflg=1&aid=1');
        $this->assertResponseCode(200);

        //get with data
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'TargetUser');
        $this->get($this->testUrl . '?openflg=1&aid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?aid=1&openflg=3&pid=1');
        $this->assertResponseCode(200);

         /**
         * POST処理
         */
          $this->switchDevice(2);
        //click button Open regist for album   (validate nickname empty )
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => 'phuongtx@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        $this->switchDevice(2);
        //click button Open regist for Album   (validate ok)
        $data = [
            'nickname' => 'Test',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'target_id' => '1',
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => 'phuongtx@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => '確認画面へ進む'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => 'test1@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
            'open_flg' => '1',
            'album_id' => '1',
            'mail' => 'test1@bip.com.vn',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
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
                'open_flg' => '1',
                'album_id' => '1',
                'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>',
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
    }

    public function setOpenDataSession($beforeScr = "AddressList")
    {
        // ffidが1番のデータを削除対象とする
        if ($beforeScr == "AddressList") {
            parent::setSessionData('AlbumOpenSetting', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '1',
                'album_id' => '1',
                'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        } else {
            parent::setSessionData('inputdata', array(
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'target_id' => '1',
                'open_flg' => '1',
                'album_id' => '1',
                'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        }
    }
}
