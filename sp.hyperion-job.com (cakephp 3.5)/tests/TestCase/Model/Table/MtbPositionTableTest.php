<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbPositionTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbPositionTable Test Case
 */
class MtbPositionTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbPositionTable
     */
    public $MtbPosition;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_position'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbPosition') ? [] : ['className' => MtbPositionTable::class];
        $this->MtbPosition = TableRegistry::get('MtbPosition', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbPosition);

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
