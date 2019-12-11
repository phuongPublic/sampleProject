<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TargetUserFixture
 *
 */
class TargetUserFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'target_user';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'target_user_seq' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'open_id' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'open_type' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'mail' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'login_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['target_user_seq', 'user_seq', 'open_id'], 'length' => []],
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
            'target_user_seq' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'open_id1',
            'open_type' => 1,
            'mail' => 'test@bip.co.jp',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
        [
            'target_user_seq' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'openid_error',
            'open_type' => 1,
            'mail' => 'test@bip.co.jpa',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
        [
            'target_user_seq' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'openid_file',
            'open_type' => 1,
            'mail' => 'test@bip.co.jp',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
        [
            'target_user_seq' => 4,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'openid_pic',
            'open_type' => 1,
            'mail' => 'test@bip.co.jp',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
        [
            'target_user_seq' => 5,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'pic_component',
            'open_type' => 3,
            'mail' => 'test@bip.co.jp',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
        [
            'target_user_seq' => 6,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'open_id' => 'pic_component2',
            'open_type' => 3,
            'mail' => 'test@bip.co.jp',
            'login_date' => '2016-09-13 07:52:16',
            'reg_date' => '2016-09-13 07:52:16'
        ],
    ];
}
