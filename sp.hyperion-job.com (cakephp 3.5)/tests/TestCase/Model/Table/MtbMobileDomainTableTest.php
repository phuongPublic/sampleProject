<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbMobileDomainTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbMobileDomainTable Test Case
 */
class MtbMobileDomainTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbMobileDomainTable
     */
    public $MtbMobileDomain;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_mobile_domain'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbMobileDomain') ? [] : ['className' => MtbMobileDomainTable::class];
        $this->MtbMobileDomain = TableRegistry::get('MtbMobileDomain', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbMobileDomain);

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
}
