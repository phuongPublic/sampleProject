<?php

namespace App\Console\Commands;

use App\Model\Applicant;
use App\Model\SupplyUserInfo;
use App\Services\ApplyService;
use App\Services\EmailService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemindSetEmployment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind_set_employment:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run: php artisan remind_set_employment:run';

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
     *
     * @return mixed
     * @throws
     */
    public function handle()
    {
        $applicants = Applicant::whereIn('seq', ['p05', 'm09'])->get();
        dd(count($applicants));
        foreach ($applicants as $applicant) {
            if (!empty($applicant->first_day_dt) && $applicant->first_day_dt < Carbon::now()) {
                if (Carbon::now()->diffInHours($applicant->first_day_dt) <= 24) {
                    continue; //don't proceed if value <= 1 days
                }

                if (Carbon::now()->diffInHours($applicant->first_day_dt) > (7 * 24)) {
                    //send mail to shop (slide 162)
                    $supply_info = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                    $applicant->first_day_dt = Carbon::createFromFormat('Y-m-d H:i:s', $applicant->first_day_dt);
                    $email_data['first_day_dt'] = $applicant->first_day_dt->format('Y/m/d');
                    $email_data['first_day_dt_add_one_week'] = $applicant->first_day_dt->addDays(7)->format('Y/m/d');
                    $email_data['user_name'] = $supply_info->last_name . $supply_info->first_name;
                    $to = $supply_info->login_id;

                    EmailService::sendBySes(
                        '【ナナコネ】採用ステータスを強制変更しました',
                        $to,
                        'email.remind_set_employment_for_cronjob_7days',
                        $email_data
                    );

                    // proceed: action set_employment (as user interact in supply)
                    $data =  [
                        "id" => $applicant->id,
                        "seq" => $applicant->seq,
                        "progress_status" => $applicant->progress_status,
                    ];
                    ApplyService::changeStatusApplicant($data);
                    continue;
                }

                //send mail to shop (slide 161)
                $supply_info = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                $applicant->first_day_dt = Carbon::createFromFormat('Y-m-d H:i:s', $applicant->first_day_dt);
                $email_data['first_day_dt'] = $applicant->first_day_dt->format('Y/m/d');
                $email_data['first_day_dt_add_one_week'] = $applicant->first_day_dt->addDays(7)->format('Y/m/d');
                $email_data['user_name'] = $supply_info->last_name . $supply_info->first_name;
                $to = $supply_info->login_id;

                EmailService::sendBySes(
                    '【ナナコネ】採用ステータスを更新してください',
                    $to,
                    'email.remind_set_employment_for_cronjob_24hrs',
                    $email_data
                );
                continue;
            }
        }
    }
}
