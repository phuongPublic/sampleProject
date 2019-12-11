<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AlbumDeleteController Test Case
 */
class AlbumDeleteControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Album/List.html'; //通常遷移
    
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
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $album = TableRegistry::get('Album');
        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);

        //delete default album
        $this->switchDevice(1);
        $data = [
            'aid' => 2,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // pc post case
        $this->switchDevice(1);        
        $data = [
            'aid' => 2,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser'); 
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 2);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        
        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser'); 
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);        
        $data = [
            'aid' => 2,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser'); 
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 2);
        $this->assertEquals(array(), $result);            
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // android
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser'); 
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);        
        $data = [
            'aid' => 2,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser'); 
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 2);
        $this->assertEquals(array(), $result);            
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
