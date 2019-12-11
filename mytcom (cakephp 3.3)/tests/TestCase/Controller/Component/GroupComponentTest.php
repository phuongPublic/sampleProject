<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Exception;

// テスト対象資源指定
use App\Controller\Component\GroupComponent;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\GroupComponent Test Case
 */
class GroupComponentTest extends IntegrationTestCase
{

    public $testUserSeq = '385cd85a14bb90c754897fd0366ff266';
    public $fixtures = ['app.AddressData', 'app.GroupTbl'];
    public $autoFixtures = false; // CUD系のテストの為自動読み込み不可。loadFixturesを使用し初期化
    public $component = null;
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $request = new Request ();
        $response = new Response ();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')->setConstructorArgs([
            $request,
            $response
        ])->setMethods(null)->getMock();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new GroupComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        /*
         * $mock = $this->getMockBuilder ( 'GroupComponent' )->setMethods ( 'checkFileExists' )->getMock ();
         * $mock->expects ( $this->any () )->method ( 'checkFileExists' )->willReturn ( false );
         * $this->component->common = $mock;
         */
    }

    /**
     * Test getGroupQuota method
     *
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getGroupQuota()
    {
        $this->assertEquals('200', $this->component->getGroupQuota());
    }

    /**
     * Test addGroup method
     *
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function addGroup()
    {
        //load fixture
        $this->loadFixtures('GroupTbl');
        $this->loadFixtures('AddressData');

        //normal case
        $groupName = 'test';
        $selectedAddress = array(1, 2);
        $groupQuota = '200';
        $this->assertEquals(null, $this->component->addGroup($this->testUserSeq, $groupName, $selectedAddress, $groupQuota));

        // > group quota
        $groupQuota = '1';
        $this->assertEquals('登録可能なグループは1件までとなります。', $this->component->addGroup($this->testUserSeq, $groupName, $selectedAddress, $groupQuota));

        // TODO: NG addAddressToGroup false

        // NG Exception
        $groupQuota = '200';
        $this->assertEquals('グループの登録に失敗しました。', $this->component->addGroup(null, "", "", $groupQuota));
    }

    /**
     * Test insertGroupData method
     *
     * @codeCoverageIgnore
     * @test
     * @expectedException Exception
     * @return void
     */
    public function insertGroupData()
    {
        //load fixture
        $this->loadFixtures('GroupTbl');
        $this->loadFixtures('AddressData');
        // OK
        $groupName = 'test';
        $groupQuota = '200';
        $this->assertEquals(5, $this->component->insertGroupData($groupName, $this->testUserSeq, $groupQuota));

        // NG Exception
        $groupName = 'test';
        $groupQuota = '200';
        $this->component->insertGroupData($groupName, null, $groupQuota);

        // NG exceed group quota
        $groupName = 'test';
        $groupQuota = '1';
        $this->assertEquals(-1, $this->component->insertGroupData($groupName, $this->testUserSeq, $groupQuota));
    }

    /**
     * Test updateGroupData method
     *
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateGroupData()
    {
        //load fixture
        $this->loadFixtures('GroupTbl');
        $this->loadFixtures('AddressData');
        // OK
        $groupName = 'test';
        $groupId = 1;
        $selectedAddress = [0 => '0-2', 1 => '1-2', 2 => '0-3', 3 => '1-3'];
        $this->assertTrue($this->component->updateGroupData($this->testUserSeq, $selectedAddress, $groupId, $groupName));

        // NG Exception
        $groupName = 'test';
        $groupId = 100;
        $selectedAddress = [0 => '0-2', 1 => '1-2', 2 => '0-3', 3 => '1-3'];
        $this->assertFalse($this->component->updateGroupData($this->testUserSeq, $selectedAddress, $groupId, $groupName));
    }

    /**
     * Test validate method
     *
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validate()
    {
        //load fixture
        $this->loadFixtures('GroupTbl');
        $this->loadFixtures('AddressData');

        //normal case
        $groupName = 'test';
        $this->assertEquals(null, $this->component->validate($groupName));

        //null group name case
        $groupName = '';
        $this->assertEquals('グループ名を入力してください。', $this->component->validate($groupName));

        //>25 char case
        $groupName = '12345678901234567890123456';
        $this->assertEquals('グループ名は25文字以内で入力してください。', $this->component->validate($groupName));
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }

}
