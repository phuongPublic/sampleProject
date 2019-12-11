<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbCountryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbCountryTable Test Case
 */
class MtbCountryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbCountryTable
     */
    public $MtbCountry;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_country'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MtbCountry') ? [] : ['className' => MtbCountryTable::class];
        $this->MtbCountry = TableRegistry::get('MtbCountry', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbCountry);

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
