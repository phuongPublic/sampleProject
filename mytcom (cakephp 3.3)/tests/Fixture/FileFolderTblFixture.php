<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FileFolderTblFixture
 *
 */
class FileFolderTblFixture extends TestFixture
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
    public $table = 'file_folder_tbl';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'file_folder_id' => ['type' => 'integer', 'length' => 5, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'file_folder_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'comment' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'up_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['file_folder_id', 'user_seq'], 'length' => []],
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
            'file_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'file_folder_name' => 'フォルダ名1番',
            'comment' => 'フォルダコメント1番',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'file_folder_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'file_folder_name' => 'フォルダ名2番',
            'comment' => 'フォルダコメント2番',
            'up_date' => '2016-10-13',
            'reg_date' => '2016-10-13'
        ],
        [
            'file_folder_id' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'file_folder_name' => 'フォルダ名3番',
            'comment' => 'フォルダコメント3番',
            'up_date' => '2016-10-13',
            'reg_date' => '2016-10-13'
        ],
    ];

}
