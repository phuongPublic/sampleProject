<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FileTblFixture
 *
 */
class FileTblFixture extends TestFixture
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
    public $table = 'file_tbl';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'file_folder_id' => ['type' => 'integer', 'length' => 5, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'file_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => '0000000000', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'file_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extension' => ['type' => 'string', 'fixed' => true, 'length' => 6, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'amount' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'base' => ['type' => 'string', 'fixed' => true, 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'file_comment' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'file_uri' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'up_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'IDX_FILE_REG' => ['type' => 'index', 'columns' => ['reg_date'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['file_folder_id', 'file_id', 'user_seq'], 'length' => []],
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
            'file_id' => 1,
            'file_name' => 'ファイル名1番.jpg',
            'name' => 'ファイル名1番',
            'extension' => 'jpg',
            'amount' => 1,
            'base' => 'base1',
            'file_comment' => 'ファイルコメント1番',
            'file_uri' => '/path1',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'file_folder_id' => 1,
            'file_id' => 2,
            'file_name' => 'ファイル名2番.txt',
            'name' => 'ファイル名2番',
            'extension' => 'txt',
            'amount' => 2,
            'base' => 'base2',
            'file_comment' => 'ファイルコメント2番',
            'file_uri' => '/path2',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'up_date' => '2016-10-13',
            'reg_date' => '2016-10-13'
        ],
        [
            'file_folder_id' => 2,
            'file_id' => 3,
            'file_name' => 'ファイル名3番.png',
            'name' => 'ファイル名3番',
            'extension' => 'png',
            'amount' => 3,
            'base' => 'base3',
            'file_comment' => 'ファイルコメント3番',
            'file_uri' => '/path3',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'up_date' => '2016-11-13',
            'reg_date' => '2016-11-13'
        ],
    ];

}
