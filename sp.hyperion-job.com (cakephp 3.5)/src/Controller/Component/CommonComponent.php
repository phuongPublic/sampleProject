<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Exception;
use Cake\Mailer\Email;

/**
 * Common component
 */
class CommonComponent extends Component
{
    public function textForView($screenName)
    {
        $langForShow = $this->request->session()->read('lang');

        $textArray =  Configure::read($screenName);
        foreach ($textArray as $key=>$item)
        {
            $textArray[$key] = $textArray[$key][$langForShow];

        }
        return $textArray;
    }

    public function updateOnlyIdTable($tableName,$newId)
    {
        $table = TableRegistry::get($tableName);
        $query = $table->query();
        try {
            $query->update()
                ->set(['sequence' => $newId])
                ->where(['sequence' => $newId-1])
                ->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * method getDeviceType
     *
     * @return int 1:PC,2:iPhone,3:android
     */
    public function getDeviceType($agent)
    {
        if ($this->_isIphone($agent)) {
            return 2;
        } elseif ($this->_isAndroid($agent)) {
            return 3;
        } else {
            return 1;
        }
    }

    /**
     * アクセス端末がiPhoneであるかチェックする
     *
     * @return boolean
     */
    private function _isIphone($agent)
    {
        // アクセス端末がiPhone系であればtrueを返す
        foreach (Configure::read('Common.user_agent_list.iphone') as $value) {
            if (stripos($agent, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * アクセス端末がAndroidであるかチェックする
     *
     * @return boolean
     */
    private function _isAndroid($agent)
    {
        // アクセス端末がAndroid系であればtrueを返す
        foreach (Configure::read('Common.user_agent_list.android') as $value) {
            if (stripos($agent, $value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Send email
     *
     * @param array $dataMail
     *
     */
    public function sendMailAction($viewVars,$dataSend)
    {
        $email = new Email();
        $result = $email->template($dataSend['template'])
            ->emailFormat('text')
            ->viewVars($viewVars)
            ->subject($dataSend['subject'])
            ->to($dataSend['to'])
            ->bcc($dataSend['bcc'])
            ->from([$dataSend['from']['address'] => $dataSend['from']['nickname']])
            ->send();
        return $result;
    }
}
