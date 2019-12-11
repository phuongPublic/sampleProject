<?php

namespace App\Http\Controllers\Supply;

use App\Http\Requests\Site\ApplyPopupRequest;
use App\Model\Applicant;
use App\Model\CompanyInfo;
use App\Model\DemandUserInfo;
use App\Model\Jobs;
use App\Model\Prefectures;
use App\Model\Stations;
use App\Services\ApplyService;
use App\Services\DefaultService;
use App\Services\JobService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Psy\Util\Json;

class JobController extends Controller
{
    const PAGINATE = 30;
    /**
     * Job list.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        return view('sample',['sample' => 'this is job index']);
    }

    /**
     * Job detail.
     * @param id $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){
        $job                = $this->getJob($id);
        if((int)$job->status == Jobs::BLOCKED_STATUS){
            Session::flash('Error',__('supply.job.access_block'));
            return redirect()->back();
        }

        $jobWorkingTime     = DefaultService::jobWorkingTime($job->jobWorkingTime);
        $category           = DefaultService::jobCategoryAll();
        $importantThing     = DefaultService::getCodeMstByGroup('important_thing');
        if(count($importantThing)> 0 )
            $importantThing = array_column($importantThing->toArray(), 'label', 'value');

        return view('supply_side.job.detail',
            [
                'job'                   => $job,
                'jobWorkingTime'        => $jobWorkingTime,
                'category'              => $category,
                'importantThing'        => $importantThing
            ]);
    }

    /**
     * Job detail.
     * @param id $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($id){
        $job                = $this->getJob($id);
//        if((int)$job->status == Jobs::BLOCKED_STATUS){
//            Session::flash('Error',__('supply.job.access_block'));
//            return redirect()->back();
//        }

        $jobWorkingTime     = DefaultService::jobWorkingTime($job->jobWorkingTime);
        $category           = DefaultService::jobCategoryAll();
        $importantThing     = DefaultService::getCodeMstByGroup('important_thing');
        $importantThing     = $importantThing->reduce(function ($carry, $item){
            $carry[$item->value] = $item->toArray();
            return $carry;
        },[]);

        return view('supply_side.job.preview',
            [
                'job'                   => $job,
                'jobWorkingTime'        => $jobWorkingTime,
                'category'              => $category,
                'importantThing'        => $importantThing
            ]);
    }

    /**
     * function job apply
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply($id){
        $user       = Auth::user();
        $job        = $this->getJob($id);
        $job->new_trigger = 0;
        $job->save();
        if((int)$job->status == Jobs::BLOCKED_STATUS){
            Session::flash('Error',__('supply.job.access_block'));
            return redirect()->back();
        }
        $sort           = $this->getSortData();
        $applicant      = $this->getApplicantBỵJob($job, $sort);
        $jobFlow        = JobService::jobFlow(true);
        $progressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
        $reasonCd       = DefaultService::getReasonCd();

        return view('supply_side.job.apply', compact('reasonCd','sort', 'user', 'job', 'applicant', 'jobFlow', 'progressStatus'));
    }

    /**
     * @return array|mixed
     */
    private function getSortData(){
        $request = request();
        if($request->sort){
            $sort = $request->sort;
        }else {
            $sort = [];
            $sort['updated_at']         = $request->input('updated_at', '');
            $sort['name']               = $request->input('name', '');
            $sort['progress_status']    = $request->input('progress_status', '');
            $sort['communicate']        = $request->input('communicate', '');
        }
        return $sort;
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

        return $model->paginate(self::PAGINATE);
    }


    /**
     * Create job.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $user       = Auth::user();
        $cid        = isset($user->company_id)?$user->company_id:null;
        $access     = JobService::accessJobBycompany($cid);
        if($access === false)
            return redirect()->back();

        $company    = DefaultService::getCompanyAddress();
        if ($company['results'] == null)
            return redirect()->route('company');

        $job = new Jobs();
        $prefectures    = $this->getSelectBoxPrefectures($request);
        $minimumWages   = DefaultService::getMinimumWagesPrefecture();
        $maximumWages   = DefaultService::getCodeMstByGroup('max_salary');
        $maximumWages   = ($maximumWages[0]['value'])?$maximumWages[0]['value']:5000;
        $important      = DefaultService::getCodeMstByGroup(Jobs::IMPORTANT_THING);
        $japaneseLevel  = DefaultService::getCodeMstByGroup(Jobs::JAPANESE_LEVEL);
        $categories     = DefaultService::jobCategoryTree();

        $errors         = [];
        if($request->method() == 'POST' && $request->ajax()){
            return $this->createJob($request);
        }

        return view('supply_side.job.form',
            [
                'job'               => $job,
                'prefectures'       => $prefectures,
                'minimumWages'      => $minimumWages,
                'maximumWages'      => $maximumWages,
                'important'         => $important,
                'japaneseLevel'     => $japaneseLevel,
                'categories'        => $categories,
                'company'           => $company,
                'error'             => $errors
            ]);
    }

    /**
     * get errors create job
     * @param Request $request
     * @return json
     */
    private function createJob(Request $request){
        $results = [
            'messages' => null,
            'results' => null,
            'status' => 400
        ];

        $errors = $this->getErrors($request);
        if(count($errors) > 0){
            $results['status'] = 200;
            $results['messages'] = $errors;
        }else{
            $registerResult = JobService::registerJob($request);
            if($registerResult === false){
                // Error insert
                $results['status'] = 400;
                $results['messages'] = __('supply.common.system_error');
            }else{
                // success insert
                $results['status'] = 200;
                $results['redirect_url'] = route('mypage', ['sort[updated_at]' => 'DESC']);
                session()->flash('Success',__('supply.common.created_job_success'));
            }
        }
        return Json::encode($results);
    }

    /**
     * get errors update job
     * @param Request $request
     * @return json
     */
    private function updateJob(Request $request){
        $results = [
            'messages' => null,
            'results' => null,
            'status' => 400
        ];

        $errors = $this->getErrors($request);
        if(count($errors) > 0){
            $results['status'] = 200;
            $results['messages'] = $errors;
        }else{
            $registerResult = JobService::updateJob($request);
            if($registerResult === false){
                // Error Update
                $results['status'] = 400;
                $results['messages'] = __('supply.common.system_error');
            }else{
                // Update insert
                $results['status'] = 200;
                $results['redirect_url'] = route('mypage', ['sort[updated_at]' => 'DESC']);
                //$results['redirect_url'] = route('supply.job.detail',['id' => $request->id]);
                session()->flash('Success',trans('supply.common.edit_job_success'));
            }
        }

        return Json::encode($results);
    }

    /**
     * get errors create job
     * @param Request $request
     * @return array
     */
    private function getErrors(Request $request){
        $errors = DefaultService::jobValidate($request)->errors()->messages();
        $results = [];
        if($errors && count($errors) > 0){
            foreach ($errors as $key => $item){
                if(count($item) > 0 )
                    $results[$key] = implode(',', $item);
            }
        }
        return $results;
    }


    /**
     * Get Select box prefectures city.
     * @param Request $request
     * @return array
     */

    private function getSelectBoxPrefectures($request){
        $result = [];
        $result['prefectures']    = DefaultService::getPrefecture();

        if(isset($request->workplace_prefecture))
            $result['workplace_city1']    = DefaultService::getCtyByPrefecture($request->workplace_prefecture);

        if(isset($request->workplace_city1))
            $result['workplace_city2']    = DefaultService::getCty2ByCityName($request->workplace_city1);

        if(isset($request->interview_prefecture))
            $result['interview_city1']    = DefaultService::getCtyByPrefecture($request->interview_prefecture);

        if(isset($request->interview_city1))
            $result['interview_city2']    = DefaultService::getCty2ByCityName($request->interview_city1);

        return $result;
    }

    /**
     * Edit job.
     * @param Request $request
     * @param id $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id){
        $job                = $this->getJob($id);

        if((int)$job->status == Jobs::BLOCKED_STATUS){
            Session::flash('Error',__('supply.job.access_block'));
            return redirect()->back();
        }

        if($request->method() == 'POST' && $request->ajax())
            return $this->updateJob($request);

        $jobWorkingTime     = DefaultService::jobWorkingTime($job->jobWorkingTime);
        $importantThing     = DefaultService::getCodeMstByGroup('important_thing');
        $prefectures        = $this->getSelectBoxPrefectures($job);

        $company = DefaultService::getCompanyAddress();
        if ($company['results'] == null)
            return redirect()->route('company');

        $minimumWages   = DefaultService::getMinimumWagesPrefecture();
        $maximumWages   = DefaultService::getCodeMstByGroup('max_salary');
        $maximumWages   = ($maximumWages[0]['value'])?$maximumWages[0]['value']:5000;
        $important      = DefaultService::getCodeMstByGroup(Jobs::IMPORTANT_THING);
        $japaneseLevel  = DefaultService::getCodeMstByGroup(Jobs::JAPANESE_LEVEL);
        $categories     = DefaultService::jobCategoryTree();

        if(count($importantThing)> 0 )
            $importantThing = array_column($importantThing->toArray(), 'label', 'value');

        return view('supply_side.job.form',
            [
                'job'                   => $job,
                'jobWorkingTime'        => $jobWorkingTime,
                'categories'            => $categories,
                'importantThing'        => $importantThing,
                'japaneseLevel'         => $japaneseLevel,
                'important'             => $important,
                'prefectures'           => $prefectures,
                'minimumWages'          => $minimumWages,
                'maximumWages'          => $maximumWages,
                'company'               => $company
            ]);
    }

    /**
     * copy job.
     * @param Request $request
     * @param id $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copy(Request $request, $id){
        $cid        = isset(Auth::user()->company_id)?Auth::user()->company_id:null;
        $access     = JobService::accessJobBycompany($cid);
        if($access === false)
            return redirect()->back();

        $job                = $this->getJob($id);
        if((int)$job->status == Jobs::BLOCKED_STATUS){
            Session::flash('Error',__('supply.job.access_block'));
            return redirect()->back();
        }


        if($request->method() == 'POST' && $request->ajax())
            return $this->createJob($request);

        $jobWorkingTime     = DefaultService::jobWorkingTime($job->jobWorkingTime);
        $importantThing     = DefaultService::getCodeMstByGroup('important_thing');
        $prefectures        = $this->getSelectBoxPrefectures($job);

        $company = DefaultService::getCompanyAddress();
        if ($company['results'] == null)
            return redirect()->route('company');

        $minimumWages   = DefaultService::getMinimumWagesPrefecture();
        $maximumWages   = DefaultService::getCodeMstByGroup('max_salary');
        $maximumWages   = ($maximumWages[0]['value'])?$maximumWages[0]['value']:5000;
        $important      = DefaultService::getCodeMstByGroup(Jobs::IMPORTANT_THING);
        $japaneseLevel  = DefaultService::getCodeMstByGroup(Jobs::JAPANESE_LEVEL);
        $categories     = DefaultService::jobCategoryTree();

        if(count($importantThing)> 0 )
            $importantThing = array_column($importantThing->toArray(), 'label', 'value');

        return view('supply_side.job.form',
            [
                'job'                   => $job,
                'jobWorkingTime'        => $jobWorkingTime,
                'categories'            => $categories,
                'importantThing'        => $importantThing,
                'japaneseLevel'         => $japaneseLevel,
                'important'             => $important,
                'prefectures'           => $prefectures,
                'minimumWages'          => $minimumWages,
                'maximumWages'          => $maximumWages,
                'company'               => $company
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function reopen(Request $request, $id){
        $job = $this->getJob($id);
        $updated = $job->reOpen();
        if($request->method() == 'GET'){
            if($updated == true){
                Session::flash('Success',__('supply.common.update_success'));
            }else{
                Session::flash('Error',__('supply.common.system_error'));
            }
            return redirect()->back();
        }elseif ($request->method() == 'POST' && $request->ajax()){
            $results = [
                'messages' => ($updated == true)? __('supply.common.update_success'):__('supply.common.system_error'),
                'results' => $updated,
                'status' => ($updated == true)?200:400,
            ];
            return Json::encode($results);
        }

        return null;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function stop(Request $request, $id){
        $job = $this->getJob($id);
        $updated = $job->stop();
        if($request->method() == 'GET'){
            if($updated == true){
                Session::flash('Success',__('supply.common.update_success'));
            }else{
                Session::flash('Error',__('supply.common.system_error'));
            }
            return redirect()->back();
        }elseif ($request->method() == 'POST' && $request->ajax()){
            $results = [
                'messages' => ($updated == true)? __('supply.common.update_success'):__('supply.common.system_error'),
                'results' => $updated,
                'status' => ($updated == true)?200:400,
            ];
            return Json::encode($results);
        }

        return null;
    }

    /**
     * Job get Description category
     * @param Request $request
     * @return Json
     */
    public function getCategoryDescription(Request $request){
        $results = [
            'message' => trans('validation.job.not_description'),
            'results'  => null,
            'status'  => 400
        ];

        $categories = DefaultService::jobCategoryTree();
        if($request->id && isset($categories[$request->id])){
            $results['status'] = 200;
            if(isset($categories[$request->id]['items']))
                $results['results'] = $categories[$request->id]['items'];
        }

        return Json::encode($results);
    }

    /**
     * Job get company address by user
     * @return Json
     */
    public function getCompanyAddress(){
        $results = DefaultService::getCompanyAddress();
        return Json::encode($results);

    }

    /**
     * @param $id
     * @param bool $isOwner
     * @return \Illuminate\Http\RedirectResponse|void
     */
    private function getJob($id, $isOwner = true){
        $job                = Jobs::find($id);
        if(!$job)
            return abort(404);

        if(Auth::user()->is_admin == 1)
            return $job;

        if(($isOwner && !$job->isOwner()) || ($isOwner && $job->company_id != Auth::user()->company_id ) )
            return abort(404);
        return $job;
    }

    /**
     * @param ApplyPopupRequest $request
     * @param $action
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function applyPopup(ApplyPopupRequest $request,$action, $id){
        $data = array();
        $jobFlow            = JobService::jobFlow(true);
        $modelApllicant     = ApplyService::findById($id);
        $jobs               = $modelApllicant->job;
        $applicant          = $modelApllicant->toArray();
        $data['applicant']  = $applicant;
        $data['jobs']       = $jobs->toArray();
        $data['action']     = $action;
        $data['company']    = CompanyInfo::find($request->companyId)->toArray();
        $demand             = DemandUserInfo::find($applicant['demand_user_id']);
        $data['demand']     = $demand->toArray();
        $data['custom']     = $request->custom;
        if($request->method() == 'GET'){

            if(in_array($action, ['send_interview_info','accept_interview_date'])){
                $template = 'send_interview_info';
                $this->setDataDefault($data, $jobs, 'interview');

            }elseif (in_array($action, ['set_acceptance','send_first_day_info'])){
                $template = 'send_first_day_info';
                $this->setDataDefault($data, $jobs, 'workplace');

            }elseif (in_array($action, ['send_interview_date','reject_interview_date','request_change_interview_date'])){
                $template = 'send_interview_date';
                $this->setItvDateDataDefault($data, $demand);

            }elseif ($action == 'apply'){
                if( $applicant['application_method'] == 0){
                    $this->setDataDefault($data, $jobs, 'interview');
                    $template =  'send_interview_info';
                }else {
                    //send_interview_date
                    $template =   'send_interview_date';
                    $this->setItvDateDataDefault($data, $demand);
                }
            }

            return view('supply_side.job.apply_modal.'.$template, compact('data'));

        } elseif ($request->method() == 'POST'){
            $results = [
                'messages' => __('supply.common.system_error'),
                'results' => null,
                'status' => 400
            ];
            if (in_array($action, ['send_interview_info', 'accept_interview_date']) || ($applicant['application_method'] == 0 && $action == 'apply')) {
                $updateData['interview_dt'] = date('Y-m-d', strtotime($request->interview_date)) . ' ' . str_replace(' ','', $request->interview_time) . ':00';
                $updateData['send_interview_info_num'] = $applicant['send_interview_info_num'] + 1;
                $updateData['seq'] = $applicant['application_method'] == 0 ? 'p02' : 'm05';
                $updateData['progress_status'] = $jobFlow[$updateData['seq']]['progress_status'];
                $update = ApplyService::updateApplicantInfo($id, $updateData);
                if ($update === true) {
                    Session::flash('Success', __('supply.common.update_success'));
                    $results = [
                        'messages' => __('supply.common.update_success'),
                        'results' => null,
                        'status' => 200
                    ];
                }

            } elseif (in_array($action, ['set_acceptance', 'send_first_day_info'])) {

                $updateData['first_day_dt'] = date('Y-m-d', strtotime($request->first_day_date)) . ' ' . str_replace(' ','', $request->first_day_time) . ':00';
                $updateData['send_first_day_info_num'] = $applicant['send_first_day_info_num'] + 1;
                $updateData['seq'] = $applicant['application_method'] == 0 ? 'p05' : 'm09';
                $updateData['progress_status'] = $jobFlow[$updateData['seq']]['progress_status'];
                $update = ApplyService::updateApplicantInfo($id, $updateData);
                if ($update === true) {
                    Session::flash('Success', __('supply.common.update_success'));
                    $results = [
                        'messages' => __('supply.common.update_success'),
                        'results' => null,
                        'status' => 200
                    ];
                }

            }elseif (in_array($action, ['send_interview_date','reject_interview_date','request_change_interview_date']) || ($applicant['application_method'] == 1 && $action == 'apply')){
                $dateArray = [
                    'day1' => date('Y-m-d', strtotime($request->interview_date_1)).' '.str_replace(' ','', $request->interview_time_1).':00',
                    'day2' => date('Y-m-d', strtotime($request->interview_date_2)).' '.str_replace(' ', '', $request->interview_time_2).':00',
                    'day3' => date('Y-m-d', strtotime($request->interview_date_3)).' '.str_replace(' ','', $request->interview_time_3).':00',
                ];
                $updateData['interview_date_info_text'] = Json::encode($dateArray);
                $updateData['send_interview_date_info_num'] = $applicant['send_interview_date_info_num'] + 1;
                $updateData['seq'] = 'm02';
                $updateData['progress_status'] = $jobFlow[$updateData['seq']]['progress_status'];

                $update = ApplyService::updateApplicantInfo($id, $updateData);
                if($update === true){
                    Session::flash('Success',__('supply.common.update_success'));
                    $results = [
                        'messages' => __('supply.common.update_success'),
                        'results' => null,
                        'status' => 200
                    ];
                }
            }
            if($results['status'] == 200){
                $results['content'] = ApplyService::applyRowContent($id);
                $results['update_row'] = $id;
            }
            return Json::encode($results);
        }
    }

    /**
     * @param $data
     * @param $jobs
     * @param $prefix
     */
    private function setDataDefault(&$data, $jobs, $prefix)
    {
        $jobObj = $jobs;
        $jobs = $jobs->toArray();
        $itvPrefecture = Prefectures::find($jobs[$prefix . '_prefecture'])->toArray()['name'];
        $data[$prefix . '_address'] = $itvPrefecture . $jobs[$prefix . '_city1'] . $jobs[$prefix . '_city2'] . $jobs[$prefix . '_detail_address'] . $jobs[$prefix . '_building_name'];
        $station = Stations::find($jobs[$prefix . '_nearest_station_cd'])->toArray();
        $prefStation = Prefectures::find($station['pref_cd'])->toArray()['name'];
        $moveType = $jobs[$prefix . '_nearest_station_move_type'] == 0 ? '徒歩' : 'バス';
        $data['stationInfo'] = $jobObj->{'is_'.$prefix.'_station'} . $moveType . $jobs[$prefix . '_nearest_station_move_time'] . '分';
    }

    private function setItvDateDataDefault(&$data, $demand)
    {
        //set work days
        $workDaysCode = $demand->workDays->toArray();
        $work_days = array();
        foreach ($workDaysCode as $item){
            array_push($work_days, $item['day']);
        }
        $data['work_days'] = $work_days;
        $data['date_text'] = json_decode($data['applicant']['interview_date_info_text'], true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resultConfirm(Request $request) {
        $user = Auth::user();
        $sort           = $this->getSortDataResultConfirm();
        $applicant      = $this->getSuccessfulApplicants($sort);
        $monthFilter    = request('month_filter', date('Y-m'));
        return view('supply_side.job.result_confirm', compact('sort', 'applicant','monthFilter', 'user'));
    }

    /**
     * @param $sort
     * @return mixed
     */
    private function getSuccessfulApplicants($sort){
        if(!$sort)
            $sort           = $this->getSortDataResultConfirm();

        $user = Auth::user();
        $time       = request('month_filter', date('Y-m'));
        $firstDay   = $time.'-01';
        $lastDay    = date("Y-m-t", strtotime($firstDay));

        $model = Applicant::select('applicant.*')
            ->join('demand_user_info', 'demand_user_info.id', '=', 'applicant.demand_user_id')
            ->join('jobs', 'jobs.job_id', '=', 'applicant.job_id')
            ->where('jobs.company_id', '=', $user->company_id)
            ->whereBetween('applicant.seq_update_dt', [$firstDay, $lastDay])
            ->whereIn('seq', ['p06', 'm10'])
            ->whereNull('delete_at');

        $sortCondition = ['ASC', 'DESC'];
        $sortKeyJob = ['workplace_name', 'job_category_cd', 'job_discription_cd'];

        if(count($sort) > 0){
            foreach ($sort as $key => $item){
                if($key == 'name' && in_array($item, $sortCondition)){
                    $model->orderBy('demand_user_info.name', $item);
                }elseif(in_array($key, $sortKeyJob) && in_array($item, $sortCondition)){
                    $model->orderBy('jobs.'.$key, $item);
                }else{
                    if(in_array($item, $sortCondition))
                        $model->orderBy('applicant.'.$key, $item);
                }
            }
        }

        return $model->paginate(self::PAGINATE);
    }

    /**
     * @return array|mixed
     */
    private function getSortDataResultConfirm(){
        $request = request();
        if($request->sort){
            $sort = $request->sort;
        }else {
            $sort = [];
            $sort['name']               = $request->input('name', '');
            $sort['seq_update_dt']               = $request->input('seq_update_dt', '');
            $sort['workplace_name']               = $request->input('workplace_name', '');
            $sort['job_category_cd']               = $request->input('job_category_cd', '');
            $sort['job_discription_cd']               = $request->input('job_discription_cd', '');
        }
        return $sort;
    }
}
