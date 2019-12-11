<?php

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\NoptIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\AddressListController Test Case
 */
class AddressListControllerTest extends NoptIntegrationTestCase
{

    public $autoFixtures = false;
    protected $redirectUrl1 = '/album/open/regist.html'; //削除遷移
    protected $redirectUrl2 = '/storage/file/open/regist.html'; //削除遷移
    protected $redirectUrl3 = '/movie/open/regist.html'; //削除遷移

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
     * Test index method for PC
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */

    public function index()
    {
        $this->switchDevice(1);
        // OK - GET request
        $this->get($this->testUrl);
        $this->assertResponseCode(200);

        // Load screen OK - get address data from group
        $this->setSession();
        $this->setDataOpenSession(1);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->get($this->testUrl.'?group_id=1&selection=表示');
        $this->assertResponseCode(200);
        $this->_session = [];

        // Album
        // commit with non address data and non targetID
        $data = ['commit' => '選択する'];
        $this->setSessionData('OpenStatusDeparture', 1);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid='); // リダイレクト先URLの確認

        //commit with non address data
        $data = [
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(1);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid=1'); // リダイレクト先URLの確認
        
        //commit with address data
        $data = [
            'adrdata_seq' => array('0000000701', '0000000702'),
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(1);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid=1'); // リダイレクト先URLの確認

         //commit with address data ,Non selected mail
        $data = [
            'adrdata_seq' => array('0000000701', '0000000702'),
            'commit' => '選択する'
        ];
        $this->setSessionData('OpenStatusAddress', null);
        $this->setDataOpenSession(1);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid=1'); // リダイレクト先URLの確認

         //commit with address data ,over 10 mail selected
        $data = [
            'adrdata_seq' => array('0000000701', '0000000702', '0000000703', '0000000704', '0000000705', '0000000706', '0000000707', '0000000708', '0000000709'),
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(1);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid=1'); // リダイレクト先URLの確認

        //back
        $data = [
            'back' => '戻る'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?return=1&aid=1'); // リダイレクト先URLの確認

        // File
        // commit with non address data and non targetID
        $data = [
            'commit' => '選択する'
        ];
        $this->setSessionData('OpenStatusDeparture', 2);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?return=1&fid='); // リダイレクト先URLの確認

        //commit with non address data
        $data = [
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(2);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?return=1&fid=1'); // リダイレクト先URLの確認

        //commit with address data
        $data = [
            'adrdata_seq' => array('0000000701', '0000000702'),
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(2);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?return=1&fid=1'); // リダイレクト先URLの確認
        //back
        $data = [
            'back' => '戻る'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl2 . '?return=1&fid=1'); // リダイレクト先URLの確認

        // Movie
        // commit with non address data and non targetID
        $data = [
            'commit' => '選択する'
        ];
        $this->setSessionData('OpenStatusDeparture', 3);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?return=1&mid='); // リダイレクト先URLの確認

        //commit with non address data
        $data = [
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(3);
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?return=1&mid=1'); // リダイレクト先URLの確認
        //commit with address data
        $data = [
            'adrdata_seq' => array('0000000701', '0000000702'),
            'commit' => '選択する'
        ];
        $this->setSession();
        $this->setDataOpenSession(3);
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?return=1&mid=1'); // リダイレクト先URLの確認
        //back
        $data = [
            'back' => '戻る'
        ];
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl3 . '?return=1&mid=1'); // リダイレクト先URLの確認
    }

    /**
     * 対象のデータを固定でセッションに格納
     *
     * @return void
     */
    protected function setSession()
    {
        parent::setSessionData('OpenStatusAddress', array(
                    '0' => 'addr11<addr11@test.co.jp>',
                    '1' => 'addr12<addr12@test.co.jp>'
                ));
    }
    
    private function setDataOpenSession($Departure)
    {
        parent::setSessionData('OpenStatusDeparture', $Departure);
        if ($Departure == 1) {
            parent::setSessionData('AlbumOpenSetting', array(
                    'nickname' => 'Test',
                    'close_date' => '3',
                    'message' => 'message',
                    'selection' => 'アドレス帳から選択する',
                    'mail' =>
                        array(
                            '0' => 'addr11<addr11@test.co.jp>',
                            '1' => 'addr12<addr12@test.co.jp>'
                        ),
                    'access_check' => '0',
                    'target_id' => '1',
                    'open_flg' => '1',
                    'album_id' => '1'
                )
            );
        } elseif ($Departure == 2) {
            parent::setSessionData('FileOpenSetting', array(
                    'nickname' => 'Test',
                    'close_date' => '3',
                    'message' => 'message',
                    'selection' => 'アドレス帳から選択する',
                    'mail' =>
                        array(
                            '0' => 'addr11<addr11@test.co.jp>',
                            '1' => 'addr12<addr12@test.co.jp>'
                        ),
                    'access_check' => '0',
                    'fid' => '1'
                )
            );
        } else {
            parent::setSessionData('MovieOpenSetting', array(
                    'nickname' => 'Test',
                    'close_date' => '3',
                    'message' => 'message',
                    'selection' => 'アドレス帳から選択する',
                    'mail' =>
                        array(
                            '0' => 'addr11<addr11@test.co.jp>',
                            '1' => 'addr12<addr12@test.co.jp>'
                        ),
                    'access_check' => '0',
                    'target_id' => '1',
                    'open_flg' => '4',
                    'movie_folder_id' => '1'
                )
            );
        }
    }
}
