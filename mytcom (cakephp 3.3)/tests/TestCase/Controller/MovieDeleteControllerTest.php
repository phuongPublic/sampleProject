<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\MovieComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use App\Validation\NoptBaseValidator;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use ReflectionClass;

/**
 * App\Controller\MovieDeleteController Test Case
 */
class MovieDeleteControllerTest extends NoptIntegrationTestCase
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
        'app.UserMst',
        'app.EncodeRequest'
    ];

    /**
     * Test index method for PC
     * covers MovieDeleteController::index
     * @test
     * @return void
     */
    public function index()
    {
        $this->switchDevice(1);
        /**
         * GET処理
         */
        // get from picture detail
        $this->get($this->testUrl. '?cid=1');
        $this->assertResponseCode(200);

        // cid not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?cid=1000');
        $this->assertResponseCode(302);


        // get missing cid
        $movieDelete = [
            'del' => [
                0 => '1',
                1 => '2'
            ]
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        parent::setSessionData('movie_delete', $movieDelete);
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        /**
         * POST処理
         */
        // pc post case delete one movie
        $data = [
            'fromsrc' => 0,
            'del' => [0 => 2]
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // pc post case delete 2 movie
        $data = [
            'fromsrc' => 0,
            'del' => [
                0 => 2,
                1 => 5
            ]
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // pc post case delete one movie encode status != 2
        $data = [
            'fromsrc' => 0,
            'del' => [0 => 3]
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //iphone
        $this->switchDevice(2);
        /**
         * GET処理
         */
        // get from picture detail
        $this->get($this->testUrl. '?cid=1');
        $this->assertResponseCode(200);

        // cid not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?cid=1000');
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        // pc post case delete one movie (delete success)
        $data = [
            'fromsrc' => 0,
            'del' => 2
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // pc post case delete one movie encode status != 2 (delete fail)
        $data = [
            'fromsrc' => 0,
            'del' => 3
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        //android
        $this->switchDevice(3);
        /**
         * GET処理
         */
        // get from picture detail
        $this->get($this->testUrl. '?cid=1');
        $this->assertResponseCode(200);

        // cid not exist
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl. '?cid=1000');
        $this->assertResponseCode(302);

        /**
         * POST処理
         */
        // pc post case delete one movie (delete success)
        $data = [
            'fromsrc' => 0,
            'del' => 2
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // pc post case delete one movie encode status != 2 (delete fail)
        $data = [
            'fromsrc' => 0,
            'del' => 3
        ];
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

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
