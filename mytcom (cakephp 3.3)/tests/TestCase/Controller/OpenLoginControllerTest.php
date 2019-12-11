<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use ReflectionClass;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use App\Controller\OpenLoginController;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\OpenLoginControllerTest Test Case
 */
class OpenLoginControllerTest extends NoptIntegrationTestCase
{
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
        $this->controller = new OpenLoginController();
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
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        //redirect case
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        //redirect case
        $this->switchDevice(2);
        $this->get($this->testUrl . '?id=open_id1');
        $this->assertResponseCode(200);
    }

    /**
     * Test indexProcess method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexProcess()
    {
        $this->loadFixtures('OpenStatus', 'TargetUser');
        //exist user_seq with normal case
        $this->get($this->testUrl . '?id=open_id1&seq=385cd85a14bb90c754897fd0366ff266');
        $this->assertResponseCode(302);

        //exist user_seq with no data
        $this->get($this->testUrl . '?id=open_id&seq=385cd85a14bb90c754897fd0366ff266');
        $this->assertResponseCode(302);

        //exist data post with normal case
        $data = [
            'mail' => 'test@bip.co.jp',
            'open_id' => 'open_id1',
            'login' => 'ログイン',
        ];
        $this->post($this->testUrl.'?id=open_id1', $data);
        $this->assertResponseCode(302);

        //exist data post with no data
        $data = [
            'mail' => 'test@bip.co.jp',
            'open_id' => 'open_id1',
            'login' => 'ログイン',
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //exist data post with no target user
        $data = [
            'mail' => 'test@bip.co.jp',
            'open_id' => 'openid_error',
            'login' => 'ログイン',
        ];
        $this->post($this->testUrl.'?id=openid_error', $data);
        $this->assertResponseCode(302);
    }

    /**
     * Test mailDataDelivery method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function mailDataDelivery()
    {
        //send mail with file open
        $openData = array (
            'OpenStatus' => array
            (
                '0' => 1,
                '1' => array
                (
                    '0' => array
                    (
                        'open_id' => 'open_id1',
                        'target_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'open_type' => 2,
                        'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                        'close_type' => 3,
                        'access_check' => 0,
                        'nickname' => 'Test',
                        'message' => 'test',
                        'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                        'download_count' => 0,
                    ),
                )
            ),
            'FileData' => array
            (
                '0' => array(
                    'file_id' => 1,
                    'file_folder_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'file_name' => 'file 1.jpg',
                    'name' => 'file 1',
                    'extension' => 'jpg',
                    'amount' => 259344,
                    'base' => 00001,
                    'file_uri' => '/home/mytcom/parsonaltool/storage/00001/385cd85a14bb90c754897fd0366ff266/album/0000000001',
                    'file_comment' => "",
                    'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                )
            ),
            'FileFolderData' => array(
                '0' => array(
                    'file_folder_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'file_folder_name' => 'test',
                    'comment' => "",
                    'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                )
            ),
            'UserData' => array
            (
                '0' => 1,
                '1' => array
                (
                    '0' => array
                    (
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'user_address' => 'kikakukaihatu23@tbz.t-com.ne.jp',
                        'user_name' => 'aaa',
                        'reg_flg' => 1,
                        'del_flg' => 0,
                        'up_date' => $this->makeTimeObj('2016-12-09 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-01-11 00:00:00.000000', 'UTC'),
                        'user_id' => 'kikakukaihatu23',
                        'user_password' => 'UZmnin9HshIrF3lhcNfEmw==',
                        'base' => 00001,
                        'mobile_id' => NULL,
                        'mail_seq' => 'ef6eb38c2b',
                        'file_size' => 0,
                        'album_size' => -2558736,
                        'reminder_pc' => NULL,
                        'reminder_mobile' => NULL,
                        'reminder_mobile_flg' => "",
                        'reminder_pc_flg' => "",
                        'reminder_time' => 0,
                        'movie_size' => 0,
                        'log_date' => $this->makeTimeObj('2016-09-28 08:49:53.000000', 'Asia/Tokyo'),
                        'google_token' => ""
                    )
                )
            )
        );
        $result = $this->invokeMethod($this->controller, "mailDataDelivery", [$openData, 2]);
        $this->assertNull($result);

        //send mail with pic or album open
        $openData = array (
            'OpenStatus' => array
            (
                '0' => 1,
                '1' => array
                (
                    '0' => array
                    (
                        'open_id' => 'open_id1',
                        'target_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'open_type' => 2,
                        'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                        'close_type' => 3,
                        'access_check' => 0,
                        'nickname' => 'Test',
                        'message' => 'test',
                        'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                        'download_count' => 0,
                    ),
                )
            ),
            'PictureData' => array
            (
                '1' => array
                (
                    '0' => array
                    (
                        'pic_id' => 1,
                        'album_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'pic_name' => 'test.PNG',
                        'name' => 'test',
                        'extension' => 'PNG',
                        'amount' => 259344,
                        'base' => 00001,
                        'pic_url' => '/home/mytcom/parsonaltool/storage/00001/a1eebec0b21bd568f235965367f6fa91/album/0000000001',
                        'pic_comment' => "",
                        'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                    )
                ),
                '0' => 1
            ),
            'AlbumData' => array
            (
                '0' => 1,
                '1' => array
                (
                    '0' => array
                    (
                        'album_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'album_name' => 'test',
                        'album_comment' => 'test',
                        'album_pic_count' => 0,
                        'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                    )
                )
            ),
            'UserData' => array
            (
                '0' => 1,
                '1' => array
                (
                    '0' => array
                    (
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'user_address' => 'kikakukaihatu23@tbz.t-com.ne.jp',
                        'user_name' => 'test',
                        'reg_flg' => 1,
                        'del_flg' => 0,
                        'up_date' => $this->makeTimeObj('2016-12-09 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-01-11 00:00:00.000000', 'UTC'),
                        'user_id' => 'kikakukaihatu23',
                        'user_password' => 'UZmnin9HshIrF3lhcNfEmw==',
                        'base' => 00001,
                        'mobile_id' => NULL,
                        'mail_seq' => 'ef6eb38c2b',
                        'file_size' => 0,
                        'album_size' => -2558736,
                        'reminder_pc' => NULL,
                        'reminder_mobile' => NULL,
                        'reminder_mobile_flg' => "",
                        'reminder_pc_flg' => "",
                        'reminder_time' => 0,
                        'movie_size' => 0,
                        'log_date' => $this->makeTimeObj('2016-09-28 08:49:53.000000', 'Asia/Tokyo'),
                        'google_token' => ""
                    )
                )
            )
        );
        $result = $this->invokeMethod($this->controller, "mailDataDelivery", [$openData, 3]);
        $this->assertNull($result);
    }

    /**
     * Test prepareData method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function prepareData()
    {
        //prepare file open data
        $openId = 'openid_file';
        $openInfo = array('0' => 1,
            '1' => array(
                '0' => array
                (
                    'open_id' => 'openid_file',
                    'target_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'open_type' => 2,
                    'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                    'close_type' => 3,
                    'access_check' => 0,
                    'nickname' => 'Test',
                    'message' => 'test',
                    'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                    'download_count' => 0)));
        $result = $this->invokeMethod($this->controller, "prepareData", [$openInfo, 2, $this->testUserSeq, $openId]);
        $this->assertEquals('/Open/Storage.html?id=' .$openId , $result);

        //prepare file pic data
        $openId = 'openid_pic';
        $openInfo = array('0' => 1,
            '1' => array(
                '0' => array
                (
                    'open_id' => 'openid_pic',
                    'target_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'open_type' => 3,
                    'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                    'close_type' => 3,
                    'access_check' => 0,
                    'nickname' => 'Test',
                    'message' => 'test',
                    'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                    'download_count' => 0)));
        $result = $this->invokeMethod($this->controller, "prepareData", [$openInfo, 3, $this->testUserSeq, $openId]);
        $this->assertEquals('/Open/Album.html?id=' .$openId , $result);
    }
    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData();
    }

    /**
     * Create time object
     * @return object
     */
    protected function makeTimeObj($time, $timeZone)
    {
        $timeInfo = new Time($time, $timeZone);
        return $timeInfo;
    }
}
