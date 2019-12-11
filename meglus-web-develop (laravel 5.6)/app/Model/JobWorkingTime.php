<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobWorkingTime extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_work_times';

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
        'job_id','time_option','day','start_time','end_time','created_id',
        'updated_id','created_at','updated_at','deleted_at'
    ];

}
