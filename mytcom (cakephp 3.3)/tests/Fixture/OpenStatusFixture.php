<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OpenStatusFixture
 *
 */
class OpenStatusFixture extends TestFixture
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
    public $table = 'open_status';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'open_id' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'target_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'open_type' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'close_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'close_type' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'access_check' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'nickname' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'message' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'download_count' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['open_id', 'target_id', 'user_seq', 'open_type'], 'length' => []],
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
     * type 1:? ,2:file, 3:?
     * @var array
     */
    public $records = [
        [
            'open_id' => 'open_id1',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 2,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 1,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'openid_error',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 2,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 1,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'openid_file',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 2,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 1,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'openid_pic',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 3,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 1,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'pic_component',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 1,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 4,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'pic_component2',
            'target_id' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 3,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 4,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        //movie folder
        [
            'open_id' => 'open_id',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 4,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 4,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        //movie
        [
            'open_id' => 'open_id2',
            'target_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 5,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 4,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
        [
            'open_id' => 'open_id3',
            'target_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_type' => 5,
            'close_date' => '2018-09-13 10:00:00',
            'close_type' => 4,
            'access_check' => 1,
            'nickname' => 'テストちゃん',
            'message' => '見てください！',
            'reg_date' => '2016-09-13 07:52:11',
            'download_count' => 1
        ],
    ];
}
