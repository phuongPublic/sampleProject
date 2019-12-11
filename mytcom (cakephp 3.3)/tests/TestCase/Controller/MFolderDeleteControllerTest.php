<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MFolderDeleteController Test Case
 */
class MFolderDeleteControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/Movie/List.html'; //通常遷移
    
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
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $mFolder = TableRegistry::get('MovieFolder');
        //Pc
        /**
         * GET処理
         */
        //folder exist
        $this->switchDevice(1);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);
        //folder not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1000');
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        //delete default movie folder
        $data = [
            'del' => [1],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // movie folder not exist
        $data = [
            'del' => [1000],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //delete success
        $data = [
            'del' => [2],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 2);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
        
        // iphone
        /**
         * GET処理
         */
        //folder exist
        $this->switchDevice(2);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);
        //folder not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1000');
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        //delete default movie folder
        $data = [
            'del' => [1],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // movie folder not exist
        $data = [
            'del' => [1000],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //delete success
        $data = [
            'del' => [2],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 2);
        $this->assertEquals(array(), $result);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // android
        /**
         * GET処理
         */
        //folder exist
        $this->switchDevice(3);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);
        //folder not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?mid=1000');
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        //delete default movie folder
        $data = [
            'del' => [1],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // movie folder not exist
        $data = [
            'del' => [1000],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        //delete success
        $data = [
            'del' => [2],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $result = $mFolder->getSingleMovieFolderData($this->testUserSeq, 2);
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
