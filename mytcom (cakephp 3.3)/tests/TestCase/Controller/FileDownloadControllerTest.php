<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FileDownloadController Test Case
 */
class FileDownloadControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.OpenStatus',
        'app.UserMst',
    ];

    /**
     * Test index method for PC
     * covers FileDownloadController::index
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
            // iphone data default
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $result = true;
        try {
            // iphone data vcf
            $this->switchDevice(2);

            $this->get($this->testUrl . '?ffid=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data rtf
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=5');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data xls
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=6');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data doc
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=7');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data ppt
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=8');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data xlsx
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=9');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data docx
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=10');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data pptx
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=11');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data mp4
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=12');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data m4a
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=13');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data aif
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=14');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data mov
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=15');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data 3gp
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=16');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data 3g2
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=17');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data m4v
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=18');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data mp3
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=19');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // iphone data wav
            $this->switchDevice(2);
            $this->get($this->testUrl . '?ffid=20');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        /**
         * GET処理
         */
        $result = true;
        try {
            // android data default
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // iphone data vcf
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=4');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data rtf
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=5');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data xls
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=6');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data doc
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=7');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data ppt
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=8');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data xlsx
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=9');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data docx
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=10');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data pptx
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=11');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data mp4
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=12');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data m4a
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=13');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data aif
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=14');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data mov
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=15');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data 3gp
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=16');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data 3g2
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=17');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
        $result = true;
        try {
            // android data m4v
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=18');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data mp3
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=19');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            // android data wav
            $this->switchDevice(3);
            $this->get($this->testUrl . '?ffid=20');
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

    }

}
