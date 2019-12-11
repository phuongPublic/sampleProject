<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\FileComponent;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;
use Cake\Validation\Validator;

/**
 * App\Controller\Component\FileComponent Test Case
 */
class FileComponentTest extends NoptComponentIntegrationTestCase
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
        $this->component = new FileComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test getFolderNameByFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFolderNameByFile()
    {
        $this->loadFixtures('FileFolderTbl', 'FileTbl');
        $expected = [
            'file_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'file_folder_name' => 'フォルダ名1番',
            'comment' => 'フォルダコメント1番',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13'
        ];

        // ファイルデータ存在
        $result = $this->component->getFolderNameByFile($this->testUserSeq, 1);
        // クエリビルダで日付を取得した場合、整形が必要
        $result [0] ['up_date'] = $result [0] ['up_date']->i18nFormat('YYYY-MM-dd');
        $result [0] ['reg_date'] = $result [0] ['reg_date']->i18nFormat('YYYY-MM-dd');

        $this->assertEquals($expected, $result [0]);

        // ファイルデータ存在しない TODO FileComponent Correction. if $fileList is null ,return array();
        $result = $this->component->getFolderNameByFile($this->testUserSeq, 9999999);
        $this->assertEquals(array(), $result);
    }

    /**
     * Test getFolderNameByFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getDelFileInfo()
    {
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus');
        $expected = array(
            0 => array(
                'file_folder_id' => 1,
                'file_id' => 1,
                'file_name' => 'ファイル名1番.jpg',
                'name' => 'ファイル名1番',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => 'base1',
                'file_comment' => 'ファイルコメント1番',
                'file_uri' => '/path1',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-09-13 00:00:00',
                'reg_date' => '2016-09-13 00:00:00',
                'openstatus' => 1,
                'folderName' => 'フォルダ名1番'
            ),
            1 => array(
                'file_folder_id' => 1,
                'file_id' => 2,
                'file_name' => 'ファイル名2番.txt',
                'name' => 'ファイル名2番',
                'extension' => 'txt',
                'amount' => 2,
                'base' => 'base2',
                'file_comment' => 'ファイルコメント2番',
                'file_uri' => '/path2',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-10-13 00:00:00',
                'reg_date' => '2016-10-13 00:00:00',
                'openstatus' => 0,
                'folderName' => 'フォルダ名1番'
            )
        );

        // 存在(1:公開情報あり,2:公開情報なし)
        $result = $this->component->getDelFileInfo($this->testUserSeq, array(
            1,
            2
        ));
        foreach ($result as $key => $value) {
            $result [$key] ['up_date'] = $result [$key] ['up_date']->i18nFormat('YYYY-MM-dd HH:mm:ss');
            $result [$key] ['reg_date'] = $result [$key] ['reg_date']->i18nFormat('YYYY-MM-dd HH:mm:ss');
        }
        $this->assertEquals($expected, $result);

        // 存在しない TODO FileComponent Correction. if $fileList is null ,return array();
        $result = $this->component->getDelFileInfo($this->testUserSeq, array(
            9999999
        ));
        $this->assertEquals(array(), $result);
    }

    /**
     * Test deleteFileData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function deleteFileData()
    {
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'UserMst');
         // 存在 TODO 処理自体正常終了していない
        $flag = true;
        try {
            $this->component->deleteFileData($this->testUserSeq, array(1, 2));
        } catch (\Exception $e) {
            $flag = false;
        }

        $this->assertTrue($flag);

        // 削除確認debug
        /*
         * $result = $this->component->getFolderNameByFile ( $this->testUserSeq, 1 );
         * $this->assertEquals ( array (), $result );
         */

        // 存在しない TODO 変更対象件数が0件の場合、どのように対応するか(false返却 or NotFoundException)によってテストメソッドの変更必要
        $flag = true;
        try {
            $this->component->deleteFileData($this->testUserSeq, array(
                9999999
            ));
        } catch (\Exception $e) {
            $flag = false;
        }
        $this->assertTrue($flag);

        // case NG
        $flag = true;
        try {
            $this->component->deleteFileData($this->testUserSeq, array(8));
        } catch (\Exception $e) {
            $flag = false;
        }
        $this->assertTrue($flag);
    }

    /**
     * Test deleteFileData method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function insertFileData()
    {
        $fileInfo = array(
            '/home/mytcom_catv/parsonaltool/storage/00001/385cd85a14bb90c754897fd0366ff266/file/0000000001',
            'zip',
            '試験用データ.zip',
            1000,
            '画面表示名'
        );
        $data = array(
            1,
            'コメント'
        );

        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'UserMst');
        $flag = true;
        try {
            $this->component->insertFileData(999, $this->testUserSeq, $fileInfo, $data, $base = '00001/');
        } catch (\Exception $e) {
            $flag = false;
        }
        $this->assertTrue($flag);

        // PK指定漏れ(実行時例外)
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'UserMst');
        $this->assertFalse($this->component->insertFileData('', $this->testUserSeq, $fileInfo, $data, $base = '00001/'));
    }

    /**
     * Test editFileInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function editFileInfo()
    {
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'UserMst', 'OpenStatus');

        // TODO 関数自体の修正が必要。ファイル名とコメント以外の画面上hiddenパラメータ項目も変更するカタチになっている。
        $data = array(
            'file_folder_id' => 2,
            'name' => 'ファイル名3番 edited',
            'extension' => 'png',
            'file_comment' => 'ファイルコメント3番',
        );

        // 存在 TODO 処理結果を返却するかによって修正が必要
        $flag = true;
        try {
            $this->component->editFileInfo($this->testUserSeq, 3, $data);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $flag = false;
        }
        $this->assertTrue($flag);

        // 変更対象カラム以外が更新されていないか確認
        $flag = true;
        $expected = array(
            'file_folder_id' => 2,
            'file_id' => 3,
            'file_name' => 'ファイル名3番 edited.png',
            'name' => 'ファイル名3番 edited',
            'extension' => 'png',
            'amount' => 3,
            'base' => 'base3',
            'file_comment' => 'ファイルコメント3番',
            'file_uri' => '/path3',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
        );

        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 3);

        $up_date = null; // 更新日付確認用(作成が面倒な場合、save関数を使用している並びにModelのカラム設定が正しくなっていることで作成の必要は不可になる可能性大)
        foreach ($result as $key => $value) {
            $up_date = $result [$key] ['up_date']->i18nFormat('YYYY-MM-dd HH:mm:ss');
            unset($result [$key] ['up_date']);
            unset($result [$key] ['reg_date']);
        }
        $this->assertEquals($expected, $result[0]);

        if (strtotime($up_date) < strtotime('2016-09-13')) {
            $flag = false;
        }
        $this->assertTrue($flag);

        // 存在しない TODO 変更対象件数が0件の場合、どのように対応するか(false返却 or NotFoundException)によってテストメソッドの変更必要
        $this->assertFalse($this->component->editFileInfo($this->testUserSeq, 9999999, $data));
    }

    /**
     * Test getSearchFiles method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getSearchFiles()
    {
		$this->loadFixtures('FileFolderTbl', 'FileTbl');
        // case 1: result single record
        $expected = array(
                        array('file_folder_id' => 1,
                            'file_id' => 1,
                            'file_name' => 'ファイル名1番.jpg',
                            'name' => 'ファイル名1番',
                            'extension' => 'jpg',
                            'amount' => 1,
                            'base' => 'base1',
                            'file_comment' => 'ファイルコメント1番',
                            'file_uri' => '/path1',
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'up_date' => '2016-09-13',
                            'reg_date' => '2016-09-13',
                            'index' => 1,
                            'file_folder_name' => 'フォルダ名1番'
                        )
        );
        $result = $this->component->getSearchFiles($this->testUserSeq, 'ファイル名1番', 'new', 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result);

        // case 2: result multiple records sort new
        $expected = array(
                        array('file_folder_id' => 1,
                            'file_id' => 2,
                            'file_name' => 'ファイル名2番.txt',
                            'name' => 'ファイル名2番',
                            'extension' => 'txt',
                            'amount' => 2,
                            'base' => 'base2',
                            'file_comment' => 'ファイルコメント2番',
                            'file_uri' => '/path2',
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'up_date' => '2016-10-13',
                            'reg_date' => '2016-10-13',
                            'index' => 1,
                            'file_folder_name' => 'フォルダ名1番'
                        ),
                        array('file_folder_id' => 1,
                            'file_id' => 1,
                            'file_name' => 'ファイル名1番.jpg',
                            'name' => 'ファイル名1番',
                            'extension' => 'jpg',
                            'amount' => 1,
                            'base' => 'base1',
                            'file_comment' => 'ファイルコメント1番',
                            'file_uri' => '/path1',
                            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                            'up_date' => '2016-09-13',
                            'reg_date' => '2016-09-13',
                            'index' => 2,
                            'file_folder_name' => 'フォルダ名1番'
                            )
                    );
        $result = $this->component->getSearchFiles($this->testUserSeq, 'ファイルコメント', 'new', 1);
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);

        // case 3: result multiple records sort old
        $expected = array(
            array('file_folder_id' => 1,
                'file_id' => 1,
                'file_name' => 'ファイル名1番.jpg',
                'name' => 'ファイル名1番',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => 'base1',
                'file_comment' => 'ファイルコメント1番',
                'file_uri' => '/path1',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'index' => 1,
                'file_folder_name' => 'フォルダ名1番'
            ),
            array('file_folder_id' => 1,
                'file_id' => 2,
                'file_name' => 'ファイル名2番.txt',
                'name' => 'ファイル名2番',
                'extension' => 'txt',
                'amount' => 2,
                'base' => 'base2',
                'file_comment' => 'ファイルコメント2番',
                'file_uri' => '/path2',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-10-13',
                'reg_date' => '2016-10-13',
                'index' => 2,
                'file_folder_name' => 'フォルダ名1番'
            )
        );
        $result = $this->component->getSearchFiles($this->testUserSeq, 'ファイル名', 'old', 1);
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);

        // case 4: result keyword is empty string
        $expected = array(
            [
                'file_folder_id' => 1,
                'file_id' => 1,
                'file_name' => 'ファイル名1番.jpg',
                'name' => 'ファイル名1番',
                'extension' => 'jpg',
                'amount' => 1,
                'base' => 'base1',
                'file_comment' => 'ファイルコメント1番',
                'file_uri' => '/path1',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-09-13',
                'reg_date' => '2016-09-13',
                'index' => 1,
                'file_folder_name' => 'フォルダ名1番'
            ],
            [
                'file_folder_id' => 1,
                'file_id' => 2,
                'file_name' => 'ファイル名2番.txt',
                'name' => 'ファイル名2番',
                'extension' => 'txt',
                'amount' => 2,
                'base' => 'base2',
                'file_comment' => 'ファイルコメント2番',
                'file_uri' => '/path2',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-10-13',
                'reg_date' => '2016-10-13',
                'index' => 2,
                'file_folder_name' => 'フォルダ名1番'
            ],
            [
                'file_folder_id' => 2,
                'file_id' => 3,
                'file_name' => 'ファイル名3番.png',
                'name' => 'ファイル名3番',
                'extension' => 'png',
                'amount' => 3,
                'base' => 'base3',
                'file_comment' => 'ファイルコメント3番',
                'file_uri' => '/path3',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-11-13',
                'reg_date' => '2016-11-13',
                'index' => 3,
                'file_folder_name' => 'フォルダ名2番'
            ],
            [
                'file_folder_id' => 8,
                'file_id' => 8,
                'file_name' => 'ファイル名3番.png',
                'name' => 'ファイル名3番',
                'extension' => 'png',
                'amount' => 3,
                'base' => 'base3',
                'file_comment' => 'ファイルコメント3番',
                'file_uri' => 'C:\home\personaltool2\storage\test\765.txt',
                'user_seq' => '385cd85a14bb90c754897fd0366ff266',
                'up_date' => '2016-11-13',
                'reg_date' => '2016-11-13',
                'index' => 4
            ]
        );
        $result = $this->component->getSearchFiles($this->testUserSeq, '', 'old');
        foreach ($result as $key => $item) {
            $upDate = $item['up_date']->i18nFormat('YYYY-MM-dd');
            $regDate = $item['reg_date']->i18nFormat('YYYY-MM-dd');
            $result[$key]['up_date'] = $upDate;
            $result[$key]['reg_date'] = $regDate;
        }
        $this->assertEquals($expected, $result);
    }

    /**
     * Test changeFilesFolder method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function changeFilesFolder()
    {
        $this->loadFixtures('FileTbl', 'UserMst');
        //case 1: folder exists
        $expected = array(
            'file_folder_id' => 1,
            'file_id' => 1,
            'file_name' => 'ファイル名1番.jpg',
            'name' => 'ファイル名1番',
            'extension' => 'jpg',
            'amount' => 1,
            'base' => 'base1',
            'file_comment' => 'ファイルコメント1番',
            'file_uri' => '/path1',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
        );
        $this->component->changeFilesFolder($this->testUserSeq, 2, 1);
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);

        //case 2: folder not exists
        $expected = array(
            'file_folder_id' => 2,
            'file_id' => 3,
            'file_name' => 'ファイル名3番.png',
            'name' => 'ファイル名3番',
            'extension' => 'png',
            'amount' => 3,
            'base' => 'base3',
            'file_comment' => 'ファイルコメント3番',
            'file_uri' => '/path3',
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'up_date' => '2016-11-13',
            'reg_date' => '2016-11-13'
        );
        $this->component->changeFilesFolder($this->testUserSeq, 0, 3);
        $fileTbl = TableRegistry::get('FileTbl');
        $result = $fileTbl->getSingleFileData($this->testUserSeq, 3);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');
        $this->assertEquals($expected, $result[0]);
    }

    /**
     * Test getFolderFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getFolderFile()
    {
        $this->loadFixtures('FileTbl', 'UserMst');
        //case 1: folder exists
        $expected = array(
            'file_folder_id' => 1,
            'user_seq' => '385cd85a14bb90c754897fd0366ff266',
            'file_folder_name' => 'フォルダ名1番',
            'comment' => 'フォルダコメント1番',
            'up_date' => '2016-09-13',
            'reg_date' => '2016-09-13',
            'num' => 2
        );
        $result = $this->component->getFolderFile($this->testUserSeq, 1);
        $result[0]['up_date'] = $result[0]['up_date']->i18nFormat('YYYY-MM-dd');
        $result[0]['reg_date'] = $result[0]['reg_date']->i18nFormat('YYYY-MM-dd');

        $this->assertEquals($expected, $result[0]);
        //case 2: folder not exists
        $expected = array();
        $result = $this->component->getFolderFile($this->testUserSeq, 0);
        $this->assertEquals($expected, $result);
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
            'file_comment' => 'フォルダコメント'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['name']['_empty'])) {
            $flag = true;
        }
        $this->assertTrue($flag);

        //case 2: name over 25 characters
        $data = [
            'name' => 'ファイル名1番 file hello every one',
            'file_comment' => 'フォルダコメント'
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
            'file_comment' => 'フォルダコメント Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'
        ];
        $validator = $this->component->validationDefault(new Validator());
        $errors = $validator->errors($data);
        $flag = null;
        if (isset($errors['file_comment']['maxLength'])) {
            $flag = true;
        }
        $this->assertTrue($flag);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }
}
