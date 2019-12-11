<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\GroupListController Test Case
 */
class GroupListControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/listview.html'; //通常遷移
    protected $redirectUrl2 = '/address/group/list.html'; //通常遷移

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
        // Redirect OK - group_id is not existed return
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // OK - Get all of address data
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1');
        $this->assertResponseCode(200);

        // Redirect OK - Incorrect page number
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1&category=&pg=100');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2. '?group_id=1&pg=1'); // リダイレクト先URLの確認

        // OK - Search address data via GET request
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1&category=1&categoryKeyword=123');
        $this->assertResponseCode(200);

        // OK - Search address via POST request
        $this->setSession();
        $postData = [
            'category' => 1,
            'categoryKeyword' => 'address',
            'group_id' => '1',
            search_x => ''
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $postData);
        $this->assertResponseCode(200);
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
