<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbCustomerCareerTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbCustomerCareerTable Test Case
 */
class DtbCustomerCareerTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbCustomerCareerTable
     */
    public $DtbCustomerCareer;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_customer_career',
        'app.customers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbCustomerCareer') ? [] : ['className' => DtbCustomerCareerTable::class];
        $this->DtbCustomerCareer = TableRegistry::get('DtbCustomerCareer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbCustomerCareer);

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
