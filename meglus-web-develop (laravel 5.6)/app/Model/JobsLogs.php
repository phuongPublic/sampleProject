<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobsLogs extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_status_log_id','workplace_name','workplace_name_en','workplace_post_cd','workplace_prefecture','workplace_city1','workplace_city2','workplace_detail_address',
        'workplace_building_name','workplace_building_name_en','workplace_nearest_station_cd','workplace_nearest_station_move_type','workplace_nearest_station_move_time',
        'workplace_lat','workplace_long',
        'interview_place_post_cd','interview_prefecture','interview_city1','interview_city2','interview_detail_address','interview_building_name','interview_building_name_en',
        'interview_nearest_station_cd','interview_nearest_station_move_type','interview_nearest_station_move_time','job_category_cd','job_discription_cd',
        'interview_lat','interview_long',
        'min_salary','max_salary','japanese_level','experience1_category_cd','experience1_description_cd','experience2_category_cd','experience2_description_cd',
        'experience3_category_cd','experience3_description_cd','important1_cd','important2_cd','important3_cd',
        'application_method','new_trigger','created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * The attributes appends  .
     * @var array
     */
    protected $appends  = [
        'is_workplace_station' => null,
        'is_interview_station'    => null,
        'is_station_name'    => null,
        'is_interview_station_name'    => null
    ];

    /**
     * Get the appends station attributes.
     *
     * @return bool
     */
    public function getIsWorkplaceStationAttribute()
    {
        $result = null;
        if(isset($this->jobStation) && isset($this->jobStation->station_name))
            $result .= $this->jobStation->station_name;
        if(isset($this->jobPrefectures) && isset($this->jobStation->stationPrefectures))
            $result = $result.'（'.$this->jobStation->stationPrefectures->name.'）';

        return $result;
    }

    /**
     * Get the appends station attributes.
     *
     * @return bool
     */
    public function getIsInterviewStationAttribute()
    {
        $result = null;
        if(isset($this->jobInterviewStation) && isset($this->jobInterviewStation->station_name))
            $result .= $this->jobInterviewStation->station_name;
        if(isset($this->jobPrefectures) && isset($this->jobStation->stationPrefectures))
            $result = $result.'（'.$this->jobStation->stationPrefectures->name.'）';

        return $result;
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
        return $this->hasMany('App\Model\JobWorkingTimeLogs','job_status_log_id', 'job_status_log_id');
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
    public function jobInterViewPrefectures()
    {
        return $this->hasOne('App\Model\Prefectures','id', 'workplace_prefecture');
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
        return $this->hasOne('App\Model\Stations','station_cd', 'workplace_nearest_station_cd');
    }

    /**
     * Get the jobCategory record associated with the job.
     */
    public function jobCategory()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id', 'job_category_cd');
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

}
