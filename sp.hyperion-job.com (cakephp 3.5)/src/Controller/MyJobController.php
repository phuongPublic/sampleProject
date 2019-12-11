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
class MyJobController extends AppController
{
    public $components = ['User', 'Common', 'PageControl', 'JobInfo', 'FileCV'];

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
        $favoriteTbl = TableRegistry::get('DtbCustomerFavoriteProducts');
        $applyTbl = TableRegistry::get('DtbOrderDetail');
        $jobTbl = TableRegistry::get('DtbProducts');
        $RegionTbl = TableRegistry::get('MtbRegion');
        $customerId = $this->request->session()->read('userData')['customer_id'];

        if (isset($this->request->query['delete']) && isset($this->request->query['job_id']) && !empty($this->request->query['job_id'])) {
            $this->JobInfo->deleteSavedJob($customerId, $this->request->query['job_id']);
            return $this->redirect('/MyJob?savedJob=1');
        }

        if (isset($this->request->query['appliedJob'])) {
            $this->set('appliesJob', $this->getListJobApplied($customerId, $applyTbl, $jobTbl, $RegionTbl));
        } else {
            $this->set('savedJob', $this->getListJobSaved($customerId, $favoriteTbl, $jobTbl, $RegionTbl));
        }
    }

    private function getListJobSaved($customerId, $favoriteTbl, $jobTbl, $RegionTbl)
    {
        $listJobId = $favoriteTbl->getAllJobSavedById($customerId);
        $listJob = (!empty($listJobId)) ? $jobTbl->getJobBasicInfoById($listJobId) : array();
        foreach ($listJob as $key => $item) {
            $listJob[$key]['region'] = $RegionTbl->getRegionById($item['region']);
            $listJob[$key]['base64Img'] = $this->FileCV->getJobImgInfo($item['main_large_image']);
        }
        return $listJob;
    }

    private function getListJobApplied($customerId, $applyTbl, $jobTbl, $RegionTbl)
    {
        $listJobId = $applyTbl->getAppliedByCustomerId($customerId);
        $listJob = (!empty($listJobId)) ? $jobTbl->getJobBasicInfoById($listJobId) : array();
        foreach ($listJob as $key => $item) {
            $listJob[$key]['region'] = $RegionTbl->getRegionById($item['region']);
            $listJob[$key]['base64Img'] = $this->FileCV->getJobImgInfo($item['main_large_image']);
        }
        return $listJob;
    }
}
