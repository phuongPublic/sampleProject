<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\AppController;

/**
 * MovieOpenDetail Controller
 *
 */
class MovieOpenDetailController extends AppController
{

    // 使用するComponentの定義
    public $components = ['LogMessage', 'Common'];

    /**
     * クラス初期化処理用メソッド
     *
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $session = $this->request->session();
        $userData = $session->read('UserData');
        $mFolderId = $this->request->query('mid') ? $this->request->query('mid') : $this->request->data['mid'];
        // フォルダ一式を選択した場合
        $openStatusTbl = TableRegistry::get('OpenStatus');
        $opType = $this->request->query('type');
        if ($this->request->is('post')) {
            $dataPost = $this->request->data;
            $this->LogMessage->logMessage("12050", $userData['user_seq']);
            $this->Common->deleteOpenDataInfo($userData['user_seq'], $dataPost, $opType);
            $this->LogMessage->logMessage("12051", $userData['user_seq']);
            $session->write("message", "公開を終了しました。");
            $url = $this->deviceName[$this->deviceTypeId] . "/movie/open/status.html?mid=" . $dataPost['mid'] . "&cid=all";
            return $this->redirect($url);
        }
        $result = $openStatusTbl->getAllOrderByCloseDateSP($userData['user_seq'], $opType, $this->request->query('id'));
        for ($i = 0; $i < count($result); $i++) {
            $targetUserTbl = TableRegistry::get('TargetUser');
            $mailAddress = $targetUserTbl->getAllTargetUserDate($result[$i]['open_id'], $userData['user_seq']);
            $result[$i]['target_mail'] = $mailAddress;
            if ($result[$i]['open_type'] == 5) {
                // 動画名とダウンロード回数を取得する。
                $fileList = $openStatusTbl->getOpenContentList($result[$i]['open_id'], $userData['user_seq']);
                $result[$i]['open_info'] = $fileList;
            }
        }
        $this->set("data", $result);
        $movieFolder = TableRegistry::get('MovieFolder');
        // get movie folder name by id
        $openFName = $movieFolder->getFolderNameById($userData['user_seq'], intval($mFolderId));
        $this->set('openfname', $openFName);
        $this->set("mid", $mFolderId);
        $this->set('userData', $userData);
        $this->set("cid", $this->request->query('cid'));
        $this->set("message", $session->consume('message'));
    }
}
