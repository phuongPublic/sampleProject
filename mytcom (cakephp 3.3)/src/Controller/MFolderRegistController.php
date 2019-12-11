<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Validation\NoptBaseValidator;
use Cake\ORM\TableRegistry;

/**
 * MFolderRegist Controller
 *
 * @property \App\Model\Table\MFolderRegistTable $MFolderRegist
 * @property MovieFolderComponent MovieFolder
 * @property LogMessageComponent LogMessage
 */
class MFolderRegistController extends AppController
{

    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'MovieFolder'];

    /**
     * クラス初期化処理用メソッド
     *
     */
    public function initialize()
    {
        parent::initialize();

        // 動画管理を選択状態とする。
        $this->menuNowFlg = 6;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('menu_now_flg', $this->menuNowFlg);
        $this->set('previousUrl', $this->previousUrl);
        if ($this->deviceTypeId == 1) {
            $mFolderList = $this->MovieFolder->getFolderInfo($this->userInfo['user_seq'], 'old');
            $this->set('movieFolderList', $mFolderList);
        }
        $status = 0;
        $errors = null;
        if ($this->request->is('post')) {
            // log started registering the folder
            $this->LogMessage->logMessage("10033", $this->userInfo['user_seq']);
            $status = 1;
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
                $movieFolderName = $this->request->data('movie_folder_name');
                $movieFolderComment = $this->request->data('movie_folder_comment');
                $result = true;
                $isOk = false;
                $mFolderTbl = TableRegistry::get('MovieFolder');
                for ($i = 0; $i < 3; $i++) {
                    if (!$isOk) {
                        $newId = $mFolderTbl->selectNextId($this->userInfo['user_seq']);
                        $folder = $mFolderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $newId);
                        if (!empty($folder)) {
                            $this->LogMessage->logMessage('10085', array($this->userInfo['user_seq'], $i + 1));
                        } else {
                            $result = $this->MovieFolder->insertFolderData($this->userInfo['user_seq'], $newId, $movieFolderName, $movieFolderComment);
                            $isOk = $result;
                            if ($result) {
                                break;
                            }
                        }
                    }
                    // if try 3 times
                    if ($i == 2 && !$isOk) {
                        $this->request->session()->write('message', "インサートに失敗しました｡");
                        // log registration processing of folder fails
                        $this->LogMessage->logMessage("10035", $this->userInfo['user_seq']);
                    }
                }
                if ($result) {
                    //set message session
                    $this->request->session()->write('message', "動画フォルダの作成が完了しました｡");
                    // log complete registering the folder
                    $this->LogMessage->logMessage("10034", $this->userInfo['user_seq']);
                }
                if ($this->deviceTypeId == 1) {
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $newId . $this->cashe);
                } else {
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                }
            }
        }
        $this->set('status', $status);
    }
}
