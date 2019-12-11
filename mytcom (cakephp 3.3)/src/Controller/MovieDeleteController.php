<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * MovieDelete Controller
 *
 * @property \App\Model\Table\MovieDeleteTable $MovieDelete
 */
class MovieDeleteController extends AppController
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
        $this->set('message', $this->request->session()->consume('message'));
        $userSeq = $this->userInfo['user_seq'];
        $this->set('menu_now_flg', $this->menuNowFlg);
        $total = $this->MovieFolder->getAllMovieFolderData($userSeq);
        $this->set('movieFolderList', $total);

        $this->set('prev_Url', $this->previousUrl);
        if ($this->request->query('cid') != null) {
            $cid = $this->request->query('cid');
            $del = array($cid);
            $this->set('cid', $cid);
        } else {
            $deleteMovie = $this->request->session()->read('movie_delete');
            $del = $deleteMovie['del'];
        }
        if ($this->request->is('post')) {
            $del = $this->request->data('del');
        }

        $data = $this->Movie->getDelMovieList($userSeq, $del);
        if (empty($data)) {
            //movie not found
            $this->LogMessage->logMessage("10028", $userSeq);
            $this->request->session()->write('message', '削除対象の動画が存在しません。');
            return $this->redirect($this->deviceName[$this->deviceTypeId] . "/movie/list.html?" . $this->cashe);
        }
        $mid = $data[0]['movie_folder_id'];
        $this->set('data', $data);
        $status = 0;
        if ($this->request->is('post')) {
            $status = 1;
            $result = 0;
            foreach ($data as $item) {
                $movieContentId = $item['movie_contents_id'];
                $this->LogMessage->logMessage("10025", $userSeq);
                $result = $this->Movie->deleteMovieData($userSeq, $movieContentId);
                if ($result == -1) {
                    //error
                    $this->LogMessage->logMessage("10027", array("userSeq" => $userSeq, "movie_contents_id" => $movieContentId));
                    $this->request->session()->write('message', '動画の削除に失敗しました｡');
                } elseif ($result == 0) {
                    // movie not found
                    $this->LogMessage->logMessage("10028", $userSeq);
                    $this->request->session()->write('message', '削除対象の動画が存在しません。');
                } else {
                    // delete success
                    $this->LogMessage->logMessage("10026", $userSeq);
                    $this->request->session()->write('message', sprintf(Configure::read('Common.delete'), '動画'));
                }
            }
            $this->request->session()->delete('movie_delete');
            if ($deleteMovie['fromsrc'] == 1 && $deleteMovie['mlscr'] == 1) {
                return $this->redirect($this->deviceName[$this->deviceTypeId] . "/movie/list.html?" . $this->cashe);
            }
            return $this->redirect($this->deviceName[$this->deviceTypeId] . "/movie/preview.html?mid=" . $mid . '&' . $this->cashe);
        }
        $this->set('mid', $mid);
        $this->set('status', $status);
    }

}
