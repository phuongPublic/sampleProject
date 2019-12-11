<?php

namespace App\Test\TestCase\Shell;

use App\Test\TestCase\NoptShellTestCase;
use App\Shell\ThumbnailGeneratorShell;
use App\Shell\Task\ThumbnailGeneratorTask;
use App\Shell\Task\StopWatchTask;

require_once APP . 'Shell\\ThumbnailGeneratorShell.php';

/**
 * App\Shell\ThumbnailGeneratorShell Test Case
 *
 * // クラス'StopWatchTask'について、実施不可能な経路以外の経路は、本クラスのexecuteを実施することにより通るため、試験コードを作成しない
 */
class ThumbnailGeneratorShellTest extends NoptShellTestCase
{

    /**
     * Test subject
     *
     * @var \App\Shell\ThumbnailGeneratorShell
     */
    public $ThumbnailGeneratorShell;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->ThumbnailGeneratorShell = new ThumbnailGeneratorShell();

        $this->ThumbnailGeneratorShell->ThumbnailGenerator = new ThumbnailGeneratorTask();
        $this->ThumbnailGeneratorShell->ThumbnailGenerator->StopWatch = new StopWatchTask();
        // put the real image file in the place below in advance
        $this->ImageFPathExist = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest\\0000000001';
        // NOT put the real image file in the place below in advance
        $this->ImageFPathNotExist = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest\\0000000002';
    }

    /**
     * Test execute method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function execute()
    {
        $ImageFPathStr = $this->ImageFPathExist . ',' . $this->ImageFPathNotExist;
        $this->assertNull($this->ThumbnailGeneratorShell->execute($ImageFPathStr));

        $this->assertFileExists($this->ImageFPathExist . SUFFIX_PC_DETAIL);
        $this->assertFileExists($this->ImageFPathExist . SUFFIX_PC_THUMB);
        $this->assertFileExists($this->ImageFPathExist . SUFFIX_MOBILE_THUMB);
        $this->assertFileExists($this->ImageFPathExist . SUFFIX_IPHONE_THUMB);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ThumbnailGeneratorShell);

        parent::tearDown();
    }

}
