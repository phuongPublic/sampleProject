<?php

namespace App\Console\Commands;

use App\Model\DemandUserDevice;
use App\Model\Jobs;
use App\Model\SupplyUserInfo;
use App\Services\EmailService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CelebrationMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'celebration_money:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run: php artisan celebration_money:run';

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
     */
    public function handle()
    {
        $records_for_proceeding = \App\Model\CelebrationMoney::where('type', 2)->whereNull('set_employment_dt')->get();
        foreach ($records_for_proceeding as $key => $value) {
            if ($value->created_at->addDays(30) > Carbon::now()) {
                if ($value->applicant->progress_status == 8) {
                    $value->type = 3;
                    $value->save();
                    DemandUserDevice::pushNotificationByUserId(
                        $value->applicant->demand_user_id,
                        'notPermissonToApplyMoney_cancelByYourSelf'
                    );
                } elseif ($value->applicant->progress_status == 5) {
                    $value->set_employment_dt = Carbon::now();
                    $value->save();

                    DemandUserDevice::pushNotificationByUserId(
                        $value->applicant->demand_user_id,
                        'successReceiveApplyMoney'
                    );
                } elseif ($value->applicant->progress_status == 6 || $value->applicant->progress_status == 7) {
                    $value->type = 1;
                    $value->save();

                    DemandUserDevice::pushNotificationByUserId(
                        $value->applicant->demand_user_id,
                        'notPermissonToApplyMoney_statusIn67'
                    );
                } else {
                    $email_data['applicant_url'] = url('job/apply/' . $value->applicant->job_id);
                    $supply_info = SupplyUserInfo::getSupplyUserInfoByJobId($value->applicant->job_id);
                    $to = $supply_info->login_id;
                    $username = $supply_info->last_name . $supply_info->first_name;

                    EmailService::sendBySes(
                        '[VN]'. $username .'様からお祝い金の申請が届いています。採用ステータスを更新してください',
                        $to,
                        'email.submit_celebration_money_to_supply',
                        $email_data
                    );
                }
            } elseif (!in_array($value->applicant->progress_status, [5,6,7,8])) {
                $value->set_employment_dt = Carbon::now();
                $value->save();

                DemandUserDevice::pushNotificationByUserId(
                    $value->applicant->demand_user_id,
                    'successReceiveApplyMoney'
                );

                $supply_info = SupplyUserInfo::getSupplyUserInfoByJobId($value->applicant->job_id);
                $email_data['applicant_url'] = url('job/apply/' . $value->applicant->job_id);
                $email_data['user_name'] = $supply_info->last_name . $supply_info->first_name;

                $to = $supply_info->login_id;

                EmailService::sendBySes(
                    '[VN]'. $email_data['user_name'] .'様の採用ステータスを「採用」に更新しました',
                    $to,
                    'email.celebration_money_to_supply_for_cronjob',
                    $email_data
                );
            }
        }
    }
}
