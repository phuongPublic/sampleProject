<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbRegionTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbRegionTable Test Case
 */
class MtbRegionTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbRegionTable
     */
    public $MtbRegion;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_region'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbRegion') ? [] : ['className' => MtbRegionTable::class];
        $this->MtbRegion = TableRegistry::get('MtbRegion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbRegion);

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
