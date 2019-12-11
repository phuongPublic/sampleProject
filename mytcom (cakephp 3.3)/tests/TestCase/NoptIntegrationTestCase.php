<?php

namespace App\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Core\Exception\Exception;
use Cake\Utility\Inflector;
use App\Test\Fixture\AddressDataFixture;
use App\Test\Fixture\AdTblFixture;
use App\Test\Fixture\AlbumFixture;
use App\Test\Fixture\FileFolderTblFixture;
use App\Test\Fixture\FileTblFixture;
use App\Test\Fixture\GroupTblFixture;
use App\Test\Fixture\MovieContentsFixture;
use App\Test\Fixture\OpenStatusFixture;
use App\Test\Fixture\PicTblFixture;
use App\Test\Fixture\TargetUserFixture;
use App\Test\Fixture\UserMstFixture;
use Cake\TestSuite\Fixture\FixtureManager;
use ReflectionClass;

abstract class NoptIntegrationTestCase extends IntegrationTestCase
{

    public $autoFixtures = false;
    //public $dropTables = false; // テーブルdropさせない(※条件によって正常動作しない模様)
    // 現時点で存在している全てのテーブルに対してMap定義
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AddressData',
        'app.Album',
        'app.BlogPic',
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.GroupTbl',
        'app.OpenStatus',
        'app.PicTbl',
        'app.TargetUser',
        'app.UserMst',
        'app.Weblog',
        'app.AdTbl',
    ];
    protected $testUserSeq = '385cd85a14bb90c754897fd0366ff266';
    protected $redirectUrl;
    protected $testUrl;
    protected $redirectUrl1;
    protected $redirectUrl2;

    abstract protected function setSession();

    public function setUp()
    {
        parent::setUp();
        $this->useHttpServer(true);

        $testUrl = get_class($this);
        $testUrl = str_replace('App\\Test\\TestCase\\Controller', '', $testUrl);
        $testUrl = str_replace('ControllerTest', '', $testUrl);
        $testUrl = str_replace('\\', '/', $testUrl);
        $this->testUrl = $testUrl;
        // 初期設定はPC
        $this->switchDevice(1);
        // Fixture操作?(全体で必要な模様なので基底でも実施)
        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * デバイスの切り替え
     *
     * @param deviceTypeId $type
     */
    public function switchDevice($type)
    {
        if ($type == 2) {
            $this->configRequest([
                'headers' => [
                    'User-Agent' => 'Mozilla /5.0 (iPhone; CPU iPhone OS 9_0 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13A344 Safari/601.1'
                ]
            ]);
        } else if ($type == 3) {
            $this->configRequest([
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Linux; Android 6.0.1; 404SC Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Mobile Safari/537.36'
                ]
            ]);
        } else {
            // ヘッダーの設定
            $this->configRequest([
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)'
                ]
            ]);
        }
    }

    /**
     * 対象セッションデータの格納
     *
     * @param deviceTypeId $type
     */
    public function setSessionData($name, $value)
    {
        $this->session([
            $name => $value
        ]);
    }

    /**
     * CSVファイルを読込んでファイル内容を返します。<br>
     * CSVファイルは実行するテストクラスと同じディレクトリに配置します。<br>
     * ※1.CSVファイルのファイルサイズは1MBまで<br>
     * ※2.CSVファイルの文字コーディングはShift_JIS<br>
     * ※3.ヘッダー行には列名が必要<br>
     *
     * @param
     *            string ファイル名
     * @return array 配列の配列を返します
     */
    protected function readCsv($filename, $code = 'UTF-8')
    {
        $path = dirname(__FILE__);

        /*
         * $class = new \Reflection($this);
         * $testPath = pathinfo($class->getFileName());
         */
        $csv = $path . DS . 'csv' . DS . $filename;

        if (!file_exists($csv)) {
            throw new Exception("Could not find CSV file. [$csv]");
        }

        $size = filesize($csv);
        if ($size > 1048576) {
            // 最大1MBまで
            throw new Exception("CSV File is over maximum size. [$csv]-[$size]");
        }

        $data = array();
        $fp = fopen($csv, "r");
        // ヘッダー行取得
        $header = fgetcsv($fp);
        while ($row = fgetcsv($fp)) {
            mb_convert_variables($code, 'UTF-8', $row);
            $array = array();
            foreach ($header as $index => $column) {
                if (array_key_exists($index, $row)) {
                    $array [$column] = $row [$index] != 'NULL' ? $row [$index] : null;
                } else {
                    $array [$column] = null;
                }
            }
            $data [] = $array;
        }
        return $data;
    }

    protected function loadCsvFixture($fixtureName, $filename, $code = 'UTF-8')
    {
        $fixture = substr($fixtureName, strlen('app.'));
        $fixturePath = TESTS . 'Fixture';

        $className = Inflector::camelize($fixture);
        if (is_readable($fixturePath . DS . $className . 'Fixture.php')) {
            $fixtureFile = $fixturePath . DS . $className . 'Fixture.php';
            require_once $fixtureFile;
            $fixtureClass = $className . 'Fixture';
        } else {
            throw new Exception('Could not read fixture class. ' . $fixtureName);
        }

        // 時間があればリファクタリング
        if ($fixtureClass == 'AddressDataFixture') {
            $fixture = new AddressDataFixture ();
        } else if ($fixtureClass == 'AlbumFixture') {
            $fixture = new AlbumFixture ();
        } else if ($fixtureClass = 'FileFolderTblFixture') {
            $fixture = new FileFolderTblFixture ();
        } else if ($fixtureClass == 'FileTblFixture') {
            $fixture = new FileTblFixture ();
        } else if ($fixtureClass == 'GroupTblFixture') {
            $fixture = new GroupTblFixture ();
        } else if ($fixtureClass == 'OpenStatusFixture') {
            $fixture = new OpenStatusFixture ();
        } else if ($fixtureClass == 'PicTblFixture') {
            $fixture = new PicTblFixture ();
        } else if ($fixtureClass == 'TargetUserFixture') {
            $fixture = new TargetUserFixture ();
        } else if ($fixtureClass == 'UserMstFixture') {
            $fixture = new UserMstFixture ();
        } else if ($fixtureClass == 'AdTblFixture') {
            $fixture = new AdTblFixture ();
        }
        // 動かない
        // $fixture = new $fixtureClass();
        $data = $this->readCsv($filename, $code);
        $fixture->records = $data;

        $fixtureManager = new AppFixtureManager ();
        $fixtureManager->loadSingleOrigin($fixture, null, true);
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
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
