<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbProductStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbProductStatusTable Test Case
 */
class DtbProductStatusTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbProductStatusTable
     */
    public $DtbProductStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_product_status',
        'app.product_statuses',
        'app.products',
        'app.creators'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbProductStatus') ? [] : ['className' => DtbProductStatusTable::class];
        $this->DtbProductStatus = TableRegistry::get('DtbProductStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbProductStatus);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
