<?php

namespace App\Test\TestCase\Controller;

use Cake\Controller\ComponentRegistry;
use App\Controller\Component\MovieFileComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\MovieFileComponentTest Test Case
 */
class MovieFileComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = ['app.MovieContents', 'app.MovieFolder'];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new MovieFileComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test checkMovieContent method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkMovieContent()
    {
        $this->loadFixtures('MovieContents');
        $userSeq = "385cd85a14bb90c754897fd0366ff266";
        $movieFileId = 1;
        $result = $this->component->checkMovieContent($userSeq, $movieFileId);
        $this->assertTrue($result);

        $movieFileId2 = 100;
        $result2 = $this->component->checkMovieContent($userSeq, $movieFileId2);
        $this->assertFalse($result2);
    }

    /**
     * Test getMovieFileInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getMovieFileInfo()
    {
        $this->loadFixtures('MovieContents');
        $userSeq = "385cd85a14bb90c754897fd0366ff266";
        $movieFileId = 1;
        $expected = array(
            'movieFilePath' => '/home/personaltool2/storage/00002/385cd85a14bb90c754897fd0366ff266\movie\0000000001\thumbnail\pc',
            'movieFileData' => '/home/personaltool2/storage/00002/385cd85a14bb90c754897fd0366ff266\movie\0000000001\thumbnail\pc\thumbnail'
        );
        $result = $this->component->getMovieFileInfo($userSeq, $movieFileId, $deviceType = 'pc');
        $this->assertEquals($expected, $result);

        $result2 = $this->component->getMovieFileInfo($userSeq, 2, $deviceType = 'pc');
        $this->assertFalse($result2);

        $result3 = $this->component->getMovieFileInfo($userSeq, 100, $deviceType = 'pc');
        $this->assertFalse($result3);
    }

    /**
     * Test rmDirMovFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function rmDirMovFile()
    {
        $this->loadFixtures('MovieContents');
        //must create folder with name is $userSeq
        $userSeq = "385cd85a14bb90c754897fd0366ff267";
        $movieFileId = 1;
        $result = $this->component->rmDirMovFile($userSeq, $movieFileId, $dir = 'movie');
        $this->assertTrue($result);

        //dont create this folder with name is $userSeq2
        $userSeq2 = "385cd85a14bb90c754897fd0366ff268";
        $result2 = $this->component->rmDirMovFile($userSeq2, $movieFileId, $dir = 'movie');
        $this->assertFalse($result2);
    }

    /**
     * Test deleteMovieFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteMovieFile()
    {
        $this->loadFixtures('MovieContents');
        $userSeq = "385cd85a14bb90c754897fd0366ff266";
        $movieFileId = 1;
        $result = $this->component->deleteMovieFile($userSeq, $movieFileId);
        $this->assertTrue($result);

        $userSeqF = "385cd85a14bb90c754897fd0366ff267";
        $resultF = $this->component->deleteMovieFile($userSeqF, $movieFileId);
        $this->assertFalse($resultF);
    }

        /**
     * Test folderSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function folderSize()
    {
        $this->loadFixtures('MovieContents');
        $path = '/home/personaltool2/storage/00002/385cd85a14bb90c754897fd0366ff266\movie\0000000001\thumbnail\pc';
        $result = $this->component->folderSize($path);
        $this->assertInternalType("int", $result);

        $path2 = '/home/personaltool2/storage/00002/385cd85a14bb90c754897fd0366ff266\movie\0000000001';
        $result2 = $this->component->folderSize($path2);
        $this->assertInternalType("int", $result2);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }
}
