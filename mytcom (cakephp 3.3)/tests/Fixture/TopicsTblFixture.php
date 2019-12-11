<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TopicsTblFixture
 *
 */
class TopicsTblFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'topics_tbl';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'topicsseq' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'categoryid' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'contents' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'file_path1' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'file_path2' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'viewflg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dateviewflg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'windowflg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'timerflg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'opendata' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'timerdata' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'updateuser' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'up_date' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'reguser' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'regdate' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'categoryid' => ['type' => 'index', 'columns' => ['categoryid', 'viewflg', 'opendata'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['topicsseq'], 'length' => []],
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
            'topicsseq' => 1,
            'categoryid' => 1,
            'title' => 'Lorem ipsum dolor sit amet',
            'contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'file_path1' => 'Lorem ipsum dolor sit amet',
            'file_path2' => 'Lorem ipsum dolor sit amet',
            'viewflg' => 1,
            'dateviewflg' => 1,
            'windowflg' => 1,
            'timerflg' => 1,
            'opendata' => '2017-05-22 17:40:16',
            'timerdata' => '2017-05-22 17:40:16',
            'updateuser' => 'Lorem ip',
            'up_date' => 1495442416,
            'reguser' => 'Lorem ip',
            'regdate' => '2017-05-22 17:40:16'
        ],
        [
            'topicsseq' => 50,
            'categoryid' => 1,
            'title' => 'Lorem ipsum dolor sit amet',
            'contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'file_path1' => 'Lorem ipsum dolor sit amet',
            'file_path2' => 'Lorem ipsum dolor sit amet',
            'viewflg' => 1,
            'dateviewflg' => 1,
            'windowflg' => 1,
            'timerflg' => 1,
            'opendata' => '2017-05-22 17:40:16',
            'timerdata' => '2017-05-22 17:40:16',
            'updateuser' => 'Lorem ip',
            'up_date' => 1495442416,
            'reguser' => 'Lorem ip',
            'regdate' => '2017-05-22 17:40:16'
        ],
        [
            'topicsseq' => 60,
            'categoryid' => 4,
            'title' => '',
            'contents' => 'members',
            'file_path1' => '',
            'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
            'viewflg' => 1,
            'dateviewflg' => null,
            'windowflg' => 1,
            'timerflg' => 1,
            'opendata' => '2016-05-18 17:03:00',
            'timerdata' => '2017-05-18 17:03:00',
            'updateuser' => 'admin',
            'update' => '2017-05-18 08:03:16',
            'reguser' => 'admin',
            'regdate' => '2017-05-18 17:03:16',
        ],
        [
            'topicsseq' => 61,
            'categoryid' => 4,
            'title' => '',
            'contents' => 'members',
            'file_path1' => '',
            'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
            'viewflg' => 3,
            'dateviewflg' => null,
            'windowflg' => 1,
            'timerflg' => 1,
            'opendata' => '2016-05-18 17:03:00',
            'timerdata' => '2019-05-18 17:03:00',
            'updateuser' => 'admin',
            'update' => '2017-05-18 08:03:16',
            'reguser' => 'admin',
            'regdate' => '2017-05-18 17:03:16',
        ],
        [
            'topicsseq' => 62,
            'categoryid' => 4,
            'title' => '',
            'contents' => 'members',
            'file_path1' => '',
            'file_path2' => '/home/AdminCustomSource/storage/00001/admin/banner/1495094596_test_post_movie_regist.png',
            'viewflg' => 2,
            'dateviewflg' => null,
            'windowflg' => 1,
            'timerflg' => 1,
            'opendata' => '2016-05-18 17:03:00',
            'timerdata' => '2019-05-18 17:03:00',
            'updateuser' => 'admin',
            'update' => '2017-05-18 08:03:16',
            'reguser' => 'admin',
            'regdate' => '2017-05-18 17:03:16',
        ],
    ];

}
