<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\FileOpenRegistControllerTest Test Case
 */
class FileOpenRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Address/List.html?'; //通常遷移
    protected $redirectUrl2 = '/Storage/File/List.html?'; //検索遷移
    protected $redirectUrl3 = '/Storage/File/open/Regist.html?'; //検索遷移
    protected $redirectUrl4 = '/iphone/Storage/File/List.html?';
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
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
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?fid=1&ffid=1');
        $this->assertResponseCode(200);

        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);
        
        $this->get($this->testUrl . '?fid=1&ffid=1');
        $this->assertResponseCode(200);
        
        //back from confirm screen
        $this->setOpenDataSession("inputdata");
        $this->get($this->testUrl . '?return=1&fid=1');
        $this->assertResponseCode(200);
        $this->_session = [];
        
        //back from addresslist screen
        $this->setOpenDataSession("AddressList");
        $this->get($this->testUrl . '?return=1&fid=1');
        $this->assertResponseCode(200);
        $this->_session = [];
        
        //start open regist scr with list file selected
        $this->setSessionData('selected_openstatus_file', array(1,2));
        $this->get($this->testUrl . '?return=1&fid=1');
        $this->assertResponseCode(200);
        $this->_session = [];

        /**
         * POST処理
         */
        $this->switchDevice(1);
        // change to address list screen ( get mail)
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'selection' => 'selection'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        
        // change to address list screen (non get mail)
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'selection' => 'selection'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        
        //click button Open regist   (validate ok)
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_reg' => 'open_file_reg'
            ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        //click button Open regist   (validate fail non selected file )
        $data = [
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_reg' => 'open_file_reg'
            ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        //click button Open regist   (validate fail selected file > 10)
        $data = [
            'selected' => array(1,2,3,4,5,6,7,8,9,10,11,12),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_reg' => 'open_file_reg'
            ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        //click button Open regist   (validate selected file : ok ; nick name empty)
        $data = [
            'selected' => array(1,2),
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_reg' => 'open_file_reg'
            ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        //click button Open regist   (validate all fail - nickname empty; non selected file)
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_reg' => 'open_file_reg'
            ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        // back from confirm scr
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'back_confirm' => 'back_confirm'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3); // リダイレクト先URLの確認
        
        // commit
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_file_commit' => 'open_file_commit'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認
    }

    /**
     * Test index method for SP
     * covers FileOpenRegistControllerTest::index
     * @test
     * @return void
     */
    public function indexSP()
    {
        $this->switchDevice(2);
        /**
         * GET処理
         */
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?fid=1&openflg=2&ffid=1');
        $this->assertResponseCode(200);
        
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $this->switchDevice(2);
        $this->setSessionData('selected_openstatus_file', array(1,2));
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);
        $this->_session = [];
        
        $this->get($this->testUrl . '?fid=0001&openflg=2&ffid=1');
        $this->assertResponseCode(200);
        
         /**
         * POST処理
         */
        $this->switchDevice(2);
        //click button Open regist (validate ok )
        $this->setSessionData('selected_openstatus_file', array(1,2));
        $data = [
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>,addr9<addr9@test.co.jp>',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => 'open_regist'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        $this->_session = [];
        
        $this->switchDevice(2);
        //click button Open regist (validate fail nickname empty )
        $data = [
            'nickname' => '',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'fid' => '1',
            'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>,addr9<addr9@test.co.jp>',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_regist' => 'open_regist'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        $this->switchDevice(2);
        //click button back confirm
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'file_folder_id' => '1',
            'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>,addr9<addr9@test.co.jp>',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_back' => 'open_back'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        //commit
        $this->switchDevice(2);
        $data = [
            'selected' => array(1, 2),
            'nickname' => 'nickname',
            'close_date' => '3',
            'message' => 'new message',
            'access_check' => '0',
            'open_flg' => '2',
            'file_folder_id' => '1',
            'mail' => 'phuongtx@bip.com.vn,addr8<addr8@test.co.jp>,addr9<addr9@test.co.jp>',
            'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
            'open_reg' => 'open_reg'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl4); // リダイレクト先URLの確認
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
    
    public function setOpenDataSession($beforeScr = "AddressList")
    {
        // ffidが1番のデータを削除対象とする
        if ($beforeScr == "AddressList") {
            parent::setSessionData('FileOpenSetting', array(
                'selected' => array(1, 2),
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'open_flg' => '2',
                'fid' => '1',
                'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        } else {
            parent::setSessionData('inputdata', array(
                'selected' => array(1, 2),
                'nickname' => 'nickname',
                'close_date' => '3',
                'message' => 'new message',
                'access_check' => '0',
                'open_flg' => '2',
                'fid' => '1',
                'mail' => array('phuongtx@bip.com.vn', 'addr8<addr8@test.co.jp>', 'addr9<addr9@test.co.jp>'),
                'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp'
            ));
        }
    }
}
