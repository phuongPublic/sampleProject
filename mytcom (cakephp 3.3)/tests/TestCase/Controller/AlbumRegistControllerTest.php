<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\AlbumRegistController Test Case
 */
class AlbumRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = true;
    protected $redirectUrl1 = '/Album/List.html'; //通常遷移
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * covers AlbumRegistController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->switchDevice(1);
        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl');  
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // pc post case
        $this->switchDevice(1);        
        $data = [
            'album_name' => 'album name pc',
            'album_comment' => 'album comment pc',           
        ];
        $this->loadFixtures('Album');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // case input valid
        $this->switchDevice(1);
        $data = [
            'album_name' => 'album name pc 12345678901234567890',
            'album_comment' => 'album comment pc',
        ];
        $this->loadFixtures('Album');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl');  
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);        
        $data = [
            'album_name' => 'album name iphone',
            'album_comment' => 'album comment iphone',           
        ];
        $this->loadFixtures('Album');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認 

        // android
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl');  
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);        
        $data = [
           'album_name' => 'album name android',
            'album_comment' => 'album comment android',           
        ];
        $this->loadFixtures('Album');
        $this->post($this->testUrl, $data);
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
        parent::setSessionData('', array());
    }
}
