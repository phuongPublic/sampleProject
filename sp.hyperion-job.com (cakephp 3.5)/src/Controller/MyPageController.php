<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;


/**
 * MyPage Controller
 *
 */
class MyPageController extends AppController
{
    public $components = ['User', 'Common', 'FileCV'];

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
        if ($this->request->is('post')) {
            if (!empty($this->request->data['file_cv']['name'])) {
                $this->uploadFile($this->request->data['file_cv'], 'cv');
            }
            if (!empty($this->request->data['file_resume']['name'])) {
                $this->uploadFile($this->request->data['file_resume'], 'resume');
            }
        }
        //set data for view
        $CustomerTbl = TableRegistry::get('DtbCustomer');
        $customInfo = $CustomerTbl->getCustomerInfoById($this->customerId);
        $customInfo['phone'] = $customInfo['tel01'] . $customInfo['tel02'] . $customInfo['tel03'];
        $this->set('customInfo', $customInfo);

        //set avatar
        $avtName = $CustomerTbl->getAvatarById($this->customerId);
        $base64Avt = '';
        if (!empty($avtName)) {
            $pathImg = UploadAvt . $avtName;
            if (file_exists($pathImg)) {
                $base64Avt = $this->FileCV->getBase64ImageData($pathImg);
            }
        }
        $this->set('base64Avt', $base64Avt);
    }

    private function uploadFile($file, $fileType)
    {
        if (!preg_match("/\.(doc|docx|xls|xlsx|pdf)$/", $file['name'])) {
            $this->set('error_'.$fileType,Configure::read('mypage.error_ext.'.$this->lang));
            //check if file size too larg
        }else if($file['size'] > Configure::read('Common.max_size_upload')){
            $this->set('error_'.$fileType,Configure::read('mypage.error_max_size.'.$this->lang));
        }else{
            //doing upload cv
            $result = $this->FileCV->UploadSingleFile($file,$this->customerId, $fileType);
            //upload error
            if (!$result) {
                $this->set('error_' . $fileType, Configure::read('mypage.error_upload_fail.' . $this->lang));
            } else {

            }
        }
    }
}
