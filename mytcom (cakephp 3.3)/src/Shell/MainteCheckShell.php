<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * ThumbnailGenerator shell command.
 */
class MainteCheckShell extends Shell
{

    public $tasks = ['AdminMainte', 'LogMessage'];

    //処理１．クーロン開始
    public function start()
    {
        $mainteTbl = TableRegistry::get("Mainte");
        //処理２ : メンテナンス情報取得
        $mainteInfo = $mainteTbl->getMainteStartReservationInfo();
        //処理概要２のデータが存在する場合、概要処理３を実施する
        //処理３．メンテナンス開始処理
        foreach ($mainteInfo as $data) {
            $this->AdminMainte->beginMaintenance($data['mainte_body']);
        }

        //処理４．メンテナンス開始中情報取得
        $maintePublic = $mainteTbl->getMainteDuringStartInfo();
        //処理概要４のデータが存在する場合、概要処理５を実施する
        //処理5．メンテナンス開始処理
        foreach ($maintePublic as $data) {
            $this->AdminMainte->beginMaintenance($data['mainte_body']);
        }

        //処理６．メンテナンス終了情報取得
        $mainteFinish = $mainteTbl->getMainteFinishInfo();
        //　処理概要６のデータが存在する場合、概要処理７～１１を実施する
        if (!empty($mainteFinish)) {
            //処理７．メンテナンス終了対象情報を取得
            $objMainteUpdate = $mainteTbl->getMainteFinishDataForUpdate();
            //処理概要７のデータが存在する場合、概要処理８～１０を実施する
            if (!empty($objMainteUpdate)) {
                //処理8.9.10.11メンテナンス終了へ更新
                $this->AdminMainte->endMaintenance($objMainteUpdate);
            }
        }

        //処理１２．メンテナンス開始中情報取得
        $objMainte = $mainteTbl->getMainteFinishData();
        //処理概要12のデータが存在しない場合、概要処理13を実施する
        if (empty($objMainte)) {
            //処理 １３．メンテナンス終了処理
            $this->AdminMainte->copyHtaccessFileToEndMainte();
        }
    }
}
