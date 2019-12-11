<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DtbMailHistorySendIdSeqTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DtbMailHistorySendIdSeqTable Test Case
 */
class DtbMailHistorySendIdSeqTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DtbMailHistorySendIdSeqTable
     */
    public $DtbMailHistorySendIdSeq;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dtb_mail_history_send_id_seq'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DtbMailHistorySendIdSeq') ? [] : ['className' => DtbMailHistorySendIdSeqTable::class];
        $this->DtbMailHistorySendIdSeq = TableRegistry::get('DtbMailHistorySendIdSeq', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DtbMailHistorySendIdSeq);

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
