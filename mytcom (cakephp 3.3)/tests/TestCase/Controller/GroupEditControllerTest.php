<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use App\Controller\GroupEditController;
use ReflectionMethod;

/**
 * App\Controller\GroupEditController Test Case
 */
class GroupEditControllerTest extends NoptIntegrationTestCase
{
    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/group/list.html'; //通常遷移
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
        // Empty AddressData table. Non-empty GroupTbl table.
        // Load screen OK
        $this->loadFixtures('GroupTbl');
        $this->get($this->testUrl. '?group_id=1');
        $this->assertResponseCode(200);

        // Edit OK - Valid group name
        $this->loadFixtures('GroupTbl');
        $inputData = [
            'group_name' => 'group name edit',
            'group_id' => 1
        ];
        $this->post($this->testUrl, $inputData);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?group_id=1');

        // Edit NG - Empty group name
        $this->loadFixtures('GroupTbl');
        $inputData = [
            'group_name' => '',
            'group_id' => 1
        ];
        $this->post($this->testUrl, $inputData);
        $this->assertResponseCode(200);

        // Edit NG - Too long group name
        $this->loadFixtures('GroupTbl');
        $inputData = [
            'group_name' => 'group name more than 25 character',
            'group_id' => 1
        ];
        $this->post($this->testUrl, $inputData);
        $this->assertResponseCode(200);

        // Non-empty GroupTbl table and AddressData table
        // Load screen OK
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1');
        $this->assertResponseCode(200);

        // Redirect OK - Load screen without group_id
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2);

        // Redirect OK - Exceed page number
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl. '?group_id=1&group_pg=100');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/address/group/edit.html?group_id=1&group_pg=1');
    }

    /**
     * Test index method for all method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function updateGroupInfo()
    {
        $this->loadFixtures('GroupTbl');
        $reflectionMethod = new ReflectionMethod('App\Controller\GroupEditController', 'updateGroupInfo');
        $reflectionMethod->setAccessible(true);

        // NG - AddressData Table doesn't exist, addressList parameter = 1
        $this->assertEquals("グループの編集に失敗しました。", $reflectionMethod->invokeArgs(new GroupEditController(), [$this->testUserSeq, 1, 'newName', 1]));
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
