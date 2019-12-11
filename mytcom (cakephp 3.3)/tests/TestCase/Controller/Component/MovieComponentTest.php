<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\MovieComponent;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use App\Validation\NoptBaseValidator;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use ReflectionClass;

/**
 * App\Controller\Component\PictureComponent Test Case
 */
class MovieComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = [
        'app.MovieFolder',
        'app.MovieContents',
        'app.OpenStatus',
        'app.UserMst',
        'app.EncodeRequest',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new MovieComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getSearchMovieByFolder method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getSearchMovieByFolder()
    {
        $this->loadFixtures('MovieFolder', 'MovieContents');
        //case 1: movie folder exists
        $resultSearch = $this->component->getSearchMovieByFolder($this->testUserSeq, 1, 'movie1', 'new');
        $movieTbl = TableRegistry::get('MovieContents');
        $result = $movieTbl->getSingleMovieData($this->testUserSeq, 1);
        $this->assertEquals($resultSearch[0], $result[0]);
        //case2: search from all movie folder
        $expected = [
            'movie_contents_id' => 1,
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_contents_name' => 'movie1.mp4',
            'name' => 'movie1',
            'extension' => 'mp4',
            'amount' => 1,
            'movie_contents_url' => 'Lorem ipsum dolor sit amet',
            'movie_contents_comment' => 'movie1 comment',
            'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'movie_capture_url' => 'Lorem ipsum dolor sit amet',
            'reproduction_time' => 'Lorem ipsum dolor sit amet',
            'resultcode' => 1,
            'file_id' => 1,
            'encode_status' => 2,
            'encode_file_id_flv' => 1,
            'encode_file_id_docomo_300k' => 1,
            'encode_file_id_docomo_2m_qcif' => 1,
            'encode_file_id_docomo_2m_qvga' => 1,
            'encode_file_id_docomo_10m' => 1,
            'encode_file_id_au' => 1,
            'encode_file_id_sb' => 1,
            'video_size' => 1,
            'encode_file_id_iphone' => 1
        ];
        $result = $this->component->getSearchMovieByFolder($this->testUserSeq, '', 'movie1', 'new');
        $this->assertEquals($expected, $result[0]);

        //case 3: sort old
        //case2: search from all movie folder
        $expected = [
            'movie_contents_id' => 1,
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_contents_name' => 'movie1.mp4',
            'name' => 'movie1',
            'extension' => 'mp4',
            'amount' => 1,
            'movie_contents_url' => 'Lorem ipsum dolor sit amet',
            'movie_contents_comment' => 'movie1 comment',
            'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'movie_capture_url' => 'Lorem ipsum dolor sit amet',
            'reproduction_time' => 'Lorem ipsum dolor sit amet',
            'resultcode' => 1,
            'file_id' => 1,
            'encode_status' => 2,
            'encode_file_id_flv' => 1,
            'encode_file_id_docomo_300k' => 1,
            'encode_file_id_docomo_2m_qcif' => 1,
            'encode_file_id_docomo_2m_qvga' => 1,
            'encode_file_id_docomo_10m' => 1,
            'encode_file_id_au' => 1,
            'encode_file_id_sb' => 1,
            'video_size' => 1,
            'encode_file_id_iphone' => 1
        ];
        $result = $this->component->getSearchMovieByFolder($this->testUserSeq, '', 'movie1', 'old');
        $this->assertEquals($expected, $result[0]);
    }

    /**
     * Test updateMovieData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateMovieData()
    {
        $this->loadFixtures('MovieContents');
        //case 1:
        $expected = [
            'movie_contents_id' => 1,
            'movie_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_contents_name' => 'Movie Title.mp4',
            'name' => 'Movie Title',
            'extension' => 'mp4',
            'amount' => 1,
            'movie_contents_url' => 'Lorem ipsum dolor sit amet',
            'movie_contents_comment' => 'Movie custom comment',
            'up_date' => date('Y-m-d'),
            'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'movie_capture_url' => 'Lorem ipsum dolor sit amet',
            'reproduction_time' => 'Lorem ipsum dolor sit amet',
            'resultcode' => 1,
            'file_id' => 1,
            'encode_status' => 2,
            'encode_file_id_flv' => 1,
            'encode_file_id_docomo_300k' => 1,
            'encode_file_id_docomo_2m_qcif' => 1,
            'encode_file_id_docomo_2m_qvga' => 1,
            'encode_file_id_docomo_10m' => 1,
            'encode_file_id_au' => 1,
            'encode_file_id_sb' => 1,
            'video_size' => 1,
            'encode_file_id_iphone' => 1
        ];
        $this->component->updateMovieData($this->testUserSeq, 1, 'Movie Title', 'Movie custom comment');
        $movieTbl = TableRegistry::get('MovieContents');
        $result = $movieTbl->getSingleMovieData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        //case not found
        $updateResult = $this->component->updateMovieData($this->testUserSeq, 9999, 'Movie Title', 'Movie custom comment');
        $this->assertEquals(0, $updateResult);
    }

    /**
     * Test deleteMovieData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteMovieData()
    {
        $result = $this->component->deleteMovieData($this->testUserSeq, 6);
        $this->assertEquals(1, $result);
    }
    /**
     * Test moveContentsFolderData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function moveContentsFolderData()
    {
        $this->loadFixtures('MovieContents');
        //case 1:
        $expected = [
            'movie_contents_id' => 1,
            'movie_folder_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'movie_contents_name' => 'movie1.mp4',
            'name' => 'movie1',
            'extension' => 'mp4',
            'amount' => 1,
            'movie_contents_url' => 'Lorem ipsum dolor sit amet',
            'movie_contents_comment' => 'movie1 comment',
            'up_date' => date('Y-m-d'),
            'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
            'movie_capture_url' => 'Lorem ipsum dolor sit amet',
            'reproduction_time' => 'Lorem ipsum dolor sit amet',
            'resultcode' => 1,
            'file_id' => 1,
            'encode_status' => 2,
            'encode_file_id_flv' => 1,
            'encode_file_id_docomo_300k' => 1,
            'encode_file_id_docomo_2m_qcif' => 1,
            'encode_file_id_docomo_2m_qvga' => 1,
            'encode_file_id_docomo_10m' => 1,
            'encode_file_id_au' => 1,
            'encode_file_id_sb' => 1,
            'video_size' => 1,
            'encode_file_id_iphone' => 1
        ];
        $this->component->moveContentsFolderData($this->testUserSeq, 2, 1);
        $movieTbl = TableRegistry::get('MovieContents');
        $result = $movieTbl->getSingleMovieData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        //case movie not found
        $updateResult = $this->component->moveContentsFolderData($this->testUserSeq, 2, 9999);
        $this->assertEquals(0, $updateResult);

        //case destination folder not found
        $updateResult = $this->component->moveContentsFolderData($this->testUserSeq, 9999, 1);
        $this->assertEquals(-1, $updateResult);
    }

    /**
     * Test checkMovieEncStatus method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkMovieEncStatus()
    {
        $result = $this->component->checkMovieEncStatus($this->testUserSeq);
    }

    /**
     * Test save method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function save()
    {
        $data = [
            'movie_folder_id' => 1,
            'extension' => 'mp4',
            'movie_contents_name' => 'movie save.mp4',
            'name' => 'movie save',
            'movie_contents_comment' => 'comment',
        ];
        $movieTbl = TableRegistry::get('MovieContents');
        $newId = $movieTbl->selectNextId($this->testUserSeq);
        $result = $this->component->save($newId, $this->testUserSeq, $data);
        $this->assertTrue($result);
    }

    /**
     * Test getFiveMovie method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFiveMovie()
    {
        $data = [
            [
                'movie_contents_id' => 1,
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_contents_name' => 'movie1.mp4',
                'name' => 'movie1',
                'extension' => 'mp4',
                'amount' => 1,
                'movie_contents_url' => 'Lorem ipsum dolor sit amet',
                'movie_contents_comment' => 'movie1 comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_capture_url' => 'Lorem ipsum dolor sit amet',
                'reproduction_time' => 'Lorem ipsum dolor sit amet',
                'resultcode' => 1,
                'file_id' => 1,
                'encode_status' => 2,
                'encode_file_id_flv' => 1,
                'encode_file_id_docomo_300k' => 1,
                'encode_file_id_docomo_2m_qcif' => 1,
                'encode_file_id_docomo_2m_qvga' => 1,
                'encode_file_id_docomo_10m' => 1,
                'encode_file_id_au' => 1,
                'encode_file_id_sb' => 1,
                'video_size' => 1,
                'encode_file_id_iphone' => 1
            ],
            [
                'movie_contents_id' => 2,
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_contents_name' => 'movie2.wmv',
                'name' => 'movie2',
                'extension' => 'wmv',
                'amount' => 1,
                'movie_contents_url' => 'Lorem ipsum dolor sit amet',
                'movie_contents_comment' => 'movie2 comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_capture_url' => 'Lorem ipsum dolor sit amet',
                'reproduction_time' => 'Lorem ipsum dolor sit amet',
                'resultcode' => 1,
                'file_id' => 1,
                'encode_status' => 0,
                'encode_file_id_flv' => 1,
                'encode_file_id_docomo_300k' => 1,
                'encode_file_id_docomo_2m_qcif' => 1,
                'encode_file_id_docomo_2m_qvga' => 1,
                'encode_file_id_docomo_10m' => 1,
                'encode_file_id_au' => 1,
                'encode_file_id_sb' => 1,
                'video_size' => 1,
                'encode_file_id_iphone' => 1
            ],
            [
                'movie_contents_id' => 3,
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_contents_name' => 'movie3.avi',
                'name' => 'movie3',
                'extension' => 'avi',
                'amount' => 1,
                'movie_contents_url' => 'Lorem ipsum dolor sit amet',
                'movie_contents_comment' => 'movie3 comment',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'movie_capture_url' => 'Lorem ipsum dolor sit amet',
                'reproduction_time' => 'Lorem ipsum dolor sit amet',
                'resultcode' => 1,
                'file_id' => 1,
                'encode_status' => 0,
                'encode_file_id_flv' => 1,
                'encode_file_id_docomo_300k' => 1,
                'encode_file_id_docomo_2m_qcif' => 1,
                'encode_file_id_docomo_2m_qvga' => 1,
                'encode_file_id_docomo_10m' => 1,
                'encode_file_id_au' => 1,
                'encode_file_id_sb' => 1,
                'video_size' => 1,
                'encode_file_id_iphone' => 1
            ],
            //encode request abnormal encode_status == 3
            [
                'movie_contents_id' => 4,
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_contents_name' => 'movie4.avi',
                'name' => 'movie4',
                'extension' => 'avi',
                'amount' => 1,
                'movie_contents_url' => 'Lorem ipsum dolor sit amet',
                'movie_contents_comment' => 'movie4 comment',
                'up_date' => '2017-09-13',
                'reg_date' => '2017-09-13',
                'movie_capture_url' => 'Lorem ipsum dolor sit amet',
                'reproduction_time' => 'Lorem ipsum dolor sit amet',
                'resultcode' => 1,
                'file_id' => 1,
                'encode_status' => 0,
                'encode_file_id_flv' => 1,
                'encode_file_id_docomo_300k' => 1,
                'encode_file_id_docomo_2m_qcif' => 1,
                'encode_file_id_docomo_2m_qvga' => 1,
                'encode_file_id_docomo_10m' => 1,
                'encode_file_id_au' => 1,
                'encode_file_id_sb' => 1,
                'video_size' => 1,
                'encode_file_id_iphone' => 1
            ],
            //movie delete reservation, encode_status == 9
            [
                'movie_contents_id' => 5,
                'movie_folder_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'movie_contents_name' => 'movie5.avi',
                'name' => 'movie5',
                'extension' => 'avi',
                'amount' => 1,
                'movie_contents_url' => 'Lorem ipsum dolor sit amet',
                'movie_contents_comment' => 'movie5 comment',
                'up_date' => '2017-09-13',
                'reg_date' => '2017-09-13',
                'movie_capture_url' => 'Lorem ipsum dolor sit amet',
                'reproduction_time' => 'Lorem ipsum dolor sit amet',
                'resultcode' => 1,
                'file_id' => 1,
                'encode_status' => 9,
                'encode_file_id_flv' => 1,
                'encode_file_id_docomo_300k' => 1,
                'encode_file_id_docomo_2m_qcif' => 1,
                'encode_file_id_docomo_2m_qvga' => 1,
                'encode_file_id_docomo_10m' => 1,
                'encode_file_id_au' => 1,
                'encode_file_id_sb' => 1,
                'video_size' => 1,
                'encode_file_id_iphone' => 1
            ],
        ];
        $this->component->getFiveMovie($data);
    }

    /**
     * Test getDelMovieList method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getDelMovieList()
    {
        $del = [1,2];
        $result = $this->component->getDelMovieList($this->testUserSeq, $del);
    }

    /**
     * Test isExitsMovieFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function isExitsMovieFile()
    {
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 1);
        $this->assertTrue($result);
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 5);
        $this->assertFalse($result);
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 9);
        $this->assertFalse($result);
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 10);
        $this->assertFalse($result);
        /*
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 4);
        $this->assertFalse($result);
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 5);
        $this->assertFalse($result);
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 6);
        $this->assertFalse($result);
        */
        $result = $this->component->isExitsMovieFile($this->testUserSeq, 9999);
        $this->assertFalse($result);
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
        /*
        //case 1: empty name
        $data = [
            'name' => '',
            'movie_contents_comment' => 'Movie comment'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name']['noValue'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
*/
        //case 2: name over 125 characters
        $name = '';
        for ($i = 0; $i <= 126; $i++) {
            $name .= 'a';
        }
        $data = [
            'name' => $name,
            'movie_contents_comment' => 'フォルダコメント'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 3: comment over 1000 characters
        $data = [
            'name' => 'ファイル名1番',
            'movie_contents_comment' => 'フォルダコメント Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'
        ];
        $validator = $this->component->validationDefault(new NoptBaseValidator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['movie_contents_comment']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test downloadAble method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function downloadAble()
    {
        $result = $this->component->downloadAble($this->testUserSeq, 1);
        $this->assertEquals(false, $result);

        $result = $this->component->downloadAble($this->testUserSeq, 4);
        $this->assertEquals(true, $result);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
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
