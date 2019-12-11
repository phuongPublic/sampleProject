<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\I18n\Time;

/**
 * App\Controller\OpenMovieController Test Case
 */
class OpenMovieControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OpenStatus',
        'app.MovieFolder',
        'app.MovieContents',
        'app.UserMst',
        'app.TargetUser'
    ];

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus', 'TargetUser');
        $result = true;
        try {
            $this->switchDevice(1);
            $this->get($this->testUrl . '?id=open_id');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            $this->switchDevice(2);
            $this->setSession();
            $this->get($this->testUrl . '?id=open_id&sort=old');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            $this->switchDevice(1);
            $this->setSession();
            $this->get($this->testUrl . '?id=open_id');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test showMoreOpenMovie method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreOpenMovie()
    {
        $result = true;
        try {
            $this->switchDevice(2);
            $this->setSession();
            $this->get($this->testUrl . '/showMoreOpenMovie?id=open_id&sort=old');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        $result = true;
        try {
            $this->switchDevice(3);
            $this->setSession();
            $this->get($this->testUrl . '/showMoreOpenMovie?id=open_id&sort=old');
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
                        'open_id' => 'open_id',
                        'target_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'open_type' => 4,
                        'close_date' => $this->makeTimeObj('2016-12-16 23:59:59.000000', 'Asia/Tokyo'),
                        'close_type' => 3,
                        'access_check' => 0,
                        'nickname' => 'Test',
                        'message' => 'fsdfds',
                        'reg_date' => $this->makeTimeObj('2016-12-09 16:51:51.000000', 'Asia/Tokyo'),
                        'download_count' => 0,
                    ),
                )),
            'MovieContentsData' => array(
                '1' => array(
                    '0' => array(
                        'movie_contents_id' => 3,
                        'movie_folder_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'movie_contents_name' => 'video_test3.flv',
                        'name' => 'video_test3',
                        'extension' => 'flv',
                        'amount' => 3333333,
                        'movie_contents_url' => '/home/storage/tcom/385cd85a14bb90c754897fd0366ff266/movie/0000000001/encode_movie/',
                        'movie_contents_comment' => 'day la comment',
                        'movie_capture_url' => '/home/storage/tcom/385cd85a14bb90c754897fd0366ff266/movie/0000000001/thumbnail/',
                        'reproduction_time' => '1:0',
                        'resultcode' => 1,
                        'file_id' => 21,
                        'encode_status' => 0,
                        'encode_file_id_flv' => 12,
                        'encode_file_id_docomo_300k' => 13,
                        'encode_file_id_docomo_2m_qcif' => 14,
                        'encode_file_id_docomo_2m_qvga' => 15,
                        'encode_file_id_docomo_10m' => 16,
                        'encode_file_id_au' => 17,
                        'encode_file_id_sb' => 18,
                        'video_size' => 0,
                        'encode_file_id_iphone' => null,
                        'downloadAble' => 0,
                        'up_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2016-10-26 00:00:00.000000', 'UTC')
                    ),
                    '1' => array(
                        'movie_contents_id' => 1,
                        'movie_folder_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'movie_contents_name' => 'video_test1.flv',
                        'name' => 'video_test3video_test3video_test3video_test3video_test3video_test3video_test3',
                        'extension' => 'flv',
                        'amount' => 3333333,
                        'movie_contents_url' => '/home/storage/tcom/385cd85a14bb90c754897fd0366ff266/movie/0000000001/encode_movie/',
                        'movie_contents_comment' => 'video_test3video_test3video_test3video_test3video_test3video_test3video_test3',
                        'movie_capture_url' => '/home/storage/tcom/385cd85a14bb90c754897fd0366ff266/movie/0000000001/thumbnail/',
                        'reproduction_time' => '1:0',
                        'resultcode' => 1,
                        'file_id' => 21,
                        'encode_status' => 0,
                        'encode_file_id_flv' => 12,
                        'encode_file_id_docomo_300k' => 13,
                        'encode_file_id_docomo_2m_qcif' => 14,
                        'encode_file_id_docomo_2m_qvga' => 15,
                        'encode_file_id_docomo_10m' => 16,
                        'encode_file_id_au' => 17,
                        'encode_file_id_sb' => 18,
                        'video_size' => 0,
                        'encode_file_id_iphone' => null,
                        'downloadAble' => 0,
                        'up_date' => $this->makeTimeObj('2017-10-26 00:00:00.000000', 'UTC'),
                        'reg_date' => $this->makeTimeObj('2017-10-26 00:00:00.000000', 'UTC')
                    )),
                '0' => 1),
            'MovieFolderData' => array(
                '0' => 1,
                '1' => array(
                    '0' => array(
                        'movie_folder_id' => 1,
                        'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                        'movie_folder_name' => 'test',
                        'movie_folder_comment' => 'comment',
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
        parent::setSessionData('openId', 'open_id');
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
