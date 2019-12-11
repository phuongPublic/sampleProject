<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MovieOpenRegist Controller
 *
 * @property \App\Model\Table\MovieOpenRegistTable $MovieOpenRegist
 */
class MovieOpenRegistController extends AppController
{

    // 選択しているメニューを管理する変数
    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'Common', 'MovieFolder'];

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
        //handling foreach device
        if ($this->deviceTypeId != 1) {
            $this->indexSP();
        } else {
            $this->indexPc();
        }
        // テンプレート出力情報の設定
        $this->set('menu_now_flg', $this->menuNowFlg);
    }

    /**
     * Index for PC method
     *
     * @return \Cake\Network\Response|null
     */
    private function indexPc()
    {
        $userSeq = $this->request->session()->read('UserData.user_seq');
        $reqQuery = $this->request->query;
        $reqData = $this->request->data;
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');
        // get left menu
        $mFolderList = $this->MovieFolder->getFolderInfo($this->request->session()->read('UserData.user_seq'), '');
        $this->set('movieFolderList', $mFolderList);

        // clear old data
        if (!isset($reqQuery['return'])) {
            $this->request->session()->delete('inputdata');
            $this->request->session()->delete('MovieOpenSetting');
            $this->request->session()->write('returnLink', $this->previousUrl);
        }

        //Create data object
        $prepareData = array("nickname" => $this->request->session()->read('UserData.user_name'),
            "message" => "",
            "access_check" => "0",
            "mail" => array(),
            "close_date" => "3");

        //Set input data
        if ($this->request->session()->check('inputdata')) {
            $aOpenRegInput = $this->request->session()->consume('inputdata');
        } elseif ($this->request->session()->check('MovieOpenSetting')) {
            $aOpenRegInput = $this->request->session()->consume('MovieOpenSetting');
        } else {
            $aOpenRegInput = $prepareData;
        }

        //openFlag 4=movie folder 5=movie
        if (!empty($reqQuery['openflg'])) {
            $openFlag = $reqQuery['openflg'];
        } elseif (!empty($aOpenRegInput['open_flg'])) {
            $openFlag = $aOpenRegInput['open_flg'];
        } else {
            $openFlag = $reqData['open_flg'];
        }
        $this->set('openflg', $openFlag);

        //get movie folder id
        if (!empty($reqQuery['mid'])) {
            $mFolderId = $reqQuery['mid'];
        } elseif (!empty($aOpenRegInput['movie_folder_id'])) {
            $mFolderId = $aOpenRegInput['movie_folder_id'];
        } else {
            $mFolderId = $reqData['movie_folder_id'];
        }

        //check movie folder
        $movieFolderInf = $movieFolder->getSingleMovieFolderData($this->userInfo['user_seq'], $mFolderId);
        if (empty($movieFolderInf)) {
            $this->LogMessage->logMessage("12053", $this->userInfo['user_seq']);
            $this->request->session()->write('message', '公開対象の動画フォルダが存在しません｡');
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
        }

        if ($openFlag == 5) {
            $openMovieFile = isset($this->request->query['del'])? $this->request->query['del']:$this->request->session()->read('mfile_open');
            foreach ($openMovieFile as $movieFileId) {
                $movieFileDetail = $movieContents->getSingleMovieData($this->userInfo['user_seq'], $movieFileId);
                if (empty($movieFileDetail)) {
                    $this->LogMessage->logMessage("12054", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '公開対象の動画が存在しません｡');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                }
            }
        }

        $this->set('mid', $mFolderId);

        // get movie folder name by id
        $openMFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openMFolderName', $openMFName);

        //get user address
        $this->set('userAddress', $this->request->session()->read('UserData.user_address'));

        //Catch action click
        if ($this->request->is(['post', 'put'])) {
            //movie open regis -> change to confirm screen
            if (!empty($reqData['open_reg'])) {
                $aOpenRegInput = $reqData;
                $isValid = $this->Common->validate($aOpenRegInput);
                if (is_array($isValid)) {
                    $this->set('errorMessage', $isValid);
                } else {
                    $this->request->session()->write('inputdata', $aOpenRegInput);
                    $this->confirm();
                }
                //back from confirm screen
            } elseif (!empty($reqData['back_confirm'])) {
                $aOpenRegInput = $reqData;
                $this->request->session()->write('inputdata', $aOpenRegInput);
                //conmit and send mail regis open regis info
            } elseif (!empty($reqData['open_commit'])) {
                $aOpenRegInput = $reqData;
                //start commit
                $this->LogMessage->logMessage("12047", $userSeq);
                $this->Common->insertOpenData($userSeq, $aOpenRegInput['open_flg'], $aOpenRegInput);
                //finish commit
                $this->LogMessage->logMessage("12048", $userSeq);
                $this->request->session()->delete('mfile_open');
                $this->request->session()->write("message", '動画公開のご案内が送信されました。');
                return $this->redirect("movie/preview.html?&mid=" . $aOpenRegInput['movie_folder_id'] . "&" . $this->cashe);
                //change to address list screen
            } elseif (isset($reqData['selection'])) {
                $this->request->session()->write("MovieOpenSetting", $reqData);
                if (isset($reqData['mail'])) {
                    foreach ($reqData['mail'] as $value) {
                        if ($value != "") {
                            $mailAddress[] = $value;
                        }
                    }
                } else {
                    $mailAddress[] = isset($reqData['mail']) ? $reqData['mail'] : null;
                }
                $this->request->session()->write("OpenStatusAddress", $mailAddress);
                $this->request->session()->write("OpenStatusDeparture", 3); //1: アルバム　2: ファイル 3:動画
                return $this->redirect("/address/list.html?" . $this->cashe);
            }
        }

        // get movie file open
        if ($this->request->session()->check("mfile_open") || !empty($reqQuery['del'])) {
            $movOpenId = !empty($reqQuery['del']) ? $reqQuery['del'] : $this->request->session()->consume('mfile_open');
            $this->request->session()->write("mfile_open", $movOpenId);
            $this->set('movOpenId', $movOpenId);
            foreach ($movOpenId as $movieFileId) {
                $movieName = $movieContents->getSingleMovieData($userSeq, $movieFileId);
                if (!empty($movieName)) {
                    $aOpenRegInput['movieName'][] = $movieName[0]['movie_contents_name'];
                }
            }
        }

        //back link
        $this->set('backUrl', $this->request->session()->read('returnLink'));
        //set input data
        $this->set('aOpenRegInput', $aOpenRegInput);
    }

    /**
     * Index for smartphone(iphone & android) method
     *
     * @return \Cake\Network\Response|null
     */
    private function indexSP()
    {
        $userSeq = $this->request->session()->read('UserData.user_seq');
        $reqQuery = $this->request->query;
        $reqData = $this->request->data;
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');

        if (isset($reqQuery['mid'])) {
            $this->request->session()->delete('inputdata');
        }
        // Fix bug click back 19/1/2017
        $this->request->session()->write('returnLink', $this->previousUrl);
        //Create data object
        $prepareData = array("nickname" => $this->request->session()->read('UserData.user_name'),
            "message" => "",
            "access_check" => "0",
            "mail" => "",
            "close_date" => "");

        //Set input data
        $aOpenRegInput = ($this->request->session()->check('inputdata')) ? $this->request->session()->consume('inputdata') : $prepareData;

        //openFlag 4=movie folder 5=movie
        $openFlag = (!empty($reqQuery['openflg'])) ? $reqQuery['openflg'] : $reqData['open_flg'];
        $this->set('openflg', $openFlag);

        //get movie folder id
        $mFolderId = (!empty($reqQuery['mid'])) ? $reqQuery['mid'] : $reqData['movie_folder_id'];
        $this->set('mid', $mFolderId);

        //check movie folder
        $mFolderInfo = $movieFolder->getSingleMovieFolderData($userSeq, $mFolderId);
        if (empty($mFolderInfo)) {
            $this->LogMessage->logMessage("12053", $userSeq);
            $this->request->session()->write('message', '公開対象の動画フォルダが存在しません｡');
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
        }

        if ($openFlag == 5) {
            $openMovieFile = isset($this->request->query['cid'])? $this->request->query['cid']:$this->request->session()->read('mfile_open');
            $movieFileDetail = $movieContents->getSingleMovieData($userSeq, $openMovieFile);
            if (empty($movieFileDetail)) {
                $this->LogMessage->logMessage("12054", $userSeq);
                $this->request->session()->write('message', '公開対象の動画が存在しません｡');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
            }
        }

        // get movie folder name by id
        $openMFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openMFolderName', $openMFName);
        //Catch action click
        if ($this->request->is(['post', 'put'])) {
            //album open regis -> change to confirm screen
            if (isset($reqData['open_regist'])) {
                $aOpenRegInput = $reqData;
                $isValid = $this->Common->validate($aOpenRegInput);
                if (is_array($isValid)) {
                    $this->set('errorMessage', $isValid);
                } else {
                    $this->request->session()->write('inputdata', $aOpenRegInput);
                    $this->confirm();
                }
                //conmit and send mail regis open regis info
            } elseif (!empty($reqData['open_back'])) {
                $aOpenRegInput = $reqData;
                $this->request->session()->write('inputdata', $aOpenRegInput);
                //conmit and send mail regis open regis info
            } elseif (!empty($reqData['open_reg'])) {
                $aOpenRegInput = $reqData;
                if (!is_array($aOpenRegInput['mail'])) {
                    $aOpenRegInput['mail'] = explode(',', $aOpenRegInput['mail']);
                }
                //start comit
                $this->LogMessage->logMessage("12047", $userSeq);
                $reqResult = $this->Common->insertOpenData($userSeq, $aOpenRegInput['open_flg'], $aOpenRegInput);
                //finish commit
                $this->LogMessage->logMessage("12048", $userSeq);
                $this->request->session()->write("message", '動画公開のご案内が送信されました。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . "/movie/preview.html?&mid=" . $aOpenRegInput['movie_folder_id'] . "&" . $this->cashe);
            }
        }

        //get picture id and name
        if (!empty($reqQuery['cid'])) {
            $cid = $reqQuery['cid'];
            $this->request->session()->write('mfile_open', $cid);
            $picName = $movieContents->getSingleMovieData($userSeq, $cid);
            $aOpenRegInput['mFileName'] = $picName[0]['movie_contents_name'];
            $aOpenRegInput['mFileNameOrigin'] = $picName[0]['name'];
        } elseif ($this->request->session()->check('mfile_open')) {
            $cid = $this->request->session()->read('mfile_open');
            $picName = $movieContents->getSingleMovieData($userSeq, $cid);
            $aOpenRegInput['mFileName'] = $picName[0]['movie_contents_name'];
            $aOpenRegInput['mFileNameOrigin'] = $picName[0]['name'];
        }

        // back button setting
        if (stripos($_SERVER['HTTP_REFERER'], '/movie/preview.html?') == true || stripos($_SERVER['HTTP_REFERER'], '/contents/detail.html?') == true) {
            $this->request->session()->write('backUrl', $_SERVER['HTTP_REFERER']);
        }
        $this->set('backUrl', $this->request->session()->read('backUrl'));

        //set input data
        $this->set('aOpenRegInput', $aOpenRegInput);

        //set user Address
        $this->set('userAddress', $this->request->session()->read('UserData.user_address'));
    }

    /**
     * Confirm method
     *
     * @return \Cake\Network\Response|null
     */
    private function confirm()
    {
        if ($this->deviceTypeId != 1) {
            $this->confirmSP();
        } else {
            $this->confirmPc();
        }
        $this->set('menu_now_flg', $this->menuNowFlg);
        $this->render('confirm');
    }

    /**
     * Confirm PC method
     *
     * @return \Cake\Network\Response|null
     */
    private function confirmPC()
    {
        $userSeq = $this->request->session()->read('UserData.user_seq');
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');
        $postData = $this->request->session()->consume('inputdata');

        //get movie id
        $mFolderId = $postData['movie_folder_id'];
        $this->set('mid', $mFolderId);

        //get movie open name
        if ($this->request->session()->check("mfile_open")) {
            $mFileOpenId = $this->request->session()->read("mfile_open");
            $this->set('mFileOpenId', $mFileOpenId);
            foreach ($mFileOpenId as $mFileId) {
                $mFileName = $movieContents->getSingleMovieData($userSeq, $mFileId);
                $postData['mFileName'][] = $mFileName[0]['movie_contents_name'];
            }
        }

        //openFlag 4=movie folder 5=movie
        $openFlag = $postData['open_flg'];
        $this->set('openflg', $openFlag);

        // get movie folder name by id
        $openMFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openMFolderName', $openMFName);

        //Create end date open display
        $endDateOpen = $this->Common->setEndDateDisplay($postData["close_date"], null, 'sub');
        $this->set('endOpen', $endDateOpen);

        //get user address
        $this->set('userAddress', $this->request->session()->read('UserData.user_address'));

        //set input data
        $this->set('aOpenRegInput', $postData);
    }

    /**
     * Confirm smartphone method
     *
     * @return \Cake\Network\Response|null
     */
    private function confirmSP()
    {
        $userSeq = $this->request->session()->read('UserData.user_seq');
        $movieContents = TableRegistry::get('MovieContents');
        $movieFolder = TableRegistry::get('MovieFolder');
        $postData = $this->request->session()->consume('inputdata');

        //get movie id
        $mFolderId = $postData['movie_folder_id'];
        $this->set('mid', $mFolderId);

        //openFlag 4=movie folder 5=movie
        $openFlag = $postData['open_flg'];
        $this->set('openflg', $openFlag);

        //get movie open name
        if ($this->request->session()->check('mfile_open')) {
            $cid = $this->request->session()->read('mfile_open');
            $this->set('cid', $cid);
            $mFileName = $movieContents->getSingleMovieData($userSeq, $cid);
            $postData['mFileName'] = $mFileName[0]['movie_contents_name'];
            $postData['mFileNameOrigin'] = $mFileName[0]['name'];
        }

        // get movie folder name by id
        $openMFName = $movieFolder->getFolderNameById($userSeq, intval($mFolderId));
        $this->set('openMFolderName', $openMFName);

        //get user address
        $this->set('userAddress', $this->request->session()->read('UserData.user_address'));

        //set input data
        $this->set('aOpenRegInput', $postData);
    }

}
