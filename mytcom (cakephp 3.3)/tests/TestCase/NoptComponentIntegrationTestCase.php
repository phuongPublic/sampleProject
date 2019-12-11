<?php

namespace App\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\Fixture\FixtureManager;
use ReflectionClass;

abstract class NoptComponentIntegrationTestCase extends IntegrationTestCase
{

    protected $testUserSeq = '385cd85a14bb90c754897fd0366ff266';
    public $autoFixtures = false; // CUD系のテストの為自動読み込み不可。loadFixturesを使用し初期化
    //public $dropTables = false; // テーブルdropさせない(※条件によって正常動作しない模様)
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AddressData',
        'app.Album',
        'app.BlogPic',
        'app.FileTbl',
        'app.GroupTbl',
        'app.OpenStatus',
        'app.PicTbl',
        'app.TargetUser',
        'app.UserMst',
        'app.Weblog',
        'app.MovieContents',
        'app.MovieFolder',
    ];
    public $component = null;
    public $controller = null;

    public function setUp()
    {
        parent::setUp();
        parent::setUp();
        $request = new Request ();
        $response = new Response ();
        $this->controller = $this->getMockBuilder('Cake\Controller\Controller')->setConstructorArgs([
                    $request,
                    $response
                ])->setMethods(null)->getMock();
        // Fixture操作?(全体で必要な模様なので基底でも実施)
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    public function tearDown()
    {
        parent::tearDown();
        //TableRegistry::clear();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }

    /**
     * DBエラー用モック
     * ※100%必要であれば使用
     * @param string $model
     * @param string $function
     *
     * @return object
     *
     */
//    protected function getModelMock($model, $function)
//    {
//        $model = $this->getMockForModel($model, ["$function"]);
//        $model
//        ->method($function)
//        ->will($this->throwException(new Exception));
//    }

        /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
