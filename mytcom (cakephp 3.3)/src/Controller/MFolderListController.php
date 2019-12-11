<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * MFolderList Controller
 *
 * @property \App\Model\Table\MFolderListTable $MFolderList
 */
class MFolderListController extends AppController
{

    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['Common', 'UserMst', 'Movie', 'MovieFolder', 'PageControl', 'OpenStatus'];

    /**
     * クラス初期化処理用メソッド
     *
     */
    public function initialize()
    {
        parent::initialize();

        // ファイル管理を選択状態とする。
        $this->menuNowFlg = 6;
        $this->set('menu_now_flg', $this->menuNowFlg);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //message session
        $this->set('message', $this->request->session()->consume('message'));

        //handling foreach device
        if ($this->deviceTypeId == 1) {
            $this->pc();
        } else {
            $this->smartPhone();
        }
    }

    /**
     * pc method
     * process if user agent is pc
     * @return \Cake\Network\Response|null
     */
    private function pc()
    {
        // 動画フォルダデータを取得する。
        $total = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        // 0件なら初期フォルダを登録する。
        if (count($total) == 0) {
            // フォルダIDを生成する。
            $movieFolderTbl = TableRegistry::get('MovieFolder');
            $nextId = $movieFolderTbl->selectNextId($this->userInfo['user_seq']);
            // 初期フォルダ生成
            $this->MovieFolder->insertFolderData($nextId, $this->userInfo['user_seq']);
            // 動画フォルダデータを再取得する。
            $total = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        }
        $modify = array();
        for ($i = 0; $i < count($total); $i++) {
            $openFlg = false;
            $movieTbl = TableRegistry::get('MovieContents');
            $movieContents = $movieTbl->getContentsByMovie($this->userInfo['user_seq'], $total[$i]['movie_folder_id']);
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $openStatusFolder = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $total[$i]['movie_folder_id'], '4');
            //ステータス設定
            if (count($openStatusFolder) > 0) {
                $openFlg = true;
            }
            if (count($movieContents) != 0 && $openFlg == false) {
                for ($j = 0; $j < count($movieContents); $j++) {
                    $openStatusMovie = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $movieContents[$j]['movie_contents_id'], '5');
                    if (count($openStatusMovie) > 0) {
                        $openFlg = true;
                        break;
                    }
                }
            }
            $moviePreviewData = $this->PageControl->pageCtl(null, $movieContents, 5);
            $data = $moviePreviewData['show_data'];
            $modify[$total[$i]['movie_folder_id']]['movie'] = $data;
            $total[$i]['open_status'] = $openFlg;
        }

        $this->set("contents", $modify);
        $this->set('movieFolderList', $total);
    }

    private function smartPhone()
    {
        // 動画フォルダデータを取得する。
        $movieFolderList = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        // 0件なら初期フォルダを登録する。
        if (count($movieFolderList) == 0) {
            // フォルダIDを生成する。
            $next_id = $this->Movie->selectNextId($this->userInfo['user_seq']);
            // 初期フォルダ生成
            $this->Movie->insertFolderData($next_id, $this->userInfo['user_seq']);
            // 動画フォルダデータを再取得する。
            $movieFolderList = $this->Movie->getAllMovieFolderData($this->userInfo['user_seq']);
        }
        $pageData = $this->PageControl->pageCtl(null, $movieFolderList, Configure::read('Movie.SPMovieFolderLimit'));
        $data = $pageData['show_data'];
        //$this->set('data', $data);
        $this->set('pageData', $pageData);
        $modify = array();
        for ($i = 0; $i < count($data); $i++) {
            $openFlg = false;
            $dataSize = 0;
            $movieTbl = TableRegistry::get('MovieContents');
            $movieContents = $movieTbl->getContentsByMovie($this->userInfo['user_seq'], $data[$i]['movie_folder_id']);
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $openStatusFolder = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $data[$i]['movie_folder_id'], '4');
            //ステータス設定
            if (count($openStatusFolder) > 0) {
                $openFlg = true;
            }
            if (count($movieContents) != 0) {
                for ($j = 0; $j < count($movieContents); $j++) {
                    $openStatusMovie = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $movieContents[$j]['movie_contents_id'], '5');
                    if (count($openStatusMovie) > 0) {
                        $openFlg = true;
                    }
                    $dataSize += $movieContents[$j]['amount'];
                }
            }
            $modify[$data[$i]['movie_folder_id']]['movie'] = $movieContents;
            $data[$i]['open_status'] = $openFlg;
            $data[$i]['datasize'] = $dataSize;
        }

        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $folderNameList = $movieFolderTbl->getMovieFolderName($this->userInfo['user_seq']);
        $this->set('folderNameList', $folderNameList);
        $this->set("contents", $modify);
        $this->set("fdata", $data);
    }

    public function showMoreMovieFolder()
    {
        $page = $this->request->query('page');

        // 動画フォルダデータを取得する。
        $movieFolderList = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);

        $pageData = $this->PageControl->pageCtl($page, $movieFolderList, Configure::read('Movie.SPMovieFolderLimit'));
        $data = $pageData['show_data'];
        //$this->set('data', $data);
        $this->set('pageData', $pageData);
        $modify = array();
        foreach ($data as $id => $folder) {
            $openFlg = false;
            $dataSize = 0;
            $movieTbl = TableRegistry::get('MovieContents');
            $movieContents = $movieTbl->getContentsByMovie($this->userInfo['user_seq'], $folder['movie_folder_id']);
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $openStatusFolder = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $folder['movie_folder_id'], '4');
            //ステータス設定
            if (count($openStatusFolder) > 0) {
                $openFlg = true;
            }
            if (count($movieContents) != 0) {
                for ($j = 0; $j < count($movieContents); $j++) {
                    $openStatusMovie = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $movieContents[$j]['movie_contents_id'], '5');
                    if (count($openStatusMovie) > 0) {
                        $openFlg = true;
                    }
                    $dataSize += $movieContents[$j]['amount'];
                }
            }
            $modify[$data[$id]['movie_folder_id']]['movie'] = $movieContents;
            $data[$id]['open_status'] = $openFlg;
            $data[$id]['datasize'] = $dataSize;
        }
        $this->set("contents", $modify);
        $this->set("fdata", $data);
        $this->set("page", $page + 1);
        if ($this->deviceTypeId == 2) {
            $this->render('Iphone.MFolderList/showMoreMovieFolder');
        } elseif ($this->deviceTypeId == 3) {
            $this->render('Android.MFolderList/showMoreMovieFolder');
        }
    }
}
