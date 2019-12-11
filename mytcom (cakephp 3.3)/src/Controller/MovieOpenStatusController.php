<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MovieOpenStatus Controller
 *
 * @property \App\Model\Table\MovieOpenStatusTable $MovieOpenStatus
 */
class MovieOpenStatusController extends AppController
{

    // 選択しているメニューを管理する変数
    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'Common', 'PageControl', 'MovieFolder'];

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
        //message session
        $this->set('abssmessage', $this->request->session()->consume('message'));
        //handling foreach device
        if ($this->deviceTypeId != 1) {
            $this->indexSP();
        } else {
            $this->set('menu_now_flg', $this->menuNowFlg);
            $this->indexPc();
        }
    }

    /**
     * Index for PC display
     *
     * @return \Cake\Network\Response|null
     */
    private function indexPc()
    {
        $session = $this->request->session();
        $userSeq = $session->read('UserData.user_seq');
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');

        //finish open status
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['delete'])) {
                $dataForDelete = $this->request->data;
                $openType = ($dataForDelete['mov_mode'] == 0) ? 4 : 5;
                //start delete open status
                $this->LogMessage->logMessage("12050", $userSeq);
                $this->Common->deleteOpenDataInfo($userSeq, $this->request->data, $openType);
                //finish delete openstatus
                $session->write('abssmessage', "公開を終了しました。");
                $this->LogMessage->logMessage("12051", $userSeq);
                $this->set('abssmessage', $session->consume('abssmessage'));
            }
        }

        // get left menu
        $mFolderList = $this->MovieFolder->getFolderInfo($userSeq, '');
        $this->set('movieFolderList', $mFolderList);

        //movie folder id
        $mFolderId = (!empty($this->request->query('mid'))) ? $this->request->query('mid') : $session->read("movie_folder_id");
        $this->set('mid', $mFolderId);

        // get movie folder name by id
        $openFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openfname', $openFName);

        //Create movie contents array
        $movieList = $movieContents->getMovieList($userSeq, $mFolderId);

        //display update list
        $modify = array();
        $modify['all'] = "全て表示";
        $modify['all_con'] = "フォルダ一式";
        $movKeyRv = array_reverse(array_keys($movieList));
        $keys = array_keys($movieList);
        $values = array_values($movieList);

        $rv = array_reverse($values);
        $movRv = array_combine(array_reverse($keys), $rv);
        $allContentsList = array_combine(array_merge(array_keys($modify), $movKeyRv), array_merge($modify, $movRv));
        $this->set('contents', $allContentsList);

        //prepare open status data
        $openData = $this->makeDisplayOpenInfo($userSeq, $mFolderId, $movieList);

        // exist data
        $this->set("selectedMovie", "all_con");
        if ($this->request->query('cid') || $this->request->query('cid') == 0) {
            $page = $this->PageControl->pageCtl($this->request->query('page') ? $this->request->query('page') : null, $openData, 1000);
            $this->set('data', $page['show_data']);
            $this->set("selectedMovie", $this->request->query('cid'));
        }
        // back button setting
        if (preg_match("/list/isx", $this->request->env('HTTP_REFERER'))) {
            $this->set('backUrl', '/movie/list.html?' . $this->cashe);
        } else {
            $this->set('backUrl', '/movie/preview.html?mid=' . $mFolderId . '&' . $this->cashe);
        }
    }

    /**
     * Index for SP display
     *
     * @return \Cake\Network\Response|null
     */
    private function indexSP()
    {
        $session = $this->request->session();
        $userSeq = $session->read('UserData.user_seq');
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');

        $mFolderId = (!empty($this->request->query('mid'))) ? $this->request->query('mid') : $session->read("movie_folder_id");
        $this->set('mid', $mFolderId);

        // get movie folder name by id
        $openFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openfname', $openFName);

        //Create album contents array
        $movieList = $movieContents->getMovieList($userSeq, $mFolderId);

        //display update list
        $modify = array();
        $modify['all'] = "全て表示";
        $modify['all_con'] = "フォルダ一式";
        $allContentsList = array_combine(array_merge(array_keys($modify), array_keys($movieList)), array_merge($modify, $movieList));
        $this->set('contents', $allContentsList);

        //prepare open status data
        $openData = $this->makeDisplayOpenInfo($userSeq, $mFolderId, $movieList);

        //check exist data
        $this->set("selectedMovie", "all_con");
        if ($this->request->query('cid') || $this->request->query('cid') == 0) {
            $page = $this->PageControl->pageCtl($this->request->query('page'), $openData, 10);
            $this->set('data', $page['show_data']);
            $this->set('next', $page['next']);
            $this->set("selectedMovie", $this->request->query('cid'));
        }

        // back button setting
        if ($this->request->query('back') != null) {
            $this->request->session()->write('back', $this->request->query('back'));
            $this->request->session()->write("backUrl", $this->request->env('HTTP_REFERER'));
        }
        $this->set('backFlg', $this->request->session()->read('back'));
        $this->set('backUrl', $this->request->session()->read('backUrl'));
    }

    /**
     * show more list open status data  for SP display
     *
     */
    public function showMoreMovieOpenStatus()
    {
        $session = $this->request->session();
        $userSeq = $session->read('UserData.user_seq');
        $mFolderId = (!empty($this->request->query('mid'))) ? $this->request->query('mid') : $session->read("movie_folder_id");
        $movieContents = TableRegistry::get('MovieContents');

        $this->set('mid', $mFolderId);

        //Create album contents array
        $movieList = $movieContents->getMovieList($userSeq, $mFolderId);

        //prepare open status data
        $openData = $this->makeDisplayOpenInfo($userSeq, $mFolderId, $movieList);

        // exist data
        $this->set("selectedMovie", "all_con");
        if ($this->request->query('cid') || $this->request->query('cid') == 0) {
            $page = $this->PageControl->pageCtl($this->request->query('page'), $openData, 10);
            $this->set('data', $page['show_data']);
            $this->set('next', $page['next']);
            $this->set("selectedMovie", $this->request->query('cid'));
        }
        // back button setting
        $this->set('backFlg', $this->request->session()->read('back'));
        $this->set('backUrl', $this->request->session()->read('backUrl'));
        if ($this->deviceTypeId == 2) {
            $this->render('Iphone.MovieOpenStatus/showMoreMovieOpenStatus');
        } elseif ($this->deviceTypeId == 3) {
            $this->render('Android.MovieOpenStatus/showMoreMovieOpenStatus');
        }
    }

    /**
     * prepare data display open status
     *
     * @return $openData
     */
    private function makeDisplayOpenInfo($userSeq, $mFolderId, $movieList)
    {
        $targetUserTbl = TableRegistry::get('TargetUser');
        $openStatusTbl = TableRegistry::get('OpenStatus');
        //choice to display open infomation
        //select all to display
        $openData = $openStatusTbl->getAllOrderByCloseDate($userSeq, $mFolderId, 4);
        if (count($movieList) > 0) {
            if ($this->request->query('cid') == "all") {
                $contentsArray = array_keys($movieList);
                $tmpVal = $openStatusTbl->getOpenDistinctStatus($contentsArray, $userSeq, 5);
                if (count($tmpVal) > 0) {
                    for ($i = 0; $i < count($tmpVal); $i++) {
                        array_push($openData, $tmpVal[$i]);
                    }
                }
                //select 1 specific video
            } else {
                $tmpVal = $openStatusTbl->getAllOrderByOpenStatus($userSeq, $this->request->query('cid'), 5);
                if (count($tmpVal) > 0) {
                    for ($i = 0; $i < count($tmpVal); $i++) {
                        array_push($openData, $tmpVal[$i]);
                    }
                }
            }
        }

        //Create data open
        for ($i = 0; $i < count($openData); $i++) {
            $mailAddress = $targetUserTbl->getAllTargetUserDate($openData[$i]['open_id'], $userSeq);
            $openData[$i]['target_mail'] = $mailAddress;
            if ($openData[$i]['open_type'] == 5) {
                $fileList = $openStatusTbl->getOpenContentList($openData[$i]['open_id'], $userSeq);
                $openData[$i]['open_info'] = $fileList;
            }
        }
        return $openData;
    }

}
