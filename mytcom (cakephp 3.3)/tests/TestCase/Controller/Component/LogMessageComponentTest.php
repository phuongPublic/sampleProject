<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\LogMessageComponent;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Validation\Validator;

/**
 * App\Controller\Component\LogMessageComponent Test Case
 */
class LogMessageComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = [];


    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new LogMessageComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }



    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }

    /**
     * Test logMessage method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function logMessage()
    {
        //case 1: log level INFO
        $this->component->logMessage('02001', $this->testUserSeq);
        //case 2: log level WARNING
        $this->component->logMessage('02009', $this->testUserSeq);
        //case 3: log level ERROR
        $this->component->logMessage('88888', $this->testUserSeq);
        //case 4: log level FATAL , add FATAL level in log ini with id 66666 to test
        $this->component->logMessage('66666', $this->testUserSeq);
        //case 5: log level FATAL , add FATAL level in log ini with id 55555 to test
        $this->component->logMessage('55555', $this->testUserSeq);
        //case 6: missing log Id
        $this->component->logMessage(null, $this->testUserSeq);
        //case 7: missing log Id, message data
        $this->component->logMessage(null);
    }
}
