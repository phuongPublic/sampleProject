<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\MovieFolderComponent;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Validation\NoptBaseValidator;
use Cake\TestSuite\IntegrationTestCase;
// テスト対象資源指定
use App\Controller\Component\MovieComponent;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use ReflectionClass;

/**
 * App\Controller\Component\MovieFolderComponent Test Case
 */
class MovieFolderComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.MovieFolder',
        'app.OpenStatus',
        'app.MovieContents',
        'app.EncodeRequest',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new MovieFolderComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getMovieFolderInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFolderInfo(){
        $this->loadFixtures('MovieFolder', 'OpenStatus', 'MovieContents');
        $expected = [
            [
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_folder_name' => 'Movie Folder 1',
                'movie_folder_comment' => 'Movie Folder 1 Comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_count' => 4,
            ],
            [
                'movie_folder_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_folder_name' => 'Movie Folder 2',
                'movie_folder_comment' => 'Movie Folder 2 Comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_count' => 1,
            ]
        ];
        //case 1: sort old

        $result = $this->component->getFolderInfo($this->testUserSeq, 'old');

        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }

        $this->assertEquals($expected, $result);

        //case 2: sort new
        $expected = [
            [
                'movie_folder_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_folder_name' => 'Movie Folder 2',
                'movie_folder_comment' => 'Movie Folder 2 Comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_count' => 1,
            ],
            [
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_folder_name' => 'Movie Folder 1',
                'movie_folder_comment' => 'Movie Folder 1 Comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_count' => 4,
            ]
        ];
        $result = $this->component->getFolderInfo($this->testUserSeq, 'new');
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }

        $this->assertEquals($expected, $result);

    }

    /**
     * Test insertFolderData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function insertFolderData()
    {
        $this->loadFixtures('MovieFolder');
        $this->component->insertFolderData($this->testUserSeq, 'Movie Folder 4', 'Comment Movie Folder 4');

        $expected = [
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_folder_name' => 'Movie Folder 1',
            'movie_folder_comment' => 'Movie Folder 1 Comment',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ];
        $mFolderTbl = TableRegistry::get('MovieFolder');
        $result = $mFolderTbl->getSingleMovieFolderData($this->testUserSeq, 1);
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result[0]);

        // case NG
        $result = $this->component->insertFolderData(null, 'Movie Folder 4', 'Comment Movie Folder 4');
        $this->assertFalse($result);
    }

    /**
     * Test confirmExistFolder method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function confirmExistFolder()
    {
        $this->loadFixtures('MovieFolder');
        //case 1: movie folder is exist
        $this->component->confirmExistFolder($this->testUserSeq, 2);
        //case 2: movie folder is not exist
        $this->assertEquals(false, $this->component->confirmExistFolder($this->testUserSeq, 1000));
    }

    /**
     * Test updateMovieFolderData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateMovieFolderData()
    {
        $this->loadFixtures('MovieFolder');
        $expected = [
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_folder_name' => 'Movie Folder Edited',
            'movie_folder_comment' => 'Movie Folder Comment',
            'up_date' => date('Y-m-d'),
            'reg_date' => '2016-09-13'
        ];
        $this->component->updateMovieFolderData(1, $this->testUserSeq, 'Movie Folder Edited', 'Movie Folder Comment');
        $mFolderTbl = TableRegistry::get('MovieFolder');
        $result = $mFolderTbl->getSingleMovieFolderData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        // NG case
        $this->assertEquals(0, $this->component->updateMovieFolderData(1000, $this->testUserSeq, 'Movie Folder Edited', 'Movie Folder Comment'));

    }

    /**
     * Test deleteMovieFolderData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteMovieFolderData()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents');
        //case 1: movie folder is exist
        $this->assertEquals(1, $this->component->deleteMovieFolderData($this->testUserSeq, 1));
        //case 2: movie folder is not exist
        $this->assertEquals(0, $this->component->deleteMovieFolderData($this->testUserSeq, 1000));
    }



    /**
     * Test getMovieFolderInfoList method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getMovieFolderInfoList()
    {
        $result = $this->component->getMovieFolderInfoList($this->testUserSeq);
    }

    /**
     * Test getMovieFolderInfoById method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getMovieFolderInfoById()
    {
        $result = $this->component->getMovieFolderInfoById($this->testUserSeq, 1);
    }

    /**
     * Test getAllMovieFolderData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getAllMovieFolderData()
    {
        $result = $this->component->getAllMovieFolderData($this->testUserSeq);
    }

    /**
     * Test validationDefault method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validationDefault()
    {
        //case 1: empty name
        $data = [
            'movie_folder_name' => '',
            'movie_folder_comment' => 'Movie Folder comment'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['movie_folder_name']['noValue'])) {
            $flag = true;
        }

        //case 2: space name
        $data = [
            'movie_folder_name' => '   ',
            'movie_folder_comment' => 'Movie Folder comment'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['movie_folder_name']['noSpaces'])) {
            $flag = true;
        }

        $this->assertTrue($flag);

        //case 3: name over 25 characters
        $name = '';
        for ($i = 0; $i <= 26; $i++) {
            $name .= 'a';
        }
        $data = [
            'movie_folder_name' => $name,
            'movie_folder_comment' => 'フォルダコメント'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['movie_folder_name']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 4: comment over 1000 characters
        $data = [
            'movie_folder_name' => 'ファイル名1番',
            'movie_folder_comment' => 'フォルダコメント Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['movie_folder_comment']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
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

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }

    /**
     * Create time object
     * @return object
     */
    protected function makeTimeObj($time, $timeZone)
    {
        $timeInfo = new FrozenDate($time, $timeZone);
        return $timeInfo;
    }

    /**
     * Create time object Frozen Time
     * @return object
     */
    protected function makeFTimeObj($time, $timeZone)
    {
        $timeInfo = new FrozenTime($time, $timeZone);
        return $timeInfo;
    }
}