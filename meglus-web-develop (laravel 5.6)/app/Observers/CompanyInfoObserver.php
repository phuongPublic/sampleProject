<?php

namespace App\Observers;

use App\Model\CompanyInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CompanyInfoObserver
{
    /**
     * Handle the company info "created" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function created(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Handle the company info "updated" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function updated(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Handle the company info "deleted" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function deleted(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     *Handle the company info "updating" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function updating(CompanyInfo $companyInfo)
    {
        $companyInfo->updated_at    = Carbon::now();
        $companyInfo->updated_id    = Auth::id();
    }

    /**
     * Handle the company info "restored" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function restored(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Handle the company info "force deleted" event.
     *
     * @param  \App\Model\CompanyInfo  $companyInfo
     * @return void
     */
    public function forceDeleted(CompanyInfo $companyInfo)
    {
        //
    }
}
