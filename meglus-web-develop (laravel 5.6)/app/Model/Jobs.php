<?php

namespace App\Model;

use App\Observers\JobsObserver;
use App\Services\DefaultService;
use App\Services\JobService;
use App\Services\UtilService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Jobs extends Model
{
    const DEACTIVATED_STATUS = 0;
    const ACTIVATED_STATUS = 1;
    const BLOCKED_STATUS = 9;
    const REOPEN_STATUS = 2;
    const STOP_STATUS = 3;
//    0 => "新規掲載"
//    1 => "記事編集"
//    2 => "掲載再開"
//    3 => "掲載停止"
//    9 => "強制停止"

    const IMPORTANT_THING   = 'important_thing';
    const JAPANESE_LEVEL    = 'japanese_level';
    const MESSAGE_SHOW_JOB  = 'message_in_job_detail';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => JobsObserver::class,
        'updated'   => JobsObserver::class,
        'updating'  => JobsObserver::class,
        'deleted'   => JobsObserver::class,
        'restored'  => JobsObserver::class,
        'forceDeleted' => JobsObserver::class,
    ];

    /**
     * The attributes appends  .
     * @var array
     */
    protected $appends  = [
        'is_workplace_station' => null,
        'is_interview_station'    => null,
        'is_station_name'    => null,
        'is_station_number'    => null,
        'is_interview_station_name'    => null
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'job_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workplace_name','workplace_name_en','workplace_post_cd','workplace_prefecture','workplace_city1','workplace_city2','workplace_detail_address',
        'workplace_building_name','workplace_building_name_en','workplace_nearest_station_cd','workplace_nearest_station_move_type','workplace_nearest_station_move_time',
        'workplace_lat','workplace_long',
        'interview_place_post_cd','interview_prefecture','interview_city1','interview_city2','interview_detail_address','interview_building_name','interview_building_name_en',
        'interview_nearest_station_cd','interview_nearest_station_move_type','interview_nearest_station_move_time','job_category_cd','job_discription_cd',
        'interview_lat','interview_long',
        'min_salary','max_salary','japanese_level','experience1_category_cd','experience1_description_cd','experience2_category_cd','experience2_description_cd',
        'experience3_category_cd','experience3_description_cd','important1_cd','important2_cd','important3_cd',
        'application_method','new_trigger','status','created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * Get the appends station attributes.
     *
     * @return bool
     */
    public function getIsWorkplaceStationAttribute()
    {
        $station = DefaultService::stationLabelByCd($this->workplace_nearest_station_cd);
        if(isset($station->label))
            return $station->label;
        return null;
        /*
        $result = null;
        if(isset($this->jobStation) && isset($this->jobStation->station_name))
            $result .= $this->jobStation->station_name;
        if(isset($this->jobPrefectures) && isset($this->jobStation->stationPrefectures))
            $result = $result.'（'.$this->jobStation->stationPrefectures->name.'）';

        return $result;
        */
    }

    /**
     * Get the appends station attributes.
     */
    public function getIsInterviewStationAttribute()
    {
        $station = DefaultService::stationLabelByCd($this->interview_nearest_station_cd);
        if(isset($station->label))
            return $station->label;
        return null;
        /*
        $result = null;
        if(isset($this->jobInterviewStation) && isset($this->jobInterviewStation->station_name))
            $result .= $this->jobInterviewStation->station_name;
        if(isset($this->jobPrefectures) && isset($this->jobStation->stationPrefectures))
            $result = $result.'（'.$this->jobStation->stationPrefectures->name.'）';

        return $result;
        */
    }

    /**
     * Get the appends station name attributes.
     *
     * @return bool
     */
    public function getIsStationNameAttribute()
    {
        $result = null;
        if(isset($this->jobStation) && isset($this->jobStation->station_name))
            $result = $this->jobStation->station_name;
        return $result;
    }

    /**
     * Get the appends station name attributes.
     *
     * @return bool
     */
    public function getIsStationNumberAttribute()
    {
        $result = null;
        if(isset($this->jobStation) && isset($this->jobStation->stationNumber))
            $result =$this->jobStation->stationNumber->station_number;
        return $result;
    }
    /**
     * Get the appends station name attributes.
     *
     * @return bool
     */
    public function getIsInterviewStationNameAttribute()
    {
        $result = null;
        if(isset($this->jobInterviewStation) && isset($this->jobInterviewStation->station_name))
            $result = $this->jobInterviewStation->station_name;
        return $result;
    }


    /**
     * Get the working time record associated with the job.
     */
    public function jobWorkingTime()
    {
        return $this->hasMany('App\Model\JobWorkingTime','job_id', 'job_id');
    }

    /**
     * Get the Prefectures record associated with the job.
     */
    public function jobPrefectures()
    {
        return $this->hasOne('App\Model\Prefectures','id', 'workplace_prefecture');
    }

    /**
     * Get the Prefectures record associated with the job.
     */
    public function jobOwner()
    {
        return $this->hasOne('App\Model\SupplyUserInfo','company_id', 'company_id')->latest();
        //return $this->hasOne('App\Model\SupplyUserInfo','id', 'created_id');

    }

    /**
     * Get the Prefectures record associated with the job.
     */
    public function jobInterViewPrefectures()
    {
        return $this->hasOne('App\Model\Prefectures','id', 'interview_prefecture');
    }

    /**
     * Get the Station record associated with the job.
     */
    public function jobStation()
    {
        return $this->hasOne('App\Model\Stations','station_cd', 'workplace_nearest_station_cd');
    }

    /**
     * Get the interview Station record associated with the job.
     */
    public function jobInterviewStation()
    {
        return $this->hasOne('App\Model\Stations','station_cd', 'interview_nearest_station_cd');
    }

    /**
     * Get the jobCategory record associated with the job.
     */
    public function jobCategory()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'job_category_cd');
    }

    /**
     * Get the company record associated with the job.
     */
    public function company()
    {
        return $this->hasOne('App\Model\CompanyInfo','company_id', 'company_id');
    }

    /**
     * Get the company record associated with the job.
     */
    public function userCompany()
    {
        return $this->hasOne('App\Model\SupplyUserInfo','company_id', 'company_id')->latest();
    }

    /**
     * Get the jobCategoryDescription record associated with the job.
     */
    public function jobCategoryDescription()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'job_discription_cd');
    }

    /**
     * Get the jobJapaneseLevel record associated with the job.
     */
    public function jobJapaneseLevel()
    {
        return $this->hasOne('App\Model\CodeMst','value', 'japanese_level')->where('group', 'japanese_level');
    }

    /**
     * Get the jobExperience Category record associated with the job.
     */
    public function jobExperienceCategory1()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience1_category_cd');
    }

    public function jobExperienceCategory2()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience2_category_cd');
    }

    public function jobExperienceCategory3()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience3_category_cd');
    }

    public function jobExperienceCategoryDescription1()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience1_description_cd');
    }

    public function jobExperienceCategoryDescription2()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience2_description_cd');
    }

    public function jobExperienceCategoryDescription3()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'experience3_description_cd');
    }


    private $rules = array(
        'workplace_name' => 'required|max:20',
        'workplace_name_en' => 'required|max:20',
        'workplace_prefecture' => 'required',
        'workplace_post_cd' => 'required|numeric|digits:7',
        'workplace_city1' => 'required',
        'workplace_city2' => 'required',
        'workplace_detail_address' => 'required',
        'workplace_nearest_station_cd' => 'required',
        'workplace_nearest_station_move_type' => 'required',
        'workplace_nearest_station_move_time' => 'required|numeric|min:1',

        'interview_place_post_cd' => 'required|numeric|digits:7',
        'interview_prefecture' => 'required',
        'interview_city1' => 'required',
        'interview_city2' => 'required',
        'interview_detail_address' => 'required',
        'interview_nearest_station_cd' => 'required',
        'interview_nearest_station_move_type' => 'required',
        'interview_nearest_station_move_time' => 'required',
        'job_category_cd' => 'required',
        'job_discription_cd' => 'required',
        'min_salary' => 'required|numeric|min:1',
        'max_salary' => 'required|numeric|min:1',
        'job_time_day_1' => 'required',
//        'job_time_day_2' => 'required',
//        'job_time_day_3' => 'required',
        'unit_time_start_1' => 'required',
//        'unit_time_start_2' => 'required',
//        'unit_time_start_3' => 'required',
        'unit_time_end_1' => 'required',
//        'unit_time_end_2' => 'required',
//        'unit_time_end_3' => 'required',
        'japanese_level' => 'required',
        //'important1_cd' => 'required',
        //'important2_cd' => 'required',
        //'important3_cd' => 'required',
    );


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'workplace_name.required' => __('supply.job.workplace_name_required'),
            'workplace_name.max' => __('supply.job.workplace_name_max'),

            'workplace_name_en.required' => __('supply.job.workplace_name_en_required'),
            'workplace_name_en.max' => __('supply.job.workplace_name_en_max'),
            'workplace_post_cd.required' => __('supply.job.workplace_post_cd_required'),
            'workplace_post_cd.numeric' => __('supply.job.workplace_post_cd_required'),
            'workplace_post_cd.digits' => __('supply.job.workplace_post_cd_required'),

            'workplace_prefecture.required' => __('supply.job.workplace_prefecture_required'),
            'workplace_city1.required' => __('supply.job.workplace_city1_required'),
            'workplace_city2.required' => __('supply.job.workplace_city2_required'),

            'workplace_detail_address.required' => __('supply.job.workplace_address_required'),

            'workplace_nearest_station_cd.required' => __('supply.job.workplace_nearest_station_cd_required'),

            'workplace_nearest_station_move_type.required' => __('supply.job.workplace_nearest_station_move_type_required'),
            'workplace_nearest_station_move_time.required' => __('supply.job.workplace_nearest_station_move_time_required'),
            'workplace_nearest_station_move_time.numeric' => __('supply.job.workplace_nearest_station_move_time_required'),
            'workplace_nearest_station_move_time.min' => __('supply.job.workplace_nearest_station_move_time_required'),

            'interview_place_post_cd.required' => __('supply.job.interview_post_cd_required'),
            'interview_place_post_cd.numeric' => __('supply.job.interview_post_cd_required'),
            'interview_place_post_cd.digits' => __('supply.job.interview_post_cd_required'),
            'interview_prefecture.required' => __('supply.job.interview_prefecture_required'),
            'interview_city1.required' => __('supply.job.interview_city1_required'),
            'interview_city2.required' => __('supply.job.interview_city2_required'),

            'interview_detail_address.required' => __('supply.job.interview_detail_address_required'),

            'interview_nearest_station_cd.required' => __('supply.job.interview_nearest_station_cd_required'),

            'interview_nearest_station_move_type.required' => __('supply.job.interview_nearest_station_move_type_required'),
            'interview_nearest_station_move_time.required' => __('supply.job.interview_nearest_station_move_time_required'),

            'job_category_cd.required' => __('supply.job.job_category_cd_required'),
            'job_discription_cd.required' => __('supply.job.job_discription_cd_required'),
            'min_salary.required' => __('supply.job.min_salary_required'),
            'max_salary.required' => __('supply.job.max_salary_required'),
            'min_salary.numeric' => __('supply.job.min_salary_required'),
            'max_salary.numeric' => __('supply.job.max_salary_required'),
            'min_salary.min' => __('supply.job.max_salary_required'),
            'max_salary.min' => __('supply.job.max_salary_required'),

            'job_time_day_1.required' => __('supply.job.job_time_day_1_required'),
            'job_time_day_2.required' => __('supply.job.job_time_day_2_required'),
            'job_time_day_3.required' => __('supply.job.job_time_day_3_required'),

            'unit_time_start_1.required' => __('supply.job.unit_time_start_1_required'),
            'unit_time_start_2.required' => __('supply.job.unit_time_start_2_required'),
            'unit_time_start_3.required' => __('supply.job.unit_time_start_3_required'),

            'unit_time_end_1.required' => __('supply.job.unit_time_end_1_required'),
            'unit_time_end_2.required' => __('supply.job.unit_time_end_2_required'),
            'unit_time_end_3.required' => __('supply.job.unit_time_end_3_required'),

            'japanese_level.required' => __('supply.job.japanese_level_required'),
            'important1_cd.required' => __('supply.job.important1_cd_required'),
            'important2_cd.required' => __('supply.job.important2_cd_required'),
            'important3_cd.required' => __('supply.job.important3_cd_required'),
        ];
    }

    /**
     * Get the Work Times for the Job.
     */
    public function work_times()
    {
        return $this->hasMany('App\Model\JobWorkTime', 'job_id');
    }

    /**
     * Get the Applicant for the Job.
     */
    public function getApplicant()
    {
        return $this->hasMany('App\Model\Applicant', 'job_id');
    }

    /**
     * Get the Applicant Active for the Job.
     */
    public function getApplicantActive()
    {
        return $this->hasMany('App\Model\Applicant', 'job_id')->where('applicant.progress_status', 5);
    }

    /**
     * Get the bookmark for the Job.
     */
    public function getBookmark()
    {
        return $this->hasMany('App\Model\Bookmark', 'job_id');
    }

    /**
     * Get the Category for the Job.
     */
    public function job_category()
    {
        return $this->belongsTo('App\Model\JobCategoryMst', 'job_category_cd');
    }

    /**
     * Get the Category (description) for the Job.
     */
    public function job_description()
    {
        return $this->belongsTo('App\Model\JobCategoryMst', 'job_discription_cd');
    }

    /**
     * Get a validator for job register.
     *
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules,$this->messages());
        $validator = $this->customValidator($validator, $data);
        return $validator;
    }

    /**
     * Custom validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function customValidator($validator, $data)
    {
        $validator->after(function ($validator) use ($data){

            if(!$validator->errors()->has('min_salary') && $data['workplace_prefecture']){
                $minimumWages = DefaultService::getMinimumWagesPrefecture();
                if( isset($data['min_salary']) && (int)$data['min_salary'] < (int)$minimumWages[$data['workplace_prefecture']]){
                    $message = __('supply.job.min_salary_min_value');
                    $message = str_replace('%d',(int)$minimumWages[$data['workplace_prefecture']],$message);
                    $validator->errors()->add('min_salary', $message);
                }
            }

            if(!$validator->errors()->has('max_salary') && $data['workplace_prefecture']){
                $maximumWages   = DefaultService::getCodeMstByGroup('max_salary');
                $maximumWages   = ($maximumWages[0]['value'])?$maximumWages[0]['value']:5000;
                if( isset($data['max_salary']) && (int)$data['max_salary'] > $maximumWages){
                    $message = __('supply.job.max_salary_max_value');
                    $message = str_replace('%d',(int)$maximumWages,$message);
                    $validator->errors()->add('max_salary', $message);
                }
            }

            if(!$validator->errors()->has('min_salary') && !$validator->errors()->has('max_salary') ){
                if($data['max_salary'] <= $data['min_salary'])
                    $validator->errors()->add('max_salary', __('supply.job.min_max_salary'));
            }

            if(!$validator->errors()->has('important1_cd') && !$validator->errors()->has('important2_cd') && !$validator->errors()->has('important3_cd') ){
                $tmp = [$data['important1_cd'],$data['important2_cd'],$data['important3_cd']];
                $duplicates = $this->array_duplicates($tmp);
                if(count($duplicates) > 0){
                    if(in_array($data['important1_cd'], $duplicates)){
                        $validator->errors()->add('important1_cd', __('supply.job.important_duplicate'));
                    }elseif (in_array($data['important2_cd'], $duplicates)){
                        $validator->errors()->add('important2_cd', __('supply.job.important_duplicate'));
                    }elseif (in_array($data['important3_cd'], $duplicates)){
                        $validator->errors()->add('important3_cd', __('supply.job.important_duplicate'));
                    }
                }
            }

            if (!$validator->errors()->has('workplace_name_en') && !DefaultService::is_hankaku($data['workplace_name_en'], false))
                $validator->errors()->add('workplace_name_en', __('supply.job.workplace_name_en_format'));

            if (!$validator->errors()->has('workplace_building_name_en') && ($data['workplace_building_name_en']
                    && !DefaultService::is_hankaku($data['workplace_building_name_en'], false) ))
                $validator->errors()->add('workplace_building_name_en', __('supply.job.workplace_building_name_en_format'));

            if (!$validator->errors()->has('interview_building_name_en') && ($data['interview_building_name_en']
                    && !DefaultService::is_hankaku($data['interview_building_name_en'], false) ))
                $validator->errors()->add('interview_building_name_en', __('supply.job.interview_building_name_en_format'));

            if(!$validator->errors()->has('unit_time_start_1')){
                if(!$this->checkFortmatTime($data['unit_time_start_1']))
                    $validator->errors()->add('unit_time_start_1', __('supply.job.unit_time_start_1_format'));
            }

            if(!$validator->errors()->has('unit_time_end_1')){
                if(!$this->checkFortmatTime($data['unit_time_end_1']))
                    $validator->errors()->add('unit_time_end_1', __('supply.job.unit_time_end_1_format'));
            }

//            if(!$validator->errors()->has('unit_time_start_1') && !$validator->errors()->has('unit_time_end_1')){
//                if(str_replace(':','',$data['unit_time_end_1']) <= str_replace(':','',$data['unit_time_start_1']))
//                    $validator->errors()->add('unit_time_end_1', __('supply.job.time_start_end'));
//            }

            /* 勤務時間帯② */
            if(isset($data['job_time_day_2']) || isset($data['unit_time_start_2']) || isset($data['unit_time_end_2'])){
                if(!isset($data['job_time_day_2']))
                    $validator->errors()->add('job_time_day_2', __('supply.job.job_time_day_2_required'));

                if(!$this->checkFortmatTime($data['unit_time_start_2']))
                    $validator->errors()->add('unit_time_start_2', __('supply.job.unit_time_start_2_format'));

                if (!$this->checkFortmatTime($data['unit_time_end_2']))
                    $validator->errors()->add('unit_time_end_2', __('supply.job.unit_time_end_2_format'));

//                if(!$validator->errors()->has('unit_time_end_2') && str_replace(':','',$data['unit_time_end_2']) <= str_replace(':','',$data['unit_time_start_2']))
//                    $validator->errors()->add('unit_time_end_2', __('supply.job.time_start_end_2'));
            }

            /* 勤務時間帯② */
            if(isset($data['job_time_day_3']) || isset($data['unit_time_start_3']) || isset($data['unit_time_end_3'])){
                if(!isset($data['job_time_day_3']))
                    $validator->errors()->add('job_time_day_3', __('supply.job.job_time_day_3_required'));

                if(!$this->checkFortmatTime($data['unit_time_start_3']))
                    $validator->errors()->add('unit_time_start_3', __('supply.job.unit_time_start_3_format'));

                if (!$this->checkFortmatTime($data['unit_time_end_3']))
                    $validator->errors()->add('unit_time_end_3', __('supply.job.unit_time_end_3_format'));

//                if(!$validator->errors()->has('unit_time_end_3') && str_replace(':','',$data['unit_time_end_3']) <= str_replace(':','',$data['unit_time_start_3']))
//                    $validator->errors()->add('unit_time_end_3', __('supply.job.time_start_end_3'));
            }
        });

        return $validator;
    }

    /**
     * Get duplicate value in array
     *
     * @param $array
     * @return array
     */
    private function array_duplicates(array $array)
    {
        $dulicates = array_diff_assoc($array, array_unique($array));
        foreach ($dulicates as $key => $item){
            if(!(int)$item > 0)
                unset($dulicates[$key]);
        }

        return $dulicates;
    }

    /**
     * Check fortmat date
     * @param string $val
     * @return boolean
     */
    private function checkFortmatTime($val)
    {
        $tmp = explode(":",$val);
        if(count($tmp) < 2)
            return false;
        if($tmp[0] == "" ||$tmp[0] == "__" || $tmp[1] == "" || $tmp[1] == "__")
            return false;
        $tmp[0] = sprintf("%02d", (int)$tmp[0]);
        $tmp[1] = sprintf("%02d", (int)$tmp[1]);
        if($tmp[0] > 23 || $tmp[1] > 59)
            return false;

        return true;
    }

    /**
     * Create job
     * @param array $data
     * @return boolean
     */
    static function registerJob($data)
    {
        if(!isset($data['created_id']))
            $data['created_id'] = Auth::user()->id;
        if(!isset($data['company_id']) && Auth::user()->companyInfo && Auth::user()->companyInfo->company_id)
            $data['company_id'] = Auth::user()->companyInfo->company_id;
        if (isset($data['workplace_nearest_station_cd']) && !empty($data['workplace_nearest_station_cd'])) {
            UtilService::calculateDistanceBetweenStations($data['workplace_nearest_station_cd']);
        }

        $job = new Jobs($data);
        return $job->save();
    }

    /**
     * Is owner
     * @return bool
     */
    public function isOwner()
    {
        //if(Auth::user() && Auth::user()->id == $this->created_id)
        if(Auth::user() && Auth::user()->company_id == $this->company_id)
            return true;

        return false;
    }

    /**
     * function get job by company id
     * @param $cid
     * @return mixed
     */
    public static function getJobsBycompany($cid){
        return self::where('company_id', $cid)->get();
    }

    /**
     * function get job by user id
     * @param $uid
     * @return mixed
     */
    public static function getJobsByUser($uid){
        return self::where('created_id', $uid)->get();
    }

    /**
     * Get job detail info by id
     * @param $id
     * @param $demand_user_id
     *
     * @return object
     */
    public static function getDetailInfo($id, $demand_user_id) {
        //check user has applied this job or not
        $isApplied = Applicant::isApplied($id, $demand_user_id);

        $job = Jobs::selectRaw(
            '`jobs`.job_id, `jobs`.workplace_name, `jobs`.workplace_name_en, `jobs`.job_category_cd, `jobs`.application_method,
                `jobs`.min_salary, `jobs`.max_salary, `jobs`.japanese_level, `jobs`.workplace_nearest_station_cd,
                `stations`.station_name, `stations`.station_name_r, `jobs`.`important1_cd`, `jobs`.important2_cd,
                `jobs`.important3_cd, `station_lines`.line_name, `station_numbers`.station_number, `station_lines`.line_color_c,
                `jobs`.workplace_nearest_station_move_time as movement_time'
        )
            ->with(['jobWorkingTime' => function($query) {
                $query->selectRaw('job_id, time_option, day, DATE_FORMAT(start_time, "%H:%i") as start_time, DATE_FORMAT(end_time, "%H:%i") as end_time');
            }])
            ->with(['getApplicant' => function($query) use ($demand_user_id) {
                $query->where('demand_user_id', $demand_user_id);
            }])
            ->join('company_info', function($join) {
                $join->on('jobs.company_id', '=', 'company_info.company_id');
            })
            ->where('jobs.job_id', $id)
            ->join('stations', 'stations.station_cd', 'jobs.workplace_nearest_station_cd')
            ->leftJoin('station_lines', 'stations.line_cd', 'station_lines.line_cd')
            ->leftJoin('station_numbers', 'stations.station_cd', 'station_numbers.station_cd');

        if (!$isApplied) {
            $job = $job->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->where(function ($query) {
                $query->where('company_info.status', '!=', DB::raw(CompanyInfo::BLOCKED_STATUS));
                $query->orWhere(function($query) {
                    $query->where('company_info.status', '=', DB::raw(CompanyInfo::DEACTIVATED_STATUS));
                    $query->where('company_info.status', '>=', Carbon::now()->subDays(30));
                });
            });
        }

        $job = $job->first();

        $job->getApplicant->load('messages');
        $job = $job->toArray();
        if (isset($job['job_working_time'])) {
            foreach ($job['job_working_time'] as $k => $v) {
                $job_working_time[$v['time_option']]['start_time'] = $v['start_time'];
                $job_working_time[$v['time_option']]['end_time'] = $v['end_time'];
                $job_working_time[$v['time_option']]['days'][] = $v['day'];
            }

            $job['job_working_time'] = array_values($job_working_time);
        }

        if (isset($job['get_applicant'][0])) {
            $job['id'] = $job['get_applicant'][0]['id'];
            $job['applied_at'] = $job['get_applicant'][0]['created_at'];
            $job['progress_status'] = $job['get_applicant'][0]['progress_status'];
            $job['seq'] = $job['get_applicant'][0]['seq'];

            if (isset($job['get_applicant'][0]['messages']) && count($job['get_applicant'][0]['messages']) > 0) {
                $job['opened_flag'] = Message::OPENED;

                foreach ($job['get_applicant'][0]['messages'] as $key => $value) {
                    if ($value['status'] == Message::NOT_OPENED) {
                        $job['opened_flag'] = Message::NOT_OPENED;
                        break;
                    }
                }
            }

            unset($job['get_applicant']);
        }

        $user = session('demand_user');
        if ($job['movement_time'] >= 0 && $job['workplace_nearest_station_cd'] > 0 && $user->home_nearest_station_move_time >= 0 && $user->home_nearest_station > 0) {
            $commuting_time = CommutingTime::where('to', $job['workplace_nearest_station_cd'])
                ->where('from', $user->home_nearest_station)->first();

            if (isset($commuting_time->times) && $commuting_time->times > 0) {
                $job['movement_time'] = $job['movement_time'] + $user->home_nearest_station_move_time + $commuting_time->times;
            } else {
                $job['movement_time'] = null;
            }
        }

        unset($job['']);

        return $job;
    }

    /**
     * Get job  info by id
     * @param $id
     *
     * @return object
     */
    public static function getInfoById($id) {
        $job = Jobs::selectRaw('
                jobs.job_id, jobs.job_category_cd, jobs.job_discription_cd, company_info.company_name, company_info.status as company_status,
                jobs.workplace_name, jobs.min_salary, jobs.max_salary, jobs.japanese_level, jobs.status,
                jobs.workplace_nearest_station_move_type, 
                jobs.workplace_nearest_station_move_time,
                jobs.experience1_category_cd, jobs.experience1_description_cd,
                jobs.experience2_category_cd, jobs.experience2_description_cd,
                jobs.experience3_category_cd, jobs.experience2_description_cd,
                jobs.important1_cd, jobs.important2_cd, jobs.important3_cd, application_method
            ')
            ->where(['jobs.job_id' => $id])
            ->join('company_info', 'company_info.company_id', '=', 'jobs.company_id')
            //->join('stations as wp_station', 'wp_station.station_cd', 'jobs.workplace_nearest_station_cd')
            ->first();

        if ($job)
            return $job;

        return null;
    }

    /**
     * @param array $sort
     * @param array $filter
     * @return mixed
     */
    public static function getAdminList($sort = [], $filter = []) {
        $model = Jobs::selectRaw('
                jobs.job_id, jobs.job_category_cd, jobs.job_discription_cd, jobs.status, 
                jobs.workplace_name, jobs.min_salary, jobs.max_salary, jobs.japanese_level,
                jobs.workplace_nearest_station_move_type, 
                jobs.workplace_nearest_station_move_time,
                jobs.experience1_category_cd, jobs.experience1_description_cd,
                jobs.experience2_category_cd, jobs.experience2_description_cd,
                jobs.experience3_category_cd, jobs.experience2_description_cd,
                jobs.important1_cd, jobs.important2_cd, jobs.important3_cd, application_method,
                jobs.created_at, jobs.updated_at,
                company_info.company_name, company_info.status as company_status,
                prefectures.name AS prefectures_name, jobs.workplace_city1, jobs.workplace_city2, jobs.workplace_detail_address
            ')
            ->join('company_info', 'company_info.company_id', '=', 'jobs.company_id')
            ->join('prefectures', 'prefectures.id', '=', 'jobs.workplace_prefecture');

            if(count($filter) > 0){
                foreach ($filter as $key => $item){
                    if($key == 'name_address') {
                        if(strlen($item) > 0)
                            $model->where(function ($query) use ($item) {
                                $query->orWhere('jobs.workplace_name', 'like', '%'.$item . '%')
                                    ->orWhere('prefectures.name', 'like', '%'.$item . '%')
                                    ->orWhere('jobs.workplace_city1', 'like', '%'.$item . '%')
                                    ->orWhere('jobs.workplace_city2', 'like', '%'.$item . '%')
                                    ->orWhere('company_info.company_name', 'like', '%'.$item . '%');
                            });
                    }elseif(in_array($key, ['job_category_cd','job_discription_cd','japanese_level']) && (int)$item > 0){
                        $model->where('jobs.'.$key, $item);
                    }elseif($key == 'status' && $item != null){
                        $model->where('jobs.status', $item);
                    }elseif($key == 'company_id' && $item != null){
                        $model->where('jobs.company_id', $item);
                    }else{
                        if($item != '')
                            $model->where($key, 'like','%'.$item .'%');
                    }
                }

            }

            if(count($sort) > 0){
                foreach ($sort as $key => $item){
                    if(in_array($key, ['address']) && in_array($item,['ASC','DESC'])){
                        $model->orderBy('prefectures.name', $item);
                        $model->orderBy('jobs.workplace_city1', $item);
                        $model->orderBy('jobs.workplace_city2', $item);
                    }elseif($key == 'job_category_cd' && in_array($item,['ASC','DESC'])){
                        $model->orderBy('job_category_cd', $item);
                        $model->orderBy('job_discription_cd', $item);
                    }elseif($key == 'salary' && in_array($item,['ASC','DESC'])){
                        $model->orderBy('jobs.min_salary', $item);
                        $model->orderBy('jobs.max_salary', $item);
                    }elseif(in_array($item,['ASC','DESC'])){
                        $model->orderBy('jobs.'.$key, $item);
                    }

                }
            }

        return $model->paginate(30);
    }

    /**
     * Get all of station cd
     * @return mixed
     */
    public static function getDistinctStationCd()
    {
        $stations = Jobs::select('workplace_nearest_station_cd')->distinct()
            ->get()
            ->toArray();

        return array_pluck($stations, 'workplace_nearest_station_cd');
    }

    /**
     * @return bool
     */
    public function reOpen(){
        DB::beginTransaction();
        try{
            $data = [
                'job_id'        => $this->job_id,
                'status_before' => $this->status,
                'status_after'  => self::REOPEN_STATUS,
            ];
            $logId = JobService::jobStatusLogs($data);

            $this->status = self::REOPEN_STATUS;
            $update = $this->save();
            DB::commit();
            return $update;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function stop(){
        DB::beginTransaction();
        try{
            $data = [
                'job_id'        => $this->job_id,
                'status_before' => $this->status,
                'status_after'  => self::STOP_STATUS,
            ];
            $logId = JobService::jobStatusLogs($data);

            $this->status = self::STOP_STATUS;
            $update = $this->save();
            DB::commit();
            return $update;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function block(){
        DB::beginTransaction();
        try{
            $data = [
                'job_id'        => $this->job_id,
                'status_before' => $this->status,
                'status_after'  => self::BLOCKED_STATUS,
            ];
            $logId = JobService::jobStatusLogs($data);

            $this->status = self::BLOCKED_STATUS;
            $update = $this->save();
            DB::commit();
            return $update;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    /**
     * Update new_trigger column in job table
     *
     * @param $job_id
     * @return mixed
     */
    public static function updateNewTrigger($job_id) {
        $job = Jobs::find($job_id);
        $job->new_trigger = 1;
        return $job->save();
    }

}
