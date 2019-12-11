<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbMailtemplateTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbMailtemplateTable Test Case
 */
class DtbMailtemplateTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbMailtemplateTable
     */
    public $DtbMailtemplate;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_mailtemplate',
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
        $config = TableRegistry::exists('DtbMailtemplate') ? [] : ['className' => DtbMailtemplateTable::class];
        $this->DtbMailtemplate = TableRegistry::get('DtbMailtemplate', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbMailtemplate);

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
