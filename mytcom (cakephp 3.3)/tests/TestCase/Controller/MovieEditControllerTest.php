<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MovieEditController Test Case
 */
class MovieEditControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Movie/Contents/Detail.html'; //通常遷移

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
     * covers MovieEditController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->setSession();
        $movieContentTbl = TableRegistry::get('MovieContents');
        //PC
        /**
         * GET処理
         */
        //Movie is exist
        $this->switchDevice(1);
        $this->get($this->testUrl.'?movie_contents_id=1');
        $this->assertResponseCode(200);
        //Movie is not exist
        $this->switchDevice(1);
        $this->get($this->testUrl.'?movie_contents_id=1000');
        $this->assertResponseCode(302);
        /**
         * POST処理
         */
        $this->setSession();
        // pc post case
        $this->switchDevice(1);
        $data = [
            'movie_contents_id' => 1,
            'name' => 'movie1',
            'movie_contents_comment' => 'movie1 comment'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $movieContentTbl->getSingleMovieData($this->testUserSeq, 1);
        $this->assertEquals('movie1', $result[0]['name']);
        $this->assertEquals('movie1 comment', $result[0]['movie_contents_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?cid=1'); // リダイレクト先URLの確認

        //case errors
        $this->setSession();
        $this->switchDevice(1);
        $data = [
            'movie_contents_id' => 1,
            'name' => 'movie name max 125 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'movie_contents_comment' => 'movie comment pc update'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // iphone
        /**
         * GET処理
         */
        //
        $this->switchDevice(2);
        $this->get($this->testUrl. '?movie_contents_id=1');
        $this->assertResponseCode(200);
        /**
         * POST処理
         */
        //
        $this->switchDevice(2);
        $data = [
            'movie_contents_id' => 1,
            'name' => 'movie name iphone update',
            'movie_contents_comment' => 'movie comment iphone update'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $movieContentTbl->getSingleMovieData($this->testUserSeq, 1);
        $this->assertEquals('movie name iphone update', $result[0]['name']);
        $this->assertEquals('movie comment iphone update', $result[0]['movie_contents_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?cid=1'); // リダイレクト先URLの確認

        // android
        /**
         * GET処理
         */
        //
        $this->switchDevice(3);
        $this->get($this->testUrl. '?movie_contents_id=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */
        $this->switchDevice(3);
        $data = [
            'movie_contents_id' => 1,
            'name' => 'movie name android update',
            'movie_contents_comment' => 'movie comment android update'
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $movieContentTbl->getSingleMovieData($this->testUserSeq, 1);
        $this->assertEquals('movie name android update', $result[0]['name']);
        $this->assertEquals('movie comment android update', $result[0]['movie_contents_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?cid=1'); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('movie_contents_id', '1');
    }

}
