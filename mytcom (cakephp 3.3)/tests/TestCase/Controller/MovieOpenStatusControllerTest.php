<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use ReflectionClass;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use App\Controller\MovieOpenStatusController;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\MovieOpenStatusController Test Case
 */
class MovieOpenStatusControllerTest extends NoptIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.TargetUser',
        'app.OpenStatus',
        'app.UserMst'
    ];

    public function setUp()
    {
        parent::setUp();
        $request = new Request();
        $response = new Response();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')->setConstructorArgs([
            $request,
            $response
        ])->setMethods(null)->getMock();
        $this->controller = new MovieOpenStatusController();
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Test index method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexPc()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->switchDevice(1);
        $this->get($this->testUrl . '?cid=all&mid=1');
        $this->assertResponseCode(200);

        $this->get($this->testUrl . '?cid=1&mid=1');
        $this->assertResponseCode(200);

        $data = [
            'cid' => 'all',
            'mid' => '1',
            'open_id' => 'pic_component',
            'target_user_seq' => array('5'),
            'mov_mode' => '0',
            'delete' => '終了する'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }

    /**
     * Test indexSP method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function indexSP()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $result = true;
        try {
            $this->switchDevice(2);
            $this->get($this->testUrl . '?cid=all&mid=1&back=1');
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test movieOpenStatusMore method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function showMoreMovieOpenStatus()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents', 'OpenStatus');
        $this->switchDevice(2);
        $this->get($this->testUrl . '/showMoreMovieOpenStatus?cid=all&mid=1&page=2');
        $this->assertResponseCode(200);

        $this->switchDevice(3);
        $this->get($this->testUrl . '/showMoreMovieOpenStatus?cid=1&mid=1&page=2');
        $this->assertResponseCode(200);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
    }
}
