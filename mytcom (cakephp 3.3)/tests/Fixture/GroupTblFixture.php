<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupTblFixture
 *
 */
class GroupTblFixture extends TestFixture
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
    public $table = 'group_tbl';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'group_id' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'group_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'up_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['group_id', 'user_seq'], 'length' => []],
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
            'group_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'group_name' => 'グループ名',
            'up_date' => '2016-09-13 09:30:00',
            'reg_date' => '2016-09-13 09:30:00'
        ],
        [
            'group_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'group_name' => 'グループ名2',
            'up_date' => '2016-09-13 09:30:00',
            'reg_date' => '2016-09-13 09:30:00'
        ],
        [
            'group_id' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'group_name' => 'グループ名3',
            'up_date' => '2016-09-13 09:30:00',
            'reg_date' => '2016-09-13 09:30:00'
        ],
        [
            'group_id' => 4,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'group_name' => 'グループ名4',
            'up_date' => '2016-09-13 09:30:00',
            'reg_date' => '2016-09-13 09:30:00'
        ],
    ];
}
