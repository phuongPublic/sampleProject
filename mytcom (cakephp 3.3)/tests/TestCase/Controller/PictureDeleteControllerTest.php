<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PictureDeleteController Test Case
 */
class PictureDeleteControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Album/List.html'; //通常遷移
    protected $redirectUrl2 = '/Album/Preview.html'; //通常遷移

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
     * covers PictureDeleteController::index
     * @test
     * @return void
     */
    public function index()
    {
        $picTbl = TableRegistry::get('PicTbl');         
        /**
         * GET処理
         */
        // get from picture detail
        /*
        $this->switchDevice(1);
        $picDelete = [
            'fromsrc' => '0',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
*/
        // get missing pid
        $this->switchDevice(1);
        $picDelete = [
            'fromsrc' => '0',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        //get from search all album
        $this->switchDevice(1);
        $picDelete = [
            'fromsrc' => '1',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);

        // pc post case delete one picture from picture detail
        $this->switchDevice(1);
        $data = [
            'fromsrc' => 0,
            'del' => [0 => 1]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $flag = false;
        if (empty($result)) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // pc post case delete multi pictures fromsrc = 1
        $this->switchDevice(1);
        $data = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $picDelete = [
            'fromsrc' => '1',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // iphone
        $this->switchDevice(2);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
        // iphone post case fromsrc = 0
        $this->switchDevice(2);
        $data = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $picDelete = [
            'fromsrc' => '1',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        // iphone post case fromsrc = 0
        $this->switchDevice(2);
        $data = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $picDelete = [
            'fromsrc' => '0',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認

        // android
        $this->switchDevice(3);
        $this->get($this->testUrl. '?pid=1');
        $this->assertResponseCode(200);
        // android post case fromsrc = 1
        $this->switchDevice(3);
        $data = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $picDelete = [
            'fromsrc' => '1',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        // android post case fromsrc = 0
        $this->switchDevice(3);
        $data = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $picDelete = [
            'fromsrc' => '1',
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        parent::setSessionData('pic_delete', $picDelete);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
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
        parent::setSessionData('del', array(1,2));
    }

}
