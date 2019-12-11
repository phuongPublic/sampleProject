<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AlbumEditController Test Case
 */
class AlbumEditControllerTest extends NoptIntegrationTestCase
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
        'app.UserMst'
    ];

    /**
     * Test index method for all method
     * covers FolderRegistController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $album = TableRegistry::get('Album');  

        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl');
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);
        
        // pc post case
        $data = [
            'aid' => '1',            
            'album_name' => 'album pc name edit',
            'album_comment' => 'album pc comment edit',
        ];
        $this->loadFixtures('Album', 'PicTbl');
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 1);
        $this->assertEquals('album pc name edit', $result[0]['album_name']); 
        $this->assertEquals('album pc comment edit', $result[0]['album_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //valid input case
        $data = [
            'aid' => '1',
            'album_name' => 'album pc name edit 1234567890',
            'album_comment' => 'Album Comment',
        ];
        $this->loadFixtures('Album', 'PicTbl');
        $this->post($this->testUrl, $data);

        $result = $album->getSingleAlbumData($this->testUserSeq, 1);
        $this->assertEquals('Album 1', $result[0]['album_name']);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl');        
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);        
        $data = [
            'aid' => '1',            
            'album_name' => 'album iphone name edit',
            'album_comment' => 'album iphone comment edit',
        ];
        $this->loadFixtures('Album', 'PicTbl');
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 1);
        $this->assertEquals('album iphone name edit', $result[0]['album_name']); 
        $this->assertEquals('album iphone comment edit', $result[0]['album_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認 

        // android
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl');        
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);        
        $data = [
            'aid' => '1',            
            'album_name' => 'album android name edit',
            'album_comment' => 'album android comment edit',
        ];
        $this->loadFixtures('Album', 'PicTbl');
        $this->post($this->testUrl, $data);
        
        $result = $album->getSingleAlbumData($this->testUserSeq, 1);
        $this->assertEquals('album android name edit', $result[0]['album_name']); 
        $this->assertEquals('album android comment edit', $result[0]['album_comment']);
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
