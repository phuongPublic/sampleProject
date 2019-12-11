<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\FileUploadComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\FileUploadComponentTest Test Case
 */
class FileUploadComponentTest extends NoptComponentIntegrationTestCase
{
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.OpenStatus',
        'app.UserMst'
    ];

    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new FileUploadComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test setUpload method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function setUpload()
    {
        // case 1
        $result = true;
        try {
            $this->component->setUpload('file', array('Upload' => 'abcd/3asds'), array('base' => 00001));
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        try {
            $this->component->setUpload('album', array('Upload' => 'abcd/3asds'), array('base' => 00001));
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        try {
            $this->component->setUpload('movie', array('BaseMovie' => 'basemovie/3asds', 'Upload' => 'upload/3asds'), array('base' => 00001));
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

    }

    /**
     * Test UploadSingleFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function UploadSingleFile()
    {
         // case 1
        $user_data = array('user_seq' => $this->testUserSeq, 'base' => '00001');
        $file_tmp = array('tmp_name' => '/home/personaltool2/storage/00001/385cd85a14bb90c754897fd0366ff266/file/a.txt');
        $file_id = 10;
        $result = true;
        try {
            $this->component->setUpload('file', array('Upload' => '/home/personaltool2/storage/'), array('base' => '00001/'));
            $this->component->UploadSingleFile($user_data, $file_tmp, $file_id);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $user_data = array('user_seq' => '54hshdas121bs121233', 'base' => '00001');
        $file_tmp = array('tmp_name' => '/home/personaltool2/storage/00001/385cd85a14bb90c754897fd0366ff266/file/b.txt');
        $file_id = 10;
        $result = true;
        try {
            $this->component->setUpload('file', array('Upload' => '/home/personaltool2/storage/'), array('base' => '00001/'));
            $this->component->UploadSingleFile($user_data, $file_tmp, $file_id);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $user_data = array('user_seq' => $this->testUserSeq, 'base' => '00001');
        $file_tmp = array('tmp_name' => '');
        $file_id = 10;
        $result = true;
        try {
            $this->component->setUpload('file', array('Upload' => '/home/personaltool2/storage/'), array('base' => '00001/'));
            $this->component->UploadSingleFile($user_data, $file_tmp, $file_id);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case 4
        $user_data = array('user_seq' => $this->testUserSeq, 'base' => '000013');
        $file_tmp = array('tmp_name' => '/home/personaltool2/storage/00001/385cd85a14bb90c754897fd0366ff266/file/c.txt');
        $file_id = 10;
        $result = true;
        try {
            $this->component->UploadSingleFile($user_data, $file_tmp, $file_id);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    /**
     * Test DeleteUploadFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function DeleteUploadFile()
    {
        $name = '0000000001';
        $this->component->setUpload('file', array('Upload' => '/home/personaltool2/storage/'), array('base' => '00001/'));
        $result = $this->component->DeleteUploadFile($this->testUserSeq, $name);
        $this->assertEquals('/home/personaltool2/storage/00001/385cd85a14bb90c754897fd0366ff266/file/0000000001', $result);
    }

    /**
     * Test checkFileInput method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkFileInput()
    {
        // case 1
        $data = array('tmp_name' => 'tmp/abch');
        $result = $this->component->checkFileInput($data);
        $this->assertTrue($result);

        // case 2
        $data = array();
        $result = $this->component->checkFileInput($data);
        $this->assertFalse($result);
    }

    /**
     * Test checkFileSize method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkFileSize()
    {
        // case 1
        $fileSize = array('size' => 100);
        $confUpload = array('UploadMax' => 90, 'max_movie' => 30000);
        $result = $this->component->checkFileSize($fileSize, $confUpload, 'album');
        $this->assertFalse($result);

        // case 2
        $fileSize = array('size' => 80);
        $confUpload = array('UploadMax' => 90, 'max_movie' => 30000);
        $result = $this->component->checkFileSize($fileSize, $confUpload, 'album');
        $this->assertTrue($result);

        // case 3
        $fileSize = array('size' => 30002);
        $confUpload = array('UploadMaxMovie' => 90, 'max_movie' => 30000);
        $result = $this->component->checkFileSize($fileSize, $confUpload, 'movie');
        $this->assertFalse($result);

        // case 4
        $fileSize = array('size' => 20002);
        $confUpload = array('UploadMaxMovie' => 90000, 'max_movie' => 30000);
        $result = $this->component->checkFileSize($fileSize, $confUpload, 'movie');
        $this->assertTrue($result);
    }

    /**
     * Test checkFileType method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkFileType()
    {
        // album: OK
        $data = array(['type' => 'image/gif'], ['type' => 'image/jpeg'], ['type' => 'image/png'], ['type' => 'image/pjpeg'], ['type' => 'image/x-png']);
        foreach ($data as $item) {
            $result = $this->component->checkFileType($item, 'album');
            $this->assertTrue($result);
        }

        // album: NG
        $data = array(['type' => 'image/psd'], ['type' => 'file/doc'], ['type' => 'file/csv']);
        foreach ($data as $item) {
            $result = $this->component->checkFileType($item, 'album');
            $this->assertFalse($result);
        }

        // movie: OK
        $data = array(
            ['name' => 'test1.avi'],
            ['name' => 'test1.mov'],
            ['name' => 'test1.wmv'],
            ['name' => 'test1.rm'],
            ['name' => 'test1.3gp'],
            ['name' => 'test1.3g2'],
            ['name' => 'test1.amc'],
            ['name' => 'test1.mp4'],
            ['name' => 'test1.m4v'],
            ['name' => 'test1.flv'],
            ['name' => 'test1.mpg'],
            ['name' => 'test1.mpe'],
            ['name' => 'test1.mpeg'],
            ['name' => 'test1.dat'],
            ['name' => 'test1.vod'],
            ['name' => 'test1.m2v'],
            ['name' => 'test1.m1v'],
            ['name' => 'test1.tp'],
            ['name' => 'test1.ts']
            );
        foreach ($data as $item) {
            $result = $this->component->checkFileType($item, 'movie');
            $this->assertTrue($result);
        }

        // movie: NG
        $data = array(
            ['name' => 'test1.acss'],
            ['name' => 'test1.adf']);
        foreach ($data as $item) {
            $result = $this->component->checkFileType($item, 'movie');
            $this->assertFalse($result);
        }
    }

    /**
     * Test checkSpaceDisk method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function checkSpaceDisk()
    {
        // case NG
        $result = $this->component->checkSpaceDisk(array('size' => 4000), 8000, 6000);
        $this->assertFalse($result);
        // case OK
        $result = $this->component->checkSpaceDisk(array('size' => 1000), 8000, 6000);
        $this->assertTrue($result);
    }

    /**
     * Test _getUploadDir method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function _getUploadDir()
    {
        // case 1
        $this->component->setUpload('file', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('C:/home/personaltool2/storage/', $this->component->_getUploadDir());

        // case 2
        $this->component->setUpload('album', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('C:/home/personaltool2/storage/', $this->component->_getUploadDir());

        // case 3
        $this->component->setUpload('movie', array('Upload' => 'C:/home/personaltool2/storage/', 'BaseMovie' => 'abc/test'), array('base' => '00001/'));
        $this->assertEquals('C:/home/personaltool2/storage/', $this->component->_getUploadDir());
    }

    /**
     * Test _getUploadDir method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function _getBaseDir()
    {
        // case 1
        $this->component->setUpload('file', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('00001/', $this->component->_getBaseDir());

        // case 2
        $this->component->setUpload('album', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('00001/', $this->component->_getBaseDir());

        // case 3
        $this->component->setUpload('movie', array('Upload' => 'C:/home/personaltool2/storage/', 'BaseMovie' => 'abc/test/'), array('base' => '00001/'));
        $this->assertEquals('abc/test/', $this->component->_getBaseDir());
    }


    /**
     * Test _getTargetDir method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function _getTargetDir()
    {
        // case 1
        $this->component->setUpload('file', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('/file/', $this->component->_getTargetDir());

        // case 2
        $this->component->setUpload('album', array('Upload' => 'C:/home/personaltool2/storage/'), array('base' => '00001/'));
        $this->assertEquals('/album/', $this->component->_getTargetDir());

        // case 3
        $this->component->setUpload('movie', array('Upload' => 'C:/home/personaltool2/storage/', 'BaseMovie' => 'abc/test/'), array('base' => '00001/'));
        $this->assertEquals('/movie/', $this->component->_getTargetDir());
    }
}