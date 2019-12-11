<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AlbumFixture
 *
 */
class EncodeRequestFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $connection = 'test_encode_movie';
    public $table = 'encode_request';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => true],
        'request_source' => ['type' => 'string', 'length' => 10, 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'movie_contents_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'encode_order' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'encode_status' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cancel' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'register_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'retry_count' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'movie_encode_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'movie_encode_mode' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'movie_encode_start' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'movie_encode_end' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'thumbnail_position' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'play_time' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'id' => 1,
              'request_source' => 'tcom',
              'movie_contents_id' => 1,
              'user_seq' => '385cd85a14bb90c754897fd0366ff266',
              'encode_order' => 0,
              'encode_status' => 0,
              'cancel' => 0,
              'register_date' => '2017-02-22',
              'retry_count' => 0,
              'movie_encode_id' => null,
              'movie_encode_mode' => null,
              'movie_encode_start' => null,
              'movie_encode_end' => null,
              'thumbnail_position' => null,
              'play_time' => null,
        ],
        [
            'id' => 2,
            'request_source' => 'tcom',
            'movie_contents_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'encode_order' => 0,
            'encode_status' => 2,
            'cancel' => 0,
            'register_date' => '2017-02-22',
            'retry_count' => 0,
            'movie_encode_id' => null,
            'movie_encode_mode' => null,
            'movie_encode_start' => null,
            'movie_encode_end' => null,
            'thumbnail_position' => null,
            'play_time' => null,
        ],
        [
            'id' => 3,
            'request_source' => 'tcom',
            'movie_contents_id' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'encode_order' => 0,
            'encode_status' => 3,
            'cancel' => 0,
            'register_date' => '2017-02-22',
            'retry_count' => 0,
            'movie_encode_id' => null,
            'movie_encode_mode' => null,
            'movie_encode_start' => null,
            'movie_encode_end' => null,
            'thumbnail_position' => null,
            'play_time' => null,
        ],
        [
            'id' => 4,
            'request_source' => 'tcom',
            'movie_contents_id' => 4,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'encode_order' => 0,
            'encode_status' => 1,
            'cancel' => 0,
            'register_date' => '2017-02-22',
            'retry_count' => 0,
            'movie_encode_id' => null,
            'movie_encode_mode' => null,
            'movie_encode_start' => null,
            'movie_encode_end' => null,
            'thumbnail_position' => null,
            'play_time' => null,
        ],
        [
            'id' => 5,
            'request_source' => 'tcom',
            'movie_contents_id' => 5,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'encode_order' => 0,
            'encode_status' => 2,
            'cancel' => 0,
            'register_date' => '2017-02-22',
            'retry_count' => 0,
            'movie_encode_id' => null,
            'movie_encode_mode' => null,
            'movie_encode_start' => null,
            'movie_encode_end' => null,
            'thumbnail_position' => null,
            'play_time' => null,
        ],
    ];
}
