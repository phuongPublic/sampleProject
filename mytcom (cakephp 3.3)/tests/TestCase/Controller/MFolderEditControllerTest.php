<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MFolderEditController Test Case
 */
class MFolderEditControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Movie/List.html'; //通常遷移
    protected $redirectUrl2 = '/Movie/Preview.html';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.UserMst'
    ];

    /**
     * Test index method for all method
     * covers MFolderEditController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $mFolder = TableRegistry::get('MovieFolder');

        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);

        // folder not exist in DB
        $this->get($this->testUrl . '?mid=1000');
        $this->assertResponseCode(302);
        
        // pc post case
        $data = [
            'mid' => '1',            
            'movie_folder_name' => 'movie folder pc name edit',
            'movie_folder_comment' => 'movie folder pc comment edit',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->post($this->testUrl, $data);
        
        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 1);
        $this->assertEquals('movie folder pc name edit', $result[0]['movie_folder_name']);
        $this->assertEquals('movie folder pc comment edit', $result[0]['movie_folder_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //valid input case
        $data = [
            'mid' => '1',
            'movie_folder_name' => 'movie folder pc name edit 1234567890',
            'movie_folder_comment' => 'movie folder Comment',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->post($this->testUrl, $data);

        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 1);
        $this->assertEquals('Movie Folder 1', $result[0]['movie_folder_name']);
        $this->assertResponseCode(200);

        //post data folder not exist
        $data = [
            'mid' => '1000',
            'movie_folder_name' => 'movie folder pc name edit 1234567890',
            'movie_folder_comment' => 'movie folder Comment',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);        
        $data = [
            'mid' => '1',            
            'movie_folder_name' => 'Movie Folder 1',
            'movie_folder_comment' => 'movie folder iphone comment edit',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->post($this->testUrl, $data);
        
        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 1);
        $this->assertEquals('Movie Folder 1', $result[0]['movie_folder_name']);
        $this->assertEquals('movie folder iphone comment edit', $result[0]['movie_folder_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認

        // android
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);        
        $data = [
            'mid' => '1',            
            'movie_folder_name' => 'Movie Folder 1',
            'movie_folder_comment' => 'movie folder android comment edit',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->post($this->testUrl, $data);
        
        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 1);
        $this->assertEquals('Movie Folder 1', $result[0]['movie_folder_name']);
        $this->assertEquals('movie folder android comment edit', $result[0]['movie_folder_comment']);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認
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
