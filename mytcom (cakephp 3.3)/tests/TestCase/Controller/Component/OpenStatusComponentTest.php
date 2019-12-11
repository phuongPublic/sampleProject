<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\OpenStatusComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\FileComponent Test Case
 */
class OpenStatusComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.OpenStatus',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new OpenStatusComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test updateDownloadCount method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateDownloadCount()
    {
        $this->loadFixtures('OpenStatus');
        // case del = null
        $openData = array('open_id' => 'open_id1', 'user_seq' => $this->testUserSeq);

        // case 1
        $result = true;
        $fileData = array(array('album_id' => 1));
        try {
            $this->component->updateDownloadCount($fileData, $openData, 1);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        $fileData = array(array('pic_id' => 1));
        try {
            $this->component->updateDownloadCount($fileData, $openData, 3);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        $fileData = array(array('file_id' => 1));
        try {
            $this->component->updateDownloadCount($fileData, $openData, 2);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }
}