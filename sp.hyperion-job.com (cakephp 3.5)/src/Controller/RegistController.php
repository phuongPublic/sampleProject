<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RegistController extends AppController
{

    public $components = ['User'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if ($this->request->is('post')) {
            $customerTbl = TableRegistry::get('DtbCustomer');
            $data = $this->request->data;
            $checkEmailExist = $customerTbl->isMatchEmail($data['email']);
            if (!$checkEmailExist) {
                $result = $this->User->registUser($this->request->data, $this->lang);
                if ($result) {
                    $this->redirect('/Login');
                } else {
                }
            } else {
                $this->set('error', Configure::read('regist.validate_email_existed.'.$this->lang));
                $this->set('data', $data);
            }
        }
    }
}
