<?php
/**
 * Created by PhpStorm.
 * User: bipjpnvm013
 * Date: 2016/12/06
 * Time: 9:53
 */

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use ReflectionClass;
use Cake\Validation\Validator;
// テスト対象資源指定
use App\Controller\Component\AddressComponent;
use Cake\TestSuite\Fixture\FixtureManager;

class AddressComponentTest extends IntegrationTestCase
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
        $this->component = new AddressComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Set protected/private variable of a class.
     *
     * @param object &$object      Instantiated object that we will set variable.
     * @param string $propertyName Variable name to set.
     * @param array  $value        Value to be set to variable.
     *
     * @return void
     */
    private function invokeProperty(&$object, $propertyName, $value)
    {
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * Test exportAddressData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function exportAddressData()
    {
        // NG - empty DB
        // Clearing DB is neccessary
        $uidList = null;
        $addressSeqList = TableRegistry::get('AddressData')->getAllAddressSeq($this->testUserSeq);
        $this->component->deleteGroupAndAddress($this->testUserSeq, $addressSeqList, null);
        $this->assertFalse($this->component->exportAddressData($this->testUserSeq, $uidList));

        // Use non-empty DB
        $this->loadFixtures('AddressData');

        //$uidList = null
        $uidList = null;
        $exportValue = $this->component->exportAddressData($this->testUserSeq, $uidList);
        $flag = (mb_strlen($exportValue) > 159) ? true : null;
        $this->assertTrue($flag);

        //$uidList = string
        $uidList = "string";
        $exportValue = $this->component->exportAddressData($this->testUserSeq, $uidList, 1);
        $this->assertFalse($exportValue);

        //type = 1
        $uidList = "";
        $exportValue = $this->component->exportAddressData($this->testUserSeq, $uidList, 2);
        $flag = (mb_strlen($exportValue) > 180) ? true : null;
        $this->assertTrue($flag);
    }

    /**
     * Test getAddressQuota method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getAddressQuota()
    {
        $this->assertEquals(34, $this->component->getAddressQuota());
    }

    /**
     * Test getPageLimit method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getPageLimit()
    {
        $this->assertEquals(15, $this->component->getPageLimit());
    }

    /**
     * Test getLimitImport method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getLimitImport()
    {
        $this->assertEquals(1000, $this->component->getLimitImport());
    }

    /**
     * Test concatPostcode method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function concatPostcode()
    {
        // Case 1: OK
        $this->assertEquals('111-2222', $this->component->concatPostcode(111, 2222));
        // Case 2: NG
        $this->assertEquals(null, $this->component->concatPostcode(111, null));
        // Case 3: NG
        $this->assertEquals(null, $this->component->concatPostcode(null, 2222));
        // Case 4: NG
        $this->assertEquals(null, $this->component->concatPostcode(null, null));
    }

    /**
     * Test addAddressData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function addAddressData()
    {
        // Case 1: OK
        $insertAddressData = array('adrdata_seq' => null,
            'user_seq' => null,
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000',
            'work_postcode2' => '0000',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '111',
            'home_postcode2' => '1111',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'ins_date' => '',
            'upd_date' => '',
            'group_id' => 1);
        $this->assertTrue($this->component->addAddressData($this->testUserSeq, $insertAddressData));

        // Case 2: NG
        $this->assertFalse($this->component->addAddressData(null, $insertAddressData));
    }

    /**
     * Test addAddressToGroup method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function addAddressToGroup()
    {
        $this->loadFixtures('AddressData');
        // Testcase 1: OK
        $this->assertTrue($this->component->addAddressToGroup(1, $this->testUserSeq, [2, 3]));

        // Testcase 2: NG
        $this->assertFalse($this->component->addAddressToGroup(99, $this->testUserSeq, [999, 1000]));
    }

    /**
     * Test updateAddressData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateAddressData()
    {
        $this->loadFixtures('AddressData');
        // Testcase 1: OK
        $updateAddressData = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'test nickname',
            'email' => 'testmail@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000',
            'work_postcode2' => '1111',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '000',
            'home_postcode2' => '3333',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'group_id' => 1);
        $this->assertTrue($this->component->updateAddressData($this->testUserSeq, 1, $updateAddressData));

        // Testcase 2: NG
        $this->assertFalse($this->component->updateAddressData($this->testUserSeq, null, $updateAddressData));

        // Testcase 3: NG
        $this->assertFalse($this->component->updateAddressData($this->testUserSeq, 999, $updateAddressData));
    }

    /**
     * Test deleteGroupAndAddress method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteGroupAndAddress()
    {
        // Testcase 1: OK delete only address
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->assertTrue($this->component->deleteGroupAndAddress($this->testUserSeq, [1, 2], null));

        // Testcase 2: OK delete only group
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->assertTrue($this->component->deleteGroupAndAddress($this->testUserSeq, null, [1, 2]));

        // Testcase 3: OK delete both group and address
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->assertTrue($this->component->deleteGroupAndAddress($this->testUserSeq, 3, 3));

        // Testcase 4: OK delete both group and address
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->assertTrue($this->component->deleteGroupAndAddress($this->testUserSeq, null, null));

        // Testcase 5: NG
        $this->assertFalse($this->component->deleteGroupAndAddress(null, 4, 4));
    }

    /**
     * Test removeEOL method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function removeEOL()
    {
        // Testcase 1: OK
        $inputData = "In computer science, code coverage is a measure used to describe\nthe degree to which the source code of a program is tested by a particular test suite.\nA program with high code coverage has been more thoroughly tested and\nhas a lower chance of containing software bugs than a program with low code coverage.";
        $expectedOutput = "In computer science, code coverage is a measure used to describethe degree to which the source code of a program is tested by a particular test suite.A program with high code coverage has been more thoroughly tested andhas a lower chance of containing software bugs than a program with low code coverage.";
        $this->assertEquals($expectedOutput, $this->invokeMethod($this->component, "removeEOL", [$inputData]));

        // Testcase 2: OK
        $inputData2 = "";
        $expectedOutput2 = "";
        $this->assertEquals($expectedOutput2, $this->invokeMethod($this->component, "removeEOL", [$inputData2]));

        // Testcase 3: NG
        $inputData3 = null;
        $expectedOutput3 = "";
        $this->assertEquals($expectedOutput3, $this->invokeMethod($this->component, "removeEOL", [$inputData3]));
    }

    /**
     * Test toStringInCsvFormat method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function toStringInCsvFormat()
    {
        // Testcase 1: OK CSV形式 (文字コード：SJIS)
        $testAdrDataType1 = array(
            0 => '姓',
            1 => '名',
            2 => '会社名',
            3 => '会社所属',
            4 => '会社番地',
            5 => '会社市区町村',
            6 => '会社都道府県',
            7 => '000-0000',
            8 => '会社国',
            9 => '自宅番地',
            10 => '自宅市区町村',
            11 => '自宅都道府県',
            12 => '111-1111',
            13 => '自宅国',
            14 => '0000-00-0000',
            15 => '0000-00-0000',
            16 => '0000-00-0000',
            17 => '0000-00-0000',
            18 => '090-1111-1111',
            19 => 'http://kaisyaURL.test',
            20 => 'testabc',
            21 => '1989/1/5',
            22 => 'address@address.test',
        );
        $expectedData1 = '"姓","名","会社名","会社所属","会社番地","会社市区町村","会社都道府県","000-0000","会社国","自宅番地","自宅市区町村","自宅都道府県","111-1111","自宅国","0000-00-0000","0000-00-0000","0000-00-0000","0000-00-0000","090-1111-1111","http://kaisyaURL.test","testabc","1989/1/5","address@address.test"';
        $this->assertEquals($expectedData1, $this->invokeMethod($this->component, "toStringInCsvFormat", [$testAdrDataType1]));

        // Testcase 2: OK CSV形式 (文字コード：UTF-8)
        $testAdrDataType2 = array(
            0 => '姓',
            1 => '名',
            2 => 'ニックネーム',
            3 => 'address@address.test',
            4 =>  '会社名',
            5 =>  '会社所属',
            6 => '会社国',
            7 => '000-0000',
            8 => '会社都道府県',
            9 => '会社市区町村',
            10 => '会社番地',
            11 => '0000-00-0000',
            12 => '0000-00-0000',
            13 => 'http://kaisyaURL.test',
            14 => '自宅国',
            15 => '111-1111',
            16 => '自宅都道府県',
            17 => '自宅市区町村',
            18 => '自宅番地',
            19 => '090-1111-1111',
            20 => '1111-11-1111',
            21 => '1111-11-1111',
            22 => 'http://zitakuURL.test',
            23 => '1989/1/5',
            24 => 'メモテスト'
        );
        $expectedData2 = '"姓","名","ニックネーム","address@address.test","会社名","会社所属","会社国","000-0000","会社都道府県","会社市区町村","会社番地","0000-00-0000","0000-00-0000","http://kaisyaURL.test","自宅国","111-1111","自宅都道府県","自宅市区町村","自宅番地","090-1111-1111","1111-11-1111","1111-11-1111","http://zitakuURL.test","1989/1/5","メモテスト"';
        $this->assertEquals($expectedData2, $this->invokeMethod($this->component, "toStringInCsvFormat", [$testAdrDataType2]));

        // Testcase 3: NG
        $testAdrDataType3 = null;
        $expectedData3 = '';
        $this->assertEquals($expectedData3, $this->invokeMethod($this->component, "toStringInCsvFormat", [$testAdrDataType3]));
    }

    /**
     * Test validationDefault method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validationDefault()
    {
        //max length exceed
        $data = [
            'name_l' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'name_f' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'email' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567',
            'nickname' => '12345678901234567890123456',
            'org_name' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'org_post' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'work_countory' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'work_tel' => '123456789012345678901234567890123456789012345678901',
            'work_fax' => '123456789012345678901234567890123456789012345678901',
            'work_pref' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'work_adr1' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'work_adr2' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'work_url' => 'http://test3.mytcommmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm.t-com.ne.jp',
            'home_countory' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'home_tel' => '123456789012345678901234567890123456789012345678901',
            'home_fax' => '123456789012345678901234567890123456789012345678901',
            'home_cell' => '123456789012345678901234567890123456789012345678901',
            'home_pref' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'home_adr1' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'home_adr2' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'home_url' => 'http://test3.mytcommmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm.t-com.ne.jp',
            'birthday' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456',
            'note' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name_l']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['name_f']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['email']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['nickname']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['org_name']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['org_post']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_countory']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_tel']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_fax']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_pref']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_adr1']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['work_adr2']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        if (isset($errors['work_url']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        if (isset($errors['home_countory']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_tel']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_fax']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_cell']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_pref']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_adr1']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        if (isset($errors['home_adr2']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        $flag = null;
        if (isset($errors['home_url']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        if (isset($errors['birthday']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
        if (isset($errors['note']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //normal case
        $data = [
            'name_l' => 'test',
            'name_f' => 'test',
            'email' => 'test@test.com',
            'nickname' => 'test',
            'org_name' => 'test',
            'org_post' => 'test',
            'work_countory' => 'test',
            'work_tel' => 'test',
            'work_fax' => 'test',
            'work_pref' => 'test',
            'work_adr1' => 'test',
            'work_adr2' => 'test',
            'work_url' => 'http://test3.mytcom.t-com.ne.jp/',
            'home_countory' => 'test',
            'home_tel' => 'test',
            'home_fax' => 'test',
            'home_cell' => 'test',
            'home_pref' => 'test',
            'home_adr1' => 'test',
            'home_adr2' => 'test',
            'home_url' => 'http://test3.mytcom.t-com.ne.jp/',
            'birthday' => 'test',
            'note' => 'test',
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (count($errors) == 0) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //wrong url
        $data = [
            'email' => 'test@test.com',
            'nickname' => 'test',
            'work_url' => '1',
            'home_url' => '1',
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (count($errors) > 0) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //wrong url with japan char
        $data = [
            'email' => 'test@test.com',
            'nickname' => 'test',
            'work_url' => 'アドレス',
            'home_url' => 'アドレス',
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (count($errors) > 0) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test isValidEmailFormat method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function isValidEmailFormat()
    {
        // email nick name with quote
        $email = '"test.test.test"@test.com';
        $this->assertTrue($this->component->isValidEmailFormat($email));

        // local-part with double @
        $email = 'test@123@tbz.t-com.ne.jp';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email character not valid in local part unless local part is quoted
        $email = '<test"@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email quoted dote
        $email = '.test.@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email japan char
        $email = 'test正@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));
        // email IPv4
        $email = 'test@[8.8.8.8]';
        $this->assertTrue($this->component->isValidEmailFormat($email));

        // email IPv4 false
        $email = 'test@[8.8.8.855555]';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email IPv6 false
        $email = "test@[2001:0db8:85a3:08d3:1319:8a2e:0370:73345]";
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email only 1 domain name
        $email = 'test@com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email quote char error
        $email = '"""@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email domain not match IPv
        $email = 'test@[test.com]';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email nick name with n dot
        $email = 'test.test.test@test.com';
        $this->assertTrue($this->component->isValidEmailFormat($email));

        // nickname with dot at the end
        $email = 'test.@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email with dot at first
        $email = '.test@test.com';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email ip correct ipv4 false
        $email = 'test@[ipv4:2001:0db8:85a3:08d3:1319:8a2e:0370:73345]';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email ip correct ipv6 false
        $email = 'test@[ipv6:8.8.8.8]';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email ip correct ipv false
        $email = 'test@[ipv3:8.8.8.8]';
        $this->assertFalse($this->component->isValidEmailFormat($email));

        // email ip correct ipv6
        $email = 'test@[ipv6:2001:0db8:85a3:08d3:1319:8a2e:0370:7334]';
        $this->assertTrue($this->component->isValidEmailFormat($email));

        // email ip correct ipv4
        $email = 'test@[ipv4:8.8.8.8]';
        $this->assertTrue($this->component->isValidEmailFormat($email));

        // email error domain
        $email = 'test@test.com,';
        $this->assertFalse($this->component->isValidEmailFormat($email));
    }

    /**
     * Test importAddressData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function importAddressData()
    {
        // Creating $fileInfo object
        $fileInfo = new \stdClass();
        // OK - correct import data in window template
        $fileInfo->fileName = "address.csv";
        $fileInfo->filePath = '\xampp\tmp\address.csv';
        $expectedOKResult = ['OK' => 1, 'NG' => 0];
        $this->assertEquals($expectedOKResult, $this->component->importAddressData($this->testUserSeq, $fileInfo));

        // NG - incorrect import data in outlook template
        $fileInfo->fileName = "address_outlook_NG.csv";
        $fileInfo->filePath = '\xampp\tmp\address_outlook_NG.csv';
        $expectedNGResult = ['OK' => 0, 'NG' => 1];
        $this->assertEquals($expectedNGResult, $this->component->importAddressData($this->testUserSeq, $fileInfo));

        // NG - invalid import file
        $fileInfo->fileName = "address_missingField1_window.csv";
        $fileInfo->filePath = '\xampp\tmp\address_missingField1_window.csv';
        $this->assertEquals(-1, $this->component->importAddressData($this->testUserSeq, $fileInfo));

        // NG - exceeded import data
        $fileInfo->fileName = "addressExceedLine.csv";
        $fileInfo->filePath = '\xampp\tmp\addressExceedLine.csv';
        $this->assertEquals(-3, $this->component->importAddressData($this->testUserSeq, $fileInfo));

        // NG - exceeded the limit of address quota which is changed to 34
        $fileInfo->fileName = "addressTest34.csv";
        $fileInfo->filePath = '\xampp\tmp\addressTest34.csv';
        $this->assertEquals(-2, $this->component->importAddressData($this->testUserSeq, $fileInfo));

        // NG - correct import data in window template
        $fileInfo->fileName = "address.csv";
        $fileInfo->filePath = '\xampp\tmp\address.csv';
        $this->assertEquals(-4, $this->component->importAddressData(null, $fileInfo));
    }

    /**
     * Test checkPostcode method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkPostcode()
    {
        // Testcase 1: OK
        $testData1 = array(
            'work_postcode' => '000',
            'work_postcode2' => '0000',
            'home_postcode' => '111',
            'home_postcode2' => '1111'
        );
        $expectedData1 = array();
        $this->assertEquals($expectedData1, $this->invokeMethod($this->component, "checkPostcode", [$testData1, $this->testUserSeq]));

        // Testcase 2: OK
        $testData2 = array(
            'work_postcode' => '000',
            'work_postcode2' => '0000',
            'home_postcode' => '',
            'home_postcode2' => ''
        );
        $expectedData2 = array();
        $this->assertEquals($expectedData2, $this->invokeMethod($this->component, "checkPostcode", [$testData2, $this->testUserSeq]));

        // Testcase 3: OK
        $testData3 = array(
            'work_postcode' => '',
            'work_postcode2' => '',
            'home_postcode' => '111',
            'home_postcode2' => '1111'
        );
        $expectedData3 = array();
        $this->assertEquals($expectedData3, $this->invokeMethod($this->component, "checkPostcode", [$testData3, $this->testUserSeq]));

        // Testcase 4: OK
        $testData4 = array(
            'work_postcode' => '',
            'work_postcode2' => '',
            'home_postcode' => '',
            'home_postcode2' => ''
        );
        $expectedData4 = array();
        $this->assertEquals($expectedData4, $this->invokeMethod($this->component, "checkPostcode", [$testData4, $this->testUserSeq]));

        // Testcase 5: NG check format
        $testData5 = array(
            'work_postcode' => '000',
            'work_postcode2' => '',
            'home_postcode' => '111',
            'home_postcode2' => ''
        );
        $expectedData5 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData5, $this->invokeMethod($this->component, "checkPostcode", [$testData5, $this->testUserSeq]));

        // Testcase 6: NG check format
        $testData6 = array(
            'work_postcode' => '',
            'work_postcode2' => '0000',
            'home_postcode' => '',
            'home_postcode2' => '1111'
        );
        $expectedData6 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData6, $this->invokeMethod($this->component, "checkPostcode", [$testData6, $this->testUserSeq]));

        // Testcase 7: NG check format
        $testData7 = array(
            'work_postcode' => 'aA%3',
            'work_postcode2' => '',
            'home_postcode' => 'bBD;3',
            'home_postcode2' => ''
        );
        $expectedData7 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData7, $this->invokeMethod($this->component, "checkPostcode", [$testData7, $this->testUserSeq]));

        // Testcase 8: NG check format
        $testData8 = array(
            'work_postcode' => '',
            'work_postcode2' => 'aAa%3',
            'home_postcode' => '',
            'home_postcode2' => 'cV12$'
        );
        $expectedData8 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData8, $this->invokeMethod($this->component, "checkPostcode", [$testData8, $this->testUserSeq]));

        // Testcase 9: NG check format
        $testData9 = array(
            'work_postcode' => '',
            'work_postcode2' => '00000',
            'home_postcode' => '',
            'home_postcode2' => '11111'
        );
        $expectedData9 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData9, $this->invokeMethod($this->component, "checkPostcode", [$testData9, $this->testUserSeq]));

        // Testcase 10: NG check format
        $testData10 = array(
            'work_postcode' => '0000',
            'work_postcode2' => '',
            'home_postcode' => '1111',
            'home_postcode2' => ''
        );
        $expectedData10 = array(
            'work_postcode' => "会社の郵便番号を半角数字で入力してください｡",
            'home_postcode' => "自宅の郵便番号を半角数字で入力してください｡"
        );
        $this->assertEquals($expectedData10, $this->invokeMethod($this->component, "checkPostcode", [$testData10, $this->testUserSeq]));

        // Testcase 11: NG check length
        $testData11 = array(
            'work_postcode' => '000',
            'work_postcode2' => '12345',
            'home_postcode' => '111',
            'home_postcode2' => '12345'
        );
        $expectedData11 = array(
            'work_postcode' => "会社の郵便番号を日本の郵便番号形式で入力してください｡",
            'home_postcode' => "自宅の郵便番号を日本の郵便番号形式で入力してください｡"
        );
        $this->assertEquals($expectedData11, $this->invokeMethod($this->component, "checkPostcode", [$testData11, $this->testUserSeq]));

        // Testcase 12: NG check length
        $testData12 = array(
            'work_postcode' => '0000',
            'work_postcode2' => '1234',
            'home_postcode' => '1111',
            'home_postcode2' => '1234'
        );
        $expectedData12 = array(
            'work_postcode' => "会社の郵便番号を日本の郵便番号形式で入力してください｡",
            'home_postcode' => "自宅の郵便番号を日本の郵便番号形式で入力してください｡"
        );
        $this->assertEquals($expectedData12, $this->invokeMethod($this->component, "checkPostcode", [$testData12, $this->testUserSeq]));

        // Testcase 13: NG check length
        $testData13 = array(
            'work_postcode' => '1',
            'work_postcode2' => '1234',
            'home_postcode' => '1',
            'home_postcode2' => '1234'
        );
        $expectedData13 = array(
            'work_postcode' => "会社の郵便番号を日本の郵便番号形式で入力してください｡",
            'home_postcode' => "自宅の郵便番号を日本の郵便番号形式で入力してください｡"
        );
        $this->assertEquals($expectedData13, $this->invokeMethod($this->component, "checkPostcode", [$testData13, $this->testUserSeq]));

        // Testcase 14: NG check length
        $testData14 = array(
            'work_postcode' => '1',
            'work_postcode2' => '1234',
            'home_postcode' => '1',
            'home_postcode2' => '1234'
        );
        $expectedData14 = array(
            'work_postcode' => "会社の郵便番号を日本の郵便番号形式で入力してください｡",
            'home_postcode' => "自宅の郵便番号を日本の郵便番号形式で入力してください｡"
        );
        $this->assertEquals($expectedData14, $this->invokeMethod($this->component, "checkPostcode", [$testData14, $this->testUserSeq]));
    }

    /**
     * Test generateImportData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function generateImportData()
    {
        $csvData = array(
            'name_l' => 0,
            'name_f' => 1,
            'nickname' => 2,
            'email' => 3,
            'org_name' => 4,
            'org_post' => 5,
            'work_countory' => 6,
            'work_postcode' => 7,
            'work_pref' => 8,
            'work_adr1' => 9,
            'work_adr2' => 10,
            'work_tel' => 11,
            'work_fax' => 12,
            'work_url' => 13,
            'home_countory' => 14,
            'home_postcode' => 15,
            'home_pref' => 16,
            'home_adr1' => 17,
            'home_adr2' => 18,
            'home_cell' => 19,
            'home_tel' => 20,
            'home_fax' => 21,
            'home_url' => 22,
            'birthday' => 23,
            'note' => 24
        );
        $this->invokeProperty($this->component, "csvData", $csvData);

        // Testcase 1: OK
        $testAdrDataType1 = array(
            0 => '姓',
            1 => '名',
            2 => 'ニックネーム',
            3 => 'address@address.test',
            4 => '会社名',
            5 => '会社所属',
            6 => '会社国',
            7 => '000-0000',
            8 => '会社都道府県',
            9 => '会社市区町村',
            10 => '会社番地',
            11 => '0000-00-0000',
            12 => '0000-00-0000',
            13 => 'http://kaisyaURL.test',
            14 => '自宅国',
            15 => '111-1111',
            16 => '自宅都道府県',
            17 => '自宅市区町村',
            18 => '自宅番地',
            19 => '090-1111-1111',
            20 => '1111-11-1111',
            21 => '1111-11-1111',
            22 => 'http://zitakuURL.test',
            23 => '1989/1/5',
            24 => 'メモテスト'
        );
        $expectedData1 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '0000',
            'work_postcode' => '000',
            'home_postcode2' => '1111',
            'home_postcode' => '111'
        );
        $this->assertEquals($expectedData1, $this->invokeMethod($this->component, "generateImportData", [$testAdrDataType1]));

        // Testcase 2: OK
        $testAdrDataType2 = array(
            0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => '',
            6 => '',
            7 => '',
            8 => '',
            9 => '',
            10 => '',
            11 => '',
            12 => '',
            13 => '',
            14 => '',
            15 => '',
            16 => '',
            17 => '',
            18 => '',
            19 => '',
            20 => '',
            21 => '',
            22 => '',
            23 => '',
            24 => ''
        );
        $expectedData2 = array(
            'name_l' => '',
            'name_f' => '',
            'nickname' => '',
            'email' => '',
            'org_name' => '',
            'org_post' => '',
            'work_countory' => '',
            'work_pref' => '',
            'work_adr1' => '',
            'work_adr2' => '',
            'work_url' => '',
            'home_countory' => '',
            'home_pref' => '',
            'home_adr1' => '',
            'home_adr2' => '',
            'home_cell' => '',
            'home_url' => '',
            'work_tel' => '',
            'work_fax' => '',
            'home_tel' => '',
            'home_fax' => '',
            'birthday' => '',
            'note' => '',
            'work_postcode2' => '',
            'work_postcode' => '',
            'home_postcode2' => '',
            'home_postcode' => ''
        );
        $this->assertEquals($expectedData2, $this->invokeMethod($this->component, "generateImportData", [$testAdrDataType2]));

        // Testcase 3: postcode NG
        $testAdrDataType3 = array(
            0 => '姓',
            1 => '名',
            2 => 'ニックネーム',
            3 => 'address@address.test',
            4 => '会社名',
            5 => '会社所属',
            6 => '会社国',
            7 => '0000-000',
            8 => '会社都道府県',
            9 => '会社市区町村',
            10 => '会社番地',
            11 => '0000-00-0000',
            12 => '0000-00-0000',
            13 => 'http://kaisyaURL.test',
            14 => '自宅国',
            15 => '11-11111',
            16 => '自宅都道府県',
            17 => '自宅市区町村',
            18 => '自宅番地',
            19 => '090-1111-1111',
            20 => '1111-11-1111',
            21 => '1111-11-1111',
            22 => 'http://zitakuURL.test',
            23 => '1989/1/5',
            24 => 'メモテスト'
        );
        $expectedData3 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '',
            'work_postcode' => '0000-000',
            'home_postcode2' => '',
            'home_postcode' => '11-11111'
        );
        $this->assertEquals($expectedData3, $this->invokeMethod($this->component, "generateImportData", [$testAdrDataType3]));

        // Testcase 4: postcode NG
        $testAdrDataType4 = array(
            0 => '姓',
            1 => '名',
            2 => 'ニックネーム',
            3 => 'address@address.test',
            4 => '会社名',
            5 => '会社所属',
            6 => '会社国',
            7 => '0000000',
            8 => '会社都道府県',
            9 => '会社市区町村',
            10 => '会社番地',
            11 => '0000-00-0000',
            12 => '0000-00-0000',
            13 => 'http://kaisyaURL.test',
            14 => '自宅国',
            15 => '1111111',
            16 => '自宅都道府県',
            17 => '自宅市区町村',
            18 => '自宅番地',
            19 => '090-1111-1111',
            20 => '1111-11-1111',
            21 => '1111-11-1111',
            22 => 'http://zitakuURL.test',
            23 => '1989/1/5',
            24 => 'メモテスト'
        );
        $expectedData4 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '',
            'work_postcode' => '0000000',
            'home_postcode2' => '',
            'home_postcode' => '1111111'
        );
        $this->assertEquals($expectedData4, $this->invokeMethod($this->component, "generateImportData", [$testAdrDataType4]));

        // Testcase 5: NG
        $this->assertFalse($this->invokeMethod($this->component, "generateImportData", [null]));
    }

    /**
     * Test validate method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validate()
    {
        // Testcase 1: OK
        $testAddress1 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '0000',
            'work_postcode' => '000',
            'home_postcode2' => '1111',
            'home_postcode' => '111'
        );
        $this->assertNull($this->component->validate($testAddress1, $this->testUserSeq));

        // Testcase 2: NG nickname is not existed
        $testAddress2 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => '',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '0000',
            'work_postcode' => '000',
            'home_postcode2' => '1111',
            'home_postcode' => '111'
        );
        $expectedOutput2 = array(
            'nickname' => ['_empty' => 'ニックネームを入力してください｡']
        );
        $this->assertEquals($expectedOutput2, $this->component->validate($testAddress2, $this->testUserSeq));

        // Testcase 3: NG incorrect postcodes' format
        $testAddress3 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '0000',
            'work_postcode' => '00',
            'home_postcode2' => '1111',
            'home_postcode' => '11'
        );
        $expectedOutput3 = array(
            'work_postcode' => '会社の郵便番号を日本の郵便番号形式で入力してください｡',
            'home_postcode' => '自宅の郵便番号を日本の郵便番号形式で入力してください｡'
        );
        $this->assertEquals($expectedOutput3, $this->component->validate($testAddress3, $this->testUserSeq));

        // Testcase 4: NG incorrect postcodes' format  and nickname is not existed
        $testAddress4 = array(
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => '',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_url' => 'http://zitakuURL.test',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'work_postcode2' => '0000',
            'work_postcode' => '00',
            'home_postcode2' => '1111',
            'home_postcode' => '11'
        );
        $expectedOutput4 = array(
            'nickname' => ['_empty' => 'ニックネームを入力してください｡'],
            'work_postcode' => '会社の郵便番号を日本の郵便番号形式で入力してください｡',
            'home_postcode' => '自宅の郵便番号を日本の郵便番号形式で入力してください｡'
        );
        $this->assertEquals($expectedOutput4, $this->component->validate($testAddress4, $this->testUserSeq));
    }

    /**
     * Test fgetCsvReg method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function fgetCsvReg()
    {
        $fileInfo = new \stdClass();
        // Testcase 1: OK
        $fileInfo->fileName = 'address_fgetCsvReg_OK.csv';
        $fileInfo->filePath = '\xampp\tmp\address_fgetCsvReg_OK.csv';
        $fp = fopen($fileInfo->filePath, 'r');
        $expectedOutput = array(
            0 => '姓',
            1 => '名',
            2 => 'ニックネーム',
            3 => '電子メール アドレス',
            4 => '会社名',
            5 => '部署',
            6 => '勤務先の国または地域',
            7 => '勤務先の郵便番号',
            8 => '勤務先の都道府県',
            9 => '勤務先の市区町村',
            10 => '勤務先の番地',
            11 => '勤務先電話番号',
            12 => '勤務先ファックス  ',
            13 => 'ビジネス Web ページ',
            14 => '国または地域',
            15 => '自宅の郵便番号',
            16 => '自宅の都道府県',
            17 => '自宅の市区町村',
            18 => '自宅の番地',
            19 => '携帯電話',
            20 => '自宅電話番号',
            21 => '自宅ファックス',
            22 => '個人 Web ページ',
            23 => '誕生日',
            24 => 'メモ'
        );
        $this->assertEquals($expectedOutput, $this->invokeMethod($this->component, "fgetCsvReg", [&$fp]));

        // Testcase 2: NG
        $fileInfo->fileName = 'addressBOM_fgetCsvReg_NG.csv';
        $fileInfo->filePath = '\xampp\tmp\addressBOM_fgetCsvReg_NG.csv';
        $fp = fopen($fileInfo->filePath, 'r');
        $this->assertEquals($expectedOutput, $this->invokeMethod($this->component, "fgetCsvReg", [&$fp]));

        // Testcase 3: NG Blank file
        $fileInfo->fileName = 'addressZeroLine.csv';
        $fileInfo->filePath = '\xampp\tmp\addressZeroLine.csv';
        $fp = fopen($fileInfo->filePath, 'r');
        $this->assertFalse($this->invokeMethod($this->component, "fgetCsvReg", [&$fp]));
    }

    /**
     * Test readCsvFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function readCsvFile()
    {
        $fileInfo = new \stdClass();
        // Case 1: OK - Window live mail template
        $fileInfo->fileName = 'address_readCsvFile_OK.csv';
        $fileInfo->filePath = '\xampp\tmp\address_readCsvFile_OK.csv';
        $expectedOutput1 = array(
            1 => [
                'name_l' => '姓',
                'name_f' => '名',
                'nickname' => 'ニックネーム',
                'email' => 'address@address.test',
                'org_name' => '会社名',
                'org_post' => '会社所属',
                'work_countory' => '会社国',
                'work_pref' => '会社都道府県',
                'work_adr1' => '会社市区町村',
                'work_adr2' => '会社番地',
                'work_url' => 'http://kaisyaURL.test',
                'home_countory' => '自宅国',
                'home_pref' => '自宅都道府県',
                'home_adr1' => '自宅市区町村',
                'home_adr2' => '自宅番地',
                'home_cell' => '090-1111-1111',
                'home_url' => 'http://zitakuURL.test',
                'work_tel' => '0000-00-0000',
                'work_fax' => '0000-00-0000',
                'home_tel' => '1111-11-1111',
                'home_fax' => '1111-11-1111',
                'birthday' => '',
                'note' => 'メモテスト',
                'work_postcode2' => '0000',
                'work_postcode' => '000',
                'home_postcode2' => '1111',
                'home_postcode' => '111'
            ]
        );
        $this->assertEquals($expectedOutput1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 2: NG - Blank file
        $fileInfo->fileName = 'addressZeroLine.csv';
        $fileInfo->filePath = '\xampp\tmp\addressZeroLine.csv';
        $this->assertEquals(array(), $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 3: NG - Non-existed file
        $fileInfo->fileName = 'non_exist_address.csv';
        $fileInfo->filePath = '\xampp\tmp\non_exist_address.csv';
        $this->assertFalse($this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 4: NG - File has no match header - Window live mail template
        $fileInfo->fileName = 'address_windowlivemail_noMatchHeader.csv';
        $fileInfo->filePath = '\xampp\tmp\address_windowlivemail_noMatchHeader.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 5: NG - Missing field - Window live mail template
        $fileInfo->fileName = 'address_missingField1_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField1_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField2_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField2_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField23_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField3_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField4_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField4_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField5_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField5_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField6_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField6_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField7_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField7_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField8_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField8_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField9_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField9_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField10_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField10_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField11_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField11_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField12_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField12_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField13_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField13_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField14_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField14_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField15_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField15_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField16_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField16_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_missingField17_window.csv';
        $fileInfo->filePath = '\xampp\tmp\address_missingField17_window.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 6: OK - Outlook
        $fileInfo->fileName = 'address_outlook_OK.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_OK.csv';
        $expectedOutput2 = array(
            1 => [
                'name_l' => '姓',
                'name_f' => '名',
                'nickname' => '',
                'email' => 'address@address.test',
                'org_name' => '会社名',
                'org_post' => '会社所属',
                'work_countory' => '会社国',
                'work_pref' => '会社都道府県',
                'work_adr1' => '会社市区町村',
                'work_adr2' => '会社番地',
                'work_url' => 'http://kaisyaURL.test',
                'home_countory' => '自宅国',
                'home_pref' => '自宅都道府県',
                'home_adr1' => '自宅市区町村',
                'home_adr2' => '自宅番地',
                'home_cell' => '090-1111-1111',
                'work_tel' => '0000-00-0000',
                'work_fax' => '0000-00-0000',
                'home_tel' => '1111-11-1111',
                'home_fax' => '1111-11-1111',
                'birthday' => '1989/1/5',
                'note' => 'メモテスト',
                'work_postcode2' => '0000',
                'work_postcode' => '000',
                'home_postcode2' => '1111',
                'home_postcode' => '111'
            ]
        );
        $this->assertEquals($expectedOutput2, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        // Case 7: NG - Missing field - Outlook template
        $fileInfo->fileName = 'address_outlook_missingField1.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField1.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField2.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField2.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField3.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField3.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField4.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField4.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField5.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField5.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField6.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField6.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField7.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField7.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField8.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField8.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField9.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField9.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField10.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField10.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField11.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField11.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField12.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField12.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField13.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField13.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField14.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField14.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField15.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField15.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));

        $fileInfo->fileName = 'address_outlook_missingField16.csv';
        $fileInfo->filePath = '\xampp\tmp\address_outlook_missingField16.csv';
        $this->assertEquals(-1, $this->invokeMethod($this->component, "readCsvFile", [$fileInfo]));
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }
}
