<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FileOpenDetailController Test Case
 */
class FileOpenDetailControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OpenStatus',
        'app.Album',
        'app.PicTbl',
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
        $this->get($this->testUrl . '?id=open_id1&fid=1&ffid=1&type=2');
        $this->assertResponseCode(200);

        //delete data
        $data = [
            'target_user_seq' => array(0 => '6'),
            'open_id' => 'open_id1',
            'fid' => '1',
            'ffid' => '1',
        ];
        $this->switchDevice(2);
        $this->post($this->testUrl.'?id=open_id1&fid=1&ffid=1&type=2', $data);
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
