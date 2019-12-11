<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\UserMstComponent;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Database\Exception;

/**
 * App\Controller\Component\UserMstComponent Test Case
 */
class UserMstComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.UserMst'
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new UserMstComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test updateUsedFileSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateUsedFileSize()
    {
        $this->loadFixtures('UserMst');
        //case 1:
        $size = 100;
        $this->component->updateUsedFileSize('album', $this->testUserSeq, $size);
        $userTbl = TableRegistry::get('UserMst');
        $user = $userTbl->getUserInformation($this->testUserSeq);
        $this->assertEquals($user[0]['album_size'], $size);

        //case 2:
        $size = 200;
        $this->component->updateUsedFileSize('movie', $this->testUserSeq, $size);
        $userTbl = TableRegistry::get('UserMst');
        $user = $userTbl->getUserInformation($this->testUserSeq);
        $this->assertEquals($user[0]['movie_size'], $size);

        //case 3:
        $size = 300;
        $this->component->updateUsedFileSize('', $this->testUserSeq, $size);
        $userTbl = TableRegistry::get('UserMst');
        $user = $userTbl->getUserInformation($this->testUserSeq);
        $this->assertEquals($user[0]['file_size'], $size);

        //DBError
        /*         $this->getModelMock('UserMst', 'find');
                $flag = false;
                try {
                    $this->component->updateUsedFileSize('', $this->testUserSeq, $size);
                } catch (Exception $e){
                     $flag = true;
                }
                $this->assertTrue($flag); */

    }

    /**
     * Test checkFileSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkFileSize()
    {
        $this->loadFixtures('UserMst');
        $userTbl = TableRegistry::get('UserMst');
        $user = $userTbl->getUserInformation($this->testUserSeq);
        //case 1:
        $result = $this->component->checkFileSize($this->testUserSeq, 'album');
        $this->assertEquals($user[0]['album_size'], $result);

        //case 2:
        $result = $this->component->checkFileSize($this->testUserSeq, 'file');
        $this->assertEquals($user[0]['file_size'], $result);

        //case 3:
        $result = $this->component->checkFileSize($this->testUserSeq, 'movie');
        $this->assertEquals($user[0]['movie_size'], $result);
    }

    /**
     * Test getUserDataSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getUserDataSize()
    {
        $expected = 210000;
        $result = $this->component->getUserDataSize($this->testUserSeq, 'movie');
        $this->assertEquals($expected, $result);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }
}