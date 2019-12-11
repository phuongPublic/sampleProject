<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Exception;
use Cake\Utility\Security;

define('AUTH_MAGIC', 'geagakaephoudrapouuaecliwrousliodrunapia');
/** 認証方式 */
define('AUTH_TYPE', "HMAC");
define('PASSWORD_HASH_ALGOS', 'sha256');

/**
 * Common component
 */
class UtilsComponent extends Component
{
    public $components = ['TextPassword'];


    /**
     * ランダムな文字列を取得する
     *
     * @param  integer $length 文字数
     * @return string  ランダムな文字列
     */
    public function getRandomString($length = 1)
    {
        return $this->TextPassword->create($length);
    }

    /**
     * パスワードのハッシュ化
     *
     * @param  string $str 暗号化したい文言
     * @param  string $salt salt
     * @return string ハッシュ暗号化された文字列
     */
    public function getHashString($str, $salt)
    {
        if ($salt == '') {
            $salt = AUTH_MAGIC;
        }
        if (AUTH_TYPE == 'PLAIN') {
            $res = $str;
        } else {
            $res = hash_hmac(PASSWORD_HASH_ALGOS, $str . ':' . AUTH_MAGIC, $salt);
        }

        return $res;
    }

    /* 一意かつ予測されにくいID */

    public function getUniqRandomId($head = '')
    {
        // 予測されないようにランダム文字列を付与する。
        $random = $this->makePassword(8);
        // 同一ホスト内で一意なIDを生成
        $id = uniqid($head);

        return $id . $random;
    }

    /*----------------------------------------------------------------------
     * [名称] makePassword
     * [概要] ランダムパスワード生成（英数字）
     * [引数] パスワードの桁数
     * [戻値] ランダム生成されたパスワード
     * [依存] なし
     * [注釈] -
     *----------------------------------------------------------------------*/
    /**
     * @param integer $pwLength
     */
    public function makePassword($pwLength)
    {
        // 乱数表のシードを決定
        srand((double)microtime() * 54234853);

        // パスワード文字列の配列を作成
        $character = 'abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ2345679';
        $pw = preg_split('//', $character, 0, PREG_SPLIT_NO_EMPTY);

        $password = '';
        for ($i = 0; $i < $pwLength; $i++) {
            $password .= $pw[array_rand($pw, 1)];
        }

        return $password;
    }

    /**
     * パスワード文字列のハッシュ一致判定
     *
     * @param  string $pass 確認したいパスワード文字列
     * @param  string $hashpass 確認したいパスワードハッシュ文字列
     * @param  string $salt salt
     * @return boolean 一致判定
     */
    public function isMatchHashPassword($pass, $hashpass, $salt)
    {
        $res = false;
        if ($hashpass != '') {
            if (AUTH_TYPE == 'PLAIN') {
                if ($pass === $hashpass) {
                    $res = true;
                }
            } else {
                if (empty($salt)) {
                    // 旧バージョン(2.11未満)からの移行を考慮
                    $hash = sha1($pass . ':' . AUTH_MAGIC);
                } else {
                    $hash = $this->getHashString($pass, $salt);
                }
                if ($hash === $hashpass) {
                    $res = true;
                }
            }
        }

        return $res;
    }


}
