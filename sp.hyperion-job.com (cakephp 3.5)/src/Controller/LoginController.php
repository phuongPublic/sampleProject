<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Validation\NoptBaseValidator;
use Cake\Core\Configure;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LoginController extends AppController
{

    public $components = ['User'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $lang = $this->request->session()->read('lang');
        if ($this->request->is('post')) {
            $checkLogin = $this->User->checkLogin($this->request->data);
            if (!$checkLogin) {
                $this->set('error', Configure::read('login.validate_login_fail.'.$lang));
            } else {
                $this->request->session()->write('userData', $checkLogin);
                if ($this->request->session()->check('fromDetailJob')) {
                    $this->redirect('/JobDetail?job_id=' . $this->request->session()->consume('fromDetailJob'));
                } else {
                    $this->redirect('/MyPage');
                }
            }
        }
    }

//    /**
//     * Validate input
//     * @param Validator $validator
//     * @return Validator
//     */
//    private function validationDefaultLogin(NoptBaseValidator $validator, $data)
//    {
//        $validator->allowEmpty('nickname');
//        $validator->add(
//            'email', 'noValue', ['rule' => function ($nickname) {
//                return $this->User->checkLogin();
//            },
//                'message' => 'メールアドレスもしくはパスワードが正しくありません。',
//            ]
//        );
//
//        return $validator;
//    }
}
