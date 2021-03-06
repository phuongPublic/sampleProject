<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AddressDeleteController Test Case
 */
class AddressDeleteControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/listview.html'; //通常遷移
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
            'app.AddressData',
            'app.GroupTbl'
    ];

    /**
     * Test index method for all method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */        
        // org = 1
        $this->setSession();
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?adrdata_seq=1&pg=1&org=1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?group_id=1&pg=1'); // リダイレクト先URLの確認
        
        // org = ''
        $this->setSession();
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?adrdata_seq=1&pg=1&org=');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?pg=1'); // リダイレクト先URLの確認

        // DB error
        $this->get($this->testUrl. '?adrdata_seq=1&pg=1&org=1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?group_id=1&pg=1'); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }
}
