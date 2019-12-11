<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PictureEditController Test Case
 */
class PictureEditControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Album/Picture/Detail.html'; //通常遷移

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
     * covers PictureEditController::index
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
        // pc
        $this->switchDevice(1);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);

        $this->setSession();
        // pc post case
        $this->switchDevice(1);
        $data = [
            'pid' => 1,
            'name' => 'picture name pc update',
            'pic_comment' => 'picture comment pc update'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals('picture name pc update', $result[0]['name']);
        $this->assertEquals('picture comment pc update', $result[0]['pic_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?pid=1'); // リダイレクト先URLの確認

        //case errors
        $this->switchDevice(1);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);

        $this->setSession();
        $this->switchDevice(3);
        $data = [
            'pid' => 1,
            'name' => 'picture name pc update 12345678901234567890',
            'pic_comment' => 'picture comment pc update'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
        // pc post case
        $this->switchDevice(2);
        $data = [
            'pid' => 1,
            'pic_name' => 'picture name iphone update',
            'pic_comment' => 'picture comment iphone update'
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals('picture name iphone update', $result[0]['name']);
        $this->assertEquals('picture comment iphone update', $result[0]['pic_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?pid=1'); // リダイレクト先URLの確認

        // android
        $this->switchDevice(3);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
        // android post case
        $this->switchDevice(3);
        $data = [
            'pid' => 1,
            'pic_name' => 'picture name android update',            
            'pic_comment' => 'picture comment android update'                
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals('picture name android update', $result[0]['name']);
        $this->assertEquals('picture comment android update', $result[0]['pic_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?pid=1'); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('pid', '1');
    }

}
