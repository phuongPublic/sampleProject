<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\FolderComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Validation\Validator;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\FileComponent Test Case
 */
class FolderComponentTest extends NoptComponentIntegrationTestCase
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
        $this->component = new FolderComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test deleteFolderData method
     * @codeCoverageIgnore
     * @expectedExceptionCode
     * @test
     * @return void
     */
    public function deleteFolderData()
    {
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'UserMst');
        // case del = null
        $result = true;
        try {
            $this->component->deleteFolderData($this->testUserSeq, []);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case del = 1,2
        $result = true;
        try {
            $this->component->deleteFolderData($this->testUserSeq, [1, 2]);
        } catch (\Exception $e) {
            $result = false;
        }
        $this->assertTrue($result);

        // case NG
        $result = $this->component->deleteFolderData('385cd85a14bb90c754897fd0366ff267', [1, 2]);

        $result = $this->component->deleteFolderData(null, [1, 2]);

    }

    /**
     * Test insertFolderData method
     * @codeCoverageIgnore
     * @expectedException
     * @test
     *
     * @return void
     */
    public function insertFolderData()
    {
        $this->loadFixtures('FileFolderTbl');

        // case 1: Add OK
        $data = array('file_folder_name' => 'Folder Name Test', 'comment' => 'Test comment', 'commit' => '追加する');
        $this->assertEquals(4, $this->component->insertFolderData($this->testUserSeq, $data));

        // case 2: Add OK
        $data = array('file_folder_name' => 'Folder Name Test', 'comment' => '', 'commit' => '追加する');
        $this->assertEquals(5, $this->component->insertFolderData($this->testUserSeq, $data));

        // case 3: Add NG
        $data = array('file_folder_name' => '', 'comment' => '', 'commit' => '追加する');
        $this->assertEquals(6, $this->component->insertFolderData($this->testUserSeq, $data));

        // case 3: Add OK
        $data = array('file_folder_name' => '$#ATDD', 'comment' => '', 'commit' => '追加する');
        $this->assertEquals(7, $this->component->insertFolderData($this->testUserSeq, $data));

        $this->component->insertFolderData(null, $data);

    }

    /**
     * Test editFolderInfo method
     * @codeCoverageIgnore
     * @expectedException
     * @test
     *
     * @return void
     */
    public function editFolderInfo()
    {
        $this->loadFixtures('FileFolderTbl');

        // case 1: Add OK
        $folderId = 2;
        $data = array('file_folder_name' => 'Folder Name Test 123', 'comment' => 'Test comment', 'commit' => '追加する');
        $result = $this->component->editFolderInfo($this->testUserSeq, $folderId, $data);
        $this->assertTrue($result);

        // case 2: Add NG
        $folderId = 2;
        $data = array('file_folder_name' => '', 'comment' => 'Test comment', 'commit' => '追加する');
        $result = $this->component->editFolderInfo($this->testUserSeq, $folderId, $data);
        $this->assertTrue($result);

        // case 3: Add NG
        $folderId = 2;
        $data = array('file_folder_name' => 'Folder Name Test 123Folder Name Test 123Folder Name Test 123Folder Name Test 123Folder Name Test 123', 'comment' => 'Test comment', 'commit' => '追加する');
        $result = $this->component->editFolderInfo($this->testUserSeq, $folderId, $data);
        $this->assertTrue($result);

        // case 4: Add NG
        $folderId = 2;
        $data = array('file_folder_name' => 'Folder Name Test', 'comment' => 'Test comment', 'commit' => '追加する');
        $result = $this->component->editFolderInfo('385cd85a14bb90c754897fd0366ff267', $folderId, $data);
    }

    /**
     * Test editFolderInfo method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function validationDefault()
    {
        // case 1: NG
        $expectedErrorMessage = 'フォルダ名が入力されていません。';
        $data = array(
            'file_folder_id' => 1,
            'user_seq' => $this->testUserSeq,
            'file_folder_name' => '',
            'comment' => 'Test comment',
            'up_date' => '2016-12-06',
            'reg_date' => '2016-12-06'
        );
        $validator = $this->component->validationDefault(new Validator);
        $errors = $validator->errors($data, true);
        $actualErrorMessage = $errors['file_folder_name']['_empty'];
        $this->assertTextEquals($expectedErrorMessage, $actualErrorMessage);

        // case 2: OK
        $data = array(
            'file_folder_id' => 1,
            'user_seq' => $this->testUserSeq,
            'file_folder_name' => 'AAA',
            'comment' => 'Test comment',
            'up_date' => '2016-12-06',
            'reg_date' => '2016-12-06'
        );
        $validator = $this->component->validationDefault(new Validator);
        $errors = $validator->errors($data, true);
        $this->assertEmpty($errors);

        // case 3: NG
        $expectedErrorMessage = 'フォルダ名には25文字以内で入力してください。';
        $data = array(
            'file_folder_id' => 1,
            'user_seq' => $this->testUserSeq,
            'file_folder_name' => 'AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA',
            'comment' => 'Test comment',
            'up_date' => '2016-12-06',
            'reg_date' => '2016-12-06'
        );
        $validator = $this->component->validationDefault(new Validator);
        $errors = $validator->errors($data, true);
        $actualErrorMessage = $errors['file_folder_name']['maxLength'];
        $this->assertTextEquals($expectedErrorMessage, $actualErrorMessage);

        // case 4: NG
        $expectedErrorMessage = 'コメントには1000文字以内で入力してください。';
        $data = array(
            'file_folder_id' => 1,
            'user_seq' => $this->testUserSeq,
            'file_folder_name' => 'Avv',
            'comment' => 'AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA
                           AAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAA AAAAAAAAAAAAAAAA',
            'up_date' => '2016-12-06',
            'reg_date' => '2016-12-06'
        );
        $validator = $this->component->validationDefault(new Validator);
        $errors = $validator->errors($data, true);
        $actualErrorMessage = $errors['comment']['maxLength'];
        $this->assertTextEquals($expectedErrorMessage, $actualErrorMessage);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->component, $this->controller);
    }
}