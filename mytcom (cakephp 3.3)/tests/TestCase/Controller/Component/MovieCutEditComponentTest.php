<?php

namespace App\Controller\Component;


use App\Controller\Component\MovieCutEditComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-16 at 01:50:59.
 */
class MovieCutEditComponentTest extends NoptComponentIntegrationTestCase {

    public $fixtures = [
        'app.MovieContents',
        'app.OpenStatus',
        'app.PicTbl',
    ];
    
    /**
     * @var MovieCutEditComponent
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //$this->object = new MovieCutEditComponent;

        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->object = new MovieCutEditComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
    }

    /**
     * @covers App\Controller\Component\MovieCutEditComponent::registerCutMovieInfo
     * @todo   Implement testRegisterCutMovieInfo().
     */
    public function testRegisterCutMovieInfo() {
        
        $userSeq = 1;
        $movieContentsId = 1;
        $movieEditMode = 1;
        $movieEditStart = 1;
        $movieEditEnd = 2;
        
        $this->object->registerCutMovieInfo($userSeq, $movieContentsId, $movieEditMode, $movieEditStart, $movieEditEnd);
    }

    /**
     * @covers App\Controller\Component\MovieCutEditComponent::getMovieInfo
     * @todo   Implement testGetMovieInfo().
     */
    // 正常
    public function testGetMovieInfo1() {
        $userSeq = 1;
        $movieContentsId = 1;
        
        $this->assertEquals(
            $this->object->getMovieInfo($userSeq, $movieContentsId), null);
    }
    
    /**
     * @covers App\Controller\Component\MovieCutEditComponent::getMovieInfo
     * @todo   Implement testGetMovieInfo().
     */
    // userSeqが存在しない
    public function testGetMovieInfo2() {
        $userSeq = 999;
        $movieContentsId = 1;
        
        $this->assertEquals(
            $this->object->getMovieInfo($userSeq, $movieContentsId), null);
    }
    
    /**
     * @covers App\Controller\Component\MovieCutEditComponent::getMovieInfo
     * @todo   Implement testGetMovieInfo().
     */
    // movieIdが存在しない
    public function testGetMovieInfo3() {
        $userSeq = 1;
        $movieContentsId = 999;
        
        $this->assertEquals(
            $this->object->getMovieInfo($userSeq, $movieContentsId), null);
    }
    
    
    /**
     * @covers App\Controller\Component\MovieCutEditComponent::getMovieInfo
     * @todo   Implement testGetMovieInfo().
     */
    // userSeq, movieIdが存在しない
    public function testGetMovieInfo4() {
        $userSeq = 999;
        $movieContentsId = 999;
        
        $this->assertEquals(
            $this->object->getMovieInfo($userSeq, $movieContentsId), null);
    }
    
    /**
     * @covers App\Controller\Component\MovieCutEditComponent::sendCutRequest
     * @todo   Implement testSendCutRequest().
     */
    // 正常
    public function testSendCutRequest1() {
        $userSeq = 1;
        $movieContentsId = 1;        
        $encodeData = 0;
        
        $this->assertEquals(sendCutRequest($userSeq, $movieContentsId, $encodeData), true);
    }
    
    /**
     * @covers App\Controller\Component\MovieCutEditComponent::sendCutRequest
     * @todo   Implement testSendCutRequest().
     */
    // 不正
    public function testSendCutRequest2() {
        $userSeq = 1;
        $movieContentsId = 1;        
        $encodeData = 0;
        
        $this->assertEquals(sendCutRequest($userSeq, $movieContentsId, $encodeData), false);
    } 

}
