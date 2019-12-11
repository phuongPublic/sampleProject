<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Cake\Controller\ComponentRegistry;
// テスト対象資源指定
use App\Controller\Component\PageControlComponent;
use Cake\ORM\TableRegistry;
use App\Test\TestCase\NoptComponentIntegrationTestCase;
use Cake\TestSuite\Fixture\FixtureManager;

/**
 * App\Controller\Component\PageControlComponent Test Case
 */
class PageControlComponentTest extends NoptComponentIntegrationTestCase
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
        $this->component = new PageControlComponent($registry);

        $this->fixtureManager = new FixtureManager();
        $this->fixtureManager->fixturize($this);
    }

    /**
     * Test pageCtl method
     * @codeCoverageIgnore
     * @test
     *
     * @return void
     */
    public function pageCtl()
    {
        $array = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
            7 => 8,
            8 => 9,
            9 => 10,
            10 => 11,
        ];
        //case 1:
        $result = $this->component->pageCtl(2, $array, 2);
        $expected = [
            'page' => 2,
            'total' => 11,
            'total_page' => 6,
            'start' => 3,
            'end' => 4,
            'next' => 3,
            'back' => 1,
            'show_data' => [
                2 => 3,
                3 => 4
            ],
            'link_num' => [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5
            ],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);

        //case 2:
        $result = $this->component->pageCtl(null, $array, 2);
        $expected = [
            'page' => 1,
            'total' => 11,
            'total_page' => 6,
            'start' => 1,
            'end' => 2,
            'next' => 2,
            'back' => '',
            'show_data' => [
                0 => 1,
                1 => 2
            ],
            'link_num' => [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5
            ],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);

        //case 3:
        $result = $this->component->pageCtl(6, $array, 2);
        $expected = [
            'page' => 6,
            'total' => 11,
            'total_page' => 6,
            'start' => 11,
            'end' => 11,
            'next' => '',
            'back' => 5,
            'show_data' => [
                10 => 11
            ],
            'link_num' => [
                0 => 2,
                1 => 3,
                2 => 4,
                3 => 5,
                4 => 6
            ],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);

        //case 4:
        $array = [
            0 => 1
        ];
        $result = $this->component->pageCtl(1, $array, 2);
        $expected = [
            'page' => 1,
            'total' => 1,
            'total_page' => 1,
            'start' => 1,
            'end' => 1,
            'next' => '',
            'back' => '',
            'show_data' => [0 => 1],
            'link_num' => [],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);

        //case 5:
        $array = [
            0 => 1,
            1 => 2,
            2 => 3,
        ];
        $result = $this->component->pageCtl(1, $array, 2);
        $expected = [
            'page' => 1,
            'total' => 3,
            'total_page' => 2,
            'start' => 1,
            'end' => 3,
            'next' => 2,
            'back' => '',
            'show_data' => [0 => 1, 1 => 2],
            'link_num' => [0 => 1, 1 => 2],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);

        //case 6:
        $array = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
            7 => 8,
            8 => 9,
            9 => 10,
            10 => 11,
        ];
        $result = $this->component->pageCtl(3, $array, 2);
        $expected = [
            'page' => 3,
            'total' => 11,
            'total_page' => 6,
            'start' => 5,
            'end' => 6,
            'next' => 4,
            'back' => 2,
            'show_data' => [
                4 => 5,
                5 => 6
            ],
            'link_num' => [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5
            ],
            'items' => 2
        ];
        $this->assertEquals($expected, $result);
    }

    public function tearDown()
    {
        parent::tearDown();
        // 完了後のクリーンアップ
        unset($this->component, $this->controller);
    }
}
