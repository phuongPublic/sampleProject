<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AddressDetailviewController Test Case
 */
class AddressDetailviewControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/edit.html'; //通常遷移
    protected $redirectUrl2 = '/address/listview.html'; //通常遷移

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
        // pg null

        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1');
        $this->assertResponseCode(200);        
        // edit add

        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?adrdata_seq=1&pg=1');
        $this->assertResponseCode(200);

        // back button event searchKeyword not exist 
        $data = [
            'adrdata_seq' => 1,
            'return' => 1,
            'pg' => 1,
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl2. '?pg=1'); // リダイレクト先URLの確認 
        
        // normal searchKeyword exist
        $this->setSession();
        $data = [
            'adrdata_seq' => 1,
            'return' => 1,
            'pg' => 1,
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains('/Array&category=1&categoryKeyword=a'); // リダイレクト先URLの確認         
        // normal OK
        $this->setSession();
        $data = [
            'submit_edit' => 1,
            'adrdata_seq' => 1,
            'return' => 1,
            'pg' => 1,
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl1. '?adrdata_seq=1'); // リダイレクト先URLの確認  
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('searchKeyword', array('category' => 1,
                'categoryKeyword' => 'a')
        );
        parent::setSessionData('lastUrl', array('lastUrl' => '/address/listview.html'));
    }
}
