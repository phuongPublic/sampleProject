<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * 広告掲出ヘルパー
 *
 */
class AdvertisingHelper extends Helper
{
    /**
     * @param int $pubFlg 掲載サイト。1＝PC／2＝携帯
     * @param int $posFlg 表示位置。1=ヘッダー／2=コンテンツ内1／3=コンテンツ内2／4=コンテンツ内3／5=ヘッダー／6=コンテンツ内1／7=フッター
     * @param int $viewflg 公開フラグ。1＝公開／2＝下書き／3＝予約／4＝公開終了
     * @param int $timerflg 公開終了タイマー。1＝設定する／2＝設定しない
     * @param datetime $opendata 0000-00-00 00:00:00    公開日時
     * @param datetime $timerdata 公開終了日時
     * @param TIMESTAMP $update 更新日時
     * @param TIMESTAMP $regdate 0000-00-00 00:00:00    登録日時
     */
    public function AdPublish($pubFlg = null, $posFlg = null)
    {
//        必須の引数が空であれば処理を抜ける
        if (is_null($pubFlg) || is_null($posFlg)) {
            return false;
        }

//掲載サイトが１または２でないときは処理を抜ける
        $pubFl_list = Configure::read('Advertising.pubFl_list');
        if (!in_array($pubFlg, $pubFl_list)) {
            return false;
        }

//表示位置が指定外の値であれば処理を抜ける
        $position_list = Configure::read('Advertising.position_list');
        if (!in_array($posFlg, $position_list)) {
            return false;
        }

        $date = Time::now();
        $AdTbl = TableRegistry::get('AdTbl');
        $AdTbl_item = $AdTbl->find()
            ->where([['pub_flg' => $pubFlg], ['pos_flg' => $posFlg]])
            ->where(['viewflg' => 1])
            ->orWhere([['viewflg' => 3],
                'AND' => [['opendata <' => $date->i18nFormat('YYYY/MM/dd HH:mm:ss')],
                    ['pub_flg' => $pubFlg],
                    ['pos_flg' => $posFlg]]])
            ->where(['timerflg' => 2])
            ->orWhere([['timerflg' => 1],
                'AND' => [
                    ['timerdata >' => $date->i18nFormat('YYYY/MM/dd HH:mm:ss')],
                    ['opendata <' => $date->i18nFormat('YYYY/MM/dd HH:mm:ss')],
                    ['pub_flg' => $pubFlg],
                    ['pos_flg' => $posFlg]]])
            ->order(['adseq' => 'DESC'])
            ->first();

//検索結果があれば出力処理を行う
        $file_path = Configure::read('Advertising.file_path');
        $replace_path = Configure::read('Advertising.replace_path');
        if(!is_null($AdTbl_item)) {
            $AdTbl_item->toArray();
            if ($AdTbl_item['file_path'] !='') {
                $banner_path = str_replace($file_path, $replace_path, $AdTbl_item['file_path']);
                echo '<a href="' . $AdTbl_item['contents'] . '"><img src=' . $banner_path . '></a>';
            } else {
                echo $AdTbl_item['contents'];
            }
        }
    }

}
