<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MovieRegistController Test Case
 */
class MovieRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Movie/Contents/Regist.html';
    protected $redirectUrl2 = '/Movie/Preview.html';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.EncodeRequest',
        'app.OpenStatus',
        'app.TargetUser',
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * covers MovieRegistController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->setSession();
        /**
         * GET処理
         * //         */
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */
        //not set movie_folder_id
        $this->switchDevice(1);
        $data = [
            'title' => 'title',
            'fileName' => 'file name',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //no file upload
        $this->switchDevice(1);
        $data = [
            'movie_folder_id' => 1,
            'title' => 'title',
            'fileName' => 'file name',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);
        /*
                        // pc file name invalid checkTraversal
                        $this->switchDevice(1);
                        $data = [
                            'movie_folder_id' => 1,
                            'title' => 'title',
                            'fileName' => 'file name',
                            'fileId' => 'o_@@@@@',
                        ];
                        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
                        $this->post($this->testUrl, $data);

                        $this->assertResponseCode(302);
                        $this->assertRedirectContains($this->redirectUrl1 . '?mid=1');

        */
        //title contain path characters
        $this->switchDevice(1);
        $data = [
            'movie_folder_id' => 1,
            'title' => '/wrong title',
            'fileName' => 'file name',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //fileName contain path characters
        $this->switchDevice(1);
        $data = [
            'movie_folder_id' => 1,
            'title' => 'title',
            'fileName' => '/wrong file name',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //title > 125 characters
        $data = [
            'movie_folder_id' => 1,
            'title' => 'title too long 234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
            'fileName' => 'file name',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //comment > 1000
        $description = '';
        for ($i = 0; $i < 1002; $i++) {
            $description .= 'a';
        }
        $data = [
            'movie_folder_id' => 1,
            'title' => 'title',
            'fileName' => 'file name',
            'description' => $description,
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //title has space
        $data = [
            'movie_folder_id' => 1,
            'title' => ' ',
            'fileName' => 'file name',
            'description' => 'comment',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //movie folder not exists
        $data = [
            'movie_folder_id' => 9999,
            'title' => 'test',
            'fileName' => 'file name',
            'description' => 'comment',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //extension not allow
        $data = [
            'movie_folder_id' => 1,
            'title' => 'test',
            'fileName' => 'file name.mp3',
            'description' => 'comment',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //nomal case
        $data = [
            'movie_folder_id' => 1,
            'title' => 'test',
            'fileName' => 'file name.mp4',
            'description' => 'comment',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);

        //over movie upload size 200MB
        $oldFile = '/home/personaltool2/storage/00002/385cd85a14bb90c754897fd0366ff266/temp/0000000011/encode_movie/original/encoding_movie';
        $newFile = '/home/200';
        rename($newFile, $oldFile);
        $data = [
            'movie_folder_id' => 1,
            'title' => 'test',
            'fileName' => 'file name.mp4',
            'description' => 'comment',
            'fileId' => 'o_1b3u8ovrahi0ac51d5h1prqe939',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);
 
        //iphone dont select file
        $this->switchDevice(2);
        $data = [
            'movie_folder_id' => 1,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //android dont select file
        $this->switchDevice(3);
        $data = [
            'movie_folder_id' => 1,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //android file wrong size > 200MB
        $this->switchDevice(3);
        $data = [

            'movie_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.mp4',
                'type' => 'video/mp4',
                'size' => 204800001
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        /*
                //over 50GB
                $this->switchDevice(3);
                $data = [
                    'movie_folder_id' => 1,
                    'fileInput' => [
                        'tmp_name' => 'file tmp_name android',
                        'name' => 'file.mp4',
                        'type' => 'video/mp4',
                        'size' => 204799999
                    ],
                ];
                $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
                $userMst = TableRegistry::get('UserMst');
                $user = $userMst->find()
                    ->where(['user_seq' => $this->testUserSeq])
                    ->first();
                $user->album_size = 53687091200;
                $user->file_size = 53687091200;
                $user->movie_size = 53687091200;
                $userMst->save($user, ['atomic' => false]);
                $this->post($this->testUrl, $data);
                $this->assertResponseCode(302);
        */
        //wrong type only
        $this->switchDevice(3);
        $data = [
            'movie_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.abc',
                'type' => 'video/hkt',
                'size' => 1
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //input name > 125
        $this->switchDevice(3);
        $data = [
            'movie_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'title too long 234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890.mp4',
                'type' => 'video/mp4',
                'size' => 1
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //wrong type only
        $this->switchDevice(3);
        $data = [
            'movie_folder_id' => 999,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.mp4',
                'type' => 'video/mp4',
                'size' => 1
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //file upload not found
        $this->switchDevice(2);
        $data = [
            'movie_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => '/home/abcxyz',
                'name' => 'file.mp4',
                'type' => 'video/mp4',
                'size' => 1
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);

        //true data iphone
        $this->switchDevice(2);
        $data = [
            'movie_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => '/home/personaltool2_movie_branch/src/personaltool2/tests/TestCase/movie/file_tmp_name_iphone',
                'name' => 'file.mp4',
                'type' => 'video/mp4',
                'size' => 1
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // fmidが1番のデータを削除対象とする
        parent::setSessionData('fileDelete', array(1));
    }

}
