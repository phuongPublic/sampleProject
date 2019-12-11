<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\AlbumOpenStatusController Test Case
 */
class AlbumOpenStatusControllerTest extends NoptIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.TargetUser',
        'app.OpenStatus',
        'app.UserMst'
    ];

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexPc()
    {
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->switchDevice(1);
        $this->get($this->testUrl . '?pid=all&aid=1');
        $this->assertResponseCode(200);
        $this->get($this->testUrl . '?pid=all&aid=1');
        $this->assertResponseCode(200);
        $data = [
            'pid' => 'all',
            'aid' => '1',
            'open_id' => 'pic_component',
            'target_user_seq' => array('5'),
            'pic_mode' => '0',
            'delete' => '終了する'
        ];
        $this->post($this->testUrl, $data);
   }

    /**
     * Test indexSP method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexSP()
    {
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->switchDevice(2);
        $this->get($this->testUrl . '?pid=all&aid=1&back=1');
        $this->assertResponseCode(200);
        $this->switchDevice(2);
        $this->get($this->testUrl . '?pid=all&aid=1');
        $this->assertResponseCode(200);
        $data = [
            'pid' => 'all',
            'aid' => '1',
            'open_id' => 'pic_component',
            'target_user_seq' => array('5'),
            'pic_mode' => '0',
            'delete' => '終了する'
        ];
        $this->post($this->testUrl, $data);
    }

    /**
     * Test albumOpenStatusMore method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function albumOpenStatusMore()
    {
        $this->loadFixtures('Album', 'PicTbl', 'OpenStatus');
        $this->switchDevice(2);
        $this->get($this->testUrl . '/albumOpenStatusMore?pid=all&aid=1&page=2');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->get($this->testUrl . '/albumOpenStatusMore?pid=1&aid=1&page=2');
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
