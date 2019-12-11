<?php

namespace App\Observers;

use \App\Model\OtpCodes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OtpCodesObserver
{
    /**
     * Handle the otp codes "created" event.
     *
     * @param \App\Model\OtpCodes $otpCodes
     * @return void
     */
    public function created(OtpCodes $otpCodes)
    {
        //
    }

    /**
     * Handle the otp codes "updated" event.
     *
     * @param  \App\Model\OtpCodes  $otpCodes
     * @return void
     */
    public function updated(OtpCodes $otpCodes)
    {
        //
    }

    /**
     * Handle the otp codes "updating" event.
     *
     * @param  \App\Model\OtpCodes  $otpCodes
     * @return void
     */
    public function updating(OtpCodes $otpCodes)
    {
        $otpCodes->updated_at    = Carbon::now();
        $otpCodes->updated_id    = Auth::id();
    }

    /**
     * Handle the otp codes "deleted" event.
     *
     * @param  \App\Model\OtpCodes  $otpCodes
     * @return void
     */
    public function deleted(OtpCodes $otpCodes)
    {
        //
    }

    /**
     * Handle the otp codes "restored" event.
     *
     * @param  \App\Model\OtpCodes  $otpCodes
     * @return void
     */
    public function restored(OtpCodes $otpCodes)
    {
        //
    }

    /**
     * Handle the otp codes "force deleted" event.
     *
     * @param  \App\Model\OtpCodes  $otpCodes
     * @return void
     */
    public function forceDeleted(OtpCodes $otpCodes)
    {
        //
    }
}
