<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AddressImportController Test Case
 */
class AddressImportControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/address/listview.html'; //通常遷移
    
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
            'app.AddressData',
            'app.GroupTbl'
    ];

    /**
     * Test index method for all method
     * @codeCoverageIgnore
     * @test
     * @return void
     */
    public function index()
    {
        /**
         * GET処理
         */        
        // get
        $this->setSession();
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->get($this->testUrl);
        $this->assertResponseCode(200);
        // cancel case
        $data = [
            'cancel_import' => '0001',
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1); // リダイレクト先URLの確認

        // submit case file error
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> '',
                'tmp_name'=> 'imort tmp name',
                'size'=> 500,
                'extension'=> 'csv',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200); 
        // submit case extension error
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> 'imort.jpg',
                'tmp_name'=> 'imort tmp name',
                'size'=> 500,
                'extension'=> 'jpg',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        // submit case normal
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> 'imort.csv',
                'tmp_name'=> 'filepath.csv',
                'size'=> 500,
                'extension'=> 'csv',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        
        // $result == -1
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> 'address_missingField17_window.csv',
                'tmp_name'=> '\xampp\tmp\address_missingField17_window.csv',
                'size'=> 500,
                'extension'=> 'csv',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
       
        // $result == -3
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> 'addressExceedLine.csv',
                'tmp_name'=> '\xampp\tmp\addressExceedLine.csv',
                'size'=> 500,
                'extension'=> 'csv',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        // $result == -2
        $data = [
            'submit_import' => '0001',
            'file' => [
                'name'=> 'addressTest34.csv',
                'tmp_name'=> '\xampp\tmp\addressTest34.csv',
                'size'=> 500,
                'extension'=> 'csv',
            ],
        ];
        $this->loadFixtures('AddressData', 'GroupTbl');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);        
    }

    /**
     * 対象のデータを固定でセッションに格納
     * @return void
     */
    protected function setSession()
    {
        // ffidが1番のデータを削除対象とする
        parent::setSessionData('UserData.user_seq', array('385cd85a14bb90c754897fd0366ff266'));
    }
}
