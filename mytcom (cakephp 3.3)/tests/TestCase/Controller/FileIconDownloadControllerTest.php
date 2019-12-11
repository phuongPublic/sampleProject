<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FileIconDownloadController Test Case
 */
class FileIconDownloadControllerTest extends NoptIntegrationTestCase
{
    /**
     * Test index method for PC
     * covers FileIconDownloadController::index
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */
        $result = true;
        try {
            // iphone data txt
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=txt');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data htm
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=htm');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data doc
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=doc');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data xls
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=xls');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data ppt
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=ppt');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data pdf
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=pdf');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data gif
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=gif');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data jpg
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=jpg');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data png
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=png');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data png
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=mp3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data png
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=mov');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data empty
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);


        $result = true;
        try {
            // android data txt
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=txt');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data htm
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=htm');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data doc
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=doc');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data xls
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=xls');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data ppt
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=ppt');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data pdf
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=pdf');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data gif
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=gif');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data jpg
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ext=jpg');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data png
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=png');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data png
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=mp3');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data png
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=mov');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data empty
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ext=');
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
