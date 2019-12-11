<?php

namespace App\Test\Fixture\MCSDataEmpty;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MainteFixture
 *
 */
class MainteFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'mainte';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'mainte_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'mainte_body' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'mainte_status' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => '1', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'mainte_start_time' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'mainte_end_flg' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => '1', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'mainte_end_time' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'mainte_opt_flg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'mainte_kso_flg' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['mainte_id'], 'length' => []],
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
    public $records;

    public function init()
    {
        $this->records = [
            
        ];
        
        //call parent::init() if you're overwriting init().
        parent::init();
    }
}
