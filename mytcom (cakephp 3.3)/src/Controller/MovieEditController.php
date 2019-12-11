<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Validation\NoptBaseValidator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * MovieEdit Controller
 *
 * @property \App\Model\Table\MovieEditTable $MovieEdit
 * @property LogMessageComponent LogMessage
 * @property MovieComponent Movie
 * @property MovieFolderComponent MovieFolder
 */
class MovieEditController extends AppController
{

    // 選択しているメニューを管理する変数
    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['LogMessage', 'MovieFolder', 'Movie'];

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
            // log start editing movie
            $this->LogMessage->logMessage("10056", $this->userInfo['user_seq']);
        }
        // テンプレート出力情報の設定
        $this->set('menu_now_flg', $this->menuNowFlg);
        $this->set('previousUrl', $this->previousUrl);
        if ($this->deviceTypeId == 1) {
            $mFolderList = $this->MovieFolder->getFolderInfo($this->userInfo['user_seq'], 'old');
            $this->set('movieFolderList', $mFolderList);
        }
        $status = 0;
        if ($this->request->is('get') && $this->request->query('movie_contents_id') != null) {
            $this->request->session()->write('movie_contents_id', $this->request->query('movie_contents_id'));
        }
        $movie_contents_id = $this->request->session()->read('movie_contents_id');
        $this->set('movie_contents_id', $movie_contents_id);
        $MovieContentsTbl = TableRegistry::get('MovieContents');
        $result = $MovieContentsTbl->getSingleMovieData($this->userInfo['user_seq'], $movie_contents_id);
        if (!empty($result)) {
            $currentMovie = $result[0];
            $this->set('currentMovie', $currentMovie);
        } else {
            //movie not found
            $this->LogMessage->logMessage("10059", $this->userInfo['user_seq']);
            $this->request->session()->write('message', '編集対象の動画が存在しません。');
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
        }

        if ($this->request->is('post')) {
            $status = 1;

            //validate
            $errors = null;
            $isValidated = true;
            $validator = $this->Movie->validationDefault(new NoptBaseValidator());
            //Get all errors including errors from nested validators
            $arr = $this->request->data();
            $arr['bypass'] = ['name' => true];
            $errors = $validator->errors($arr);
            if ($errors) {
                $this->set('errors', $errors);
                $isValidated = false;
            }

            if ($isValidated) {
                $movieName = $this->request->data('name');
                $movieComment = $this->request->data('movie_contents_comment');
                $movieId = $this->request->data('movie_contents_id');
                if(is_array($movieName)) {
                    $movieName = " ";
                }
                if(is_array($movieComment)) {
                    $movieComment = "";
                }
                if(is_array($movieId)) {
                    $movieId = "";
                }
                $result = $this->Movie->updateMovieData($this->userInfo['user_seq'], $movieId, $movieName, $movieComment);
                $movieId = $this->request->session()->consume('movie_contents_id');
                if ($result == -1) {
                    //edit error
                    $this->LogMessage->logMessage("10058", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '動画の編集に失敗しました｡');
                } elseif ($result == 0) {
                    //Movie not found
                    $this->LogMessage->logMessage("10059", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '編集対象の動画が存在しません。');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                } else {
                    //log complete editing pic
                    $this->LogMessage->logMessage("10057", $this->userInfo['user_seq']);
                    $this->request->session()->write('message', sprintf(Configure::read('Common.update'), '動画'));
                }
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/contents/detail.html?cid=' . $movieId . '&' . $this->cashe);
            }
        }
        $this->set('status', $status);
    }
}
