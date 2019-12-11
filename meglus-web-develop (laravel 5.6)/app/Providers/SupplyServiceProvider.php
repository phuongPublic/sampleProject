<?php

namespace App\Providers;

use App\Model\Applicant;
use App\Model\CompanyInfo;
use App\Model\Jobs;
use App\Model\JobStatusLogs;
use App\Model\OtpCodes;
use App\Observers\ApplicantObserver;
use App\Observers\CompanyInfoObserver;
use App\Observers\JobsObserver;
use App\Observers\JobStatusLogsObserver;
use App\Observers\OtpCodesObserver;
use Illuminate\Support\ServiceProvider;

class SupplyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        OtpCodes::observe(OtpCodesObserver::class);
        CompanyInfo::observe(CompanyInfoObserver::class);
        Jobs::observe(JobsObserver::class);
        JobStatusLogs::observe(JobStatusLogsObserver::class);
        Applicant::observe(ApplicantObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/Supply.php';
    }
}
