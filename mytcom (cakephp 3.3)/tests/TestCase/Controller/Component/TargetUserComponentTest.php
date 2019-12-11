<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\TargetUserComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\TargetUserComponent Test Case
 */
class TargetUserComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.TargetUser',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new TargetUserComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test loginStamp method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function loginStamp()
    {
        $this->loadFixtures('TargetUser');
        $dataArray = array('target_user_seq' => '1', 'user_seq' => $this->testUserSeq);
        $result = true;
        try {
            $this->component->loginStamp($dataArray);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }
}