<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * MovieEncode Controller
 * This controller use to Ethna system call to check movie encode status
 * If all project is converted to CakePHP, this controller is unnecessary
 */
class MovieEncodeController extends AppController
{
    // 使用するComponentの定義
    public $components = ['LogMessage', 'Movie'];

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
        if ($this->request->is('post')) {
            $userSeq = $this->request->data('user_seq');
            //check movie encode status to update used size
            $this->Movie->checkMovieEncStatus($userSeq);
        }
    }

}
