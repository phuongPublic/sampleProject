<?php

namespace App\Observers;

use App\Model\JobWorkingTime;

class JobWorkingTimeObserver
{
    /**
     * Handle the job working time "created" event.
     *
     * @param  \App\Model\JobWorkingTime  $jobWorkingTime
     * @return void
     */
    public function created(JobWorkingTime $jobWorkingTime)
    {
        //
    }

    /**
     * Handle the job working time "updated" event.
     *
     * @param  \App\Model\JobWorkingTime  $jobWorkingTime
     * @return void
     */
    public function updated(JobWorkingTime $jobWorkingTime)
    {
        //
    }

    /**
     * Handle the job working time "deleted" event.
     *
     * @param  \App\Model\JobWorkingTime  $jobWorkingTime
     * @return void
     */
    public function deleted(JobWorkingTime $jobWorkingTime)
    {
        //
    }

    /**
     * Handle the job working time "restored" event.
     *
     * @param  \App\Model\JobWorkingTime  $jobWorkingTime
     * @return void
     */
    public function restored(JobWorkingTime $jobWorkingTime)
    {
        //
    }

    /**
     * Handle the job working time "force deleted" event.
     *
     * @param  \App\Model\JobWorkingTime  $jobWorkingTime
     * @return void
     */
    public function forceDeleted(JobWorkingTime $jobWorkingTime)
    {
        //
    }
}
