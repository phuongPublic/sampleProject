<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\MFolderPreviewController Test Case
 */
class MFolderPreviewControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = true;
    protected $redirectUrl1 = '/Movie/Contents/Delete.html'; //通常遷移
    protected $redirectUrl2 = '/Movie/Preview.html'; //検索遷移
    protected $redirectUrl3 = '/Movie/Open/Regist.html'; //検索遷移


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
     * @codeCoverageIgnore
     *
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        // pc
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);

        //movie folder not exists
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=9999');
        $this->assertResponseCode(302);

        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?mid=0001');
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?mid=0003');
        $this->assertResponseCode(200);

        //get sort, keyword
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?mid=1&sort=new&keyword=shjfsbfs&src=all&page=1');
        $this->assertResponseCode(200);

        //get sort, keyword
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?mid=1');
        $this->assertResponseCode(200);

        //get sort, keyword
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?mid=1&search=1&fromsrc=1&src=1');
        $this->assertResponseCode(200);

        //keyword too long (65535)
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $keyword = '';
        for ($i = 0; $i <= 65560; $i++) {
            $keyword .= 'a';
        }
        $this->get($this->testUrl . '?keyword=' . $keyword);
        $this->assertResponseCode(302);

        //get from all
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?src=all');
        $this->assertResponseCode(200);

        //search params
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->get($this->testUrl . '?fromsrc=1');
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $keyword = '';
        for ($i = 0; $i <= 65560; $i++) {
            $keyword .= 'a';
        }
        $data = [
            'keyword' => $keyword
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        $this->setSession();
        //delete file
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'mid' => '0001',
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => 1,
        ];

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'mid' => 1,
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => 1,
            'open' => 1
        ];

        // open
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'fromsrc' => 1,
            'open' => 1,
            'mid' => 1
        ];

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //delete file
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'mid' => '0001',
            'fromsrc' => 1,
            'deletefile' => 1,
            'del' => null,
        ];

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // pc open case
        $data = [
            'mid' => '1',
            'fromsrc' => 1,
            'open' => 1,
            'del' => [
                0 => 1,
                1 => 2
            ],
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3); // リダイレクト先URLの確認

        $this->switchDevice(1);
        // pc move case
        $data = [
            'mid' => '0001',
            'fromsrc' => 1,
            'remove' => 1,
            'del' => [],
            'folder' => '0002',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        //$this->assertRedirectContains($this->redirectUrl2 . '?mid=0001');

        //case move movie to another folder
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'remove' => 1,
            'del' => [
                0 => 1,
                1 => 2,
            ],
            'folder' => 2,
            'mid' => 1,
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?mid=2');

        // android
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=0001&keyword=fjsfjksfjk&src=all&sort=new');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?fromsrc=1&keyword=fjsfjksfjk&src=all&sort=new');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?page=1');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=0001&keyword=fjsfjksfjk&src=all&sort=new');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?page=1');
        $this->assertResponseCode(200);

        // android post
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $data = [
            'sort' => 'old',
            'keyword' => 'movie',
            'mid' => 1,
            'search' => '1',
            'fromsrc' => '1',
            'src' => '1'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // android move case
        $this->switchDevice(3);
        $data = [
            'mid' => '0001',
            'fromsrc' => 1,
            'remove' => 1,
            'del' => [],
            'folder' => '0002',
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //case move movie to another folder
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'remove' => 1,
            'del' => [
                0 => 1,
                1 => 2,
            ],
            'folder' => 2,
            'mid' => 1,
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?mid=2');

        //iphone post
        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $data = [
            'sort' => 'old',
            'keyword' => 'movie',
            'mid' => 1,
            'search' => '1',
            'fromsrc' => '1',
            'src' => 'all'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // iphone
        $this->switchDevice(2);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=0001');
        $this->assertResponseCode(200);

        // android
        $this->switchDevice(3);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->get($this->testUrl . '?mid=0001');
        $this->assertResponseCode(200);
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'mid' => '0001',
            'fromsrc' => 1,
            'del' => 1,
            'open' => 1
        ];

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // a du
        $this->switchDevice(1);
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $data = [
            'fromsrc' => 1,
            'open' => 1,
            'mid' => 1
        ];

        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreMovie()
    {
        /**
         * GET処理
         */
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser', 'UserMst');
        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreMovie?page=1');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->get($this->testUrl . '/showMoreMovie');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreMovie?page=1&sort=new');
        $this->assertResponseCode(200);

        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreMovie?page=1&sort=new&keyword=ruwfjds');
        $this->assertResponseCode(200);

        //post keyword
        $this->switchDevice(2);
        $data = [
            'keyword' => 'ruwfjds'
        ];
        $this->post($this->testUrl . '/showMoreMovie', $data);
        $this->assertResponseCode(200);

        //key mid
        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreMovie?mid=1&src=all');
        $this->assertResponseCode(200);

        //post mid
        $this->switchDevice(2);
        $data = [
            'mid' => 1,
            'src' => 'all',
            'search' => 'movie'
        ];
        $this->post($this->testUrl . '/showMoreMovie', $data);
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData('keyword', 'custom keyword');
    }

}
