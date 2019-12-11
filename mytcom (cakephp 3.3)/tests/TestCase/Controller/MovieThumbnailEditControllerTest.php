<?php

//namespace App\Test\TestCase\Controller\src\Controller;

namespace App\Controller;

use App\Controller;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-13 at 10:29:30.
 */
class MovieThumbnailEditControllerTest extends \Cake\TestSuite\TestCase {

    /**
     * @var MovieThumbnailEditController
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp() {
        $this->object = new MovieThumbnailController();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown() {
        
    }

    /**
     * @covers App\Controller\MovieThumbnailEditController::initialize
     * @todo   Implement testInitialize().
     */
    public function testInitialize() {
//        $this->object->initialize();
    }

    /**
     * @covers App\Controller\MovieThumbnailEditController::index
     * @todo   Implement testIndex().
     */
    // 正常
    public function testIndex1() {
        $this->session([
            'UserData' => [
                'user_seq' => '1'
            ]
        ]);
               
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'ContentType' => 'application/json; charset=utf-8'
            ],
            'movie_contents_id' => 1, 
            'thumbnail_position' => '00:00.01'
        ]);
        
        $message = "サムネイル画像の設定が完了しました。";
        
         $this->assertEquals(
            $this->object->index(), $message);
    }

    /**
     * @covers App\Controller\MovieThumbnailEditController::index
     * @todo   Implement testIndex().
     */
    // サムネイル編集対象の動画が存在しない
    public function testIndex2() {
        $this->session([
            'UserData' => [
                'user_seq' => '1'
            ]
        ]);
        
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'ContentType' => 'application/json; charset=utf-8'
            ],
            'movie_contents_id' => 0, 
            'thumbnail_position' => '00:00.01'
        ]);
        
        $message = "受付に失敗しました。\n時間を開けて再度登録してください。";
        
         $this->assertEquals(
            $this->object->index(), $message);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::index
     * @todo   Implement testIndex().
     */
    // サムネイルの指定位置が不正
    public function testIndex3() {        
        $this->session([
            'UserData' => [
                'user_seq' => '1'
            ]
        ]);
        
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'ContentType' => 'application/json; charset=utf-8'
            ],
            'movie_contents_id' => 1, 
            'thumbnail_position' => '60:00.01'
        ]);
        
        $message = "サムネイルの編集点は\n動画の時間以内で設定してください。"; 
        
         $this->assertEquals(
            $this->object->index(), $message);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::index
     * @todo   Implement testIndex().
     */
    // DB登録エラー
    public function testIndex4() {        
        $this->session([
            'UserData' => [
                'user_seq' => '1'
            ]
        ]);
        
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'ContentType' => 'application/json; charset=utf-8'
            ],
            'movie_contents_id' => 1, 
            'thumbnail_position' => '00:00.01'
        ]);
        
        $message = "受付に失敗しました。\n時間を開けて再度登録してください。";
        
         $this->assertEquals(
            $this->object->index(), $message);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::index
     * @todo   Implement testIndex().
     */
    // ajax でない場合
    public function testIndex5() {
        $this->session([
            'UserData' => [
                'user_seq' => '1'
            ]
        ]);
        
        $this->configRequest([
            'movie_contents_id' => 1, 
            'thumbnail_position' => '00:00.01'
        ]);
        
        $message = "受付に失敗しました。\n時間を開けて再度登録してください。";
        
         $this->assertEquals(
            $this->object->index(), $message);
    }
    

    /**
     * @covers App\Controller\MovieThumbnailEditController::checkThumbnailPosition
     * @todo   Implement testCheckThumbnailPosition().
     */
    // thumbnailPositionが最小値の場合
    public function testCheckThumbnailPosition1() {
        $thumbnailPosition = "00:00.00";
        $reproductionTime = "00:33.30";
        $result = true;
        
        $this->assertEquals(
            $this->object->checkThumbnailPosition($thumbnailPosition, $reproductionTime), $result);      
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::checkThumbnailPosition
     * @todo   Implement testCheckThumbnailPosition().
     */
    // thumbnailPositionが条件を満たしている場合
    public function testCheckThumbnailPosition2() {
        $thumbnailPosition = "00:05.00";
        $reproductionTime = "00:33.30";
        $result = true;
        
        $this->assertEquals(
            $this->object->checkThumbnailPosition($thumbnailPosition, $reproductionTime), $result);
        }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::checkThumbnailPosition
     * @todo   Implement testCheckThumbnailPosition().
     */
    // thumbnailPositionが最大値の場合
    public function testCheckThumbnailPosition3() {
        $thumbnailPosition = "00:22.00";
        $reproductionTime = "00:22.00";
        $result = true;
        
        $this->assertEquals(
            $this->object->checkThumbnailPosition($thumbnailPosition, $reproductionTime), $result);
        }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::checkThumbnailPosition
     * @todo   Implement testCheckThumbnailPosition().
     */
    // thumbnailPositionが条件を満たしていない場合
    public function testCheckThumbnailPosition4() {
        $thumbnailPosition = "00:25.00";
        $reproductionTime = "00:22.00";
        $result = false;
        
        $this->assertEquals(
            $this->object->checkThumbnailPosition($thumbnailPosition, $reproductionTime), $result);
        }
    

    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond1() {
        $textTime = "12:23.11";      
        
        $this->assertEquals(
            $this->object->textToSecond($textTime), 743.11);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond2() {
        $textTime = "00:13.11";
        
        $this->assertEquals(
            $this->object->textToSecond($textTime), 13.11);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond3() {
        $textTime = "01:00.93";
       
        $this->assertEquals(
            $this->object->textToSecond($textTime), 60.93);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond4() {
        $textTime = "00:00.93";
        
        $this->assertEquals(
            $this->object->textToSecond($textTime), 0.93);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond5() {
        $textTime = "00:00.00";
        
        $this->assertEquals(
           $this->object->textToSecond($textTime), 0);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond6() {
        $textTime = "0:0.0";
        
        $this->assertEquals(
           $this->object->textToSecond($textTime), -1);
    }
    
    /**
     * @covers App\Controller\MovieThumbnailEditController::textToSecond
     * @todo   Implement testTextToSecond().
     */
    public function testTextToSecond7() {
        $textTime = "";
        
        $this->assertEquals(
           $this->object->textToSecond($textTime), -1);
    }
    
}
