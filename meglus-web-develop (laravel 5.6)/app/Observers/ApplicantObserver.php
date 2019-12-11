<?php

namespace App\Observers;

use App\Model\Applicant;
use App\Services\LogsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;

class ApplicantObserver
{
    /**
     * Handle the applicant "created" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function created(Applicant $applicant)
    {
        $attributes = $applicant->getAttributes();
        LogsService::logContent($applicant->getTable(), $attributes['id'], null, Json::encode($attributes), null);
    }

    /**
     * Handle the applicant "creating" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function creating(Applicant $applicant)
    {
        $applicant->created_id    = Auth::id();
        $applicant->updated_id    = Auth::id();
        $applicant->seq_update_dt    = Carbon::now();
//        $applicant->seq = 'p01';
        $applicant->progress_status = 1;
    }

    /**
     * Handle the applicant "updated" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function updated(Applicant $applicant)
    {
        $origin     = $applicant->getOriginal();
        $attributes = $applicant->getAttributes();
        LogsService::logContent($applicant->getTable(), $origin['id'], Json::encode($origin), Json::encode($attributes), $origin['seq']);
    }

    /**
     * Handle the applicant "updating" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function updating(Applicant $applicant)
    {
        $applicant->updated_at    = Carbon::now();
        $applicant->updated_id    = Auth::id();

        if(
        ($applicant->getOriginal('seq') != $applicant->getAttribute('seq'))
         || ($applicant->getOriginal('send_interview_info_num') != $applicant->getAttribute('send_interview_info_num'))
         || ($applicant->getOriginal('send_first_day_info_num') != $applicant->getAttribute('send_first_day_info_num'))
        ){
            $applicant->seq_update_dt    = Carbon::now();
        }
    }

    /**
     * Handle the applicant "saving" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function saving(Applicant $applicant)
    {
        //
    }

    /**
     * Handle the applicant "deleted" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function deleted(Applicant $applicant)
    {
        //
    }

    /**
     * Handle the applicant "restored" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function restored(Applicant $applicant)
    {
        //
    }

    /**
     * Handle the applicant "force deleted" event.
     *
     * @param  \App\Model\Applicant  $applicant
     * @return void
     */
    public function forceDeleted(Applicant $applicant)
    {
        //
    }
}
