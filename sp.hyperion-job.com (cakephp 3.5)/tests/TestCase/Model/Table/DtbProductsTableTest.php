<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbProductsTable Test Case
 */
class DtbProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbProductsTable
     */
    public $DtbProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_products',
        'app.makers',
        'app.creators',
        'app.deliv_dates',
        'app.clients',
        'app.categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbProducts') ? [] : ['className' => DtbProductsTable::class];
        $this->DtbProducts = TableRegistry::get('DtbProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbProducts);

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
