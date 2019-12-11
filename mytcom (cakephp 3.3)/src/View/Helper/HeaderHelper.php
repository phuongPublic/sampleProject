<?php

/**
 * ヘッダ向けヘルパー
 *
 * @copyright (c) 2016, TOKAI Communications Corporation All rights reserved.
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;
use Cake\View\View;

/**
 * ヘッダーヘルパークラス
 *
 */
class HeaderHelper extends Helper
{

    /**
     * ユーザ名の部分を応答するメソッド
     *
     * @return type
     */
    public function getUsername()
    {
        // セッション情報読み込み
        $userMst = $this->request->session()->read('UserData');

        // ユーザ名が設定されている場合はユーザ名を返却
        if (isset($userMst['user_name']) && !empty($userMst['user_name'])) {
            return $userMst['user_name'];
        }

        // メールアドレスを返却する
        return $userMst['user_address'];
    }

    /**
     * get user address
     *
     * @return string
     */
    public function getUserAddress()
    {
        // セッション情報読み込み
        $userMst = $this->request->session()->read('UserData');

        // ユーザ名が設定されている場合はユーザ名を返却
        if (isset($userMst['user_address'])) {
            return $userMst['user_address'];
        }

        // メールアドレスを返却する
        return $userMst['user_address'];
    }

    /**
     * ユーザのディスク使用量を応答するメソッド
     *
     * @return type
     */
    public function getUseCapacity()
    {
        // セッション情報読み込み
        $userMst = $this->request->session()->read('UserData');
        // 使用量の表示は、小数点を切り上げる。
        $view = new View();
        $commonHelper = new CommonHelper($view);
        return $commonHelper->modifierByte($userMst['AmountDataSize']);
    }

    /**
     * ユーザのディスク使用量割合を応答するメソッド
     *
     * @return type
     */
    public function getUseCapacityPercent()
    {
        // セッション情報読み込み
        $userMst = $this->request->session()->read('UserData');

        // ディスク使用率の算出
        $usePercent = ceil(($userMst['AmountDataSize'] / Configure::read('Common.DiskSize') * 100)) . '%';

        return $usePercent;
    }

    /**
     * サービスの契約容量の文字列を応答するメソッド
     *
     * @return type
     */
    public function getContractCapacityStr()
    {
        return Configure::read('Common.DiskSizeStr');
    }

    /**
     * サービスの契約容量の文字列を応答するメソッド
     *
     * @return type
     */
    public function getTitleStr($titleId)
    {
        $title = Configure::read('Common.PageTitle');

        return $title[$titleId];
    }

}
