<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbWelfareTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbWelfareTable Test Case
 */
class MtbWelfareTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbWelfareTable
     */
    public $MtbWelfare;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_welfare'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbWelfare') ? [] : ['className' => MtbWelfareTable::class];
        $this->MtbWelfare = TableRegistry::get('MtbWelfare', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbWelfare);

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
