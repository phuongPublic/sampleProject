<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\MovieOpenDetailController Test
 */
class MovieOpenDetailControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OpenStatus',
        'app.MovieFolder',
        'app.MovieContents',
        'app.UserMst',
        'app.TargetUser'
    ];

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->switchDevice(2);
        $this->get($this->testUrl . '?id=open_id2&mid=1&cid=1&type=5');
        $this->assertResponseCode(200);

        //delete data
        $data = [
            'target_user_seq' => array(0 => '6'),
            'open_id' => 'open_id2',
            'mid' => '1',
            'cid' => '1',
        ];
        $this->switchDevice(2);
        $this->post($this->testUrl.'?id=open_id2', $data);
        $this->assertResponseCode(302);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
    }
}
