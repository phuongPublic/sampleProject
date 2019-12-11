<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbMailHistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbMailHistoryTable Test Case
 */
class DtbMailHistoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbMailHistoryTable
     */
    public $DtbMailHistory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_mail_history',
        'app.orders',
        'app.templates',
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
        $config = TableRegistry::exists('DtbMailHistory') ? [] : ['className' => DtbMailHistoryTable::class];
        $this->DtbMailHistory = TableRegistry::get('DtbMailHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbMailHistory);

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
