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
class SearchJobController extends AppController
{
    public $components = ['User', 'Common', 'PageControl', 'FileCV'];


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $jobTbl = TableRegistry::get('DtbProducts');

        $jobCartTbl = TableRegistry::get('MtbCategory');
        $RegionTbl = TableRegistry::get('MtbRegion');
        $langguage = $this->request->session()->read('lang') == 'vn' ? '_vn' : '';
        $this->set('textLang', $langguage);

        //search condition area

        $jobFastShow = $this->getListFiveJobFollowStatus(Configure::read('Common.job_status.fast_job'));
        $this->set('jobFast', $jobFastShow);

        $jobAbsShow = $this->getListFiveJobFollowStatus(Configure::read('Common.job_status.fast_job'));
        $this->set('jobAbs', $jobAbsShow);

        $jobCart = $jobCartTbl->getAllCartegoryJobForMobile();
        $jobCartArray = array();
        foreach ($jobCart as $jobItem) {
            $jobCartArray += array($jobItem['id'] => $jobItem['name' . $langguage]);
        }
        $this->set('jobCartArray', $jobCartArray);


        $Region = $RegionTbl->getAllRegion();
        $RegionArray = array();
        foreach ($Region as $RjItem) {
            $RegionArray += array($RjItem['id'] => $RjItem['name' . $langguage]);
        }
        $this->set('RegionArray', $RegionArray);
        //end search condition area

        //search event
        if (isset($this->request->query['search'])) {
            $searchResult = $jobTbl->getSearchResult($this->request->query);
            $page = isset($this->request->query['page']) ? $this->request->query['page'] : 1;
            $pageData = $this->PageControl->pageCtl($page, $searchResult, Configure::read('Common.page_item'));
            foreach ($pageData['show_data'] as $key => $item) {
                $pageData['show_data'][$key]['region'] = $RegionTbl->getRegionById($item['region']);
                $pageData['show_data'][$key]['base64Img'] = $this->FileCV->getJobImgInfo($item['main_large_image']);
            }
            $this->set('jobSearchResult', $pageData['show_data']);
            unset($pageData['show_data']);
            $pageData['link_num'] = empty($pageData['link_num']) ? array(1) : $pageData['link_num'];
            $pageData['queryStr'] = $this->getgetQueryString();
            $this->set('pageData', $pageData);
            $this->set('search', 1);
            $this->set('searchKeyword', $this->request->query('searchKeyword'));
        }
    }

    private function getgetQueryString()
    {
        $queryArr = $this->request->getQueryParams();
        unset($queryArr['url']);
        unset($queryArr['page']);
        $queryStr = '/SearchJob?';
        foreach ($queryArr as $key => $item) {
            $queryStr .= $key.'='.$item.'&';
        }
        return $queryStr;
    }

    private function getListFiveJobFollowStatus($status)
    {
        $jobStatusTbl = TableRegistry::get('DtbProductStatus');
        $jobTbl = TableRegistry::get('DtbProducts');
        $RegionTbl = TableRegistry::get('MtbRegion');
        $listJobId = $jobStatusTbl->getFileJobIdWithStatus($status);
        $listJob = (!empty($listJobId)) ? $jobTbl->getJobBasicInfoById($listJobId) : array();
        foreach ($listJob as $key => $item) {
            $listJob[$key]['region'] = $RegionTbl->getRegionById($item['region']);
            $listJob[$key]['base64Img'] = $this->FileCV->getJobImgInfo( $item['main_large_image']);
        }
        return $listJob;
    }
}
