<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AddressEditController Test Case
 */
class AddressEditControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/listview.html'; //通常遷移
    protected $redirectUrl2 = '/address/group/list.html'; //通常遷移

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
        //PC
        // get regist
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?adrdata_seq=1');
        $this->assertResponseCode(200);

        // get edit
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1');
        $this->assertResponseCode(200);

        // validate error
        $data = [
            'adrdata_seq' => 1,
            'submit_edit' => 1,
            'work_postcode' => '12334566',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // register normal group_id
        $data = [
            'submit_edit' => 1,
            'group_id' => 1,
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com',
            'note' => 'xx',
            'work_postcode' => '123',
            'work_postcode2' => '1234',
            'home_postcode' => '123',
            'home_postcode2' => '1234',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl2. '?group_id=1'); // リダイレクト先URLの確認

        // register normal group_id not exist
        $data = [
            'submit_edit' => 1,
            'group_id' => '',
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com',
            'note' => 'xx',
            'work_postcode' => '123',
            'work_postcode2' => '1234',
            'home_postcode' => '123',
            'home_postcode2' => '1234',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // register fail because of exceeding address quota
        $data = [
            'submit_edit' => 1,
            'group_id' => '',
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com'
        ];
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // edit normal group_id
        $data = [
            'submit_edit' => 1,
            'adrdata_seq' => 1,
            'group_id' => 1,
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com',
            'note' => 'xx',
            'work_postcode' => '123',
            'work_postcode2' => '1234',
            'home_postcode' => '123',
            'home_postcode2' => '1234',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl2. '?group_id=1'); // リダイレクト先URLの確認

        // edit normal group_id not exist
        $data = [
            'submit_edit' => 1,
            'adrdata_seq' => 1,
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com',
            'note' => 'xx',
            'work_postcode' => '123',
            'work_postcode2' => '1234',
            'home_postcode' => '123',
            'home_postcode2' => '1234',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // edit normal over quota setting address quota = 5
        $data = [
            'submit_edit' => 1,
            'nickname' => 'nickname',
            'email' => 'testmail@gmail.com',
            'note' => 'xx',
            'work_postcode' => '123',
            'work_postcode2' => '1234',
            'home_postcode' => '123',
            'home_postcode2' => '1234',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
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
