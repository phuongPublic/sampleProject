<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\I18n\Time;

/**
 * App\Controller\MovieOpenDisplayController Test Case
 */
class MovieOpenDisplayControllerTest extends NoptIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.OpenStatus',
        'app.UserMst'
    ];

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexPc()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->setSession();

        //failed pc
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?cid=100&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //failed sp
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?cid=100&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //pc
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?cid=1&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //iphone
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?cid=1&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        //android
        $result = true;
        try {
            $this->switchDevice(3);
            $this->get($this->testUrl . '?cid=1&type=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('OpenStatusData', array(
            'OpenStatus' => array(
                '0' => 1,
                '1' => array(
                    '0' => array(
                        'open_id' => 'openid_pic',
                        'target_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'open_type' => 5,
                        'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                        'close_type' => 3,
                        'access_check' => 0,
                        'nickname' => 'Test',
                        'message' => 'fsdfds',
                        'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                        'download_count' => 0,
                    ),
                )),
            'PictureData' => array(
                '1' => array(
                    '0' => array(
                        'pic_id' => 1,
                        'album_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'pic_name' => '12345678901234567890123.PNG',
                        'name' => '12345678901234567890123',
                        'extension' => 'PNG',
                        'amount' => 259344,
                        'base' => 00001,
                        'pic_url' => '/home/mytcom/parsonaltool/storage/00001/a1eebec0b21bd568f235965367f6fa91/album/0000000001',
                        'pic_comment' => "",
                        'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                    )),
                '0' => 1),
            'AlbumData' => array(
                '0' => 1,
                '1' => array(
                    '0' => array(
                        'album_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'album_name' => '12345678901234567890123',
                        'album_comment' => "",
                        'album_pic_count' => 0,
                        'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                    ))),
            'UserData' => array(
                '0' => 1,
                '1' => array(
                    '0' => array(
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
                        'mobile_id' => null,
                        'mail_seq' => 'ef6eb38c2b',
                        'file_size' => 0,
                        'album_size' => -2558736,
                        'reminder_pc' => null,
                        'reminder_mobile' => null,
                        'reminder_mobile_flg' => "",
                        'reminder_pc_flg' => "",
                        'reminder_time' => 0,
                        'movie_size' => 0,
                        'log_date' => $this->makeTimeObj('2016-09-28 08:49:53.000000', 'Asia/Tokyo'),
                        'google_token' => ""
                    )
                )
            )
        ));
        parent::setSessionData('openId', 'openid_pic');
        parent::setSessionData('openflg', 1);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return object
     */
    protected function makeTimeObj($time, $timeZone)
    {
        $timeInfo = new Time($time, $timeZone);
        return $timeInfo;
    }
}
