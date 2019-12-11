<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JobDetailController extends AppController
{

    public $components = ['JobInfo'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $jobId = $this->request->query('job_id');
        $lang = $this->request->session()->read('lang');
        $textLang = $lang == 'vn' ? '_vn' : '';

        //event apply
        if ($this->request->is('get') && isset($this->request->query['apply'])) {
            //non login
            if (!$this->request->session()->check('userData')) {
                $this->request->session()->write('fromDetailJob', $jobId);
                $this->redirect('/Login');
            } else {
                $customerId = $this->request->session()->read('userData')['customer_id'];
                $result = $this->JobInfo->applyJob($customerId, $jobId, $lang);
                if($result) {
                    return $this->redirect('/JobDetail?job_id='.$jobId);
                }
            }
        }

        //event save job
        if ($this->request->is('get') && isset($this->request->query['save_job'])) {
            //non login
            if (!$this->request->session()->check('userData')) {
                $this->request->session()->write('fromDetailJob', $jobId);
                $this->redirect('/Login');
            } else {
                $customerId = $this->request->session()->read('userData')['customer_id'];
                $result = $this->JobInfo->saveJob($customerId, $jobId);
                if($result) {
                    return $this->redirect('/JobDetail?job_id='.$jobId);
                }            }
        }

        //check this job was applied
        $jobApplied = false;
        $jobSaved = false;
        if ($this->request->session()->check('userData')) {
            $customerId = $this->request->session()->read('userData')['customer_id'];
            $table = TableRegistry::get('DtbOrder');
            $checkApplied = $table->getCustomerAppliedByJobId($jobId,$customerId);
            if(!empty($checkApplied))
            {
                $jobApplied = true;
            }
            $tablefavorite = TableRegistry::get('DtbCustomerFavoriteProducts');

            $checkSaved = $tablefavorite->getCustomerSavedJob($jobId,$customerId);
            if(!empty($checkSaved))
            {
                $jobSaved = true;
            }
        }
        $this->set('JobApplied',$jobApplied);
        $this->set('jobSaved',$jobSaved);
        $this->set('JobInfo', $this->JobInfo->getDataJobDetail($jobId, $textLang, $lang));
    }
}
