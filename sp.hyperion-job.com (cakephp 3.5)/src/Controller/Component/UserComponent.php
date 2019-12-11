<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Exception;
use Cake\Utility\Security;
use Cake\I18n\Time;


/**
 * Common component
 */
class UserComponent extends Component
{
    public $components = ['Utils', 'Common'];

    public function checkLogin($data)
    {
        $customerTbl = TableRegistry::get('DtbCustomer');
        //check email is match
        if ($customerTbl->isMatchEmail($data['email'])) {
            $passInfo = $customerTbl->getPasswordInfo($data['email']);
            if ($this->Utils->isMatchHashPassword($data['password'], $passInfo['password'], $passInfo['salt'])) {
                return $customerTbl->getBasicInfoCustumer($passInfo['customer_id']);
            }
        }
        return false;
    }

    public function registUser($data, $lang)
    {
        $customerTbl = TableRegistry::get('DtbCustomer');
        $customerIdTbl = TableRegistry::get('DtbCustomerCustomerIdSeq');

        //get sceret_key
        $data['secret_key'] = $this->Utils->getUniqRandomId('r');
        //get user id
        $maxId = $customerIdTbl->getMaxId()['sequence'];
        $data['customer_id'] = $maxId + 1;

        // get salt
        $salt = $this->Utils->getRandomString(10);
        $data['salt'] = $salt;
        //encode password
        $data['password'] = $this->Utils->getHashString($data['password'], $salt);
        unset($data['pass_confirm']);
        $result =  $this->insertUserData($data);
        if($result){
            $this->sendMailRegistSuccess($data['customer_id'], $lang);
        }
        return $result;
    }

    private function sendMailRegistSuccess($customerId, $lang)
    {
        $textLangEn = $lang == 'vn' ? '_eng' : '';
        $customerTbl = TableRegistry::get('DtbCustomer');
        $baseInfolTbl = TableRegistry::get('DtbBaseinfo');

        $accountInfo = $customerTbl->getBasicInfoCustumer($customerId);
        $baseInfo = $baseInfolTbl->get(1);
        //data for view template mail
        $viewVars = array();
        $viewVars['create_name'] = $accountInfo['name01'] . ' ' . $accountInfo['name02'];
        $viewVars['company_name'] = $baseInfo['shop_name'];
        $viewVars['mail_contact'] = $baseInfo['email02'];

        //data for sendmail
        $dataSend['template'] = 'regist_success_mail_' . $lang;
        $dataSend['subject'] = $baseInfo['shop_name'.$textLangEn] . Configure::read('regist.mail_subject.' . $lang);;
        $dataSend['from']['address'] = $baseInfo['email03'];
        $dataSend['from']['nickname'] = $baseInfo['shop_name'];
        $dataSend['to'] = $accountInfo['email'];
        $dataSend['bcc'] = $baseInfo['email01'];
        //do send mail
        return $this->Common->sendMailAction($viewVars, $dataSend);
    }

    private function insertUserData($data)
    {
        $result = false;
        try {
            $customerTbl = TableRegistry::get('DtbCustomer');
            $userData = $customerTbl->newEntity();

            //convert phone number to anrray (3 element)
            foreach (str_split($data['phone'],4) as $key=>$temp)
            {
                $data['tel0'.($key+1)] = $temp;
            }
            unset($data['phone']);
            // 仮会員 1 本会員 2
            $data['status'] = Configure::read('Common.customer_confirm_mail') ? 1 : 2;
            foreach ($data as $key => $item) {
                $userData->{$key} = $item;
            }
            //transaction
            $customerTbl->connection()->transactional(function () use ($customerTbl, $userData) {
                $customerTbl->save($userData, ['atomic' => false]);
            });
            $result = true;
        } catch (Exception $e) {
            $result = false;
        }
        return $result;
    }

    public function updateUserData($data)
    {
        $customerTbl = TableRegistry::get('DtbCustomer');
        $userData = $customerTbl->newEntity();
        $entity = $customerTbl->get($data['customer_id']);

        $data['birth_day'] = $data['birth_day']['year'] . '-' . $data['birth_day']['month'] . '-' . $data['birth_day']['day'];
        $data['desired_work'] = !empty($data['desired_work']) ? implode(" ", $data['desired_work']) : '';
//        $data['desired_position'] = !empty($data['desired_position']) ? implode(" ", $data['desired_position']) : '';
        $data['desired_region'] = !empty($data['desired_region']) ? implode(" ", $data['desired_region']) : '';
        if($data['reminder_answer'] == Configure::read('Common.default_password') || $data['reminder_answer'] == '')
        {
            unset($data['reminder_answer']);
        }else {
            $salt = $customerTbl->getCustomerSaltById($data['customer_id']);
            $data['reminder_answer'] = $this->Utils->getHashString($data['reminder_answer'], $salt);
        }
        // convert arraay experion for update
        foreach ($data as $key => $item) {
                $userData->{$key} = $item;
        }
        try {
            //transaction
            $customerTbl->connection()->transactional(function () use ($customerTbl, $userData) {
                $customerTbl->save($userData, ['atomic' => false]);
            });
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
