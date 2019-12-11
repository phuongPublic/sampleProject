<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * MFolderDelete Controller
 *
 * @property \App\Model\Table\MFolderDeleteTable $MFolderDelete
 */
class MFolderDeleteController extends AppController
{

    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'Common', 'MovieFolder', 'Movie'];

    /**
     * クラス初期化処理用メソッド
     *
     */
    public function initialize()
    {
        parent::initialize();

        // ファイル管理を選択状態とする。
        $this->menuNowFlg = 6;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $userSeq = $this->userInfo['user_seq'];
        $this->set('menu_now_flg', $this->menuNowFlg);
        $this->set('previousUrl', $this->previousUrl);
        if ($this->request->is('post')) {
            $movieFolderId = $this->request->data('del');
            $movieFolderId = $movieFolderId[0];
            if ($movieFolderId != 1) {
                // log start deleting movie folder
                $this->LogMessage->logMessage("10044", $userSeq);
                $deleteAction = $this->MovieFolder->deleteMovieFolderData($userSeq, $movieFolderId);
                if ($deleteAction == -1) {
                    //error DB
                    $this->LogMessage->logMessage('10046', $userSeq);
                    $this->request->session()->write('message', '削除に失敗しました｡');
                } elseif ($deleteAction == 0) {
                    //movie folder not found
                    $this->LogMessage->logMessage('10050', $userSeq);
                    $this->request->session()->write('message', '削除対象の動画フォルダが存在しません｡');
                } else {
                    //delete success
                    $this->LogMessage->logMessage('10045', $userSeq);
                    $this->request->session()->write('message', sprintf(Configure::read('Common.delete'), '動画フォルダ'));
                }
            }
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
        } else {
            // load page
            $total = $this->MovieFolder->getAllMovieFolderData($userSeq);
            $this->set('movieFolderList', $total);
            $movieFolderId = intval($this->request->query('mid'));
            $mFolderTbl = TableRegistry::get('MovieFolder');
            $movieFolder = $mFolderTbl->getSingleMovieFolderData($userSeq, $movieFolderId);
            if (isset($movieFolder[0])) {
                $this->set('data', array($movieFolder[0]));
            } else {
                $this->set('data', array());
                //movie folder not found
                $this->LogMessage->logMessage('10050', $userSeq);
                $this->request->session()->write('message', '削除対象の動画フォルダが存在しません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
            }
            $movieContentsTbl = TableRegistry::get('MovieContents');
            $amount = $movieContentsTbl->getMovieCapacity($userSeq, $movieFolderId);
            $this->set('amount', $amount);
            $this->set('mid', $movieFolderId);
        }
    }
}
