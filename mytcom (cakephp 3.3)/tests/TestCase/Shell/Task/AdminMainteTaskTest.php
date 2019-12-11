<?php

namespace App\Test\TestCase\Shell\Task;

use App\Test\TestCase\NoptShellTestCase;
use App\Shell\Task\AdminMainteTask;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Shell\Task\AdminMainteTaskTest Test Case
 */
class AdminMainteTaskTest extends NoptShellTestCase
{

    public $fixtures = [
        'app.Mainte'
    ];

    /**
     * Test subject
     *
     * @var \App\Shell\Task\AdminMainte
     */
    public $AdminMainte;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->AdminMainte = new AdminMainteTask();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $this->loadFixtures('Mainte');
    }

    /**
     * Test Test_AMT_beginMaintenance_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMaintenance_001()
    {
        $mainteBody = 'Body';
        $this->assertNull($this->AdminMainte->beginMaintenance($mainteBody));
    }

    /**
     * Test Test_AMT_beginMaintenance_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMaintenance_002()
    {
        $mainteBody = '';
        $this->assertNull($this->AdminMainte->beginMaintenance($mainteBody));
    }

    /**
     * Test Test_AMT_beginMainteCommon_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMainteCommon_001()
    {
        $mainteBody = 'Body';
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "beginMainteCommon", [$filePath, $mainteBody]);
        $this->assertFileExists($filePath['mainte']);
        $this->assertFileExists($filePath['mainte_iphone']);
        $this->assertFileExists($filePath['mainte_android']);

        $this->assertFileEquals($filePath['htaccess_mainte'], $filePath['htaccess']);
    }

    /**
     * Test Test_AMT_beginMainteEthna_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMainteEthna_001()
    {
        $mainteBody = 'Body';
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "beginMainteEthna", [$filePath, $mainteBody]);
        $this->assertFileExists($filePath['mainte_opt_pc']);
        $this->assertFileExists($filePath['mainte_opt_ip']);
        $this->assertFileExists($filePath['mainte_opt_ad']);

        $this->assertFileEquals($filePath['htaccess_mainte_opt_pc'], $filePath['htaccess_opt_pc']);
        $this->assertFileEquals($filePath['htaccess_mainte_opt_ip'], $filePath['htaccess_opt_ip']);
        $this->assertFileEquals($filePath['htaccess_mainte_opt_ad'], $filePath['htaccess_opt_ad']);
    }

    /**
     * Test Test_AMT_beginMainteBbs_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMainteBbs_001()
    {
        $mainteBody = 'Body';
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "beginMainteBbs", [$filePath, $mainteBody]);
        $this->assertFileExists($filePath['mainte_bbs']);
        $this->assertFileExists($filePath['mainte_sp_bbs']);

        $this->assertFileEquals($filePath['htaccess_mainte_bbs'], $filePath['htaccess_bbs']);
    }

    /**
     * Test Test_AMT_beginMainteBbsKso_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_beginMainteBbsKso_001()
    {
        $mainteBody = 'Body';
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "beginMainteEthna", [$filePath, $mainteBody]);
        // TCOMの場合
        if ($_SERVER['NOPT_ISP'] == "tcom") {
            $this->assertFileExists($filePath['mainte_kso']);

            $this->assertFileEquals($filePath['htaccess_mainte_kso'], $filePath['htaccess_kso']);
            $this->assertFileEquals($filePath['htaccess_mainte_kso_1'], $filePath['htaccess_kso_1']);
            $this->assertFileEquals($filePath['htaccess_mainte_kso_app'], $filePath['htaccess_kso_app']);
            $this->assertFileEquals($filePath['htaccess_mainte_kso_webroot'], $filePath['htaccess_kso_webroot']);
        }
    }

    /**
     * Test Test_AMT_createFileMainte_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_createFileMainte_001()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $originFile = $filePath['mainte_template'];
        $destFile = $filePath['mainte'];
        $mainteBody = 'Body';
        $this->assertNull($this->invokeMethod($this->AdminMainte, "createFileMainte", [$originFile, $destFile, $mainteBody]));
    }

    /**
     * Test Test_AMT_endMaintenance_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_endMaintenance_001()
    {
        $mainteTbl = TableRegistry::get("Mainte");
        $objMainteUpdate = $mainteTbl->getMainteFinishDataForUpdate();
        $this->assertTrue($this->AdminMainte->endMaintenance($objMainteUpdate));
    }

    /**
     * Test Test_AMT_updateStatusToEndMainte_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_updateStatusToEndMainte_001()
    {
        $this->loadFixtures('Mainte');
        $mainteTbl = TableRegistry::get("Mainte");
        $objMainteUpdate = $mainteTbl->getMainteFinishDataForUpdate();
        $this->invokeMethod($this->AdminMainte, "updateStatusToEndMainte", [$objMainteUpdate]);
        foreach ($objMainteUpdate as $mainte) {
            $compare = $mainteTbl->getMainte($mainte['mainte_id']);
            $this->assertEquals(array_search("公開終了", Configure::read('Common.AdminModule.Mainte.AdminMainteStatus')), $compare['mainte_status']);
        }
    }

    /**
     * Test Test_AMT_copyHtaccessFileToEndMainte_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_copyHtaccessFileToEndMainte_001()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->assertFileEquals($filePath['htaccess_normal'], $filePath['htaccess']);
        $this->assertTrue($this->AdminMainte->copyHtaccessFileToEndMainte());
    }

    /**
     * Test Test_AMT_ethnaCloseMainte_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_ethnaCloseMainte_001()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "ethnaCloseMainte", [$filePath]);
        $this->assertFileEquals($filePath['htaccess_normal_opt_pc'], $filePath['htaccess_opt_pc']);
        $this->assertFileEquals($filePath['htaccess_normal_opt_ip'], $filePath['htaccess_opt_ip']);
        $this->assertFileEquals($filePath['htaccess_normal_opt_ad'], $filePath['htaccess_opt_ad']);
    }

    /**
     * Test Test_AMT_endMainteBbsKso_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_endMainteBbsKso_001()
    {
        // TCOMの場合
        if ($_SERVER['NOPT_ISP'] == "tcom") {
            $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
            $this->invokeMethod($this->AdminMainte, "endMainteBbsKso", [$filePath]);
            $this->assertFileEquals($filePath['htaccess_normal_kso'], $filePath['htaccess_kso']);
            $this->assertFileEquals($filePath['htaccess_normal_kso_1'], $filePath['htaccess_kso_1']);
            $this->assertFileEquals($filePath['htaccess_normal_kso_app'], $filePath['htaccess_kso_app']);
            $this->assertFileEquals($filePath['htaccess_normal_kso_webroot'], $filePath['htaccess_kso_webroot']);
        }
    }

    /**
     * Test Test_AMT_endMainteBbs_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_endMainteBbs_001()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $this->invokeMethod($this->AdminMainte, "endMainteBbs", [$filePath]);
        $this->assertFileEquals($filePath['htaccess_normal_bbs'], $filePath['htaccess_bbs']);
    }

    /**
     * Test Test_AMT_writeLogWhenCopyError_001 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_writeLogWhenCopyError_001()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $originFile = $filePath['mainte_template'];
        $destFile = $filePath['mainte'];
        $this->assertNull($this->invokeMethod($this->AdminMainte, "writeLogWhenCopyError", [true, $originFile, $destFile]));
    }

    /**
     * Test Test_AMT_writeLogWhenCopyError_002 method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function Test_AMT_writeLogWhenCopyError_002()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        $originFile = $filePath['mainte_template'];
        $destFile = $filePath['mainte'];
        $this->assertNull($this->invokeMethod($this->AdminMainte, "writeLogWhenCopyError", [false, $originFile, $destFile]));
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        // 完了後のクリーンアップ
        unset($this->AdminMainte);
        parent::tearDown();
    }

}
