<?php

namespace App\Model;

use App\Observers\JobStatusLogsObserver;
use Illuminate\Database\Eloquent\Model;

class JobStatusLogs extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_status_logs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating'   => JobStatusLogsObserver::class,
        'created'   => JobStatusLogsObserver::class,
        'updated'   => JobStatusLogsObserver::class,
        'updating'  => JobStatusLogsObserver::class,
        'deleted'   => JobStatusLogsObserver::class,
        'restored'  => JobStatusLogsObserver::class,
        'forceDeleted' => JobStatusLogsObserver::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','job_id','status_before','status_after',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * @param $id
     * @return mixed
     */
    static function getHistoryByJobId($id){
        return self::where('job_id',$id)->get();
    }

    /**
     * Get the  job log.
     */
    public function jobLog()
    {
        return $this->hasOne('App\Model\JobsLogs','job_status_log_id', 'id');
    }



    /**
     * Get the Prefectures record associated with the job.
     */
    public function owner()
    {
        return $this->hasOne('App\Model\SupplyUserInfo','id', 'created_id');
    }


    /**
     * Get the first change with the job log.
     */
    public function compare()
    {
        return self::where('id', '<', $this->id)
            ->where('job_id', '=', $this->job_id)
            ->whereIn('status_after',[0,1])->orderBy('id','DESC')->first();
    }


}
