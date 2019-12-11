<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbCustomerTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbCustomerTable Test Case
 */
class DtbCustomerTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbCustomerTable
     */
    public $DtbCustomer;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_customer',
        'app.countries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbCustomer') ? [] : ['className' => DtbCustomerTable::class];
        $this->DtbCustomer = TableRegistry::get('DtbCustomer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbCustomer);

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
     * Test getMaxId method
     *
     * @return void
     */
    public function testGetMaxId()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test isMatchEmail method
     *
     * @return void
     */
    public function testIsMatchEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getPasswordInfo method
     *
     * @return void
     */
    public function testGetPasswordInfo()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getBasicInfoCustumer method
     *
     * @return void
     */
    public function testGetBasicInfoCustumer()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCustomerInfoById method
     *
     * @return void
     */
    public function testGetCustomerInfoById()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCustomerCVById method
     *
     * @return void
     */
    public function testGetCustomerCVById()
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
