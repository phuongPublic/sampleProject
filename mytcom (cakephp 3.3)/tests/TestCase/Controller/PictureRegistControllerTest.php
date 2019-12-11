<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PictureRegistController Test Case
 */
class PictureRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Album/Picture/Regist.html'; //通常遷移
    protected $redirectUrl2 = '/Album/Preview.html'; //検索遷移

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
     * covers PictureRegistController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->setSession();
        /**
         * GET処理
        //         */
        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?aid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */
        // pc file name invalid checkTraversal
        $this->switchDevice(1);
        $data = [
            'album_id' => 1,
            'fileId' => '$$',
            'fileSize' => 1000,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?aid=1'); // リダイレクト先URLの確認
        //no file was upload
        $data = [
            'album_id' => 1,
            'title' => [],
            'fileId' => []
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // file upload > 10
        $data = [
            'album_id' => 1,
            'fileSize' => [1,1,1,1,1,1,1,1,1,1,1],
            'title' => ['Title added 1','','','','','','','','','',''],
            'description' => ['Comment added  1', '', '', '', '', '', '', '', '', '', ''],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png', 'Picture added 2.png', 'Picture added 3.png', 'Picture added 4.png', 'Picture added 5.png', 'Picture added 6.png', 'Picture added 7.png', 'Picture added 8.png', 'Picture added 9.png', 'Picture added 10.png', 'Picture added 11.png',],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939', 'o_1b3u8ovra2b6j7b18eqbl8eba'],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //title contain path characters
        $this->switchDevice(1);
        $data = [
            'album_id' => 1,
            'title' => ['/wrong title'],
            'fileName' => ['file name'],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939'],
            'fileSize' => [4244]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //fileName contain path characters
        $this->switchDevice(1);
        $data = [
            'album_id' => 1,
            'title' => ['title'],
            'fileName' => ['/wrong file name'],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939'],
            'fileSize' => [4244]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //title > 125 characters
        $data = [
            'album_id' => 1,
            'title' => ['title too long 234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'],
            'fileName' => ['file name'],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939'],
            'fileSize' => [4244]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //comment > 1000
        $description = '';
        for ($i = 0; $i < 1002; $i++) {
            $description .= 'a';
        }
        $data = [
            'album_id' => 1,
            'title' => ['title'],
            'fileName' => ['file name'],
            'description' => [$description],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939'],
            'fileSize' => [4244]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //upload max > 100MB
        $data = [
            'album_id' => 1,
            'title' => ['title1', 'title2'],
            'fileName' => ['file name1.png', 'file name2.png'],
            'description' => ['description1', 'description2'],
            'fileId' => ['o_100aaaaaaaaaa', 'o_100bbbbbbbbbb'],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //upload size + usedsize > 50GB
        $data = [
            'album_id' => 1,
            'title' => ['title2'],
            'fileName' => ['file name2.png', 'file name3.png'],
            'description' => ['description2', 'description3'],
            'fileId' => ['o_100bbbbbbbbbb', 'o_100cccccccccc'],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //type is not image, change exe to image
        $data = [
            'album_id' => 1,
            'title' => ['title'],
            'fileName' => ['file_name.png'],
            'description' => ['description'],
            'fileId' => ['o_xxxxxxxxxx'],
            'fileSize' => [1]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //correct data
        $data = [
            'album_id' => 1,
            'title' => ['title'],
            'fileName' => ['file_name.png'],
            'description' => ['description'],
            'fileId' => ['o_12345678901234567890'],
            'fileSize' => [1]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);

        //correct data not title
        $data = [
            'album_id' => 1,
            'title' => [''],
            'fileName' => ['file_name.png'],
            'description' => ['description'],
            'fileId' => ['o_987654321987654321'],
            'fileSize' => [1]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);
/*
        //correct data rename fail, set permission deny in OS for file
        $data = [
            'album_id' => 1,
            'title' => [''],
            'fileName' => ['file_name.png'],
            'description' => ['description'],
            'fileId' => ['o_abc123abc123'],
            'fileSize' => [1]
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);
*/
        //iphone dont select file
        $this->switchDevice(2);
        $data = [
            'fileUploadFlg' => 1,
            'album_id' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //android dont select file
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'album_id' => 1,
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //android file wrong type, wrong size
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'selalbm' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.abc',
                'type' => 'image/abc',
                'size' => 104857601
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);

        //wrong size
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'selalbm' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.png',
                'type' => 'image/png',
                'size' => 104857601
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);

        //wrong type only
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'selalbm' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.abc',
                'type' => 'image/abc',
                'size' => 1
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);

        //over 50GB
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'selalbm' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.png',
                'type' => 'image/png',
                'size' => 53687091201
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);

        //true data iphone
        $this->switchDevice(2);
        $data = [
            'fileUploadFlg' => 1,
            'selalbm' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name iphone',
                'name' => 'file.png',
                'type' => 'image/png',
                'size' => 1
            ],
        ];
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // faidが1番のデータを削除対象とする
        parent::setSessionData('fileDelete', array(1));
    }

}
