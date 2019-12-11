<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\PictureViewController Test Case
 */
class PictureViewControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.OpenStatus',
        'app.TargetUser',
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        //no pid
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // pc data type 1
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=1&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //thumb_NGFlg
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=2&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //no _thumb, no _thumb_NGFlg
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=3&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // pc data type 2
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=1&type=2');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // pc data type 3
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=1&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //pc type = 3, _thumb_NGFlg
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=2&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //type = 3 no _thumb, no _thumb_NGFlg
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=3&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //type 999
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=1&type=999');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //case no target file exist
        $this->switchDevice(1);
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?pid=4&type=2');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // smartphone data type 1
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=1&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // iphone data type 3
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=1&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //no file detail
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=2&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //no file detail, no _flg
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=3&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //case no target file exist type = 3
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=4&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //android type = 3
        $this->switchDevice(3);
        $result = true;
        try {
            $this->switchDevice(3);
            $this->get($this->testUrl . '?pid=1&type=3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // smartphone data type 4
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=1&type=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //no file detail
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=2&type=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //no file detail, no _flg
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=3&type=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //case no target file exist type = 4
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=4&type=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //smartphone no picture
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // smartphone data type 5 and _iphone exists
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=1&type=5');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // smartphone data type 5
        $this->switchDevice(2);
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?pid=3&type=5');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
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
