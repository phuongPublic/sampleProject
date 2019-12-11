<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\AlbumComponent;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\AlbumComponent Test Case
 */
class AlbumComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.Album',
        'app.OpenStatus',
        'app.PicTbl',
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new AlbumComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getAlbumInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getAlbumInfo(){
        $this->loadFixtures('Album', 'OpenStatus', 'PicTbl');
        $expected = [
            [
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 1',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 2,
                'amount' => 3.0,
                'openstatus' => 1,
            ],
            [
                'album_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 2',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 2,
                'amount' => 6.0,
                'openstatus' => 1,
            ],
            [
                'album_id' => 3,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 3',
                'album_comment' => '',
                'album_pic_count' => 0,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 0,
                'amount' => 0,
                'openstatus' => 0,
            ],
        ];
        $result = $this->component->getAlbumInfo($this->testUserSeq, 'old');
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
                'album_id' => 3,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 3',
                'album_comment' => '',
                'album_pic_count' => 0,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 0,
                'amount' => 0,
                'openstatus' => 0,
            ],
            [
                'album_id' => 2,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 2',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 2,
                'amount' => 6.0,
                'openstatus' => 1,
            ],
            [
                'album_id' => 1,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'album_name' => 'Album 1',
                'album_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'album_pic_count' => 1,
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'count' => 2,
                'amount' => 3.0,
                'openstatus' => 1,
            ],
        ];
        $result = $this->component->getAlbumInfo($this->testUserSeq, 'new');
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * Test getAlbumCapacity method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getAlbumCapacity()
    {
        //case 1: exists pictures in album
        $this->loadFixtures('Album', 'PicTbl');
        $expected = 3;
        $result = $this->component->getAlbumCapacity($this->testUserSeq, 1);
        $this->assertEquals($expected, $result);
        //case 2: no pictures in album
        //case 1: exists pictures in album
        $this->loadFixtures('Album', 'PicTbl');
        $expected = 0;
        $result = $this->component->getAlbumCapacity($this->testUserSeq, 3);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test deleteAlbumData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteAlbumData()
    {
        //case 1: album is public
        $this->loadFixtures('Album', 'OpenStatus', 'PicTbl');
        $this->component->deleteAlbumData($this->testUserSeq, 1);
        $flag = false;
        $albumTbl = TableRegistry::get('Album');
        $album = $albumTbl->getSingleAlbumData($this->testUserSeq, 1);
        $picTbl = TableRegistry::get('PicTbl');
        $pics = $picTbl->getPictureInfo($this->testUserSeq, 1);
        if (empty($album) && empty($pics)) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 2: album has picture which is public
        $this->loadFixtures('Album', 'OpenStatus', 'PicTbl');
        $this->component->deleteAlbumData($this->testUserSeq, 2);
        $flag = false;
        $albumTbl = TableRegistry::get('Album');
        $album = $albumTbl->getSingleAlbumData($this->testUserSeq, 2);
        $picTbl = TableRegistry::get('PicTbl');
        $pics = $picTbl->getPictureInfo($this->testUserSeq, 2);
        if (empty($album) && empty($pics)) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 3: album has picture which is public
        $this->loadFixtures('Album', 'OpenStatus', 'PicTbl');
        $this->component->deleteAlbumData($this->testUserSeq, 2);
        $flag = false;
        $albumTbl = TableRegistry::get('Album');
        $album = $albumTbl->getSingleAlbumData($this->testUserSeq, 2000);
        $picTbl = TableRegistry::get('PicTbl');
        $pics = $picTbl->getPictureInfo($this->testUserSeq, 2000);
        if (empty($album) && empty($pics)) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test insertAlbumData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function insertAlbumData()
    {
        $this->loadFixtures('Album');
        $this->component->insertAlbumData($this->testUserSeq, 'Album 4', 'Comment album 4');
        $expected = [
            'album_id' => 4,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'album_name' => 'Album 4',
            'album_comment' => 'Comment album 4',
            'album_pic_count' => 0,
            'up_date' => date('Y-m-d'),
            'reg_date' => date('Y-m-d')
        ];
        $albumTbl = TableRegistry::get('Album');
        $result = $albumTbl->getSingleAlbumData($this->testUserSeq, 4);
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result[0]);

        // case NG
        $result = $this->component->insertAlbumData(null, 'Album 4', 'Comment album 4');
        $this->assertFalse($result);
    }

    /**
     * Test updateAlbumData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function updateAlbumData()
    {
        $this->loadFixtures('Album');
        $expected = [
            'album_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'album_name' => 'Album Edited',
            'album_comment' => 'Album Comment',
            'album_pic_count' => 1,
            'up_date' => date('Y-m-d'),
            'reg_date' => '2016-09-13'
        ];
        $this->component->updateAlbumData(1, $this->testUserSeq, 'Album Edited', 'Album Comment');
        $albumTbl = TableRegistry::get('Album');
        $result = $albumTbl->getSingleAlbumData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        // NG case
        $this->assertFalse($this->component->updateAlbumData(1000, $this->testUserSeq, 'Album Edited', 'Album Comment'));

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
            'album_name' => '',
            'album_comment' => 'Pic comment'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['album_name']['_empty'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 2: name over 125 characters
        $data = [
            'album_name' => 'album name lorem islsum hello every one',
            'album_comment' => 'フォルダコメント'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['album_name']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 3: comment over 1000 characters
        $data = [
            'album_name' => 'ファイル名1番',
            'album_comment' => 'フォルダコメント Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['album_comment']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }
}