<?php

namespace App\Test\TestCase\Controller;

use App\Controller\AppController;
use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Event\Event;
use ReflectionMethod;
use Cake\Network\Response;
use ReflectionClass;

/**
 * App\Controller\AppControllerTest Test Case
 */
class AppControllerTest extends NoptIntegrationTestCase
{
    public $fixtures = [
        'app.PicTbl',
        'app.MovieContents',
        'app.UserMst'
    ];

    /**
     * Test initialize method
     * covers AppControllerTest::initialize
     * @test
     * @return void
     */
    public function initialize()
    {
        $appController = new AppController;
        $result = true;
        try {
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'initialize');
            $reflectionMethod->invoke($appController);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test beforeRender method
     * covers AppControllerTest::beforeRender
     * @test
     * @return void
     */
    public function beforeFilter()
    {
        $appController = new AppController;
        $event = new Event('Model.Order.afterPlace', $this, array(
            'order' => 'ASC'
        ));

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
        $this->loadFixtures('PicTbl', 'UserMst', 'MovieContents');
        // case 1
        $result = true;
        try {
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'beforeFilter');
            $reflectionMethod->invoke($appController, $event);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2 for response json
        $result = true;
        $response = new Response();
        $response->type('application/json');
        $reflection = new ReflectionClass($appController);
        $reflection_property = $reflection->getProperty('response');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($appController, $response);
        try {
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'beforeFilter');
            $reflectionMethod->invoke($appController, $event);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3 for response xml
        $result = true;
        $response = new Response();
        $response->type('application/xml');
        $reflection = new ReflectionClass($appController);
        $reflection_property = $reflection->getProperty('response');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($appController, $response);
        try {
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'beforeFilter');
            $reflectionMethod->invoke($appController, $event);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test beforeRender method
     * covers AppControllerTest::beforeRender
     * @test
     * @return void
     */
    public function beforeRender()
    {
        $appController = new AppController;
        $reflection = new ReflectionClass($appController);
        $reflection_property = $reflection->getProperty('deviceTypeId');
        $reflection_property->setAccessible(true);

        // case 1 for Iphone
        $reflection_property->setValue($appController, 2);
        $result = true;
        try {
            $event = new Event('Model.Order.afterPlace', $this, array(
                'order' => 'ASC'
            ));
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'beforeRender');
            $reflectionMethod->invoke($appController, $event);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2: for Android
        $reflection_property->setValue($appController, 3);
        $result = true;
        try {
            $event = new Event('Model.Order.afterPlace', $this, array(
                'order' => 'ASC'
            ));
            $reflectionMethod = new ReflectionMethod('App\Controller\AppController', 'beforeRender');
            $reflectionMethod->invoke($appController, $event);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData();
    }
}