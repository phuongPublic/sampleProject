<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Component\ActionClassComponent;
use Cake\Controller\ComponentRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;

/**
 * App\Controller\Component\FileComponent Test Case
 */
class ActionClassComponentTest extends NoptComponentIntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry($this->controller);
        $this->component = new ActionClassComponent($registry);
    }

    /**
     * Test openUserAuth method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function openUserAuth()
    {
        // case 1 pc error
        $expected = 'android/Open/Login.html';
        $result = $this->component->openUserAuth('android', false);
        $this->assertEquals($expected, $result);

        // case 2 android
        $expected = 'android/Open/Login.html?id=2';
        $result = $this->component->openUserAuth('android', true, 1, 2);
        $this->assertEquals($expected, $result);

        // case 3 ihpone
        $expected = 'iphone/Open/Login.html';
        $result = $this->component->openUserAuth('iphone', false);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test sendMailAction method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function sendMailAction()
    {
        // case 1
        $result = true;
        try {
            $data = array(
                'template' => 'album_user_mail',
                'mail_data' => array (
                    'nickname' => 'LoanVD',
                    'close_date' => '2016-12-06',
                    'message' => 'Nopt',
                    'open_id' => '1',
                    'from_mail' => 'loanvdit@mytcom.t-com.ne.jp',
                    'mail' => 'abc@mytcom.t-com.ne.jp',
                    'disc_size' => '2343'
                ),
                'from' => array (
                    'address' => 'loanvdit@mytcom.t-com.ne.jp',
                    'nickname' => 'LoanVD',
                ),
                'to' => 'loanvdit@mytcom.t-com.ne.jp',
                'subject' => '【My@T COM】LoanVDさんからアルバム公開のお知らせです'
            );
            $this->component->sendMailAction($data, 'OpenRegist');
        } catch (\Exception $e) {
            //print_r($e); die;
            $result = false;
        }
        $this->assertTrue($result);

        // case 2
        $result = true;
        try {
            $data = array(
                'template' => 'album_access_mail',
                'mail_data' => array (
                    'nickname' => 'LoanVD',
                    'close_date' => '2016-12-06',
                    'message' => 'Nopt',
                    'open_id' => '1',
                    'from_mail' => 'loanvdit@mytcom.t-com.ne.jp',
                    'mail' => 'abc@mytcom.t-com.ne.jp',
                    'disc_size' => '2343',
                    'album_name' => 'Funny',
                    'reg_date' => '2016-12-05'
                ),
                'from' => array (
                    'address' => 'loanvdit@mytcom.t-com.ne.jp',
                    'nickname' => 'LoanVD',
                ),
                'to' => 'loanvdit@mytcom.t-com.ne.jp',
                'subject' => '【My@T COM】LoanVDさんからアルバム公開のお知らせです'
            );
            $this->component->sendMailAction($data);
        } catch (\Exception $e) {
            //print_r($e); die;
            $result = false;
        }
        $this->assertTrue($result);

        // case 3
        $result = true;
        try {
            $data = array(
                'template' => 'file_access_mail',
                'mail_data' => array (
                    'nickname' => 'LoanVD',
                    'close_date' => '2016-12-06',
                    'message' => 'Nopt',
                    'open_id' => '1',
                    'from_mail' => 'loanvdit@mytcom.t-com.ne.jp',
                    'mail' => 'abc@mytcom.t-com.ne.jp',
                    'disc_size' => '2343',
                    'file_name' => 'Funny',
                    'reg_date' => '2016-12-05'
                ),
                'from' => array (
                    'address' => 'loanvdit@mytcom.t-com.ne.jp',
                    'nickname' => 'LoanVD',
                ),
                'to' => 'loanvdit@mytcom.t-com.ne.jp',
                'subject' => '【My@T COM】LoanVDさんからアルバム公開のお知らせです'
            );
            $this->component->sendMailAction($data);
        } catch (\Exception $e) {
            //print_r($e); die;
            $result = false;
        }
        $this->assertTrue($result);
    }
}