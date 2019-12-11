<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobWorkingTimeLogs extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_work_times_logs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ['job_id','time_option','day'];

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_status_log_id','time_option','day','start_time','end_time','created_id',
        'updated_id','created_at','updated_at','deleted_at'
    ];
}
