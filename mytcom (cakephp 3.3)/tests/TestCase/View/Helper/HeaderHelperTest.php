<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\HeaderHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class HeaderHelperTest extends TestCase
{

    public $helper = null;

    public function setUp()
    {
        parent::setUp();
        $View = new View();
        $this->helper = new HeaderHelper($View);
    }

    /**
     * Test getUsername method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getUsername()
    {
        $result = $this->helper->getUsername();
        var_dump($result);
    }

    /**
     * Test getUseCapacity method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getUseCapacity()
    {
        $result = $this->helper->getUseCapacity();
        $this->assertNotEmpty($result);
    }

    /**
     * Test getUseCapacityPercent method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getUseCapacityPercent()
    {
        $result = $this->helper->getUseCapacityPercent();
        $this->assertNotEmpty($result);
    }

    /**
     * Test getFolderNameByFile method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getContractCapacityStr()
    {
        // ISP毎に差分があるので値が設定されているなら正常とみなす
        $result = $this->helper->getContractCapacityStr();
        $this->assertEquals('50GB', $result);
    }

    /**
     * Test getTitleStr method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getTitleStr()
    {
        $result = $this->helper->getTitleStr(1);
        $this->assertEquals('家族掲示板', $result);

        $result = $this->helper->getTitleStr(2);
        $this->assertEquals('スケジュール', $result);

        $result = $this->helper->getTitleStr(3);
        $this->assertEquals('日記', $result);

        $result = $this->helper->getTitleStr(4);
        $this->assertEquals('家計簿', $result);

        $result = $this->helper->getTitleStr(5);
        $this->assertEquals('アルバム', $result);

        $result = $this->helper->getTitleStr(6);
        $this->assertEquals('動画', $result);

        $result = $this->helper->getTitleStr(7);
        $this->assertEquals('ファイル管理', $result);

        $result = $this->helper->getTitleStr(8);
        $this->assertEquals('メール', $result);

        $result = $this->helper->getTitleStr(9);
        $this->assertEquals('アドレス帳', $result);

        $result = $this->helper->getTitleStr(10);
        $this->assertEquals('設定', $result);

        //case if id is not exist
        $result = $this->helper->getTitleStr(12);
        $this->assertEquals('スケジュール', $result);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->helper);
    }

}
