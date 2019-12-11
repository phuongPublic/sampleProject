<?php

namespace App\Test\TestCase\Controller;

use App\Controller\AddressListviewController;
use App\Test\TestCase\NoptIntegrationTestCase;
use ReflectionMethod;
use ReflectionClass;

/**
 * App\Controller\AddressListviewController Test Case
 */
class AddressListviewControllerTest extends NoptIntegrationTestCase
{

    protected $redirectUrl1 = '/address/listview.html'; //通常遷移
    protected $redirectUrl2 = '/address/export.html'; //通常遷移
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
     * covers AddressListviewController::index
     *
     * @test
     *
     * @return void
     */
    public function index()
    {
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->get($this->testUrl. '?category=1&categoryKeyword=1');
        $this->assertResponseCode(200);

        // total page >
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->get($this->testUrl . '?pg=100');
        $this->assertResponseCode(302);
        $this->assertRedirectContains($this->redirectUrl1 . '?pg=1'); // リダイレクト先URLの確認

        // export case checkedAddress not exist
        $data = [
            'export' => '1',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認

        // export case checkedAddress not exist
        $data = [
            'optSearch' => '1',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);

        // export case checkedAddress exist
        $data = [
            'export' => '1',
            'checkedAddress' => 'checkedAddress',
            'category' => 'category',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertRedirectContains($this->redirectUrl2); // リダイレクト先URLの確認

        // delete case checkedAddress checkedGroup not exist
        $data = [
            'delete' => '1',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        // delete case checkedAddress checkedGroup exist
        $data = [
            'delete' => '1',
            'checkedAddress' => array(),
            'checkedGroup' => array(),
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
        // Search data
        $data = [
            'category' => 1,
            'categoryKeyword' => '',
        ];
        $this->loadCsvFixture ( 'app.AddressData', 'address_data.csv', 'UTF-8' );
        $this->post($this->testUrl, $data);
        $this->assertResponseCode(200);
    }

    /**
     * Test getAddressList method
     * covers AddressListviewController::getAddressList
     *
     * @test
     *
     * @return void
     */
    // TODO Componentに処理をうつすこと検討してください。また今のアクセス修飾子を使うと直接アクセス出来ます。
    // Componentが長くなりすぎて可読性が悪いなどありましたら、相談してComponentを増やすなどを検討するようにしてください。
    // Componentを分割するのは悪いことではないです。必要なもののみControllerでインスタンス化($componentに指定)出来れば結果としてよくなります。
    // 品質を保つ上で、処理としてテストが切り出し出来た方がテストパターンを増やせます。
    // 右記のアドレスにアクセスしてください http://localhost:9002/AddressListView/getAddressList?&c=85bf7b22d6fda34a5245b8a2f43dba29
    // エラー画面に遷移しています⇒12/07時点のapp.phpの設定ではErrorログが出力される。⇒ログ監視にてアラートがあがる⇒対応を促される
    // アクセス修飾子がpublicの関数はControllerの内部処理の箇所には記載しないでください。nginxにrewriteに対応するものがないので、apacheを自端末以外からアクセスさせないことで回避出来ますが
    // 完全に対応できるものではないです。
    // 個人的な好みで好きではないですが、みたところ「return list($searchKeyword,$addressList);」を返却するカタチで関数に出来るかと思います。
    public function getAddressList()
    {
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->loadFixtures('GroupTbl');
        $reflectionMethod = new ReflectionMethod('App\Controller\AddressListviewController', 'getAddressList');
        $reflectionMethod->setAccessible(true);

        // カテゴリ1, キーワードなし
        $this->assertCount(14, $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 1, '']));

        // カテゴリ1, キーワードあり(データあり)
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 1, 'test1@bip.co.jp']);
        // 該当IDのデータが存在すること確認
        $this->assertCount(1, $result);
        $this->assertEquals(701, $result [0] ['adrdata_seq']);

        // カテゴリ1, キーワードあり(データなし)
        $this->loadCsvFixture('app.AddressData', 'empty_address_data.csv', 'UTF-8');
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 1, 'test1@bip.co.jp']);
        $this->assertEquals(null, $result);

        // カテゴリ2, キーワードなし
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->assertCount(14, $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 2, '']));

        // カテゴリ2, キーワードあり
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 2, 'あだな2']);
        $this->assertCount(1, $result);
        $this->assertEquals(702, $result[0]['adrdata_seq']);

        // カテゴリ2, キーワードあり(データなし) ※ただしパターンとして必要ないものと推測される
        $this->loadCsvFixture('app.AddressData', 'empty_address_data.csv', 'UTF-8');
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 2, 'test1@bip.co.jp']);
        $this->assertEquals(null, $result);

        // カテゴリ3(存在しないカテゴリー), キーワードなし ※ただしパターンとして必要ないものと推測される
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->assertCount(14, $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 3, ''])); // この動きを正とした場合。私見では正

        // カテゴリ3(存在しないカテゴリー), キーワードあり
        $this->assertCount(14, $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 3, 'あだな1'])); // この動きを正とした場合。私見では正

        // カテゴリ3, キーワードあり(データなし)
        $this->loadCsvFixture('app.AddressData', 'empty_address_data.csv', 'UTF-8');
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, 3, 'test1@bip.co.jp']);
        $this->assertTrue(is_array($result));

        // カテゴリなし, キーワードなし
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $this->assertCount(14, $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, '', '']));

        // ただしパターンとして必要ないものと推測される
        // カテゴリなし, キーワードあり
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, '', 'あだな1']);
        $this->assertCount(14, $result); // この動きを正とした場合。私見では正

        // カテゴリなし, キーワードなし
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq, '', '']);
        $this->assertCount(14, $result);

        // 該当するユーザの情報がない場合
        // カテゴリなし, キーワードなし
        $result = $reflectionMethod->invokeArgs(new AddressListviewController(), [$this->testUserSeq . 'exclude', '', '']);
        $this->assertEmpty($result);
    }

    /**
     * Test paging method
     * covers AddressListviewController::paging
     *
     * @test
     *
     * @return void
     */
    // TODO Componentに処理をうつすこと検討してください。
    // 関数内でPageControlComponentの関数を呼び出しているので、PageControlComponentに移動後この関数のテストを実施すればPageControllComponentのpageCtl関数テストは必要がなくなると思います。
    public function paging()
    {
        $this->loadCsvFixture('app.AddressData', 'address_data.csv', 'UTF-8');
        $reflectionMethod = new ReflectionMethod('App\Controller\AddressListviewController', 'paging');
    }


    /**
     * 対象のデータを固定でセッションに格納
     *
     * @return void
     */
    protected function setSession()
    {
    }
}
