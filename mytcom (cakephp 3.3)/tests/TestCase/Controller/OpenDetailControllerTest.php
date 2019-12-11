<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\I18n\Time;

/**
 * App\Controller\OpenDetailControllerTest Test Case
 */
class OpenDetailControllerTest extends NoptIntegrationTestCase
{
    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        //redirect case
        $this->switchDevice(2);
        $this->get($this->testUrl . '?id=open_id1&fid=0001&ffid=1');
        $this->assertResponseCode(302);

        $this->loadFixtures('OpenStatus');
        //normal case
        $this->switchDevice(2);
        $this->setSession();
        $this->get($this->testUrl . '?id=open_id1&fid=0001&ffid=1');
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData('OpenStatusData', Array (
            'OpenStatus' => Array
            (
                '0' => 1,
                '1' => Array
                (
                    '0' => Array
                    (
                        'open_id' => 'open_id1',
                        'target_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'open_type' => 2,
                        'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                        'close_type' => 3,
                        'access_check' => 0,
                        'nickname' => 'Test',
                        'message' => 'fsdfds',
                        'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                        'download_count' => 0,
                    ),
                )
            ),
            'FileData' => Array
            (
                '0' => Array(
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
            'FileFolderData' => Array(
                '0' => Array(
                    'file_folder_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'file_folder_name' => 'dfdf',
                    'comment' => "",
                    'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                )
            ),
            'UserData' => Array
            (
                '0' => 1,
                '1' => Array
                (
                    '0' => Array
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
        ));
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
