<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserMstFixture
 *
 */
class UserMstFixture extends TestFixture
{
    public $connection = 'test';
    public function init()
    {
        parent::init();
    }

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'user_mst';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'user_address' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_name' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'reg_flg' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'del_flg' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'up_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_password' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'base' => ['type' => 'string', 'fixed' => true, 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'mobile_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mail_seq' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'file_size' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'album_size' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'reminder_pc' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'reminder_mobile' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'reminder_mobile_flg' => ['type' => 'integer', 'length' => 2, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'reminder_pc_flg' => ['type' => 'integer', 'length' => 2, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'reminder_time' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'movie_size' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'log_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'google_token' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['user_seq'], 'length' => []],
            'iser_address' => ['type' => 'unique', 'columns' => ['user_address'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'user_address' => 'user@gmail.com',
            'user_name' => 'テスト 太郎',
            'reg_flg' => '1',
            'del_flg' => '0',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'user_id' => 'xyz',
            'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
            'base' => '00001/',
            'mobile_id' => 'Lorem ipsum dolor sit amet',
            'mail_seq' => 'fd041c3eab',
            'file_size' => 60000,
            'album_size' => 70000,
            'reminder_pc' => 'remider_pc@gmail.com',
            'reminder_mobile' => 'remider_mobile@gmail.com',
            'reminder_mobile_flg' => 1,
            'reminder_pc_flg' => 1,
            'reminder_time' => 1,
            'movie_size' => 80000,
            'log_date' => '2016-09-13 07:52:22',
            'google_token' => 'test_token'
        ],
        [
            'user_seq' => '385cd85a14bb90c754897fd0366ff267',
            'user_address' => 'bipsv@gmail.com',
            'user_name' => 'テスト 太郎',
            'reg_flg' => '1',
            'del_flg' => '0',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'user_id' => 'ne910027',
            'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
            'base' => '00001/',
            'mobile_id' => 'Lorem ipsum dolor sit amet',
            'mail_seq' => 'fd041c3eab',
            'file_size' => 60000,
            'album_size' => 70000,
            'reminder_pc' => 'remider_pc@gmail.com',
            'reminder_mobile' => 'remider_mobile@gmail.com',
            'reminder_mobile_flg' => 1,
            'reminder_pc_flg' => 1,
            'reminder_time' => 1,
            'movie_size' => 80000,
            'log_date' => '2016-09-13 07:52:22',
            'google_token' => 'test_token'
        ],
        [
            'user_seq' => '385cd85a14bb90c754897fd0366ff268',
            'user_address' => 'bipsv1@gmail.com',
            'user_name' => 'テスト 太郎',
            'reg_flg' => '1',
            'del_flg' => '1',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'user_id' => 'ne910027',
            'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
            'base' => '00001/',
            'mobile_id' => 'Lorem ipsum dolor sit amet',
            'mail_seq' => 'fd041c3eab',
            'file_size' => 60000,
            'album_size' => 70000,
            'reminder_pc' => 'remider_pc@gmail.com',
            'reminder_mobile' => 'remider_mobile@gmail.com',
            'reminder_mobile_flg' => 1,
            'reminder_pc_flg' => 1,
            'reminder_time' => 1,
            'movie_size' => 80000,
            'log_date' => '2016-09-13 07:52:22',
            'google_token' => 'test_token'
        ],
        [
            'user_seq' => '385cd85a14bb90c754897fd0366ff269',
            'user_address' => 'bipsv2@gmail.com',
            'user_name' => 'テスト 太郎',
            'reg_flg' => '1',
            'del_flg' => '1',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'user_id' => 'ne910028',
            'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
            'base' => '00001/',
            'mobile_id' => 'Lorem ipsum dolor sit amet',
            'mail_seq' => 'fd041c3eab',
            'file_size' => 60000,
            'album_size' => 70000,
            'reminder_pc' => 'remider_pc@gmail.com',
            'reminder_mobile' => 'remider_mobile@gmail.com',
            'reminder_mobile_flg' => 1,
            'reminder_pc_flg' => 1,
            'reminder_time' => 1,
            'movie_size' => 80000,
            'log_date' => '2016-09-13 07:52:22',
            'google_token' => 'test_token'
        ],
        [
            'user_seq' => '385cd85a14bb90c754897fd0366ff270',
            'user_address' => 'bipsv3@gmail.com',
            'user_name' => 'テスト 太郎',
            'reg_flg' => '1',
            'del_flg' => '9',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'user_id' => 'ne910029',
            'user_password' => 'P0W8rW1nbwUrF3lhcNfEmw==',
            'base' => '00001/',
            'mobile_id' => 'Lorem ipsum dolor sit amet',
            'mail_seq' => 'fd041c3eab',
            'file_size' => 60000,
            'album_size' => 70000,
            'reminder_pc' => 'remider_pc@gmail.com',
            'reminder_mobile' => 'remider_mobile@gmail.com',
            'reminder_mobile_flg' => 1,
            'reminder_pc_flg' => 1,
            'reminder_time' => 1,
            'movie_size' => 80000,
            'log_date' => '2016-09-13 07:52:22',
            'google_token' => 'test_token'
        ],
    ];
}
