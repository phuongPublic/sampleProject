<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbPrefTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbPrefTable Test Case
 */
class MtbPrefTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbPrefTable
     */
    public $MtbPref;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_pref',
        'app.objects'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbPref') ? [] : ['className' => MtbPrefTable::class];
        $this->MtbPref = TableRegistry::get('MtbPref', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbPref);

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
