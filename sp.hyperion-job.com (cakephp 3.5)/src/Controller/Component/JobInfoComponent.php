<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Exception;

/**
 * Common component
 */
class JobInfoComponent extends Component
{
    public $components = ['Utils', 'Common'];

    public function getDataJobDetail($id, $textLang, $lang)
    {
        $jobTbl = TableRegistry::get('DtbProducts');
        $regionTbl = TableRegistry::get('MtbRegion');
        $positionTbl = TableRegistry::get('MtbPosition');
        $cityTbl = TableRegistry::get('MtbCity');
        $empStatusTbl = TableRegistry::get('MtbEmploymentStatus');
        $welfareTbl = TableRegistry::get('MtbWelfare');
        $processTbl = TableRegistry::get('MtbProcess');
        $jobStatusTbl = TableRegistry::get('DtbProductStatus');

        $sex = Configure::read('jobdetail.sex_show.' . $lang);
        $infoRecArray = $jobTbl->getJobInfoById($id);
        //job description
        $infoRecArray['client_introduction'] = ($infoRecArray['employment_status'] == 1) ? $infoRecArray['client_introduction' . $textLang] : '';
        //loai cong viec
        $infoRecArray['employment_status'] = $empStatusTbl->getEmployStatusById($infoRecArray['employment_status'])['name' . $textLang];

        //regiton
        $infoRecArray['region'] = $regionTbl->getRegionById($infoRecArray['region'])['name' . $textLang];
        //city
        $infoRecArray['city'] = $cityTbl->getCityById($infoRecArray['city'])['name' . $textLang];
        //position
        $infoRecArray['position'] = $positionTbl->getPositionById($infoRecArray['position'])['name' . $textLang];
        //work time
        $infoRecArray['work_time'] = nl2br($infoRecArray['working_hour' . $textLang]) . '<br>' . Configure::read('jobdetail.content_lunch_time.' . $lang) . $infoRecArray['lunch_time' . $textLang];
        //salary rank
        $infoRecArray['salary_type'] = Configure::read('jobdetail.content_salary_type.' . $lang . '.' . $infoRecArray['salary_type']);
        $currency = Configure::read('Common.currency.' . $infoRecArray['currency']);
        $infoRecArray['salary_rank'] = $infoRecArray['salary_type'] . ' ' . $infoRecArray['salary_min'] . $currency . '〜' . $infoRecArray['salary_max'] . $currency;
        //sex

        $infoRecArray['sex'] = !empty($infoRecArray['sex']) ? $sex[$infoRecArray['sex']] : '';
        //work place
        $infoRecArray['place'] = $infoRecArray['region'] . " " . $infoRecArray['city'] . "<br>" . $infoRecArray['work_location' . $textLang];
        //welfare
        $welfareArray = (explode(" ", $infoRecArray['welfare']));
        $welfareStr = '';
        foreach ($welfareArray as $item) {
            $welfareStr .= '■ ' . $welfareTbl->getWelfareById($item)['name' . $textLang] . '<br>';
        }
        $infoRecArray['welfare'] = $welfareStr;

        //process
        $processArray = (explode(" ", $infoRecArray['selection_process']));
        $processStr = '';
        foreach ($processArray as $item) {
            $processStr .= '■ ' . $processTbl->getProcessById($item)['name' . $textLang] . '<br>';
        }
        $infoRecArray['selection_process'] = $processStr;

        //job req status
        $infoRecArray['product_status_id'] = $jobStatusTbl->getJobStatus($id);
        foreach ($infoRecArray['product_status_id'] as $key => $item) {

            $infoRecArray['product_status_id'][$key] = $item['product_status_id'];
        }

        return $infoRecArray;
    }

    public function saveJob($customerId, $JobId)
    {
        $table = TableRegistry::get('DtbCustomerFavoriteProducts');
        $checkExist = $table->get(array($customerId, $JobId));
        if (!empty($checkExist)) return true;

        $saveData = $table->newEntity();;
        $saveData['update_date'] = date("Y-m-d H:i:s");
        $saveData['create_date'] = date("Y-m-d H:i:s");
        $saveData['customer_id'] = $customerId;
        $saveData['product_id'] = $JobId;
        try {
            $table->connection()->transactional(function () use ($table, $saveData) {
                $table->save($saveData, ['atomic' => false]);
            });
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function applyJob($customerId, $JobId, $lang)
    {
        $dtbOrderOrderIdSeqTbl = TableRegistry::get('DtbOrderOrderIdSeq');
        $dtbOrderTbl = TableRegistry::get('DtbOrder');
        $applyData = array();
        $applyData['update_date'] = date("Y-m-d H:i:s");
        $applyData['create_date'] = date("Y-m-d H:i:s");
        $applyData['order_id'] = $dtbOrderOrderIdSeqTbl->getNewOrderId();
        $applyData['order_temp_id'] = $this->Utils->getUniqRandomId('r');
        $applyData['customer_id'] = $customerId;
        $applyData['order_country_id'] = Configure::read('Common.default_country_id');
        $applyData['del_flg'] = 1;
        $applyData['cv_type'] = 2;
        $applyData['device_type_id'] = 10;

        //check exist apply this job
        $appliedCheck = $dtbOrderTbl->getCustomerAppliedByJobId($JobId,$customerId);

        if(!empty($appliedCheck)) return true;
        try {
            $this->insertOrderTempTbl($applyData);
            $this->insertOrderTbl($applyData);
            $this->insertOrderDetailTbl($applyData, $JobId);
            //sendmail
            $this->doSendMail($customerId, $JobId, $lang, $applyData['order_id']);
            //update order_id to DtbOrderOrderIdSeq table
            $this->Common->updateOnlyIdTable('DtbOrderOrderIdSeq', $applyData['order_id']);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function doSendMail($customerId, $JobId, $lang, $orderId)
    {
        $textLang = $lang == 'vn' ? '_vn' : '';
        $textLangEn = $lang == 'vn' ? '_eng' : '';
        $customerTbl = TableRegistry::get('DtbCustomer');
        $jobTbl = TableRegistry::get('DtbProducts');
        $regionTbl = TableRegistry::get('MtbRegion');
        $cityTbl = TableRegistry::get('MtbCity');
        $tempMailTbl = TableRegistry::get('DtbMailtemplate');
        $baseInfolTbl = TableRegistry::get('DtbBaseinfo');

        $accountInfo = $customerTbl->getBasicInfoCustumer($customerId);
        $jobInfo = $jobTbl->getJobInfoById($JobId);
        //data for view template mail
        $viewVars = array();
        $viewVars['apply_name'] = $accountInfo['name01'] . ' ' . $accountInfo['name02'];
        $viewVars['job_name'] = $jobInfo['name' . $textLang];

        $currency = Configure::read('Common.currency.' . $jobInfo['currency']);
        $salary_type = Configure::read('jobdetail.content_salary_type.' . $textLang . '.' . $jobInfo['salary_type']);
        $viewVars['salary_rank'] = $salary_type . ' ' . $jobInfo['salary_min'] . $currency .'〜'. $jobInfo['salary_max'] . $currency;
        $viewVars['salary_full'] = $jobInfo['salary' . $textLang];

        $viewVars['working_day'] = $jobInfo['working_day' . $textLang];
        $viewVars['working_hour'] = $jobInfo['working_hour' . $textLang];

        $viewVars['region'] = $regionTbl->getRegionById($jobInfo['region'])['name' . $textLang];
        $viewVars['city'] = $cityTbl->getCityById($jobInfo['city'])['name' . $textLang];
        $viewVars['work_location'] = $cityTbl->getCityById($jobInfo['city'])['name' . $textLang];

        $tempMail = $tempMailTbl->get(Configure::read('Common.temp_mail_id.apply'));
        $viewVars['header'] = $tempMail['header' . $textLang];
        $viewVars['footer'] = $tempMail['footer' . $textLang];

        //data for sendmail
        $arrInfo = $baseInfolTbl->get(1);
        $dataSend['template'] = 'apply_mail_' . $lang;
        $dataSend['subject'] = $arrInfo['shop_name'.$textLangEn].' '.$tempMail['subject' . $textLang];
        $dataSend['from']['address'] = $arrInfo['email03'];
        $dataSend['from']['nickname'] = $arrInfo['shop_name'];
        $dataSend['to'] = $accountInfo['email'];
        $dataSend['bcc'] = $arrInfo['email01'];
        //do send mail
        $result = $this->Common->sendMailAction($viewVars, $dataSend);
        //save history send mail
        $this->saveMailHistory($orderId, Configure::read('Common.temp_mail_id.apply'), $dataSend['subject'], $result['message']);
    }

    /**
     * @param string $subject
     */
    private function saveMailHistory($order_id, $template_id, $subject, $body)
    {
        $newId = TableRegistry::get('DtbMailHistorySendIdSeq')->getNewId();
        $dtbMailHistory = TableRegistry::get('DtbMailHistory');
        $mailHistory = $dtbMailHistory->newEntity();
        $mailHistory->subject = $subject;
        $mailHistory->order_id = $order_id;
        $mailHistory->template_id = $template_id;
        $mailHistory->send_date = date("Y-m-d H:i:s");
        $mailHistory->creator_id = '0';
        $mailHistory->mail_body = $body;
        $mailHistory->send_id = $newId;
        try {
            $dtbMailHistory->connection()->transactional(function () use ($dtbMailHistory, $mailHistory) {
                $dtbMailHistory->save($mailHistory, ['atomic' => false]);
            });
            //update new id
            $this->Common->updateOnlyIdTable('DtbMailHistorySendIdSeq', $newId);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteSavedJob($customerId, $JobId)
    {
        $table = TableRegistry::get('DtbCustomerFavoriteProducts');
        $saveData = $table->get(array($customerId, $JobId));
        $saveData['customer_id'] = $customerId;
        $saveData['product_id'] = $JobId;
        try {
            $table->connection()->transactional(function () use ($table, $saveData) {
                $table->delete($saveData, ['atomic' => false]);
            });
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    private function insertOrderTempTbl($data)
    {
        $dtbOrderTempTbl = TableRegistry::get('DtbOrderTemp');
        $dtbOrderTempData = $dtbOrderTempTbl->newEntity();
        foreach ($data as $key => $item) {
            $dtbOrderTempData->{$key} = $item;
        }

        try {

            $dtbOrderTempTbl->connection()->transactional(function () use ($dtbOrderTempTbl, $dtbOrderTempData) {
                $dtbOrderTempTbl->save($dtbOrderTempData, ['atomic' => false]);
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function insertOrderDetailTbl($applyData, $JobId)
    {
        $dtbOrderTbl = TableRegistry::get('DtbOrderDetail');
        $dtbOrderData = $dtbOrderTbl->newEntity();

        $data = array();
        $data['order_detail_id'] = TableRegistry::get('DtbOrderDetailOrderDetailIdSeq')->getNewOrderDetailId();
        $data['order_id'] = $applyData['order_id'];
        $data['product_id'] = $JobId;
        $data['product_class_id'] = TableRegistry::get('DtbProductsClass')->getProductClassIdFromProductId($JobId);
        $data['product_name'] = TableRegistry::get('DtbProducts')->getJobNameById($JobId);
        $data['quantity'] = 1;
        $data['price'] = 0;
        $data['tax_rate'] = 8;
        $data['tax_rule'] = 1;
        foreach ($data as $key => $item) {
            $dtbOrderData->{$key} = $item;
        }
        try {
            $dtbOrderTbl->connection()->transactional(function () use ($dtbOrderTbl, $dtbOrderData) {
                $dtbOrderTbl->save($dtbOrderData, ['atomic' => false]);
            });
            //update order_id to DtbOrderDetailOrderDetailIdSeq table
            $this->Common->updateOnlyIdTable('DtbOrderDetailOrderDetailIdSeq', $data['order_detail_id']);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function insertOrderTbl($data)
    {
        $dtbOrderDetailTbl = TableRegistry::get('DtbOrder');
        $customerTbl = TableRegistry::get('DtbCustomer');
        $customerDataForApply = $customerTbl->getCustomerDataForApply($data['customer_id']);
        $dtbOrderDetailData = $dtbOrderDetailTbl->newEntity();

        $data['del_flg'] = 0;
        $data['status'] = 1;
        foreach ($data as $key => $item) {
            $dtbOrderDetailData->{$key} = $item;
        }

        foreach ($customerDataForApply as $key => $item) {
            $dtbOrderDetailData->{'order_' . $key} = $item;
        }
        try {
            $dtbOrderDetailTbl->connection()->transactional(function () use ($dtbOrderDetailTbl, $dtbOrderDetailData) {
                $dtbOrderDetailTbl->save($dtbOrderDetailData, ['atomic' => false]);
            });
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
