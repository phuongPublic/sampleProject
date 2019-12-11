<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FileOpenStatusControllerTest Test Case
 */
class FileOpenStatusControllerTest extends NoptIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.TargetUser',
        'app.OpenStatus',
        'app.UserMst'
    ];

    /**
     * Test Pc method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Pc()
    {
        $this->loadFixtures('OpenStatus', 'FileFolderTbl', 'FileTbl', 'UserMst', 'TargetUser');

        //ffid = all
        $this->switchDevice(1);
        $this->get($this->testUrl . '?ffid=all&fid=1');
        $this->assertResponseCode(200);

        //ffid = 1
        $this->switchDevice(1);
        $this->get($this->testUrl . '?ffid=1&fid=1');
        $this->assertResponseCode(200);

        // Delete status
        $data = [
            'target_id' => array('1','2'),
            'fid' => '1',
            'open_id' => 'open_id1',
            'target_user_seq' => array('1'),
            'ffid' => 'all',
            'delete' => '終了する'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function smartPhone()
    {
        $this->loadFixtures('OpenStatus', 'FileFolderTbl', 'FileTbl', 'UserMst', 'TargetUser');

        //ffid = all
        $this->switchDevice(2);
        $this->get($this->testUrl . '?ffid=all&fid=1&back=1');
        $this->assertResponseCode(200);

        //ffid = 1
        $this->switchDevice(2);
        $this->get($this->testUrl . '?ffid=1&fid=1');
        $this->assertResponseCode(200);
    }

    /**
     * Test showMoreStatus method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreStatus()
    {
        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreStatus?ffid=all&fid=1&page=2');
        $this->assertResponseCode(200);
        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreStatus?ffid=1&fid=1&page=2&back=1');
        $this->assertResponseCode(200);
        $this->switchDevice(3);
        $this->get($this->testUrl . '/showMoreStatus?ffid=all&fid=1&page=2');
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
