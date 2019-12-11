<?php

namespace App\Observers;

use App\Model\Jobs;

class JobsObserver
{
    /**
     * Handle the jobs "created" event.
     *
     * @param  \App\Model\Jobs  $jobs
     * @return void
     */
    public function created(Jobs $jobs)
    {

    }

    /**
     * Handle the jobs "updated" event.
     *
     * @param  \App\Model\Jobs  $jobs
     * @return void
     */
    public function updated(Jobs $jobs)
    {
    }

    /**
     * Handle the jobs "deleted" event.
     *
     * @param  \App\Model\Jobs  $jobs
     * @return void
     */
    public function deleted(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the jobs "restored" event.
     *
     * @param  \App\Model\Jobs  $jobs
     * @return void
     */
    public function restored(Jobs $jobs)
    {
        //
    }

    /**
     * Handle the jobs "force deleted" event.
     *
     * @param  \App\Model\Jobs  $jobs
     * @return void
     */
    public function forceDeleted(Jobs $jobs)
    {
        //
    }
}
