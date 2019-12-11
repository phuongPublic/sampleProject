<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MFolderRegistController Test Case
 */
class MFolderRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/movie/List.html'; //通常遷移
    
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
     * Test index method for PC
     * covers MFolderRegistController::index
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
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // pc post case
        $this->switchDevice(1);        
        $data = [
            'movie_folder_name' => 'movie folder name pc',
            'movie_folder_comment' => 'movie folder comment pc',
        ];
        $this->loadFixtures('MovieFolder');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // case input valid
        $this->switchDevice(1);
        $data = [
            'movie_folder_name' => 'movie folder name pc 12345678901234567890',
            'movie_folder_comment' => 'movie folder comment pc',
        ];
        $this->loadFixtures('MovieFolder');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

//        $mock = $this->getMockBuilder('App\Controller\Component\MovieFolderComponent')
//            ->setMethods(['update'])
//            ->getMock();
//
//        $mock->expects($this->exactly(3))
//            ->method('update')
//            ->will($this->returnValue(false));
//
//        $this->object->MovieFolder = $mock;
//
//        $this->post();

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // iphone post case
        $this->switchDevice(2);        
        $data = [
            'movie_folder_name' => 'movie folder name iphone',
            'movie_folder_comment' => 'movie folder comment iphone',
        ];
        $this->loadFixtures('MovieFolder');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認 

        // android
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        // android post case
        $this->switchDevice(3);        
        $data = [
           'movie_folder_name' => 'movie folder name android',
            'movie_folder_comment' => 'movie folder comment android',
        ];
        $this->loadFixtures('MovieFolder');
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
