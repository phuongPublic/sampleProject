<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UpdateUserInfoController extends AppController
{

    public $components = ['User'];

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //Check if not logged in
        if(!$this->request->session()->check('userData'))
        {
            $this->redirect('/Login');
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->getDataForView();
        if($this->request->is('post'))
        {
            $this->User->updateUserData($this->request->data);
            $this->redirect('/MyPage');
        }
    }

    private function getDataForView ()
    {
        $textLang = $this->request->session()->read('lang') == 'vn' ? '_vn' : '';
        $prefTbl = TableRegistry::get('MtbPref');
        $cateTbl = TableRegistry::get('MtbCategory');
        $regionTbl = TableRegistry::get('MtbRegion');
        $CustomerTbl = TableRegistry::get('DtbCustomer');

        //tinh thanh pho
        $pref = $this->bindingDataFromTbl($prefTbl->getListPref(),$textLang);
        $this->set('pref',$pref);
        // category
        $cart = $this->bindingDataFromTbl($cateTbl->getAllCartegoryJob(),$textLang);
        $this->set('cart',$cart);
        //region
        $region = $this->bindingDataFromTbl($regionTbl->getAllRegion(),$textLang);
        $this->set('region',$region);
        //customer info
        $customInfo = $CustomerTbl->getCustomerInfoById($this->customerId);
        $customInfo['phone'] = $customInfo['tel01'].$customInfo['tel02'].$customInfo['tel03'];
        $this->set('customInfo',$customInfo);
        //customer experion
    }

    private function bindingDataFromTbl($tblArray,$textLang)
    {
            $result = array();
            foreach ($tblArray as $key=>$item)
            {
                $result[$item['id']] = $item['name'.$textLang];
            }
            return $result;
    }

}
