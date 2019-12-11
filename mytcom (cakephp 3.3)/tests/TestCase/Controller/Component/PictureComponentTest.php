<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\PictureComponent;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Validation\Validator;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use ReflectionClass;
/**
 * App\Controller\Component\PictureComponent Test Case
 */
class PictureComponentTest extends NoptComponentIntegrationTestCase
{

    public $fixtures = [
        'app.Album',
        'app.PicTbl',
        'app.OpenStatus',
        'app.Weblog',
        'app.BlogPic',
        'app.UserMst'
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new PictureComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getSearchPicByAlbum method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getSearchPicByAlbum()
    {
        $this->loadFixtures('PicTbl');
        //case 1: old sort
        $result = $this->component->getSearchPicByAlbum($this->testUserSeq, 1, 'Picture', 'old');
        $expected = [
            [
                'pic_id' => 1,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 1.jpg',
                'name' => 'Picture 1',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
            [
                'pic_id' => 2,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 2.png',
                'name' => 'Picture 2',
                'extension' => 'png',
                'amount' => 2,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
        ];
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);

        //case 2: new sort
        $result = $this->component->getSearchPicByAlbum($this->testUserSeq, 1, 'Picture', 'new');
        $expected = [
            [
                'pic_id' => 2,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 2.png',
                'name' => 'Picture 2',
                'extension' => 'png',
                'amount' => 2,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
            [
                'pic_id' => 1,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 1.jpg',
                'name' => 'Picture 1',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
        ];
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);

        //case 3: missing album id
        $result = $this->component->getSearchPicByAlbum($this->testUserSeq, '', 'Picture', 'old');
        $expected = [
            [
                'pic_id' => 1,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 1.jpg',
                'name' => 'Picture 1',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
            [
                'pic_id' => 2,
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 2.png',
                'name' => 'Picture 2',
                'extension' => 'png',
                'amount' => 2,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
            [
                'pic_id' => 3,
                'album_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 3.gif',
                'name' => 'Picture 3',
                'extension' => 'gif',
                'amount' => 3,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000003',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
            [
                'pic_id' => 4,
                'album_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'pic_name' => 'Picture 4.gif',
                'name' => 'Picture 4',
                'extension' => 'gif',
                'amount' => 3,
                'base' => '00001/',
                'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000004',
                'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13'
            ],
        ];
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * Test movePicToAlbum method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function movePicToAlbum()
    {
        $this->loadFixtures('PicTbl', 'Album');
        //case 1: album exists
        $expected = array(
            'pic_id' => 1,
            'album_id' => 2,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 1.jpg',
            'name' => 'Picture 1',
            'extension' => 'jpg',
            'amount' => 1,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => date('Y-m-d'),
            'reg_date' => '2016-09-13'
        );
        $this->component->movePicToAlbum($this->testUserSeq, 2, 1);
        $fileTbl = TableRegistry::get('PicTbl');
        $result = $fileTbl->getSinglePicData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        //case 2: album is not exists
        //case 1: album exists
        $expected = array(
            'pic_id' => 2,
            'album_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture 2.png',
            'name' => 'Picture 2',
            'extension' => 'png',
            'amount' => 2,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
            'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        );
        $this->component->movePicToAlbum($this->testUserSeq, 0, 2);
        $fileTbl = TableRegistry::get('PicTbl');
        $result = $fileTbl->getSinglePicData($this->testUserSeq, 2);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);
    }

    /**
     * Test insertPicData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function insertPicData()
    {
        $this->loadFixtures('Album', 'PicTbl');
        //case 1: album id correct
        $fileInfo = array(
            '/home/mytcom_catv/parsonaltool/storage/00001/385cd85a14bb90c754897fd0366ff266/album/0000000001',
            'png',
            'Picture XYZ.png',
            1000,
            'Picture XYZ'
        );
        $data = array(
            1,
            'Pic Comment'
        );

        $flag = true;
        try {
            $this->component->insertPicData(999, $this->testUserSeq, $fileInfo, $data, $base = '00001/');
        } catch (\Exception $e) {
            $flag = false;
        }
        $this->assertTrue($flag);

        //case 2: album id wrong
        $this->loadFixtures('Album', 'PicTbl');
        //case 1: album id correct
        $fileInfo = array(
            '/home/mytcom_catv/parsonaltool/storage/00001/385cd85a14bb90c754897fd0366ff266/album/0000000009',
            'png',
            'Picture XYZ.png',
            1000,
            'Picture XYZ'
        );
        $data = array(
            0,
            'Pic Comment'
        );
        $this->component->insertPicData(9, $this->testUserSeq, $fileInfo, $data, $base = '00001/');
        $flag = true;
        $picTbl = TableRegistry::get('PicTbl');
        $result = $picTbl->getSinglePicData($this->testUserSeq, 9);
        if (empty($result)) {
            $flag = false;
        }
        $this->assertFalse($flag);
    }

    /**
     * Test updatePicData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updatePicData()
    {
        $this->loadFixtures('PicTbl');
        //case 1:
        $expected = [
            'pic_id' => 1,
            'album_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'pic_name' => 'Picture Title.jpg',
            'name' => 'Picture Title',
            'extension' => 'jpg',
            'amount' => 1,
            'base' => '00001/',
            'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
            'pic_comment' => 'Picture custom comment',
            'up_date' => date('Y-m-d'),
            'reg_date' => '2016-09-13'
        ];
        $this->component->updatePicData($this->testUserSeq, 1, 'Picture Title', 'Picture custom comment');
        $picTbl = TableRegistry::get('PicTbl');
        $result = $picTbl->getSinglePicData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);
    }

    /**
     * Test deletePicData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deletePicData()
    {
        $this->loadFixtures('PicTbl', 'UserMst');
        //case 1
        $this->component->deletePicData($this->testUserSeq, [1, 3]);
        $flag = false;
        $picTbl = TableRegistry::get('PicTbl');
        $result1 = $picTbl->getSinglePicData($this->testUserSeq, 3);
        if (empty($result1) && empty($result1)) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test getPicExtension method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getPicExtension()
    {
        //case type = 1
        $result = $this->component->getPicExtension(1);
        $this->assertEquals('gif', $result);

        //case type = 2
        $result = $this->component->getPicExtension(2);
        $this->assertEquals('jpeg', $result);

        //case type = 3
        $result = $this->component->getPicExtension(3);
        $this->assertEquals('png', $result);

        //case type not found
        $result = $this->component->getPicExtension(4);
        $this->assertEquals('png', $result);
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
            'name' => '',
            'pic_comment' => 'Pic comment'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name']['_empty'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 2: name over 125 characters
        $name = '';
        for ($i = 0; $i <= 126; $i++) {
            $name .= 'a';
        }
        $data = [
            'name' => $name,
            'pic_comment' => 'フォルダコメント'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 3: comment over 1000 characters
        $data = [
            'name' => 'ファイル名1番',
            'pic_comment' => 'フォルダコメント Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['pic_comment']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test getSingleAlbumInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getSingleAlbumInfo()
    {
        $this->loadFixtures('PicTbl', 'Album', 'OpenStatus', 'BlogPic', 'Weblog');
        //normal case
        $expected = array(
            'LoopStart' => 1,
            'open_status' => 1,
            'slide' => array(
                0 => array(
                    'pic_id' => 2,
                    'album_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'pic_name' => 'Picture 2.png',
                    'name' => 'Picture 2',
                    'extension' => 'png',
                    'amount' => 2,
                    'base' => '00001/',
                    'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000002',
                    'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'album_name' => 'Album 1',
                    'open_status' => 1),
                1 => array(
                    'pic_id' => 1,
                    'album_id' => 1,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'pic_name' => 'Picture 1.jpg',
                    'name' => 'Picture 1',
                    'extension' => 'jpg',
                    'amount' => 1,
                    'base' => '00001/',
                    'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000001',
                    'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'album_name' => 'Album 1',
                    'open_status' => 1),
            ),
            'modify' => array(
                1 => array(
                    0 => array (
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'log_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'weblog_wather' => 1,
                    'weblog_title' => 'Lorem ipsum dolor sit amet',
                    'weblog_body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'weblog_url1' => 'Lorem ipsum dolor sit amet',
                    'weblog_url2' => 'Lorem ipsum dolor sit amet',
                    'weblog_url3' => 'Lorem ipsum dolor sit amet',
                    'up_date' => $this->makeFTimeObj('2016-09-13 07:52:23', 'Asia/Tokyo'),
                    'reg_date' => $this->makeFTimeObj('2016-09-13 07:52:23', 'Asia/Tokyo'),
                    'weblog_id' => 1),
                )
            ),
            'list' => array(
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 1',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC')),
        );
        $result = $this->component->getSingleAlbumInfo($this->testUserSeq, 1, 1, 'DESC');
        $this->assertEquals($expected, $result);

        //full case
        $expected = array(
            'LoopStart' => 1,
            'open_status' => 1,
            'slide' => array(
                0 => array(
                    'pic_id' => 4,
                    'album_id' => 2,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'pic_name' => 'Picture 4.gif',
                    'name' => 'Picture 4',
                    'extension' => 'gif',
                    'amount' => 3,
                    'base' => '00001/',
                    'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000004',
                    'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'album_name' => 'Album 2',
                    'open_status' => 0),
                1 => array(
                    'pic_id' => 3,
                    'album_id' => 2,
                    'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                    'pic_name' => 'Picture 3.gif',
                    'name' => 'Picture 3',
                    'extension' => 'gif',
                    'amount' => 3,
                    'base' => '00001/',
                    'pic_url' => '/home/personaltool2/tests/TestCase/pic/0000000003',
                    'pic_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                    'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                    'album_name' => 'Album 2',
                    'open_status' => 1),
            ),
            'modify' => array(),
            'list' => array(
                'album_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 2',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => $this->makeTimeObj('2016-09-13', 'UTC'),
                'reg_date' => $this->makeTimeObj('2016-09-13', 'UTC')),
        );
        $result = $this->component->getSingleAlbumInfo($this->testUserSeq, 3, 2, 'DESC');
        $this->assertEquals($expected, $result);
    }

    /**
     * Test displayImage method
     * @codeCoverageIgnore
     * @runInSeparateProcess
     * @test
     *
     * @return void
     */
    public function displayImage()
    {
        // => for png
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000024';
        $imgType = '';
        $result = true;
        try {
            $this->component->displayImage($picUrl, $imgType);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // => for jpg
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000025';
        $imgType = '';
        $result = true;
        try {
            $this->component->displayImage($picUrl, $imgType);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // => for gif
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000026';
        $imgType = '';
        $result = true;
        try {
            $this->component->displayImage($picUrl, $imgType);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test makeAndDisplayIphoneThumbnail method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function makeAndDisplayIphoneThumbnail()
    {
        // case 1
        $result = true;
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000025';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 200, 200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000025';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 1200, 1200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000026';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 1200, 1200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 4
        $result = true;
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000027';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 1200, 1200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 5
        $result = true;
        $picUrl = 'C:\home\personaltool2\tests\TestCase\pic\0000000027';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 1200, 1200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 6
        $result = true;
        $picUrl = 'C:\Users\Public\Pictures\Sample Pictures\a12.jpg';
        try {
            $this->component->makeAndDisplayIphoneThumbnail($picUrl, 1200, 1200);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test makeAndDisplayIphoneThumbnail method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function unlinkPicture()
    {
        $result = true;
        try {
            $this->invokeMethod($this->component, 'unlinkPicture', ['C:\home\personaltool2\storage\pics\'']);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
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
