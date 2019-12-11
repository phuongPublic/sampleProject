<?php

namespace App\Test\TestCase\Controller;

use App\Controller\Component\AdminCommonComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\I18n\Time;

/**
 * App\Controller\Component\AdminCommonComponentTest Test Case
 */
class AdminCommonComponentTest extends NoptComponentIntegrationTestCase
{

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AdminCommonComponent($registry);
    }

    /**
     * Test Test_ACCpn_compareWithNow_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_compareWithNow_001()
    {
        // case 1 parameter $date has normal value
        $date = Time::now();
        $date->modify('-1 days');
        $result = $this->component->compareWithNow($date);
        $this->assertTrue($result);
    }

    /**
     * Test Test_ACCpn_compareWithNow_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_compareWithNow_002()
    {
        // case 1 parameter $date has abnormal value
        $date = null;
        $result = $this->component->compareWithNow($date);
        $this->assertFalse($result);
    }

    /**
     * Test Test_ACCpn_compareWithNow_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_compareWithNow_003()
    {
        // case 1 parameter $date has normal value
        $date = Time::now();
        $date->modify('+1 days');
        $result = $this->component->compareWithNow($date);
        $this->assertFalse($result);
    }

    /**
     * Test Test_ACCpn_uploadImage_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_uploadImage_001()
    {
        // case 1 parameter $imageData has normal value
        $imageData = array(
            'name' => 'imageTest.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
            'error' => 0,
            'size' => 1000
        );
        $uploaded = $this->component->uploadImage($imageData);
        // GET PATH in: config/tcom/local-dev/environment_setting.php
        $expected = 'E:\home\personaltool2\storage\00001\admin\banner';
        $result = substr_compare($uploaded, $expected, 0, 48, TRUE);
        $this->assertEquals(0, $result);
    }

    /**
     * Test Test_ACCpn_uploadImage_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_uploadImage_002()
    {
        // case 1 parameter $imageData has normal value
        $imageData = array(
            'name' => '',
            'type' => '',
            'tmp_name' => '',
            'error' => 0,
            'size' => 0
        );
        $result = $this->component->uploadImage($imageData);
        $this->assertFalse($result);
    }

    /**
     * Test Test_ACCpn_parseDate_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_parseDate_001()
    {
        // case 1 parameter $pieces has normal value
        $pieces = array(
            'year' => '2017',
            'month' => '05',
            'day' => '22',
            'hour' => '15',
            'minute' => '00'
        );
        $equalsResult = '2017-05-22 15:00:00';

        $result = $this->component->parseDate($pieces);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_parseDate_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_parseDate_002()
    {
        // case 1 parameter $pieces has normal value
        $pieces = array(
        );
        $equalsResult = date('Y-m-d H:i:s');

        $result = $this->component->parseDate($pieces);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_getListYear_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_getListYear_001()
    {
        // case 1 parameter $action has normal value
        $action = 'topics';
        $equalsResult = array(
            2017 => '2017',
            2018 => 2018,
            2019 => 2019,
            2020 => 2020,
            99 => '下書き'
        );

        $result = $this->component->getListYear($action);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_getListYear_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_getListYear_002()
    {
        // case 1 parameter $action has normal value
        $action = 'campaign';
        $equalsResult = array(
            2017 => '2017',
            2018 => 2018,
            2019 => 2019,
            2020 => 2020,
            99 => '下書き'
        );

        $result = $this->component->getListYear($action);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_getListYear_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_getListYear_003()
    {
        // case 1 parameter $action has normal value
        $action = 'ad';
        $equalsResult = array(
            2017 => '2017',
            2018 => 2018,
            2019 => 2019,
            2020 => 2020,
            99 => '下書き'
        );

        $result = $this->component->getListYear($action);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_getListYear_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_getListYear_004()
    {
        // case 1 parameter $action has normal value
        $action = '';
        $equalsResult = array(
            2017 => '2017',
            2018 => 2018,
            2019 => 2019,
            2020 => 2020,
            99 => '下書き'
        );

        $result = $this->component->getListYear($action);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_changeOrder_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_changeOrder_001()
    {
        // case 1 parameter $order has normal value
        $order = '';
        $equalsResult = 2;

        $result = $this->component->changeOrder($order);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_changeOrder_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_changeOrder_002()
    {
        // case 1 parameter $order has normal value
        $order = 1;
        $equalsResult = 2;

        $result = $this->component->changeOrder($order);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_changeOrder_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_changeOrder_003()
    {
        // case 1 parameter $order has normal value
        $order = 2;
        $equalsResult = 1;

        $result = $this->component->changeOrder($order);
        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_001()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '33'
            ],
        ];

        $equalsResult = array(
            'viewFlg' => '1',
            'timerFlg' => '1',
            'openData' => date('Y-m-d H:i:s'),
            'timerData' => '2017-05-24 15:33:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_002()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '1',
            'timerFlg' => '2'
        ];

        $equalsResult = array(
            'viewFlg' => '1',
            'timerFlg' => '2',
            'openData' => date('Y-m-d H:i:s'),
            'timerData' => '0000-00-00 00:00:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_003()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '2',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '05'
            ],
        ];

        $equalsResult = array(
            'viewFlg' => '2',
            'timerFlg' => '1',
            'openData' => date('Y-m-d H:i:s'),
            'timerData' => '2017-05-24 15:05:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_004()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '2',
            'timerFlg' => '2'
        ];

        $equalsResult = array(
            'viewFlg' => '2',
            'timerFlg' => '2',
            'openData' => date('Y-m-d H:i:s'),
            'timerData' => '0000-00-00 00:00:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_005()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '05'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '06'
            ]
        ];

        $equalsResult = array(
            'viewFlg' => '3',
            'openData' => '2017-05-24 15:05:00',
            'timerFlg' => '1',
            'timerData' => '2017-05-24 15:06:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_006 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_006()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '05'
            ],
            'timerFlg' => '2'
        ];

        $equalsResult = array(
            'viewFlg' => '3',
            'openData' => '2017-05-24 15:05:00',
            'timerFlg' => '2',
            'timerData' => '0000-00-00 00:00:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_007 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_007()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '4',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '05',
                'day' => '24',
                'hour' => '15',
                'minute' => '05'
            ]
        ];

        $equalsResult = array(
            'viewFlg' => '4',
            'timerFlg' => '1',
            'timerData' => '2017-05-24 15:05:00',
            'openData' => date('Y-m-d H:i:s')
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    /**
     * Test Test_ACCpn_createDatetime_008 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_ACCpn_createDatetime_008()
    {
        // case 1 parameter $data has normal value
        $data = [
            'viewFlg' => '4',
            'timerFlg' => '2'
        ];

        $equalsResult = array(
            'viewFlg' => '4',
            'timerFlg' => '2',
            'openData' => date('Y-m-d H:i:s'),
            'timerData' => '0000-00-00 00:00:00'
        );

        $result = $this->component->createDatetime($data);

        $this->assertEquals($equalsResult, $result);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }

}
