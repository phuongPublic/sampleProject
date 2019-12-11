<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\ApiAjaxUploadController Test Case
 */
class ApiAjaxUploadControllerTest extends NoptIntegrationTestCase
{
    /**
     * Test index method for PC
     * covers ApiAjaxUploadController::index
     * @test
     * @return void
     */
    public function index()
    {
        // case 1
        $data = array (
                    'name' => 'download (1).jpg',
                    'fileId' => 'o_1b3p9v0unjfn18771n8m100k1d68',
                    'saveto' => 'album',
                    'file' => array (
                                    'name' => 'download (1).jpg',
                                    'type' => 'image/jpeg',
                                    'tmp_name' => 'C:\xampp\tmp\phpFC70.tmp',
                                    'error' => 0,
                                    'size' => 9514
                                ),
                );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // case 2
        $data = array (
            'name' => 'download (1).jpg',
            'fileId' => 'o_1b3p9v0unjfn18771n8m100k1d68',
            'saveto' => 'mb',
            'file' => array (
                'name' => 'download (1).jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'C:\xampp\tmp\phpFC70.tmp',
                'error' => 0,
                'size' => 9514
            ),
        );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('fileDelete', array(1));
    }
}