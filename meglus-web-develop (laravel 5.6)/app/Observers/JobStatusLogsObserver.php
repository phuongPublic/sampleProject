<?php

namespace App\Observers;

use App\Model\JobStatusLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobStatusLogsObserver
{
    /**
     * Handle the job status logs "creating" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function creating(JobStatusLogs $jobStatusLogs)
    {
        $jobStatusLogs->setCreatedAt(Carbon::now());
        $jobStatusLogs->setUpdatedAt(Carbon::now());
        $jobStatusLogs->created_id = Auth::id();
    }

    /**
     * Handle the job status logs "created" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function created(JobStatusLogs $jobStatusLogs)
    {
        //
    }

    /**
     * Handle the job status logs "updated" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function updated(JobStatusLogs $jobStatusLogs)
    {
        //
    }

    /**
     * Handle the job status logs "updating" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function updating(JobStatusLogs $jobStatusLogs)
    {
        $jobStatusLogs->setUpdatedAt(Carbon::now());
        $jobStatusLogs->updated_id = Auth::id();
    }

    /**
     * Handle the job status logs "deleted" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function deleted(JobStatusLogs $jobStatusLogs)
    {
        //
    }

    /**
     * Handle the job status logs "restored" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function restored(JobStatusLogs $jobStatusLogs)
    {
        //
    }

    /**
     * Handle the job status logs "force deleted" event.
     *
     * @param  \App\Model\JobStatusLogs  $jobStatusLogs
     * @return void
     */
    public function forceDeleted(JobStatusLogs $jobStatusLogs)
    {
        //
    }
}
