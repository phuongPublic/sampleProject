<?php

namespace App\Test\TestCase\Controller;

use Cake\Controller\ComponentRegistry;
use App\Controller\Component\CommonComponent;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\CommonComponent Test Case
 */
class CommonComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = ['app.OpenStatus', 'app.FileFolderTbl', 'app.FileTbl', 'app.TargetUser', 'app.PicTbl', 'app.MovieContents'];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new CommonComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test readTargetFileContents method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function readTargetFileContents()
    {
        $file = '/home/personaltool2/tests/TestData/readme.txt';
        $result = $this->component->readTargetFileContents($file);
        $this->assertEquals('aaa', $result);
    }

    /**
     * Test urlRandString method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function urlRandString()
    {
        $result = $this->component->urlRandString();
        $this->assertEquals(34, mb_strlen($result, 'UTF-8'));
    }

    /**
     * Test deleteOpenDataInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteOpenDataInfo()
    {
        $this->loadFixtures('OpenStatus');
        $result = true;
        try {
            $dataInput = array('target_id' => array(1),
                'target_user_seq' => array(9),
                'open_id' => 'open_id1',
                'fid' => 2,
                'ffid' => 'all',
                'delete' => '終了する');
            $this->component->deleteOpenDataInfo($this->testUserSeq, $dataInput);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test sendToInviteEmail method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function sendToInviteEmail()
    {
        // case test for album
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => 3,
                        'message' => 'unittest phase',
                        'mail' => array ('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'target_id' => 1,
                        'userAddress' => 'test@mytcom.t-com.ne.jp',
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'template' => 'album_user_mail'
                    );
        $result = $this->component->sendToInviteEmail($dataPost, 10, $this->testUserSeq, 1);
        $this->assertTrue($result);

        // case test for file
        $dataPost = array (
                        'nickname' => 'Test',
                        'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
                        'close_date' => 3,
                        'message' => 'Accddf',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'target_id' => 1,
                        'pen_type' => 1,
                        'open_commit' => '送信する',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'selected' => array(1),
                        'template' => 'file_user_mail'
                    );
        $result = $this->component->sendToInviteEmail($dataPost, 10, $this->testUserSeq, 2);
        $this->assertTrue($result);

        // case test for picture
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => 3,
                        'message' => 'unittest phase',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'userAddress' => 'test@mytcom.t-com.ne.jp',
                        'target_id' => 1,
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'pic_open' => array(1),
                        'template' => 'album_user_mail'
                    );
        $result = $this->component->sendToInviteEmail($dataPost, 10, $this->testUserSeq, 3);
        $this->assertTrue($result);

        // case test for picture
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => 3,
                        'message' => 'unittest phase',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'userAddress' => 'test@mytcom.t-com.ne.jp',
                        'target_id' => 1,
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'pic_open' => array(1),
                        'template' => 'movie_user_mail'
                    );
        $result = $this->component->sendToInviteEmail($dataPost, 10, $this->testUserSeq, 4);
        $this->assertTrue($result);

        // case test for picture
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => 3,
                        'message' => 'unittest phase',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'userAddress' => 'test@mytcom.t-com.ne.jp',
                        'target_id' => 1,
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'pic_open' => array(1),
                        'template' => 'movie_user_mail'
                    );
        $result = $this->component->sendToInviteEmail($dataPost, 10, $this->testUserSeq, 5);
        $this->assertTrue($result);
    }

    /**
     * Test validate method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validate()
    {
        // case nickname null
        $data['nickname'] = '  ';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp';
        $expected = array('nickname' => array('noValue' => 'ニックネームを入力してください｡', 'noSpaces' => '半角スペースのみの登録はできません。'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // case nickname max length
        $data['nickname'] = '123456789012345678901234567';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp';
        $expected = array('nickname' => array('maxLength' => 'ニックネームを25文字以内で入力してください｡'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // case message null
        $data['nickname'] = 'test';
        $data['message'] = '  ';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp';
        $expected = array('message' => array('noValue' => 'メッセージが入力されていません｡', 'noSpaces' => '半角スペースのみの登録はできません。'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // case message max length
        $data['nickname'] = 'test';
        $data['message'] = '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp';
        $expected = array('message' => array('maxLength' => 'メッセージには125文字以内で入力してください。'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // case mail = 0
        $data['nickname'] = 'test';
        $data['message'] = 'test';
        $data['mail'] = '';
        $expected = array('mail' => array('noValue' => 'メールアドレスを入力してください｡'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // case mail > 10
        $data['nickname'] = 'test';
        $data['message'] = 'test';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp';
        $expected = array('mail' => array('maxNumber' => '追加できるアドレスは10件までです。'));
        $result = $this->component->validate($data);
        $this->assertEquals($expected, $result);

        // full case
        $data['nickname'] = 'test';
        $data['message'] = 'test';
        $data['mail'] = 'kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp,kikaku@mytcom.t-com.ne.jp';
        $result = $this->component->validate($data);
        $this->assertTrue($result);
    }

    /**
     * Test checkFileExists method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkFileExists()
    {
        // case 1
        $file = '/home/personaltool2/tests/TestData/ThumbnailGeneratorTaskTest/0000000002';
        $result = $this->component->checkFileExists($file);
        $this->assertTrue($result);
        // case 2
        $file = '/home/personaltool2/tests/TestData/readmex.txt';
        $result = $this->component->checkFileExists($file, 123);
        $this->assertFalse($result);
    }

    /**
     * Test removeDataFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function removeDataFile()
    {
        // must exist file home\personaltool2\tests\TestData\ThumbnailGeneratorTaskTest\0000000001
        // case 1
        $data = array(array('file_uri' => '/home/personaltool2/tests/TestData/ThumbnailGeneratorTaskTest/0000000001'));
        $result = true;
        try {
            $this->component->removeDataFile($data, 1);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // must exist file home\personaltool2\tests\TestData\ThumbnailGeneratorTaskTest\dstImageName
        // case 2
        $data = array(array('pic_url' => '/home/personaltool2/tests/TestData/ThumbnailGeneratorTaskTest/dstImageName'));
        $result = true;
        try {
            $this->component->removeDataFile($data, 2);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // must exist file home\personaltool2\tests\TestData\ThumbnailGeneratorTaskTest\srcImageName
        // case 3
        $data = array(array('movie_contents_url' => '/home/personaltool2/tests/TestData/ThumbnailGeneratorTaskTest/srcImageName'));
        $result = true;
        try {
            $this->component->removeDataFile($data, 3);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test deleteOpenStatusData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteOpenStatusData()
    {
        $this->loadFixtures('OpenStatus');
        // case 1
        $dataList = array (
            array (
                'file_folder_id' => 4,
                'file_id' => 6,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
            array (
                'file_folder_id' => 4,
                'file_id' => 7,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
        );
        $expected = array (6,7);
        $result = $this->component->deleteOpenStatusData($this->testUserSeq, $dataList, 2);
        $this->assertEquals($expected, $result);

        // case 2
        $dataList = array (
            array (
                'file_folder_id' => 4,
                'album_id' => 6,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
            array (
                'file_folder_id' => 4,
                'album_id' => 7,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
        );
        $this->loadFixtures('OpenStatus');
        $expected = array (6,7);
        $result = $this->component->deleteOpenStatusData($this->testUserSeq, $dataList, 1);
        $this->assertEquals($expected, $result);

        // case 3
        $dataList = array (
            array (
                'file_folder_id' => 4,
                'pic_id' => 6,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
            array (
                'file_folder_id' => 4,
                'pic_id' => 7,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
        );
        $this->loadFixtures('OpenStatus');
        $expected = array (6,7);
        $result = $this->component->deleteOpenStatusData($this->testUserSeq, $dataList, 3);
        $this->assertEquals($expected, $result);

        // case 4
        $dataList = array (
            array (
                'movie_folder_id' => 4,
                'movie_contents_id' => 6,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
            array (
                'movie_folder_id' => 4,
                'movie_contents_id' => 7,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
        );
        $expected = array (4,4);
        $result = $this->component->deleteOpenStatusData($this->testUserSeq, $dataList, 4);
        $this->assertEquals($expected, $result);

        // case 5
        $dataList = array (
            array (
                'movie_folder_id' => 4,
                'movie_contents_id' => 6,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
            array (
                'movie_folder_id' => 4,
                'movie_contents_id' => 7,
                'file_name' => 'package.xml',
                'name' => 'package',
                'extension' => 'xml',
                'amount' => 416908,
                'user_seq' => '385cd85a14bb90c754897fd0366ff266'
            ),
        );
        $this->loadFixtures('OpenStatus');
        $expected = array (6,7);
        $result = $this->component->deleteOpenStatusData($this->testUserSeq, $dataList, 5);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test insertOpenData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function insertOpenData()
    {
        $this->loadFixtures('OpenStatus');

        // case test for album
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => '3',
                        'message' => 'Alo ma',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'target_id' => 1,
                        'userAddress' => 'abchgdf@mytcom.t-com.ne.jp',
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'template' =>'movie_user_mail'
                    );
        $result = $this->component->insertOpenData($this->testUserSeq, 1, $dataPost);
        $this->assertTrue($result);

        // case test for file
        $dataPost = array (
                        'nickname' => 'Test',
                        'userAddress' => 'kikakukaihatu23@tbz.t-com.ne.jp',
                        'close_date' => 3,
                        'message' => 'Accddf',
                        'mail' => ['abc@mytcom.t-com.ne.jp'],
                        'access_check' => 0,
                        'target_id' => '',
                        'open_type' => 1,
                        'open_commit' => '送信する',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'selected' => array(1),
                        'template' =>'movie_user_mail'
                    );
        $result = $this->component->insertOpenData($this->testUserSeq, 2, $dataPost);
        $this->assertTrue($result);

        // case test for picture
        $dataPost = array(
                        'nickname' => 'Test123',
                        'close_date' => '3',
                        'message' => 'Alo ma',
                        'mail' => array('abc@mytcom.t-com.ne.jp'),
                        'access_check' => 0,
                        'userAddress' => 'abchgdf@mytcom.t-com.ne.jp',
                        'target_id' => 1,
                        'open_type' => 1,
                        'open_reg' => '確認画面へ進む',
                        'open_flg' => 1,
                        'album_id' => 1,
                        'pic_open' => [1],
                        'template' =>'movie_user_mail'
                    );
        $result = $this->component->insertOpenData($this->testUserSeq, 3, $dataPost);
        $this->assertTrue($result);

        // case test movies folder
        $dataPost = array(
            'nickname' => 'Test123',
            'close_date' => '3',
            'message' => 'Alo ma',
            'mail' => array('abc@mytcom.t-com.ne.jp'),
            'access_check' => 0,
            'userAddress' => 'abchgdf@mytcom.t-com.ne.jp',
            'target_id' => 1,
            'open_type' => 1,
            'open_reg' => '確認画面へ進む',
            'open_flg' => 1,
            'album_id' => 1,
            'pic_open' => [1],
            'template' =>'file_user_email',
            'movie_folder_id' => 1
        );
        $result = $this->component->insertOpenData($this->testUserSeq, 4, $dataPost);
        $this->assertTrue($result);

        // case test movies
        $dataPost = array(
            'nickname' => 'Test123',
            'close_date' => '3',
            'message' => 'Alo ma',
            'mail' => array('abc@mytcom.t-com.ne.jp'),
            'access_check' => 0,
            'userAddress' => 'abchgdf@mytcom.t-com.ne.jp',
            'target_id' => 1,
            'open_type' => 1,
            'open_reg' => '確認画面へ進む',
            'open_flg' => 1,
            'album_id' => 1,
            'mfile_open' => [1],
            'template' =>'file_user_email',
            'movie_folder_id' => 1
        );
        $result = $this->component->insertOpenData($this->testUserSeq, 5, $dataPost);
        $this->assertTrue($result);
    }

    /**
     * Test deleteTargetUserData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteTargetUserData()
    {
        $this->loadFixtures('OpenStatus', 'TargetUser');
        // case 1
        $result = true;
        try {
            $this->component->deleteTargetUserData($this->testUserSeq, [1,2], 1);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        try {
            $this->component->deleteTargetUserData($this->testUserSeq, [1,2], 2);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        try {
            $this->component->deleteTargetUserData($this->testUserSeq, [1,2], 2);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test checkMailData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkMailData()
    {
        // case 1
        $mailArray = array('abcd123@mytcom.t-com.ne.jp', 'duma123@mytcom.t-com.ne.jp', 'lukaku', 'funny.dm');
        $result = $this->component->checkMailData($mailArray);
        $this->assertFalse($result);

        // case 2
        $mailArray = array('abcd123@mytcom.t-com.ne.jp');
        $result = $this->component->checkMailData($mailArray);
        $this->assertTrue($result);

        //case 3:
        $mailArray = array('sf/ff<>@mytcom.t-com.ne.jp');
        $result = $this->component->checkMailData($mailArray);
        $this->assertFalse($result);

        //case 4
        $mailArray = array('<ass@gmail.com>');
        $result = $this->component->checkMailData($mailArray);
        $this->assertTrue($result);
    }

    /**
     * Test encodeFileName method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function encodeFileName()
    {
        // case 1
        $file = 'test';
        $result = $this->component->encodeFileName($file);
        $this->assertEquals('test', $result);

        // case 2
        $file = 'ニックネーム';
        $result = $this->component->encodeFileName($file);
        $this->assertEquals('ニックネーム', $result);
    }

    /**
     * Test isIE method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function isIE()
    {
        // case IE 9.0
        $userAgent = 'Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))';
        $result = $this->component->isIE($userAgent);
        $this->assertTrue($result);

        // case IE 11.0
        $userAgent = 'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
        $result = $this->component->isIE($userAgent);
        $this->assertTrue($result);

        // case Edge 12.246
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246';
        $result = $this->component->isIE($userAgent);
        $this->assertFalse($result);

        // case ChromePlus 1.6.3.1
        $userAgent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30 ChromePlus/1.6.3.1';
        $result = $this->component->isIE($userAgent);
        $this->assertFalse($result);
    }

    /**
     * Test getFileSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFileSize()
    {
        $this->loadFixtures('FileTbl');
        $result = $this->component->getFileSize($this->testUserSeq);
        $this->assertEquals(105, $result);
    }

    /**
     * Test getPicSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getPicSize()
    {
        $this->loadFixtures('PicTbl');
        $result = $this->component->getPicSize($this->testUserSeq);
        $this->assertEquals(129, $result);
    }

    /**
     * Test getMovieSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getMovieSize()
    {
        $this->loadFixtures('MovieContents');
        $result = $this->component->getMovieSize($this->testUserSeq);
        $this->assertEquals(294, $result);
    }

    /**
     * Test getUsedSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getUsedSize()
    {
        $this->loadFixtures('FileTbl');
        $this->loadFixtures('PicTbl');
        $this->loadFixtures('MovieContents');
        $result = $this->component->getUsedSize($this->testUserSeq);
        $this->assertEquals(528, $result);
    }

    /**
     * Test getFolderStorageInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFolderStorageInfo()
    {
        //case 1:
        $this->loadFixtures('OpenStatus', 'FileFolderTbl', 'FileTbl');
        $expected = array(
                        array('file_folder_id' => 1,
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'file_folder_name' => 'フォルダ名1番',
                            'comment' => 'フォルダコメント1番',
                            'up_date' => '2016-09-13',
                            'reg_date' => '2016-09-13',
                            'openstatus' => 1,
                            'count' => 2,
                            'amount' => 3.0
                        )
                    );
        $result = $this->component->getFolderStorageInfo($this->testUserSeq, [1], 'new');
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result);

        //case 2:
        $result = $this->component->getFolderStorageInfo($this->testUserSeq, [1], 'old');
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result);

        //case 3
        $expected = array( array (
                            'file_folder_id' => 1,
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'file_folder_name' => 'フォルダ名1番',
                            'comment' => "フォルダコメント1番",
                            'up_date' => '2016-09-13',
                            'reg_date' => '2016-09-13',
                            'openstatus' => 1,
                            'count' => 2,
                            'amount' => 3
                        ), array (
                            'file_folder_id' => 2,
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'file_folder_name' => 'フォルダ名2番',
                            'comment' => 'フォルダコメント2番',
                            'up_date' => '2016-10-13',
                            'reg_date' =>'2016-10-13',
                            'openstatus' => 0,
                            'count' => 1,
                            'amount' => 3.0
                        ), array (
                            'file_folder_id' => 3,
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'file_folder_name' => 'フォルダ名3番',
                            'comment' => 'フォルダコメント3番',
                            'up_date' => '2016-10-13',
                            'reg_date' => '2016-10-13',
                            'openstatus' => 0,
                            'count' => 0,
                            'amount' => 0
                        )
                    );
        $result = $this->component->getFolderStorageInfo($this->testUserSeq, null, 'old');
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $result[1]['up_date'] = $result[1]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[1]['reg_date'] = $result[1]['reg_date']->i18nFormat('YYYY-MM-dd');
        $result[2]['up_date'] = $result[2]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[2]['reg_date'] = $result[2]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result);
    }

    /**
     * Test getPageNum method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getPageNum()
    {
        // case 1
        $page_number = '12$3%^A';
        $result = $this->component->getPageNum($page_number);
        $this->assertEquals(null, $result);

        // case 2
        $page_number = '124';
        $result = $this->component->getPageNum($page_number);
        $this->assertEquals(124, $result);

        // case 3
        $page_number = '012';
        $result = $this->component->getPageNum($page_number);
        $this->assertEquals(12, $result);
    }

    /**
     * Test getFolderNameByFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getDeviceType()
    {
        // iOS9.0
        $userAgent = 'Mozilla /5.0 (iPhone; CPU iPhone OS 9_0 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13A344 Safari/601.1';
        $result = $this->component->getDeviceType($userAgent);
        $this->assertEquals(2, $result);

        // Android6.0
        $userAgent = 'Mozilla/5.0 (Linux; Android 6.0.1; 404SC Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Mobile Safari/537.36';
        $result = $this->component->getDeviceType($userAgent);
        $this->assertEquals(3, $result);

        // IE10
        $userAgent = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)';
        $result = $this->component->getDeviceType($userAgent);
        $this->assertEquals(1, $result);
    }

    /**
     * Test setEndDateDisplay method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function setEndDateDisplay()
    {
        // case 1
        $expected = '2016年12月12日(月) 23時59分';
        $result = $this->component->setEndDateDisplay('2016-12-12 23:59:59', 1);
        $this->assertEquals($expected, $result);

        // case 2
        $expected = date("Y-m-d 23:59:59", strtotime("+1 month"));
        $expected = $this->component->setEndDateDisplay($expected, 1);
        $result = $this->component->setEndDateDisplay(1);
        $this->assertEquals($expected, $result);

        // case 3
        $result = $this->component->setEndDateDisplay(4);
        $this->assertEquals('無期限', $result);

        // case 4
        //$expected = today (the day when running unittest)
        $expected = 'string';
        $result = $this->component->setEndDateDisplay(3, null, 'sub');
        $this->assertInternalType($expected, $result);
    }

    /**
     * Test getStrlenNoNewline method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getStrlenNoNewline()
    {
        // case 1
        $file = 'test';
        $result = $this->component->getStrlenNoNewline($file);
        $this->assertEquals(4, $result);
    }

    /**
     * Test fixFormatId method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function fixFormatId()
    {
        // case 1
        $file = 1;
        $result = $this->component->fixFormatId($file);
        $this->assertEquals('0000000001', $result);
    }

    /**
     * Test umaskMkdir method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function umaskMkdir()
    {
        // case 1
        $file = '/home/personaltool2/tests/TestData/MakeColor';
        $result = $this->component->umaskMkdir($file, '0777');
        $this->assertNull($result);
    }

    /**
     * Test setEndDateOpen method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function setEndDateOpen()
    {
        // case 1 if date now = 12/05/2016
        $expected = date("Y-m-d 23:59:59", strtotime("+1 month"));
        $result = $this->component->setEndDateOpen(1);
        $this->assertEquals($expected, $result);

        // case 2 if date now = 12/05/2016
        $expected = date("Y-m-d 23:59:59", strtotime("+2 week"));
        $result = $this->component->setEndDateOpen(2);
        $this->assertEquals($expected, $result);

        // case 3 if date now = 12/05/2016
        $expected = date("Y-m-d 23:59:59", strtotime("+1 week"));
        $result = $this->component->setEndDateOpen(3);
        $this->assertEquals($expected, $result);

        // case 4 if date now = 12/05/2016
        $expected = '2037-12-31 23:59:59';
        $result = $this->component->setEndDateOpen(4);
        $this->assertEquals($expected, $result);
    }
    /**
     * Test getPreviousUrl method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getPreviousUrl()
    {
        $this->assertEmpty($this->component->getPreviousUrl());
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }
}
