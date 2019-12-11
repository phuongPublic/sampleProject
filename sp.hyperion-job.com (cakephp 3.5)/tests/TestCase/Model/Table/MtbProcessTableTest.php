<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbProcessTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbProcessTable Test Case
 */
class MtbProcessTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbProcessTable
     */
    public $MtbProcess;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_process'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbProcess') ? [] : ['className' => MtbProcessTable::class];
        $this->MtbProcess = TableRegistry::get('MtbProcess', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbProcess);

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
