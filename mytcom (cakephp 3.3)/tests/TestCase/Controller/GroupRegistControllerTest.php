<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use App\Controller\GroupRegistController;
use ReflectionMethod;

/**
 * App\Controller\GroupRegistController Test Case
 */
class GroupRegistControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl = '/address/listview.html'; //通常遷移

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
        // Load screen OK - Empty DB
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // Registration OK - Valid group name without address data
        $registerData = [
            'group_name' => 'testgroup'
        ];
        $this->post($this->testUrl, $registerData);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl);

        // Registration NG - Empty group name without address data
        $registerData = [
            'group_name' => ''
        ];
        $this->post($this->testUrl, $registerData);
        $this->assertResponseCode(200);

        // Registration NG - Exceed group name's length without address data
        $registerData = [
            'group_name' => 'group name more than 25 character'
        ];
        $this->post($this->testUrl, $registerData);
        $this->assertResponseCode(200);

        // Load DB contains data
        $this->loadFixtures('AddressData', 'GroupTbl');
        // Load screen OK - DB has data
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // Redirect OK - Invalid page number
        $this->get($this->testUrl. '?group_pg=100');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/address/group/regist.html?group_pg=1');

        // Registation OK - Valid group name with selected address
        $registerData = [
            'group_name' => 'testgroup',
            'adrdata_seq' => [1, 2]
        ];
        $this->post($this->testUrl, $registerData);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl);
    }

    /**
     * Test index method for all method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function registerGroup()
    {
        $this->loadFixtures('GroupTbl');
        $reflectionMethod = new ReflectionMethod('App\Controller\GroupRegistController', 'registerGroup');
        $reflectionMethod->setAccessible(true);

        // NG - AddressData Table doesn't exist, addressList parameter = 1
        $this->assertEquals("グループの登録に失敗しました。", $reflectionMethod->invokeArgs(new GroupRegistController(), [$this->testUserSeq, 'newName', 200, 1]));
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
