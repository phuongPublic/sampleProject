<?php

namespace App\Model;

use App\Observers\ApplicantObserver;
use App\Services\DefaultService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Applicant extends Model
{
    const SEND_MESSAGE = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applicant';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating'  => ApplicantObserver::class,
        'created'   => ApplicantObserver::class,
        'updated'   => ApplicantObserver::class,
        'updating'  => ApplicantObserver::class,
        'saving'    => ApplicantObserver::class,
        'deleted'   => ApplicantObserver::class,
        'restored'  => ApplicantObserver::class,
        'forceDeleted' => ApplicantObserver::class,
    ];



    /**
     * Get the demand user with the Apllicant.
     */
    public function demand()
    {
        return $this->hasOne('App\Model\DemandUserInfo','id', 'demand_user_id');
    }


    public static function getApplicantByJobIdAndDemandId($demand_user_id, $jobId){
        return self::where(['demand_user_id' => $demand_user_id, 'job_id' => $jobId])->first();
    }

    public static function getApplicantById($id){
        return self::where(['id' => $id])->first();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','job_id','demand_user_id','application_method','seq','progress_status', 'seq_update_dt', 'interview_dt','send_interview_date_num',
        'send_interview_info_num', 'interview_date_info_text','send_interview_date_info_num' , 'interview_date_adjustment_text',
        'first_day_dt' ,'send_first_day_info_num','reason_cd','reason_text',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * Get the DemandUser record associated with the applicant.
     */
    public function demandUser()
    {
        return $this->hasOne('App\Model\DemandUserInfo','id', 'demand_user_id');
    }

    /**
     * Get the job record associated with the applicant.
     */
    public function job()
    {
        return $this->hasOne('App\Model\Jobs','job_id', 'job_id');
    }

    /**
     * Get the DemandUser record associated with the applicant.
     */
    public function jobFlow()
    {
        //return $this->hasOne('App\Model\JobFlow','application_method', 'application_method')->where('progress_status', $this->progress_status);
        return $this->hasOne('App\Model\JobFlow','seq', 'seq');
    }

    /**
     * Get the Messages for the Applicant.
     */
    public function messages()
    {
        return $this->hasMany('App\Model\Message');
    }

    /**
     * @param $jid
     * @return mixed
     */
    public static function getByJobId($jid){
        return self::where('job_id', $jid)->whereNull('delete_at')->orderBy('updated_at','DESC');
    }

    /**
     * Check user can apply or not
     *
     * @param $demand_user_id
     * @param $number_of_job_will_apply
     * @return bool
     */
    public static function checkUserCanApply($demand_user_id, $number_of_job_will_apply = 1) {
        $number_of_applied_job = Applicant::where('demand_user_id', $demand_user_id)
            ->whereBetween('created_at', [Carbon::now()->format('Y-m-d') . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 23:59:59'])
            ->count();

        $max_job_per_day = env('MAX_JOB_USER_CAN_APPLY_PER_DAY', 1);
        return (($number_of_applied_job + $number_of_job_will_apply) <= $max_job_per_day);
    }

    /**
     * Get applied jobs list by user with Sort
     * @param $demand_user_id
     * @param $filter_sorts
     * @return mixed
     */
    public static function getAppliedListByUserWithSort($demand_user_id, $filter_sorts = []) {
        $user = session('demand_user');
        $selected_column = '`jobs`.job_id, `jobs`.workplace_name, `jobs`.workplace_name_en, `jobs`.job_category_cd,
                `jobs`.application_method, `applicant`.id, `applicant`.seq, job_flow.progress_status, `jobs`.min_salary, 
                `jobs`.max_salary, `jobs`.workplace_nearest_station_cd,
                COUNT(IF(message.`status`="0",1, NULL)) "number_of_unread",
                COUNT(IF(message.`status`="1",1, NULL)) "number_of_read",
                `jobs`.workplace_nearest_station_move_time as movement_time';

        $selected_column .= DefaultService::generateSqlQueryForMovementTime(
            'home_nearest_station_move_time',
            'home_nearest_station',
            $user
        );

        if (isset($filter_sorts->school_station_sort) && in_array($filter_sorts->school_station_sort, ['asc', 'desc'])) {
            $selected_column .= DefaultService::generateSqlQueryForMovementTime(
                'school_nearest_station_move_time',
                'school_nearest_station',
                $user
            );
        }

        $result = Applicant::selectRaw($selected_column)
            ->join('jobs', 'jobs.job_id', 'applicant.job_id')
            ->join('job_flow', 'applicant.seq', 'job_flow.seq')
            ->leftJoin('message', 'applicant.id', 'message.applicant_id')
            ->join('company_info', function($join) {
                $join->on('jobs.company_id', '=', 'company_info.company_id');
//                $join->on('company_info.status', '!=', DB::raw(CompanyInfo::BLOCKED_STATUS));
            })
//            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->where('demand_user_id', $demand_user_id)
            ->groupBy('jobs.job_id');

        DefaultService::addSortAndFilterForJobsListApi($result, $filter_sorts);

        $applied_jobs = $result->paginate(env('APPLIED_JOBS_LIST_LIMITATION', 20))->toArray();
        foreach ($applied_jobs['data'] as $key => $value) {
            if (key_exists('school_nearest_station_move_time', $value)) {
                $applied_jobs['data'][$key]['movement_time'] = $value['school_nearest_station_move_time'];
            } elseif (key_exists('home_nearest_station_move_time', $value)) {
                $applied_jobs['data'][$key]['movement_time'] = $value['home_nearest_station_move_time'];
            } else {
                $applied_jobs['data'][$key]['movement_time'] = null;
            }

            //unread flag
            if ($value['number_of_unread'] > 0 || $value['number_of_read'] > 0) {
                $applied_jobs['data'][$key]['opened_flag'] = Message::OPENED;
                if ($value['number_of_unread'] > 0) {
                    $applied_jobs['data'][$key]['opened_flag'] = Message::NOT_OPENED;
                }
            }

            unset($applied_jobs['data'][$key]['number_of_read'], $applied_jobs['data'][$key]['number_of_unread']);
        }

        return $applied_jobs['data'];
    }

    /**
     * @param array $sort
     * @param array $filter
     * @return mixed
     */
    public static function getList($sort = [], $filter = []){

        $model = Applicant::select('applicant.*')
            ->join('demand_user_info', 'demand_user_info.id', '=', 'applicant.demand_user_id')
            ->join('jobs', 'jobs.job_id', '=', 'applicant.job_id')
            ->whereNull('delete_at');

        if (count($filter) > 0) {
            foreach ($filter as $key => $item) {
                if (($key == 'name') && (strlen($item) > 0)) {
                    $model->where('demand_user_info.name', 'like', '%' . $item . '%');
                }elseif (($key == 'workplace_name') && (strlen($item) > 0)) {
                    $model->where('jobs.workplace_name', 'like', '%' . $item . '%');
                }
            }
        }

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

        return $model->paginate(30);
    }

    /**
     * @param $did
     * @param array $data
     * @return mixed
     */
    public static function getListByDemand($did, $data = []){

        $model = Applicant::select('applicant.*')
            ->join('demand_user_info', 'demand_user_info.id', '=', 'applicant.demand_user_id')
            ->join('jobs', 'jobs.job_id', '=', 'applicant.job_id')
            ->where('demand_user_id', $did)
            ->whereNull('delete_at');

        if (isset($data['filter']) && count($data['filter']) > 0) {
            $filter = $data['filter'];
            foreach ($filter as $key => $item) {
                if (($key == 'name') && (strlen($item) > 0)) {
                    $model->where('demand_user_info.name', 'like', '%' . $item . '%');
                }elseif (($key == 'workplace_name') && (strlen($item) > 0)) {
                    $model->where('jobs.workplace_name', 'like', '%' . $item . '%');
                }
            }
        }

        $sortCondition = ['ASC', 'DESC'];
        $sortKeyJob = ['workplace_name', 'job_category_cd', 'job_discription_cd'];

        if (isset($data['sort']) && count($data['sort']) > 0) {
            $sort = $data['sort'];
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

        return $model->paginate(30);
    }

    /**
     * Check: user has applied this job or has not
     *
     * @param $job_id
     * @param $demand_user_id
     * @return bool
     */
    public static function isApplied($job_id, $demand_user_id) {
        $count = Applicant::where('demand_user_id', $demand_user_id)->where('job_id', $job_id)->count();

        return (boolean) $count;
    }
}
