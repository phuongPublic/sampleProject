<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;

/**
 * App\Controller\FileRegistController Test Case
 */
class FileRegistControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/storage/file/regist.html'; //通常遷移
    protected $redirectUrl2 = '/storage/folder/list.html'; //検索遷移
    protected $redirectUrl3 = '/storage/file/list.html'; //検索遷移

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileFolderTbl',
        'app.FileTbl',
        'app.OpenStatus',
        'app.TargetUser',
        'app.UserMst'
    ];

    /**
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        $this->setSession();
        /**
         * GET処理
         */
        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        $this->switchDevice(1);
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->get($this->testUrl . '?fid=1');
        $this->assertResponseCode(200);

        /**
         * POST処理
         */

        // pc file name invalid checkTraversal
        $this->switchDevice(1);
        $data = [
            'folder_id' => 1,
            'fileId' => '$$',
            'fileSize' => 1000,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?fid=1'); // リダイレクト先URLの確認
//        //no file was upload
        $data = [
            'folder_id' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // file upload > 10
        $data = [
            'folder_id' => 1,
            'fileSize' => [845941,780831,780831,780831,780831,780831,780831,780831,780831,780831,780831],
            'title' => ['Title added 1','','','','','','','','','',''],
            'description' => ['Comment added  1', '', '', '', '', '', '', '', '', '', ''],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png', 'Picture added 2.png', 'Picture added 3.png', 'Picture added 4.png', 'Picture added 5.png', 'Picture added 6.png', 'Picture added 7.png', 'Picture added 8.png', 'Picture added 9.png', 'Picture added 10.png', 'Picture added 11.png',],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939', 'o_1b3u8ovra2b6j7b18eqbl8eba'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

        // invalid input
        $data = [
            'folder_id' => 1,
            'fileSize' => [53687091200,780831, 780831, 780831],
            'title' => ['Title added 1', '', 'Title added 234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890', 'Title added 1'
            ],
            'description' => ['Comment added  1', '', '',
                'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
                Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png', 'Picture added 3.png', 'Picture added 4.png'],
            'fileId' => ['o_1b3u8ovrahi0ac51d5h1prqe939', 'o_1b3u8ovra2b6j7b18eqbl8eba', 'o_1b3u8ovraet3535353t3t53', 'o_1b3u8ovraet4646'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);

         //post pc
        $data = [
            'folder_id' => 1,
            'fileSize' => [845941, 780831],
            'title' => ['Title added 1', ''],
            'description' => ['Comment added  1', ''],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png'],
            'fileId' => ['o_123456789', 'o_987654321'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //post pc
        $data = [
            'folder_id' => 1,
            'fileSize' => [845941, 780831],
            'title' => ['//', ''],
            'description' => ['Comment added  1', ''],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png'],
            'fileId' => ['o_123456789', 'o_987654321'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //post pc
        $data = [
            'folder_id' => 1,
            'fileSize' => [845941, 780831],
            'title' => ['asss', ''],
            'description' => ['Comment added  1', ''],
            'fileName' => ['//sdss.png', 'Picture added 2.png'],
            'fileId' => ['o_123456789', 'o_987654321'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

         //pc file name insert fail
        $this->switchDevice(1);
        $data = [
            'folder_id' => 1,
            'fileId' => '$$',
            'title' => '/',
            'fileSize' => 1000,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);  //リダイレクト先URLの確認

         //pc file name insert success
        $this->switchDevice(1);
        $data = [
            'folder_id' => 1,
            'fileId' => 'abc',
            'fileName' => 'file name pc',
            'title' => 'file title pc',
            'description' => 'file description pc',
            'fileSize' => 1000,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1. '?fid=1');  //リダイレクト先URLの確認

         //pc file over max upload
        $this->switchDevice(1);
        $data = [
            'folder_id' => 1,
            'fileId' => array('o_123456791'),
            'fileName' => 'file name pc',
            'title' => 'file title pc',
            'description' => 'file description pc',
            'fileSize' => array(2905088),
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);  //リダイレクト先URLの確認


        //pc file over max disc size
        $this->switchDevice(1);
        $data = [
            'folder_id' => 1,
            'fileId' => array('o_123456790'),
            'fileName' => 'file name pc',
            'title' => 'file title pc',
            'description' => 'file description pc',
            'fileSize' => array(2905088),
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1);  //リダイレクト先URLの確認

        /**
         * POST処理
         */
        //smart phone file size over discsize change discsize =100MB change environment setting
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => '\xampp\tmp\phpE4CF.tmp',
                'name' => 'file2',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?fid=1');  //リダイレクト先URLの確認

        //post pc
        $data = [
            'folder_id' => 1,
            'fileSize' => [845941, 780831],
            'title' => ['Title added 1', ''],
            'description' => ['Comment added  1', ''],
            'fileName' => ['Picture added 1.png', 'Picture added 2.png'],
            'fileId' => ['o_123456792', 'o_12345679293'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        //smart phone file size over 100MB change environment setting
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => '\xampp\tmp\phpE4CF.tmp',
                'name' => 'file',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?fid=1');  //リダイレクト先URLの確認


         //android dont select file
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3. '?fid=1');  //リダイレクト先URLの確認

         //android file name insert success
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.jpg',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3. '?fid=1');  //リダイレクト先URLの確認

        // case n
        $data = [
            'folder_id' => 1,
            'fileSize' => [1],
            'title' => ['Title added 1'],
            'description' => ['Comment added  1'],
            'fileName' => ['Picture added 1.png'],
            'fileId' => ['o_123456789'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // case n + 1
        $data = [
            'folder_id' => 1,
            'fileSize' => [2],
            'title' => [''],
            'description' => ['Accddfd'],
            'fileName' => ['Picture added 2.png'],
            'fileId' => ['o_987654321'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // case n + 2
        $data = [
            'folder_id' => 1,
            'fileSize' => [2],
            'title' => [''],
            'description' => [''],
            'fileName' => ['Picture added 2'],
            'fileId' => ['o_987654322'],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);

        // case n + 3
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => '//file.jpg',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3. '?fid=1');  //リダイレクト先URLの確認

        // case n + 4
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => 'file tmp_name android',
                'name' => 'file.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpgfile.jpg',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3. '?fid=1');  //リダイレクト先URLの確認

        // case n + 5
        $this->switchDevice(3);
        $data = [
            'fileUploadFlg' => 1,
            'file_folder_id' => 1,
            'fileInput' => [
                'tmp_name' => '\xampp\tmp\phpE4CF.tmp',
                'name' => 'file.jpgfile.jpgfile.',
            ],
        ];
        $this->loadFixtures('FileFolderTbl', 'FileTbl', 'OpenStatus', 'UserMst', 'TargetUser');
        $this->post($this->testUrl, $data);

        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3. '?fid=1');  //リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
    }

}
