<?php

namespace App\Test\TestCase\Controller;

use App\Controller\Component\AdminMainteComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\Controller\ComponentRegistry;
use App\Validation\NoptBaseValidator;
use ReflectionClass;
use Cake\TestSuite\Fixture\FixtureManager;

class AdminMainteComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = ['app.Mainte'];
    public $autoFixtures = false; // CUD系のテストの為自動読み込み不可。loadFixturesを使用し初期化
    public $component = null;

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AdminMainteComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }

    /**
     * Test_AMCpn_registMainte_001: Register successfully with valid input
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_registMainte_001()
    {
        $mainteObj = [
            'mainte_status' => '3',
            'mainte_start_time' => '2017-01-01 00:00:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->registMainte($mainteObj));
    }

    /**
     * Test_AMCpn_registMainte_003
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_registMainte_003()
    {
        $mainteObj = [
            'mainte_status' => '1',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->registMainte($mainteObj));
    }

    /**
     * Test_AMCpn_registMainte_004
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_registMainte_004()
    {
        $mainteObj = [
            'mainte_status' => '2',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->registMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_registMainte_005
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_registMainte_005()
    {
        $mainteObj = [
            'mainte_status' => '4',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->registMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_registMainte_006
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_registMainte_006()
    {
        $mainteObj = [
            'mainte_status' => '1',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '2',
            'mainte_end_time' => '0000-00-00 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->registMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_updateMainte_001: Update successfully with valid input
     * 
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_updateMainte_001()
    {
        $this->loadFixtures('Mainte');
        $mainteObj = [
            'mainte_id' => 1,
            'mainte_status' => '1',
            'mainte_start_time' => '2017-05-17 00:00:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->updateMainte($mainteObj));
    }

    /**
     * Test_AMCpn_updateMainte_002
     * 
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_updateMainte_002()
    {
        $this->loadFixtures('Mainte');
        $mainteObj = [
            'mainte_id' => 1,
            'mainte_status' => '2',
            'mainte_start_time' => '2017-05-17 00:00:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->updateMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_updateMainte_003
     * 
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_updateMainte_003()
    {
        $this->loadFixtures('Mainte');
        $mainteObj = [
            'mainte_id' => 1,
            'mainte_status' => '3',
            'mainte_start_time' => '2017-05-17 00:00:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->updateMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_updateMainte_004
     * 
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_updateMainte_004()
    {
        $this->loadFixtures('Mainte');
        $mainteObj = [
            'mainte_id' => 1,
            'mainte_status' => '4',
            'mainte_start_time' => '2017-05-17 00:00:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2018-01-01 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->updateMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_updateMainte_005
     * 
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_updateMainte_005()
    {
        $this->loadFixtures('Mainte');
        $mainteObj = [
            'mainte_id' => 1,
            'mainte_status' => '4',
            'mainte_start_time' => '2017-05-17 00:00:00',
            'mainte_end_flg' => '2',
            'mainte_end_time' => '0000-00-00 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertTrue($this->component->updateMainte($mainteObj));
    }
    
    /**
     * Test_AMCpn_deleteMainte_001: Delete successfully with valid input
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_deleteMainte_001()
    {
        $this->loadFixtures('Mainte');
        $mainteId = 1;
        $this->assertTrue($this->component->deleteMainte($mainteId));
    }
    
    /**
     * Test_AMCpn_deleteMainte_002: Delete successfully with valid input and empty DB
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_deleteMainte_002()
    {
        $mainteId = 1;
        $this->assertTrue($this->component->deleteMainte($mainteId));
    }
    
    /**
     * Test_AMCpn_deleteMainte_003: Exception
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
//    public function Test_AMCpn_deleteMainte_003()
//    {
//        $mainteId = 1;
//        $this->component->deleteMainte($mainteId);
//    }
    
    /**
     * Test_AMCpn_subUpdate_001
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_subUpdate_001()
    {
        $this->loadFixtures('Mainte');
        $mainteId = 1;
        $this->assertTrue($this->invokeMethod($this->component, "subUpdate", [$mainteId]));
    }
   
    /**
     * Test_AMCpn_closeMainte_001
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_closeMainte_001()
    {
        $this->loadFixtures('Mainte');
        $mainteArray = [
            1 => [
                'mainte_id' => 1,
                'mainte_status' => '3',
                'mainte_start_time' => '2017-01-01 00:00:00',
                'mainte_end_flg' => '1',
                'mainte_end_time' => '2018-01-01 00:00:00',
                'mainte_body' => 'test'
            ],
        ];
        $this->assertTrue($this->component->closeMainte($mainteArray));
    }

    /**
     * Test_AMCpn_closeMainte_002
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_closeMainte_002()
    {
        $this->loadFixtures('Mainte');
        $mainteArray = [];
        $this->assertTrue($this->component->closeMainte($mainteArray));
    }

    /**
     * Test_AMCpn_convertPostData_001
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_convertPostData_001()
    {
        $input = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test'
        ];
        $flg = 'resetData';
        $expectedOutput = [
            'mainte_status' => '3',
            'mainte_start_time' => '2017-05-17 12:15:00',
            'mainte_end_flg' => '1',
            'mainte_end_time' => '2017-05-17 12:15:00',
            'mainte_body' => 'test'
        ];
        $this->assertEquals($expectedOutput, $this->component->convertPostData($input, $flg));
    }
    
    /**
     * Test_AMCpn_convertPostData_002
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_convertPostData_002()
    {
        $input = [
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test'
        ];
        $flg = 'saveData';
        $expectedOutput = [
            'mainte_status' => '1',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '2',
            'mainte_end_time' => '0000-00-00 00:00:00',
            'mainte_body' => 'test'
        ];
        $this->assertEquals($expectedOutput, $this->component->convertPostData($input, $flg));
    }
    
    /**
     * Test_AMCpn_convertPostData_003
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_convertPostData_003()
    {
        $input = [
            'mainte_id' => 1,
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test'
        ];
        $flg = 'resetData';
        $expectedOutput = [
            'mainte_id' => 1,
            'mainte_status' => '1',
            'mainte_start_time' => date('Y-m-d H:i:s'),
            'mainte_end_flg' => '2',
            'mainte_end_time' => date('Y-m-d H:i:s'),
            'mainte_body' => 'test'
        ];
        $this->assertEquals($expectedOutput, $this->component->convertPostData($input, $flg));
    }
    
    /**
     * Test_AMCpn_validateInputData_001
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_validateInputData_001()
    {
        $input = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
            'checkTime' => [
                'mainte_start_time' => '2017-05-17 12:15:00',
                'mainte_end_time' => '2018-05-17 12:15:00',
            ],
            'bypass' => [
                'mainte_body' => true
            ],
        ];
        $validator = $this->component->validateInputData(new NoptBaseValidator());
        $this->assertEmpty($validator->errors($input));
    }
    
    /**
     * Test_AMCpn_validateInputData_002
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_validateInputData_002()
    {
        $input = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => '',
            'checkTime' => [
                'mainte_start_time' => '2017-05-17 12:15:00',
                'mainte_end_time' => '2018-05-17 12:15:00',
            ],
            'bypass' => [
                'mainte_body' => true
            ],
        ];
        $expectedOutput['mainte_body']['noValue'] = '内容が入力されていません｡';
        
        $validator = $this->component->validateInputData(new NoptBaseValidator());
        $this->assertSame($expectedOutput, $validator->errors($input));
    }
    
    /**
     * Test_AMCpn_validateInputData_003
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_validateInputData_003()
    {
        $input = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2018',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
            'checkTime' => [
                'mainte_start_time' => '2017-02-31 12:15:00',
                'mainte_end_time' => '2018-05-17 12:15:00',
            ],
            'bypass' => [
                'mainte_body' => true
            ],
        ];
        $expectedOutput['mainte_start_time']['notValidDate'] = '正しい公開日時を選択してください。';
        
        $validator = $this->component->validateInputData(new NoptBaseValidator());
        $this->assertSame($expectedOutput, $validator->errors($input));
    }
    
    /**
     * Test_AMCpn_validateInputData_004
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_validateInputData_004()
    {
        $input = [
            'mainte_status' => '3',
            'mainte_start_time' => [
                'year' => '2017',
                'month' => '05',
                'day' => '17',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_end_flg' => '1',
            'mainte_end_time' => [
                'year' => '2010',
                'month' => '02',
                'day' => '31',
                'hour' => '12',
                'minute' => '15'
            ],
            'mainte_body' => 'test',
            'checkTime' => [
                'mainte_start_time' => '2017-05-17 12:15:00',
                'mainte_end_time' => '2010-02-31 12:15:00',
            ],
            'bypass' => [
                'mainte_body' => true
            ],
        ];
        $expectedOutput = [
            'checkTime' => [
                'validTime' => '公開終了日時が予約開始日時より前になっています。',
            ],
            'mainte_end_time' => [
                'notValidDate' => '正しい公開終了日時を選択してください。',
            ],
        ];
        
        $validator = $this->component->validateInputData(new NoptBaseValidator());
        $this->assertSame($expectedOutput, $validator->errors($input));
    }
    
    /**
     * Test_AMCpn_validateInputData_005
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMCpn_validateInputData_005()
    {
        $input = [
            'mainte_status' => '1',
            'mainte_end_flg' => '2',
            'mainte_body' => 'test',
            'bypass' => [
                'mainte_body' => true
            ],
        ];
        $validator = $this->component->validateInputData(new NoptBaseValidator());
        $this->assertEmpty($validator->errors($input));
    }
}
