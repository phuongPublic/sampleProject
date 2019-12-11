<?php

namespace App\Console\Commands;

use App\Services\MakeKpiDataService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MakeKpiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make_kpi_data:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run: php artisan make_kpi_data:run';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $date = Carbon::now()->toDateString();
        $keys = array_merge($this->keysSupply(), $this->keysDemand());
        MakeKpiDataService::makeKpiData($date, null, $keys);
    }

    /**
     * @return array
     */
    private function keysSupply(){
        return [
            // supply
            'account_register',
            'company_register',
            'account_register_job',
            'supply_account_cumulative',
            'company_account_cumulative',
            'new_jobs',
            'active_jobs',
            'stoped_jobs',
            'edited_jobs',
            'jobs_apply_by_phone',
            'jobs_apply_by_phone_and_email',
            'sequence',
            'cumulative_sequence',
            'job_japanese_level',
            'job_important_thing_cd',
            'jobs_per_job',
            'average_salary_per_job',
            'workplace_stations'
        ];
    }

    /**
     * @return array
     */
    private function keysDemand(){
        return [
            // $demand
            'watching',
            'apply_by_phone',
            'apply_by_email',
            'acceptance',
            'cancel_employment',
            'cancel_acceptance',
            'employment',
            'celebration',
            'apply_by_phone_job',
            'apply_by_email_job',
            'acceptance_job',
            'cancel_employment_job',
            'cancel_acceptance_job',
            'employment_job',
            'japanese_level',
            'important_thing_cd',
            'home_nearest_station',
            'school_nearest_station',
        ];
    }
}
