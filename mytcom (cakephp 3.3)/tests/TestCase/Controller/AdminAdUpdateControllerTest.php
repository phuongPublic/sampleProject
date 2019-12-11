<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Controller\AdminAdUpdateController;

/**
 * App\Controller\AdminAdListControllerTest Test Case
 */
class AdminAdUpdateControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/admin/ad/list.html'; //通常遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.AdTbl'];
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('AdTbl');
        $this->controller = new AdminAdUpdateController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test Test_AAUCtl_index_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_index_001()
    {
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test Test_AAUCtl_index_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_index_002()
    {
        $postData = array(
            'title' => 'Test ad title',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 1,
            'timerFlg' => 2,
            'contents' => 'test ad 01',
            'adseq' => 1,
        );
        $this->post($this->testUrl, $postData);
        $this->assertResponseCode(302);
    }

    /**
     * Test Test_AAUCtl_loadData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_loadData_001()
    {
        $this->loadFixtures('AdTbl');
        $adseq = 1;
        $result = $this->invokeMethod($this->controller, 'loadData', array($adseq));
        $this->assertNull($result);
    }

    /**
     * Test Test_AAUCtl_loadData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_loadData_002()
    {
        $this->loadFixtures('AdTbl');
        $adseq = null;
        $result = $this->invokeMethod($this->controller, 'loadData', array($adseq));
        $this->assertNull($result);
    }

    /**
     * Test Test_AAUCtl_updateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_updateData_001()
    {
        $this->loadFixtures('AdTbl');
        $data = array(
            'title' => 'Test ad title',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 2,
            'contents' => 'Ad contents',
            'adseq' => 1,
        );
        $result = $this->invokeMethod($this->controller, 'updateData', array($data));
        $this->assertNotNull($result);
    }

    /**
     * Test Test_AAUCtl_updateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_updateData_002()
    {
        $this->loadFixtures('AdTbl');
        $data = array(
            'title' => 'Test ad title',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 1,
            'timerData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '00',
                'minute' => '01'
            ),
            'contents' => 'Ad contents',
            'adseq' => 1,
        );
        $result = $this->invokeMethod($this->controller, 'updateData', array($data));
        $this->assertNotNull($result);
    }

    /**
     * Test Test_AAUCtl_updateData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_updateData_003()
    {
        $this->loadFixtures('AdTbl');
        $data = array(
            'title' => 'Test ad title 5. Unit testcase title with english max length 150 characters. Test ad title unit testcase title with english max length 150 characters.',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 1,
            'timerData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '19',
                'hour' => '01',
                'minute' => '01'
            ),
            'contents' => 'Ad contents',
            'adseq' => 1,
        );
        $result = $this->invokeMethod($this->controller, 'updateData', array($data));
        $this->assertNull($result);
    }

    /**
     * Test Test_AAUCtl_validateData_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_001()
    {
        // case: title: 半角150文字 TRUE
        $data = array(
            'title' => 'Test ad title 5. Unit testcase title with english max length 150 characters. Test ad title unit testcase title with english max length 150 characters.',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }


    /**
     * Test Test_AAUCtl_validateData_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_002()
    {
        // case: title: 半角150文字 FALSE
        $data = array(
            'title' => 'Test ad title 5. Unit testcase title with english max length 150 characters. Test ad title unit testcase title with english max length 150 characters...',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_003()
    {
        // case: title: 全角50文字 TRUE
        $data = array(
            'title' => 'サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。データテスト',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }


    /**
     * Test Test_AAUCtl_validateData_004
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_004()
    {
        // case: title: 全角50文字 FALSE
        $data = array(
            'title' => 'サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。サンプルデータテスト。データテスト。',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_005
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_005()
    {
        $data = array(
            'contents' => 'test ad contents',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_006
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_006()
    {
        $data = array(
            'contents' => '',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_007
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_007()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_008
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_008()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.jpg',
                'type' => 'image/pjpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ]
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }


    /**
     * Test Test_AAUCtl_validateData_009
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_009()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.png',
                'type' => 'image/png',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_010
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_010()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.png',
                'type' => 'image/x-png',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ]
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }


    /**
     * Test Test_AAUCtl_validateData_011
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_011()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.gif',
                'type' => 'image/gif',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_012
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_012()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.bmp',
                'type' => 'image/bitmap',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ]
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }


    /**
     * Test Test_AAUCtl_validateData_013
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_013()
    {
        $data = array(
            'adImage' => [
                'name' => 'imageTest.psd',
                'type' => 'image/photoshop',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => (int) 0,
                'size' => (int) 1000
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_014
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_014()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '30',
                'hour' => '15',
                'minute' => '45'
            ],
            'timerFlg' => '2',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_015
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_015()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '31',
                'hour' => '15',
                'minute' => '45'
            ],
            'timerFlg' => '2',
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_016
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_016()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '30',
                'hour' => '15',
                'minute' => '49'
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_017
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_017()
    {
        $data = array(
            'viewFlg' => '1',
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '31',
                'hour' => '15',
                'minute' => '49'
            ],
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_018
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_018()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '01',
                'hour' => '15',
                'minute' => '52'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '30',
                'hour' => '15',
                'minute' => '52'
            ],
            'checkTime' => [
                'openData' => '2017-06-01 15:52:00',
                'timerData' => '2017-06-30 15:52:00'
            ]
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertTrue($validator);
    }

    /**
     * Test Test_AAUCtl_validateData_019
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_validateData_019()
    {
        $data = array(
            'viewFlg' => '3',
            'openData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '01',
                'hour' => '15',
                'minute' => '52'
            ],
            'timerFlg' => '1',
            'timerData' => [
                'year' => '2017',
                'month' => '06',
                'day' => '01',
                'hour' => '15',
                'minute' => '52'
            ],
            'checkTime' => [
                'openData' => '2017-06-01 15:52:00',
                'timerData' => '2017-06-01 15:52:00'
            ]
        );
        $validator = $this->invokeMethod($this->controller, 'validateData', array($data));
        $this->assertFalse($validator);
    }

    /**
     * Test Test_AAUCtl_update_001
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_update_001()
    {
        $data = array(
            'title' => 'Hanoi Ad',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 1,
            'timerData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '00',
                'minute' => '01'
            ),
            'contents' => 'Ad contents',
            'adseq' => 1
        );
        $result = $this->invokeMethod($this->controller, 'update', array($data));
        $this->assertTrue($result);
    }

    /**
     * Test Test_AAUCtl_update_002
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_update_002()
    {
        $data = array(
            'title' => 'Hanoi Ad',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 1,
            'timerData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '00',
                'minute' => '01'
            ),
            'contents' => 'Ad contents',
            'adseq' => 1,
            'adImage' => array(
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '\home\personaltool2\tests\TestData\imageTest.tmp',
                'error' => 0,
                'size' => 1000
            )
        );
        $result = $this->invokeMethod($this->controller, 'update', array($data));
        $this->assertTrue($result);
    }

    /**
     * Test Test_AAUCtl_update_003
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function Test_AAUCtl_update_003()
    {
        $data = array(
            'title' => 'Hanoi Ad',
            'pub_flg' => 1,
            'pos_flg' => 1,
            'viewFlg' => 3,
            'openData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '22',
                'hour' => '12',
                'minute' => '01'
            ),
            'timerFlg' => 1,
            'timerData' => array(
                'year' => '2017',
                'month' => '05',
                'day' => '23',
                'hour' => '00',
                'minute' => '01'
            ),
            'contents' => 'Ad contents',
            'adseq' => 1,
            'adImage' => array(
                'name' => 'imageTest.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '',
                'error' => 0,
                'size' => 1000
            )
        );
        $result = $this->invokeMethod($this->controller, 'update', array($data));
        $this->assertFalse($result);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
// ffidが1番のデータを削除対象とする
//parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }

}
