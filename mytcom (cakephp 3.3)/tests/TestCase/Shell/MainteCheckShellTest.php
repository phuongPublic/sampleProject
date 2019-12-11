<?php

namespace App\Test\TestCase\Shell;

use App\Test\TestCase\NoptShellTestCase;
use App\Shell\MainteCheckShell;
use App\Shell\Task\AdminMainteTask;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Shell\MainteCheckShell Test Case
 *
 * // クラス'StopWatchTask'について、実施不可能な経路以外の経路は、本クラスのexecuteを実施することにより通るため、試験コードを作成しない
 */
class MainteCheckShellTest extends NoptShellTestCase
{

    public $fixtures = ['app.Mainte'];

    /**
     * Test subject
     *
     * @var \App\Shell\MainteCheckShell
     */
    public $MainteCheckShell;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->MainteCheckShell = new MainteCheckShell();
        $this->MainteCheckShell->AdminMainte = new AdminMainteTask();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    private function fixturesSetting($fixtureRegion)
    {
        $fixtures = 'app.' . $fixtureRegion . '/Mainte';
        $this->fixtures = [$fixtures];
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $this->loadFixtures('Mainte');
    }

    /**
     * Test start method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_001()
    {
        $this->loadFixtures('Mainte');
        $this->assertNull($this->MainteCheckShell->start());
    }

    /**
     * Test Test_MCShl_start_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_002()
    {
        $this->assertNull($this->MainteCheckShell->start());
    }
    

    /**
     * Test Test_MCShl_start_003 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_003()
    {
        $this->fixturesSetting('MCSDataReservationInfo');
        $this->assertNull($this->MainteCheckShell->start());
    }

    /**
     * Test Test_MCShl_start_004 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_004()
    {
        $this->fixturesSetting('MCSDataEmpty');
        $this->assertNull($this->MainteCheckShell->start());
    }

    /**
     * Test Test_MCShl_start_005 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_005()
    {
        $this->fixturesSetting('MCSDataDuringStartInfo');
        $this->assertNull($this->MainteCheckShell->start());
    }

    /**
     * Test Test_MCShl_start_007 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_007()
    {
        $this->fixturesSetting('MCSDataFinishInfo');
        $this->assertNull($this->MainteCheckShell->start());
    }
    
    /**
     * Test Test_MCShl_start_009 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_009()
    {
        $this->fixturesSetting('MCSDataFinishDataForUpdate');
        $this->assertNull($this->MainteCheckShell->start());
    }
    
     /**
     * Test Test_MCShl_start_011 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_MCShl_start_011()
    {
        $this->fixturesSetting('MCSDataFinishData');
        $this->assertNull($this->MainteCheckShell->start());
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MainteCheckShell);

        parent::tearDown();
    }
}
