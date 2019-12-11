<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\AddressExportController Test Case
 */
class AddressExportControllerTest extends NoptIntegrationTestCase {

    public $autoFixtures = false;
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
            'app.AddressData'
    ];
    protected $redirectUrl1 = '/address/listview.html'; //削除遷移

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index(){
//        $this->fixtureManager = new FixtureManager();
//        $this->fixtureManager->fixturize($this);
//        $this->switchDevice(1);
        /**
         * GET処理
         */
        //PC
        $this->loadFixtures('AddressData');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        
        //download with type file UTF-8
         $data = [
            'type' => 2,
            'download_export' => 'ダウンロード',
        ];
        $this->setSession();
        $this->loadFixtures('AddressData');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

         //download with type file SJIS
         $data = [
            'type' => 1,
            'download_export' => 'ダウンロード',
        ];
        $this->setSession();
        $this->loadFixtures('AddressData');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //download with type = 3
        $data = [
            'type' => 3,
            'download_export' => 'ダウンロード',
        ];
        $this->setSession();
        $this->loadFixtures('AddressData');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // download fails if export list format is incorrect
        $data = [
            'type' => 2,
            'download_export' => 'ダウンロード',
        ];
        $this->_session = [];
        $this->setSessionData('expUidList', 'string');
        $this->loadFixtures('AddressData');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        //back
        $data = [
            'cancel_export' => '戻る'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     *
     * @return void
     */
    protected function setSession(){
        parent::setSessionData('UserData.user_seq', $this->testUserSeq);
        parent::setSessionData('expUidList', null);
    }
}
