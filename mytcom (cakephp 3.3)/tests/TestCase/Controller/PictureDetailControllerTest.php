<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PictureDetailController Test Case
 */
class PictureDetailControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/album/list.html'; //通常遷移

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
     * covers PictureDetailController::index
     * @test
     * @return void
     */
    public function index()
    {
        //pc get no pid
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);

        //pc get invalid pid
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?pid=abc');
        $this->assertResponseCode(302);

        //post download picture
        $data = [
            'picture' => 1,
            'prev_page' => '',
            'remove' => '',
            'folder' => '',
            'delete' => '',
            'del' => [0 => 28]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // pc data
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?pid=1&sort=old');
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);

        // iphone data
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');            
        $this->get($this->testUrl . '?pid=1&sort=old');
        $this->assertResponseCode(200);

        // iphone pid not exist
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');        
        $this->get($this->testUrl . '?pid=abc&sort=old');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // iphone alnumInfo not exist
        $this->switchDevice(2);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');        
        $this->get($this->testUrl . '?pid=1&sort=old');
        $this->assertResponseCode(200);

        // android
        $this->switchDevice(3);
        $this->get($this->testUrl);
        $this->assertResponseCode(302);

        // android data
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');            
        $this->get($this->testUrl . '?pid=1&sort=old');
        $this->assertResponseCode(200);

        // android pid not exist
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');        
        $this->get($this->testUrl . '?pid=abc&sort=old');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // android alnumInfo not exist
        $this->switchDevice(3);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');        
        $this->get($this->testUrl . '?pid=1&sort=old');
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
    }

}
