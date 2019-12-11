<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AddressDataFixture
 *
 */
class AddressDataFixture extends TestFixture
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
    public $table = 'address_data';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'adrdata_seq' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_seq' => ['type' => 'string', 'fixed' => true, 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'name_l' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_f' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'nickname' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'org_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'org_post' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_countory' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_postcode' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_pref' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_adr1' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_adr2' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_tel' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_fax' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'work_url' => ['type' => 'string', 'length' => 2083, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_countory' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_postcode' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_pref' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_adr1' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_adr2' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_cell' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_tel' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_fax' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'home_url' => ['type' => 'string', 'length' => 2083, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birthday' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'ins_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'upd_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'group_id' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'IDX_address_data_01' => ['type' => 'index', 'columns' => ['user_seq'], 'length' => []],
            'IDX_address_data_02' => ['type' => 'index', 'columns' => ['email'], 'length' => ['email' => '255']],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['adrdata_seq'], 'length' => []],
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
            'adrdata_seq' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000-0000',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '000-0000',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'ins_date' => '2016-09-13 07:51:53',
            'upd_date' => '2016-09-13 07:51:53',
            'group_id' => 1
        ],
        [
            'adrdata_seq' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000-0000',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '000-0000',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'ins_date' => '2016-09-13 07:51:53',
            'upd_date' => '2016-09-13 07:51:53',
            'group_id' => 0
        ],
        [
            'adrdata_seq' => 3,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000-0000',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '000-0000',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'ins_date' => '2016-09-13 07:51:53',
            'upd_date' => '2016-09-13 07:51:53',
            'group_id' => 0
        ],
        [
            'adrdata_seq' => 4,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'name_l' => '姓',
            'name_f' => '名',
            'nickname' => 'ニックネーム',
            'email' => 'address@address.test',
            'org_name' => '会社名',
            'org_post' => '会社所属',
            'work_countory' => '会社国',
            'work_postcode' => '000-0000',
            'work_pref' => '会社都道府県',
            'work_adr1' => '会社市区町村',
            'work_adr2' => '会社番地',
            'work_tel' => '0000-00-0000',
            'work_fax' => '0000-00-0000',
            'work_url' => 'http://kaisyaURL.test',
            'home_countory' => '自宅国',
            'home_postcode' => '000-0000',
            'home_pref' => '自宅都道府県',
            'home_adr1' => '自宅市区町村',
            'home_adr2' => '自宅番地',
            'home_cell' => '090-1111-1111',
            'home_tel' => '1111-11-1111',
            'home_fax' => '1111-11-1111',
            'home_url' => 'http://zitakuURL.test',
            'birthday' => '1989/1/5',
            'note' => 'メモテスト',
            'ins_date' => '2016-09-13 07:51:53',
            'upd_date' => '2016-09-13 07:51:53',
            'group_id' => 2
        ],
    ];
}
