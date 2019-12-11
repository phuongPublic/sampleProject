<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MovieFolderFixture
 *
 */
class MovieFolderFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'movie_folder';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'movie_folder_id' => ['type' => 'integer', 'length' => 5, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'movie_folder_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'movie_folder_comment' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'up_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['movie_folder_id', 'user_seq'], 'length' => []],
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
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_folder_name' => 'Movie Folder 1',
            'movie_folder_comment' => 'Movie Folder 1 Comment',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'movie_folder_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_folder_name' => 'Movie Folder 2',
            'movie_folder_comment' => 'Movie Folder 2 Comment',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'movie_folder_id' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_folder_name' => 'Movie Folder 2 this is custom movie foldername',
            'movie_folder_comment' => 'Movie Folder 2 Comment',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
    ];
}
