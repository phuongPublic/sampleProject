<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbBaseinfoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbBaseinfoTable Test Case
 */
class DtbBaseinfoTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbBaseinfoTable
     */
    public $DtbBaseinfo;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_baseinfo',
        'app.countries',
        'app.law_countries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbBaseinfo') ? [] : ['className' => DtbBaseinfoTable::class];
        $this->DtbBaseinfo = TableRegistry::get('DtbBaseinfo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbBaseinfo);

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
