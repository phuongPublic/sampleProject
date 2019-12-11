<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\CommonHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class CommonHelperTest extends TestCase
{

    public $helper = null;

    public function setUp()
    {
        parent::setUp();
        $View = new View ();
        $this->helper = new CommonHelper($View);
    }

    /**
     * Test getIsp method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function getIsp()
    {
        $result = $this->helper->getIsp();
        $this->assertEquals('tcom', $result);
    }

    /**
     * Test kbyte method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function kbyte()
    {
        $result = $this->helper->kbyte(512);
        $this->assertEquals('1KB', $result);

        $result = $this->helper->kbyte(1024);
        $this->assertEquals('1KB', $result);

        $result = $this->helper->kbyte(1536);
        $this->assertEquals('2KB', $result);
    }

    /**
     * Test mbwordwrap method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function mbwordwrap()
    {
        //case 1: japanse
        $result = $this->helper->mbwordwrap("アルバム名をクリックすると詳細を見ることができます。", 10);
        $expected = "アルバム名をクリック\nすると詳細を見ること\nができます。\n";
        $this->assertEquals($expected, $result);
        //case 2: english
        $result = $this->helper->mbwordwrap("could you tell me how to get to the supermarket please ?", 10);
        $expected = "could you\ntell me\nhow to get\nto the\nsupermarket\nplease ?";
        $this->assertEquals($expected, $result);
    }

    /**
     * Test htmlEscape method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function htmlEscape()
    {
        $result = $this->helper->htmlEscape("3 > 2? \"hello\" everyone");
        $expected = '3 &gt; 2? &quot;hello&quot; everyone';
        $this->assertEquals($expected, $result);

        $result = $this->helper->htmlEscape("<a href='test'>Test</a>");
        $expected = '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;';
        $this->assertEquals($expected, $result);
    }

    /**
     * Test date_format method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function date_format()
    {
        //case 1:
        $result = $this->helper->date_format('2015/10/30');
        $expected = 'Oct 30, 2015';
        $this->assertEquals($expected, $result);

        //case 2:
        $result = $this->helper->date_format('2015/02/31');
        $expected = 'Mar 3, 2015';
        $this->assertEquals($expected, $result);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->helper);
    }

}
