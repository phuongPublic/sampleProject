<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MovieDetailController Test Case
 */
class MovieDetailControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Movie/list.html'; //通常遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.OpenStatus',
        'app.TargetUser',
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * covers MovieDetailController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->switchDevice(1);
        /**
         * GET処理
         */
        //pc get no cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        //pc get invalid cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=abc');
        $this->assertResponseCode(302);

        //pc get valid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */

        //post download movie (folder was public)
        $data = [
            'movieId' => 1,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder was not public and movie is public)
        $data = [
            'movieId' => 2,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder not exist)
        $data = [
            'movieId' => 7,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        /**
         * GET処理
         */
        //pc get no cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        //pc get invalid cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=abc');
        $this->assertResponseCode(302);

        //pc get valid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */

        //post download movie (folder was public)
        $data = [
            'movieId' => 1,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder was not public and movie is public)
        $data = [
            'movieId' => 2,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder not exist)
        $data = [
            'movieId' => 7,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //Android
        $this->switchDevice(3);
        /**
         * GET処理
         */
        //pc get no cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        //pc get invalid cid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=abc');
        $this->assertResponseCode(302);

        //pc get valid
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl.'?cid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */

        //post download movie (folder was public)
        $data = [
            'movieId' => 1,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder was not public and movie is public)
        $data = [
            'movieId' => 2,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //post download movie (folder not exist)
        $data = [
            'movieId' => 7,
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
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
