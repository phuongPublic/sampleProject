<?php
namespace App\Test\TestCase\Controller;

use App\Model\Table\MovieContentsTable;
use App\Controller\Component\MovieThumbnailEditComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-13 at 10:29:46.
 */
class MovieThumbnailEditComponentTest extends NoptComponentIntegrationTestCase {

    public $fixtures = [
        'app.MovieContents',
        'app.OpenStatus',
        'app.PicTbl',
    ];

    /**
     * @var MovieThumbnailEditComponent
     */
//    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->object = new MovieThumbnailEditComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }
    
    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown() {
    }

    /**
     * @covers App\Controller\Component\MovieThumbnailEditComponent::selectMovieReproductionTime
     * @todo   Implement testSelectMovieReproductionTime().
     */
    // 正常
    public function testGetMovieReproductionTime1() {
        $userSeq = 1;
        $movieContentsId = 1;
        $reproductionTime = 33;
        
        $this->assertEquals(
                $this->object->selectMovieReproductionTime($userSeq, $movieContentsId), $reproductionTime);
    }
    
    /**
     * @covers App\Controller\Component\MovieThumbnailEditComponent::selectMovieReproductionTime
     * @expectedException Exception
     */
    // SELECTに失敗した場合
    public function testGetMovieReproductionTime2() {
        $this->loadFixtures('MovieContents', 'OpenStatus', 'PicTbl');
        $userSeq = 1;
        $movieContentsId = 1;
        
        $this->object->selectMovieReproductionTime($userSeq, $movieContentsId);
    }
    
    /**
     * @covers App\Controller\Component\MovieThumbnailEditComponent::selectMovieReproductionTime
     * @expectedException Exception
     */
    // SELECTの結果が空だった場合
    public function testGetMovieReproductionTime3() {
        $userSeq = 1;
        $movieContentsId = 1;
        
        $this->object->selectMovieReproductionTime($userSeq, $movieContentsId);
    }
    
    /**
     * @covers App\Controller\Component\MovieThumbnailEditComponent::addMovieThumbnailEditRequest
     * @todo   Implement testAddMovieThumbnailEditRequest().
     */
    // 正常
    public function testAddMovieThumbnailEditRequest1() {
        $userSeq = 1;
        $movieContentsId = 1;
        $thumbnailPosition = 5;
        
        $this->assertEquals(
            $this->object->addMovieThumbnailEditRequest($userSeq, $movieContentsId, $thumbnailPosition), true);
    }
    
    /**
     * @covers App\Controller\Component\MovieThumbnailEditComponent::addMovieThumbnailEditRequest
     * @todo   Implement testAddMovieThumbnailEditRequest().
     */
    // INSERTに失敗した場合
    public function testAddMovieThumbnailEditRequest2() {
        $userSeq = 1;
        $movieContentsId = 1;
        $thumbnailPosition = 5;
        
        $this->assertEquals(
            $this->object->addMovieThumbnailEditRequest($userSeq, $movieContentsId, $thumbnailPosition), true);
    }

}