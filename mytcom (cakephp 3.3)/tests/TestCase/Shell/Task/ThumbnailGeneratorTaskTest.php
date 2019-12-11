<?php

namespace App\Test\TestCase\Shell\Task;

use App\Test\TestCase\NoptShellTestCase;
use App\Shell\Task\ThumbnailGeneratorTask;
use App\Shell\Task\StopWatchTask;

require_once APP . 'Shell\\ThumbnailGeneratorShell.php';

/**
 * App\Shell\Task\ThumbnailGeneratorTask Test Case
 *
 * 下記のメソッドについて,
 * 実施不可能な経路以外の経路は、本クラスのexecuteを実施することにより通るため、試験コードを作成しない
 * initialSetting
 * createPcDetail
 * createPcThumbnail
 * createMobileThumbnail
 * createIphoneThumbnail
 * makeImageByPhpThumb
 * getImageInfo
 */
class ThumbnailGeneratorTaskTest extends NoptShellTestCase
{

    public $ImageFPathExist;
    public $ImageFPathNotExist;

    /**
     * Test subject
     *
     * @var \App\Shell\Task\ThumbnailGeneratorTask
     */
    public $ThumbnailGenerator;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->ThumbnailGenerator = new ThumbnailGeneratorTask();

        $this->ThumbnailGenerator->StopWatch = new StopWatchTask();
        // put the real image file in the place below in advance
        $this->ImageFPathExist = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest\\0000000001';
        // NOT put the real image file in the place below in advance
        $this->ImageFPathNotExist = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest\\0000000002';
    }

    /**
     * Test getImageFormatForPhpthumb method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getImageFormatForPhpthumb()
    {
        $methodName = "getImageFormatForPhpthumb";
        $this->assertEquals('jpg', $this->invokeMethod($this->ThumbnailGenerator, $methodName, ['image/jpg']));
        $this->assertEquals('png', $this->invokeMethod($this->ThumbnailGenerator, $methodName, ['image/png']));
        $this->assertEquals('gif', $this->invokeMethod($this->ThumbnailGenerator, $methodName, ['image/gif']));
    }

    /**
     * Test makeNgFlgFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function makeNgFlgFile()
    {
        $methodName = "makeNgFlgFile";
        $this->assertNull($this->invokeMethod($this->ThumbnailGenerator, $methodName, [$this->ImageFPathExist]));
        $this->assertFileExists($this->ImageFPathExist . SUFFIX_NG_FLG);
    }

    /**
     * Test deleteNgFlgFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    // makeNgFlgFileで作成したNGフラグファイルをdeleteNgFlgFileで削除する
    public function deleteNgFlgFile()
    {
        $methodName = "deleteNgFlgFile";
        // 削除対象ファイルがある場合
        $this->assertNull($this->invokeMethod($this->ThumbnailGenerator, $methodName, [$this->ImageFPathExist]));
        $this->assertFileNotExists($this->ImageFPathExist . SUFFIX_NG_FLG);
        // 削除対象ファイルがない場合
        $this->assertNull($this->invokeMethod($this->ThumbnailGenerator, $methodName, [$this->ImageFPathNotExist]));
        $this->assertFileNotExists($this->ImageFPathNotExist . SUFFIX_NG_FLG);
    }

    /**
     * Test getSizeForPcDetail method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function convertImageSize()
    {
        $methodName = "convertImageSize";

        $dstImageWidth = 160;
        $dstImageHeight = 160;
        $makeProcNameForLog = "TEST:convertImageSize";

        $imageNamePatternMulti = [
            ['width_1000-height_1000_out.jpg', 'width_1000-height_1000.jpg'],
            ['width_1001-height_1000_out.jpg', 'width_1001-height_1000.jpg'],
            ['width_1000-height_1001_out.jpg', 'width_1000-height_1001.jpg'],
        ];
        foreach ($imageNamePatternMulti as $imageNamePatternSingle) {
            $dstImageName = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest' . DS . $imageNamePatternSingle[0];
            $srcImageName = ROOT . DS . 'tests\\TestData\\ThumbnailGeneratorTaskTest' . DS . $imageNamePatternSingle[1];
            $this->assertNull($this->invokeMethod($this->ThumbnailGenerator, $methodName, [$dstImageName, $srcImageName, $dstImageWidth, $dstImageHeight, $makeProcNameForLog]));
            $this->assertFileExists($dstImageName);
        }
    }

    /**
     * Test getSizeForPcDetail method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getSizeForPcDetail()
    {
        $methodName = "getSizeForPcDetail";

        $imageSizePatternMulti = [
            // 右記の場合　$this->orgImageWidth <= WIDTH_MAX_DETAIL && $this->orgImageHeight <= HEIGHT_MAX_DETAIL
            [WIDTH_MAX_DETAIL, HEIGHT_MAX_DETAIL],
            // 右記の場合　$this->orgImageWidth <= WIDTH_MAX_DETAIL && $this->orgImageHeight > HEIGHT_MAX_DETAIL
            [WIDTH_MAX_DETAIL, HEIGHT_MAX_DETAIL + 1],
            // 右記の場合　$this->orgImageWidth > WIDTH_MAX_DETAIL && $this->orgImageHeight <= HEIGHT_MAX_DETAIL
            [WIDTH_MAX_DETAIL + 1, HEIGHT_MAX_DETAIL],
            // 下記のAかつBの場合　
            // A.$this->orgImageWidth > WIDTH_MAX_DETAIL && $this->orgImageHeight > HEIGHT_MAX_DETAIL
            // B.$orgImageWidthRated < $orgImageHeightRated
            [WIDTH_MAX_DETAIL + 1, HEIGHT_MAX_DETAIL + 2],
            // 下記のAかつBの場合　
            // A.$this->orgImageWidth > WIDTH_MAX_DETAIL && $this->orgImageHeight > HEIGHT_MAX_DETAIL
            // B.$orgImageWidthRated => $orgImageHeightRated
            [WIDTH_MAX_DETAIL + 2, HEIGHT_MAX_DETAIL + 1],
        ];
        foreach ($imageSizePatternMulti as $imageSizePatternSingle) {
            $orgImageWidth = $imageSizePatternSingle[0];
            $orgImageHeight = $imageSizePatternSingle[1];
            $this->invokeProperty($this->ThumbnailGenerator, 'orgImageWidth', $orgImageWidth);
            $this->invokeProperty($this->ThumbnailGenerator, 'orgImageHeight', $orgImageHeight);
            $this->assertArrayHasKey(0, $this->invokeMethod($this->ThumbnailGenerator, $methodName));
            $this->assertArrayHasKey(1, $this->invokeMethod($this->ThumbnailGenerator, $methodName));
        }
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
        // 引数が不正なパス・または画像ファイルでないとき
        $this->assertNull($this->ThumbnailGenerator->execute($this->ImageFPathNotExist));
        // 引数が不正なパス・または画像ファイルでないとき
        $this->assertNull(($this->ThumbnailGenerator->execute($this->ImageFPathExist)));

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
        // 完了後のクリーンアップ
        unset($this->ThumbnailGenerator);
        parent::tearDown();
    }

}
