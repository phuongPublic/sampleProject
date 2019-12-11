<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Supply;
use App\Http\Controllers\Api\BaseController;
use App\Model\Applicant;
use App\Model\Bookmark;
use App\Model\CelebrationMoney;
use App\Model\CompanyInfo;
use App\Model\DemandUserBankInfo;
use App\Model\DemandUserInfo;
use App\Model\Jobs;
use App\Model\SupplyUserInfo;
use App\Model\Trash;
use App\Services\ApplyService;
use App\Services\DefaultService;
use App\Services\EmailService;
use App\Services\JobService;
use App\Services\ValidationService;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends BaseController
{
    use Helpers;

    /**
     * API for get job detail
     * @return mixed
     */
    public function detail($id) {
        $user = session('demand_user');
        $response = $this->getDefaultResponse();
        $response['data'] = Jobs::getDetailInfo($id, $user->id);

        return $this->response->array($response);
    }

    /**
     * API for get all of jobs
     *
     * @param $request
     * @return mixed
     */
    public function listAll(Request $request) {
        $user = session('demand_user');
        $params = $request->all();

        $filter_sorts = null;
        if (isset($params['filter'])) {
            $filter_sorts = json_decode($params['filter']);
        }

        $response = $this->getDefaultResponse();

        $bookmark = Bookmark::getBookmarkListByUser($user->id)->pluck('job_id');
        $trash = Trash::getTrashListByUser($user->id)->pluck('job_id');

        $bookmark_trash_list = $bookmark->merge($trash)->toArray();

        $applied_jobs = Applicant::select('job_id')->where('demand_user_id', $user->id)->get()->pluck('job_id')->toArray();
        $bookmark_trash_list = array_merge($bookmark_trash_list, $applied_jobs);

        $selected_column = 'DISTINCT `jobs`.job_id, `jobs`.workplace_name, `jobs`.workplace_name_en,
                `jobs`.job_category_cd, `jobs`.application_method, `jobs`.min_salary, `jobs`.max_salary,
                `jobs`.japanese_level, `jobs`.workplace_nearest_station_cd, `stations`.station_name,
                `stations`.station_name_r, `jobs`.`important1_cd`, `jobs`.important2_cd, `jobs`.important3_cd,
                `station_lines`.line_name, `station_numbers`.station_number, `station_lines`.line_color_c';

        //sort by home station (as the default)
        $selected_column .= DefaultService::generateSqlQueryForMovementTime(
            'home_nearest_station_move_time',
            'home_nearest_station',
            $user,
            $filter_sorts
        );

        if (isset($filter_sorts->school_station_sort) && in_array($filter_sorts->school_station_sort, ['asc', 'desc'])) {
            $selected_column .= DefaultService::generateSqlQueryForMovementTime(
                'school_nearest_station_move_time',
                'school_nearest_station',
                $user
            );
        }

        $result = Jobs::whereNotIn('job_id', $bookmark_trash_list)
            ->selectRaw($selected_column)
            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->join('stations', 'stations.station_cd', 'jobs.workplace_nearest_station_cd')
            ->leftJoin('station_lines', 'stations.line_cd', 'station_lines.line_cd')
            ->leftJoin('station_numbers', 'stations.station_cd', 'station_numbers.station_cd')
            ->join('company_info', function($join) {
                $join->on('jobs.company_id', '=', 'company_info.company_id');
            })
            ->join('supply_user_info', function($join) {
                $join->on('supply_user_info.company_id', '=', 'company_info.company_id');
            })
            ->where(function ($query) {
                $query->where('company_info.status', '!=', DB::raw(CompanyInfo::BLOCKED_STATUS));
                $query->orWhere(function($query) {
                    $query->where('company_info.status', '=', DB::raw(CompanyInfo::DEACTIVATED_STATUS));
                    $query->where('company_info.created_at', '>=', Carbon::now()->subDays(30));
                });
            })
            ->where(function ($query) {
                $query->where('supply_user_info.status', '=', DB::raw(SupplyUserInfo::ACTIVATED_STATUS));
                $query->orWhere(function($query) {
                    $query->where('supply_user_info.status', '=', DB::raw(SupplyUserInfo::DEACTIVATED_STATUS));
                    $query->where('supply_user_info.created_at', '>=', Carbon::now()->subDays(30));
                });
            });

        DefaultService::addSortAndFilterForJobsListApi($result, $filter_sorts);

        $jobs = $result->limit(env('JOB_LIST_LIMITATION', 20))
            ->with(['jobWorkingTime' => function($query) {
                $query->selectRaw('job_id, time_option, day, DATE_FORMAT(start_time, "%H:%i") as start_time, DATE_FORMAT(end_time, "%H:%i") as end_time');
            }])
            ->get()->toArray();

        foreach ($jobs as $key => $value) {
            $jobs[$key]['movement_time'] = $value['home_nearest_station_move_time'];
            if (isset($value['school_nearest_station_move_time'])) {
                $jobs[$key]['movement_time'] = $value['school_nearest_station_move_time'];
            }

            $new_job_working_time = array();
            foreach ($value['job_working_time'] as $k => $v) {
                $new_job_working_time[$v['time_option']]['start_time'] = $v['start_time'];
                $new_job_working_time[$v['time_option']]['end_time'] = $v['end_time'];
                $new_job_working_time[$v['time_option']]['days'][] = $v['day'];
            }

            $jobs[$key]['job_working_time'] = array_values($new_job_working_time);
            unset($jobs[$key]['']);
        }

        $response['data'] = $jobs;
        return $this->response->array($response);
    }

    /**
     * Check status of applicant status
     *
     * @return mixed
     */
    public function totalApplyStatus() {
        $user = session('demand_user');

        $today = Carbon::now()->format('Y-m-d');
        $number_of_applied_jobs = Applicant::where('demand_user_id', $user->id)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '" . $today . "'")
            ->count();


        $response = $this->getDefaultResponse();
        $response['data']['today'] = $today;
        $response['data']['applied_jobs'] = $number_of_applied_jobs;
        $response['data']['remaining'] = env('MAX_JOB_USER_CAN_APPLY_PER_DAY', 1) - $number_of_applied_jobs;
        return $this->response->array($response);
    }

    /**
     * Get Applied jobs list by User
     *
     * @param Request $request
     * @return mixed
     */
    public function listApply(Request $request) {
        $user = session('demand_user');

        $params = $request->all();
        $filter_sorts = [];
        if (isset($params['filter'])) {
            $filter_sorts = json_decode($params['filter']);
        }

        $response = $this->getDefaultResponse();
        $response['data']['applied_jobs'] = Applicant::getAppliedListByUserWithSort($user->id, $filter_sorts);

        return $this->response->array($response);
    }

    /**
     * API for apply job
     *
     * @param Request $request
     * @throws
     * @return null
     */
    public function apply(Request $request) {
        $user = session('demand_user');
        $response = $this->getDefaultResponse();

        $params = json_decode($request->get('params'));
        $jobFlow = JobService::jobFlow();

        if (count($params) == 1 && isset($params[0]->action) && isset($params[0]->applicant_id)) {
            $applicant_id = $params[0]->applicant_id;
            $applicant = Applicant::find($applicant_id);

            $job        = $applicant->job;
            $demand     = $applicant->demandUser;

            $action = $params[0]->action;
            switch ($action) {
                case 'cancel_application':
                    $send_mail_status = $jobFlow->firstWhere('action', 'cancel_application')->mail_to_supply_user;

                    if ($send_mail_status) {
                        $supply = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                        EmailService::sendBySes('【ナナコネ】応募者から応募辞退の連絡が届いています', $supply->login_id, 'supply_side.applicant.mail_template.progress_status_p09',
                            [
                                'job' => $job,
                                'demand' => $demand
                            ]
                        );
                    }

                    $applicant->seq = 'p09';
                    $applicant->seq_update_dt = Carbon::now();
                    $applicant->progress_status = 8;
                    $applicant->reason_cd = ($params[0]->reason_cd) ?? null;
                    $applicant->reason_text = ($params[0]->reason_text) ?? null;
                    $applicant->save();

                    Jobs::updateNewTrigger($applicant->job_id);
                    break;
                case 'accept_interview_date':
                    $send_mail_status = $jobFlow->firstWhere('action', 'accept_interview_date')->mail_to_supply_user;
                    if ($send_mail_status) {
                        $supply = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                        EmailService::sendBySes('【ナナコネ】応募者から面接候補日の返信が届いています', $supply->login_id, 'supply_side.applicant.mail_template.progress_status_m03',
                            [
                                'job' => $job,
                                'demand' => $demand
                            ]
                        );
                    }

                    $applicant->seq = 'm03';
                    $applicant->seq_update_dt = Carbon::now();
                    $applicant->progress_status = 9;
                    $applicant->interview_date_adjustment_text = ($params[0]->date) ?? null;

                    $applicant->save();

                    Jobs::updateNewTrigger($applicant->job_id);
                    break;
                case 'reject_interview_date':
                    $send_mail_status = $jobFlow->firstWhere('action', 'reject_interview_date')->mail_to_supply_user;
                    if ($send_mail_status) {
                        $supply = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                        EmailService::sendBySes('【ナナコネ】応募者が面接候補日を選択できませんでした', $supply->login_id, 'supply_side.applicant.mail_template.progress_status_m04',
                            [
                                'job' => $job,
                                'demand' => $demand
                            ]
                        );
                    }

                    $applicant->seq = 'm04';
                    $applicant->seq_update_dt = Carbon::now();
                    $applicant->progress_status = 9;
                    $applicant->interview_date_adjustment_text = ($params[0]->date) ?? null;

                    $applicant->save();
                    Jobs::updateNewTrigger($applicant->job_id);
                    break;
                case 'request_change_interview_date':
                    $send_mail_status = $jobFlow->firstWhere('action', 'request_change_interview_date')->mail_to_supply_user;
                    if ($send_mail_status) {
                        $supply = SupplyUserInfo::getSupplyUserInfoByJobId($applicant->job_id);
                        EmailService::sendBySes('【ナナコネ】応募者から面接候補日の再調整依頼が届いています', $supply->login_id, 'supply_side.applicant.mail_template.progress_status_m06',
                            [
                                'job' => $job,
                                'demand' => $demand
                            ]
                        );
                    }

                    $applicant->seq = 'm06';
                    $applicant->seq_update_dt = Carbon::now();
                    $applicant->progress_status = 9;
                    $applicant->interview_date_adjustment_text = ($params[0]->date) ?? null;

                    $applicant->save();
                    Jobs::updateNewTrigger($applicant->job_id);
                    break;
            }

            return $this->response->array($response);
        }


        $job_ids = array_pluck($params, 'job_id');
        if (!is_array($job_ids) || count($job_ids) == 0) {
            $response['status_code'] = 422;
            $response['errors'][] = 'errorApply_invalid_job_id';
            return $this->response->array($response);
        }

        $check = Applicant::checkUserCanApply($user->id, count($job_ids));
        if (!$check) {
            $response['status_code'] = 422;
            $response['errors'][] = 'errorApply_exceed_limit_job';
            return $this->response->array($response);
        }

        //validate user information
        $user->load('residences', 'workDays');

        $errors = ValidationService::validateForApi(
            $user->toArray(),
            ValidationService::validateRuleForUserProfileWhenApply(),
            $response,
            ValidationService::validateMessageForUserProfileWhenApply()
        );
        if (!empty($errors)) return $this->response->array($errors);

        DB::beginTransaction();
        $dataForSendMail = array();
        foreach ($params as $value) {
            //check existing
            $applicant_checking = Applicant::where(['job_id' => $value->job_id, 'demand_user_id' => $user->id])->first();
            if ($applicant_checking) {
                DB::rollBack();
                $response['status_code'] = 422;
                $response['errors'][] = 'errorApply_alreadyApply';
                return $this->response->array($response);
            }

            $job = Jobs::getInfoById($value->job_id);
            Jobs::updateNewTrigger($value->job_id);

            if (!isset($job->job_id) ||
                in_array($job->status, [Jobs::BLOCKED_STATUS, Jobs::STOP_STATUS]) ||
                in_array($job->company_status, [CompanyInfo::DEACTIVATED_STATUS, CompanyInfo::BLOCKED_STATUS])) {
                DB::rollBack();
                $response['status_code'] = 422;
                $response['errors'][] = 'errorApply_jobNotPublic';
                return $this->response->array($response);
            }

            if ($job->application_method == 0 && $job->application_method != $value->apply_method) {
                DB::rollBack();

                $response['status_code'] = 422;
                $response['errors'][] = 'errorApply_methodIsNotAllowed';
                return $this->response->array($response);
            }

            $applicant = new Applicant();
            $applicant->job_id = $value->job_id;
            $applicant->demand_user_id = $user->id;
            $applicant->application_method = $value->apply_method;
            if ($value->apply_method == 0) {
                $applicant->seq = $dataForSendMail[$value->job_id]['seq'] = $dataForSendMail[$value->job_id]['seq_old'] = 'p01';
            } elseif ($value->apply_method == 1) {
                $applicant->seq = $dataForSendMail[$value->job_id]['seq'] = $dataForSendMail[$value->job_id]['seq_old'] = 'm01';
            }

            $applicant->save();
            $dataForSendMail[$value->job_id]['applicant'] = $applicant;
        }

        //remove the job ids from bookmark
        Bookmark::where('demand_user_id', $user->id)->whereIn('job_id', $job_ids)->delete();
        DB::commit();

        foreach ($dataForSendMail as $key => $value) {
            ApplyService::sendNotificationBySeq($value);
        }

        return $this->response->array($response);
    }

    /**
     * Submit Celebration Money
     *
     * @param Request $request
     * @return mixed
     */
    public function submitCelebrationMoney(Request $request) {
        $user = session('demand_user');
        $response = $this->getDefaultResponse();

        $errors = ValidationService::validateForApi($request->all(), ValidationService::validateRuleForSubmitCelebrationMoney(), $response);
        if (!empty($errors)) return $this->response->array($errors);

        //save bank info to DB
        DemandUserBankInfo::updateOrCreate(
            [
                'demand_user_id' => $user->id,
                'bank_cd' => $request->get('bank_cd'),
                'bank_name' => $request->get('bank_name'),
                'bank_branch_cd' => $request->get('bank_branch_cd'),
                'bank_branch_name' => $request->get('bank_branch_name'),
                'bank_account_type' => $request->get('bank_account_type'),
                'bank_account_name' => $request->get('bank_account_name'),
                'bank_account_number' => $request->get('bank_account_num'),
            ],
            ['deleted_at' => null]
        );

        $applicant = Applicant::where('job_id', $request->get('job_id'))->where('demand_user_id', $user->id)->first();
        if (!isset($applicant->id)) {
            $response['status_code'] = 422;
            $response['errors'][] = 'application_id_is_not_exist';
            return $this->response->array($response);
        }

        //over 90days
        $diff_in_days = Carbon::now()->diffInDays($applicant->created_at);
        if ($diff_in_days > 90) {
            $response['status_code'] = 422;
            $response['errors'][] = 'notPermissonToApply_over90days';
            return $this->response->array($response);
        }

        $celebration_money = CelebrationMoney::where('applicant_id', $applicant->id)->first();
        if (isset($celebration_money->id)) {
            $response['status_code'] = 422;
            $response['errors'][] = 'alreadyApplyMoney';
            return $this->response->array($response);
        }

        $number_of_times_in_six_month = CelebrationMoney::where('applicant.demand_user_id', $user->id)
            ->where('celebration_money.created_at', '>=', Carbon::now()->subMonths(6))
            ->join('applicant', 'applicant.id', 'celebration_money.applicant_id')
            ->count();
        if ($number_of_times_in_six_month >= 2) {
            $response['status_code'] = 422;
            $response['errors'][] = 'notPermissonToApplyMoney_overLimitNumber';
            return $this->response->array($response);
        }

        if ($applicant->progress_status == 8) {
            $response['status_code'] = 422;
            $response['errors'][] = 'notPermissonToApplyMoney_cancelByYourSelf';
            return $this->response->array($response);
        }

        $celebration_money = new CelebrationMoney();
        $celebration_money->applicant_id = $applicant->id;
        $celebration_money->bank_cd = $request->get('bank_cd');
        $celebration_money->bank_name = $request->get('bank_name');
        $celebration_money->bank_branch_cd = $request->get('bank_branch_cd');
        $celebration_money->bank_branch_name = $request->get('bank_branch_name');
        $celebration_money->bank_account_type = $request->get('bank_account_type');
        $celebration_money->bank_account_name = $request->get('bank_account_name');
        $celebration_money->bank_account_num = $request->get('bank_account_num');
        $celebration_money->first_work_day = $request->get('first_work_day');
        $celebration_money->questionnaire_score = $request->get('questionnaire_score');
        $celebration_money->questionnaire_text = $request->get('questionnaire_text');
        if ($applicant->progress_status == 5) {
            $celebration_money->type = 0;
            $celebration_money->set_employment_dt = $applicant->seq_update_dt;
            $response['message'] = 'successReceiveApplyMoney';
        } elseif ($applicant->progress_status == 6 || $applicant->progress_status == 7) {
            $celebration_money->type = 1;
            $response['message'] = 'notPermissonToApplyMoney_statusIn67';
        } else {
            $celebration_money->type = 2;
            $response['message'] = 'notPermissonToApplyMoney_shopNotChangeStatus';

            //Send mail to shop
            $email_data['applicant_url'] = url('job/apply/' . $request->get('job_id'));
            $supply_info = Jobs::select('supply_user_info.login_id')->where('jobs.job_id', $request->get('job_id'))
                ->join('supply_user_info', 'supply_user_info.company_id', 'jobs.company_id')->first();
            $to = $supply_info->login_id;
            EmailService::sendBySes(
                '[VN]%様からお祝い金の申請が届いています。採用ステータスを更新してください',
                $to,
                'email.submit_celebration_money_to_supply',
                $email_data
            );
        }

        $celebration_money->save();
        return $this->response->array($response);
    }
}
