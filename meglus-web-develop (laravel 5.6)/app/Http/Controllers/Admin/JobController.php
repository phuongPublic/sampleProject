<?php

namespace App\Http\Controllers\Admin;

use App\Model\Applicant;
use App\Model\CodeMst;
use App\Model\DemandUserInfo;
use App\Model\Jobs;
use App\Model\JobStatusLogs;
use App\Services\DefaultService;
use App\Http\Controllers\Controller;
use App\Services\JobService;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($cid = null){
        $sort                   = $this->getSortData();
        $filter                 = $this->getFilterData();
        if($cid != null)
            $filter['company_id'] = $cid;
        $category               = DefaultService::jobCategoryTree();
        $japanese               = DefaultService::getCodeMstByGroup('japanese_level',true);
        $statusCd               = DefaultService::getCodeMstByGroup('job_status', true);
        $jobs                   = Jobs::getAdminList($sort, $filter);
        // remove blocked apply job
        unset($statusCd[DemandUserInfo::BLOCKED_APPLY]);
        unset($filter['company_id']);
        return view('admin.job.index', compact('jobs','sort', 'filter','category','japanese','statusCd', 'cid'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function block($id){
        $job        = $this->getJob($id);
        $updated    = $job->block();
        if($updated == true){
            Session::flash('Success',__('supply.common.update_success'));
        }else{
            Session::flash('Error',__('supply.common.system_error'));
        }
        return redirect()->back();
    }

    /**
     * @param $companyId
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function stopAll($companyId) {
        try {
            $jobOfCompany = Jobs::where('company_id', $companyId)->get();
            foreach ($jobOfCompany as $value) {
                $job        = $this->getJob($value->job_id);
                $updated    = $job->stop();
            }
            Session::flash('Success',__('supply.common.update_success'));
        } catch(\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }
        return redirect()->back();
    }

    /**
     * @param $companyId
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function reOpenAll($companyId) {
        try {
            $jobOfCompany = Jobs::where('company_id', $companyId)->get();
            foreach ($jobOfCompany as $value) {
                $job        = $this->getJob($value->job_id);
                $updated    = $job->reOpen();
            }
            Session::flash('Success',__('supply.common.update_success'));
        } catch(\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }
        return redirect()->back();
    }

    /**
     * function job apply
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply($id){
        $job        = $this->getJob($id);
        $user       = isset($job->userCompany)? $job->userCompany: null;

        $sort           = $this->getSortData();
        $applicant      = $this->getApplicantBỵJob($job, $sort);
        $jobFlow        = JobService::jobFlow(true);
        $progressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
        $reasonCd       = DefaultService::getReasonCd();
        return view('admin.job.apply', compact('reasonCd','sort', 'user', 'job', 'applicant', 'jobFlow', 'progressStatus'));
    }

    /**
     * @param $job
     * @param $sort
     * @return mixed
     */
    private function getApplicantBỵJob($job, $sort){
        if(!$sort)
            $sort           = $this->getSortData();
        $model = Applicant::select(['applicant.*','demand_user_info.name','demand_user_info.id AS demand_user_id','demand_user_info.tel','demand_user_info.mail']);
        $model->join('demand_user_info', 'demand_user_info.id', '=', 'applicant.demand_user_id')->where('job_id', $job->job_id)->whereNull('delete_at');
        if(count($sort) > 0){
            foreach ($sort as $key => $item){
                if($key == 'name' && in_array($item,['ASC','DESC'])){
                    $model->orderBy('demand_user_info.name', $item);
                }else{
                    if(in_array($item,['ASC','DESC']))
                        $model->orderBy('applicant.'.$key, $item);
                }
            }
        }

        return $model->paginate(30);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history($id){
        $this->getJob($id);
        $history        = JobStatusLogs::select()->where('job_id',$id)->paginate(30);
        $statusCd       = DefaultService::getCodeMstByGroup('job_status', true);
        return view('admin.job.history', compact('statusCd','history'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailHistory($id){
        $history    = $this->getJobDetailHistory($id);
        if(!$history->compare() || ! $history->compare()->jobLog || !$history->jobLog)
            abort(404);

        $job = $history->jobLog;
        $jobWorkingTime         = DefaultService::jobWorkingTime($job->jobWorkingTime);

        $compare = $history->compare()->jobLog;
        $compareWorkingTime     = DefaultService::jobWorkingTime($compare->jobWorkingTime);

        $category           = DefaultService::jobCategoryAll();
        $importantThing     = DefaultService::getCodeMstByGroup('important_thing');
        if(count($importantThing)> 0 )
            $importantThing = array_column($importantThing->toArray(), 'label', 'value');
        return view('admin.job.detail-history',
            compact('history','job','jobWorkingTime', 'compare','compareWorkingTime','category','importantThing')
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function setting() {
        $keys = [
            'max_job',
            'max_salary',
        ];

        $settings = CodeMst::select()->whereIn('group', $keys)->get()->reduce(function ($carry, $item) {
            $carry[$item->group] = $item->value;
            return $carry;
        },[]);

        if (request()->method() == 'POST') {
            $data = request()->only($keys);
            if (count($data) > 0 ) {
                try {
                    foreach ($data as $key => $item) {
                        CodeMst::where('group', $key)->update(['value' => $item, 'label' => $item]);
                    }
                    Session::flash('Success',__('supply.common.update_success'));
                } catch (\Exception $e) {
                    Session::flash('Success',__('supply.common.system_error'));
                }
            }
            return redirect()->route('admin.job.setting');
        }
        return view('admin.job.setting', compact('settings','keys'));
    }

    /**
     * check access job
     * @param $id
     * @return bool
     */
    private function getJob($id){
        $item = Jobs::find($id);
        if($item)
            return $item;
        return abort(404);
    }

    /**
     * check detail access job
     * @param $id
     * @return bool
     */
    private function getJobDetailHistory($id){
        $item = JobStatusLogs::find($id);
        if($item)
            return $item;
        return abort(404);
    }

    /**
     * @return array|mixed
     */
    private function getSortData(){
        $request = request();

        $sort = [];
        if($request->sort)
            $sort = $request->sort;

        return $sort;
    }

    /**
     * @return array|mixed
     */
    private function getFilterData(){
        $filter = [];
        $request = request();
        if($request->filter)
            $filter = $request->filter;

        return $filter;
    }
}
