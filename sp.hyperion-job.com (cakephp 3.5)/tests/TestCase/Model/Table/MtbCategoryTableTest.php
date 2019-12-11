<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtbCategoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtbCategoryTable Test Case
 */
class MtbCategoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MtbCategoryTable
     */
    public $MtbCategory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mtb_category',
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
        $config = TableRegistry::exists('MtbCategory') ? [] : ['className' => MtbCategoryTable::class];
        $this->MtbCategory = TableRegistry::get('MtbCategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MtbCategory);

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
     * Test getAllCartegoryJob method
     *
     * @return void
     */
    public function testGetAllCartegoryJob()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getAllCartegoryJobForMobile method
     *
     * @return void
     */
    public function testGetAllCartegoryJobForMobile()
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
