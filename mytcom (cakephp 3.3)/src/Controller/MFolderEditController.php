<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Validation\NoptBaseValidator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * MFolderEdit Controller
 *
 * @property \App\Model\Table\MFolderEditTable $MFolderEdit
 * @property LogMessageComponent LogMessage
 * @property MovieFolderComponent MovieFolder
 */
class MFolderEditController extends AppController
{

    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'MovieFolder'];

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
        if ($this->request->is('post')) {
            // log start editing movie folder
            $this->LogMessage->logMessage("10041", $this->userInfo['user_seq']);
        }
        // テンプレート出力情報の設定
        $this->set('menu_now_flg', $this->menuNowFlg);
        $this->set('previousUrl', $this->previousUrl);
        //message sesstion
        $this->set('message', $this->request->session()->consume('message'));
        if ($this->deviceTypeId == 1) {
            $mFolderList = $this->MovieFolder->getFolderInfo($this->userInfo['user_seq'], 'old');
            $this->set('movieFolderList', $mFolderList);
        }

        $mFolderTbl = TableRegistry::get('MovieFolder');
        if ($this->request->is('get') && $this->request->query('mid')) {
            $mid = $this->request->query('mid');
            $mFolder = $mFolderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $mid);
            if (!empty($mFolder)) {
                $this->set('currentFolder', $mFolder[0]);
            } else {
                //movie folder not found
                $this->LogMessage->logMessage("10047", $this->userInfo['user_seq']);
                $this->request->session()->write('message', '編集対象の動画フォルダが存在しません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
            }
        }

        $status = 0;
        $errors = null;
        if ($this->request->is('post') && $this->request->data('mid')) {
            $status = 1;
            $mid = $this->request->data('mid');
            $mFolder = $mFolderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $mid);
            if (!empty($mFolder)) {
                $this->set('currentFolder', $mFolder[0]);
            } else {
                //no found movie folder
                $this->LogMessage->logMessage("10047", $this->userInfo['user_seq']);
                $this->request->session()->write('message', '編集対象の動画フォルダが存在しません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
            }

            //validate $_POST data
            $isValidated = true;
            $validator = $this->MovieFolder->validationDefault(new NoptBaseValidator());
            //ネストされたバリデータからのエラーを含むすべてのエラーを取得する
            $arr = $this->request->data();
            $arr['bypass'] = ['movie_folder_name' => true];
            $errors = $validator->errors($arr);
            if ($errors) {
                $this->set('errors', $errors);
                $isValidated = false;
            }
            $this->set('movieFolderName', $this->request->data('movie_folder_name'));
            $this->set('movieFolderComment', $this->request->data('movie_folder_comment'));
            if ($isValidated) {
                $mFolderName = $this->request->data('movie_folder_name');
                $mFolderComment = $this->request->data('movie_folder_comment');
                $result = $this->MovieFolder->updateMovieFolderData(intval($mid), $this->userInfo['user_seq'], $mFolderName, $mFolderComment);
                if ($result == -1) {
                    //error DB
					$this->LogMessage->logMessage("10043", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', 'アップデートに失敗しました。');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/edit.html?' . $this->cashe);
                } elseif ($result == 0) {
                    //no found movie folder
					$this->LogMessage->logMessage("10047", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '編集対象の動画フォルダが存在しません。');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                } else {
                    //log complete editing movie
                    $this->LogMessage->logMessage("10042", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', sprintf(Configure::read('Common.update'), '動画フォルダ'));
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $mid . '&' . $this->cashe);
                }
            }
        }
        $this->set('mid', $mid);
        $this->set('status', $status);
    }
}
