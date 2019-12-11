<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PicTblFixture
 *
 */
class PicTblFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'pic_tbl';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'pic_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'album_id' => ['type' => 'integer', 'length' => 5, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'pic_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extension' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'amount' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'base' => ['type' => 'string', 'fixed' => true, 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'pic_url' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'pic_comment' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'up_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reg_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'IDX_ALBUM_REG' => ['type' => 'index', 'columns' => ['reg_date'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['pic_id', 'user_seq'], 'length' => []],
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
            'pic_id' => 1,
            'album_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 1.jpg',
            'name' => 'Picture 1',
            'extension' => 'jpg',
            'amount' => 1,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'pic_id' => 2,
            'album_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 2.png',
            'name' => 'Picture 2',
            'extension' => 'png',
            'amount' => 2,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'pic_id' => 3,
            'album_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 3.gif',
            'name' => 'Picture 3',
            'extension' => 'gif',
            'amount' => 3,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000003',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
        [
            'pic_id' => 4,
            'album_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 4.gif',
            'name' => 'Picture 4',
            'extension' => 'gif',
            'amount' => 3,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000004',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ],
    ];
}
