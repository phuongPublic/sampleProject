<?php
namespace App\Services;
use App\Model\Applicant;
use App\Model\Jobs;
use App\Model\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

/**
 * Class ApplyService
 * @package App\Services
 */
class ApplyService {

    /**
     * @param $id
     * @param $updateData
     * @return bool
     * @throws \Throwable
     */
    public static function updateApplicantInfo($id, $updateData)
    {
        $updateData['id'] = $id;
        return self::changeStatusApplicant($updateData);
//        DB::beginTransaction();
//        try {
//            //$data = Applicant::where('id', $id)->update($updateData);
//            $data = Applicant::where('id', $id)->first();
//            $oldSeq = $data->seq;
//            $data->fill($updateData);
//            $seq = $data->seq;
//            // send noti
//            $param = [
//                'seq'       => $seq,
//                'seq_old'   => $oldSeq,
//                'applicant' => $data
//            ];
//            $data->save();
//            // Update message log
//            $message = self::updateLogMessage($param['applicant']);
//            if($message === false){
//                DB::rollBack();
//                return false;
//            }
//            $messageId = isset($message['id'])?$message['id'] : 0;
//            // send notification & email
//            $send = self::sendNotificationBySeq($param, $messageId);
//            DB::commit();
//            return true;
//        } catch (\Exception $e) {
//            Log::error(__METHOD__ . ':' . $e->getMessage());
//            DB::rollback();
//            return false;
//        }
    }

    /**
     * @param $data
     * @return bool
     * @throws \Throwable
     */
    public static function changeStatusApplicant($data){
        DB::beginTransaction();
        try{
            $condition = [
                'id' => $data['id']
            ];

            if(isset($data['jid']))
                $condition['job_id'] = $data['jid'];
            if(isset($data['seq_old']))
                $condition['seq'] = $data['seq_old'];

            //applicant
            $applicant = Applicant::where($condition)->first();
            if(!$applicant)
                return false;

            $applicant->fill($data);
            $data['applicant'] = $applicant;
            $applicant->save();

            // Update message log
            $message = self::updateLogMessage($data['applicant']);
            if($message === false){
                DB::rollBack();
                return false;
            }
            $messageId = isset($message['id'])?$message['id'] : 0;
            // send notification & email
            $send = self::sendNotificationBySeq($data, $messageId);
            if($send == false){
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        }catch (\Exception $exception){
            Log::error(__METHOD__ . ':' . $exception->getMessage());
            DB::rollBack();
        }

        return false;
    }

    public static function updateLogMessage($applicant){
        try{
            $attributes = $applicant->getAttributes();
            $original   = $applicant->getOriginal();
            $job        = $applicant->job;
            $demand     = $applicant->demand;
            $jobFlow    = JobService::jobFlow(true);
            $data = [];
            if(in_array($attributes['seq'],['p02','p05','m02','m05','m09'])){
                if(in_array($attributes['seq'],['p05','m09'])){
                    $data = [
                        "company_name" => $job->company->company_name,
                        "company_name_en" => $job->company->company_name_en,
                        "company_tel" => $job->company->tel,
                        "workplace_name" => $job->workplace_name,
                        "workplace_name_en" => $job->workplace_name_en,
                        "workplace_post_cd" => $job->workplace_post_cd,
                        "workplace_prefecture" => $job->jobPrefectures->name,
                        "workplace_city1" => $job->workplace_city1,
                        "workplace_city2" => $job->workplace_city2,
                        "workplace_detail_address" => $job->workplace_detail_address,
                        "workplace_building_name" => $job->workplace_building_name,
                        "workplace_building_name_en" => $job->workplace_building_name_en,
                        "workplace_nearest_station_name" => $job->jobStation->station_name,
                        "workplace_nearest_station_name_r" => $job->jobStation->station_name_r,
                        "workplace_nearest_station_move_type" => $job->workplace_nearest_station_move_type,
                        "workplace_nearest_station_move_time" => $job->workplace_nearest_station_move_time,
                        "workplace_lat" => ($job->workplace_lat != 0.0)?$job->workplace_lat : 0,
                        "workplace_lon" => ($job->workplace_long != 0.0)?$job->workplace_long : 0,
                        "station_line" => (isset($job->jobStation) && isset($job->jobStation->stationLine))? $job->jobStation->stationLine->line_name:'',
                        "station_number" => $job->jobStation->stationNumber->station_number,
                        "station_prefecture" => isset($job->jobStation->stationPrefectures)? $job->jobStation->stationPrefectures->name:'',
                        "send_first_day_info_num" => $attributes['send_first_day_info_num'],
                        "first_day_dt" => $attributes['first_day_dt'],
                        "progress_status" => $attributes['progress_status'],
                        "seq" => $attributes['seq'],
                        "demand_user_name" => $demand->name
                    ];
                }elseif (in_array($attributes['seq'],['m03','m04'])){
                    $data = [
                        "company_name" => $job->company->company_name,
                        "company_name_en" => $job->company->company_name_en,
                        "company_tel" => $job->company->tel,
                        "workplace_name" => $job->workplace_name,
                        "workplace_name_en" => $job->workplace_name_en,
                        "interview_place_post_cd" => $job->interview_place_post_cd,
                        "interview_prefecture" => $job->jobInterViewPrefectures->name,
                        "interview_city1" => $job->interview_city1,
                        "interview_city2" => $job->interview_city2,
                        "interview_detail_address" => $job->interview_detail_address,
                        "interview_building_name" => $job->interview_building_name,
                        "interview_building_name_en" => $job->interview_building_name_en,
                        "interview_nearest_station_name" => $job->jobInterviewStation->station_name,
                        "interview_nearest_station_name_r" => $job->jobInterviewStation->station_name_r,
                        "interview_nearest_station_move_type" => $job->interview_nearest_station_move_type,
                        "interview_nearest_station_move_time" => $job->interview_nearest_station_move_time,
                        "interview_lat" => ($job->interview_lat != 0.0)?$job->interview_lat : 0,
                        "interview_lon" => ($job->interview_long != 0.0)?$job->interview_long : 0,
                        "station_line" => (isset($job->jobInterviewStation) && isset($job->jobInterviewStation->stationLine))? $job->jobInterviewStation->stationLine->line_name:'',
                        "station_number" => $job->jobInterviewStation->stationNumber->station_number,
                        "station_prefecture" => isset($job->jobInterviewStation->stationPrefectures)? $job->jobInterviewStation->stationPrefectures->name:'',
                        "interview_date_adjustment_text" => $applicant->interview_date_adjustment_text,
                        "progress_status" => $attributes['progress_status'],
                        "seq" => $attributes['seq'],
                        "demand_user_name" => $demand->name
                    ];
                }else{
                    $data = [
                        "company_name" => $job->company->company_name,
                        "company_name_en" => $job->company->company_name_en,
                        "company_tel" => $job->company->tel,
                        "workplace_name" => $job->workplace_name,
                        "workplace_name_en" => $job->workplace_name_en,
                        "interview_place_post_cd" => $job->interview_place_post_cd,
                        "interview_prefecture" => $job->jobInterViewPrefectures->name,
                        "interview_city1" => $job->interview_city1,
                        "interview_city2" => $job->interview_city2,
                        "interview_detail_address" => $job->interview_detail_address,
                        "interview_building_name" => $job->interview_building_name,
                        "interview_building_name_en" => $job->interview_building_name_en,
                        "interview_nearest_station_name" => $job->jobInterviewStation->station_name,
                        "interview_nearest_station_name_r" => $job->jobInterviewStation->station_name_r,
                        "interview_nearest_station_move_type" => $job->interview_nearest_station_move_type,
                        "interview_nearest_station_move_time" => $job->interview_nearest_station_move_time,
                        "interview_lat" => ($job->interview_lat != 0.0)?$job->interview_lat : 0,
                        "interview_lon" => ($job->interview_long != 0.0)?$job->interview_long : 0,
                        "station_line" => (isset($job->jobInterviewStation) && isset($job->jobInterviewStation->stationLine))? $job->jobInterviewStation->stationLine->line_name:'',
                        "station_number" => $job->jobInterviewStation->stationNumber->station_number,
                        "station_prefecture" => isset($job->jobInterviewStation->stationPrefectures)? $job->jobInterviewStation->stationPrefectures->name:'',
                        "progress_status" => $attributes['progress_status'],
                        "seq" => $attributes['seq'],
                        "demand_user_name" => $demand->name
                    ];
                }


                if($attributes['seq'] == 'p02' || $attributes['seq'] == 'm05'){
                    $data['send_interview_info_num']    = $attributes['send_interview_info_num'];
                    $data['interview_dt']               = $attributes['interview_dt'];
                }

                if(in_array($attributes['seq'],['m02'])){
                    $data['send_first_day_info_num']    = $attributes['send_first_day_info_num'];
                    $data['interview_date_info_text']   = json_decode($attributes['interview_date_info_text'], true);
                }

            }elseif (in_array($attributes['seq'],['p03','p04','p06','p07','p08','m07','m08','m10','m11','m12'])){
                $reasonCd = DefaultService::getReasonCd();
                $data = [
                    "company_name" => $job->company->company_name,
                    "company_name_en" => $job->company->company_name_en,
                    "workplace_name" => $job->workplace_name,
                    "workplace_name_en" => $job->workplace_name_en,
                    "progress_status" => $attributes['progress_status'],
                    "created_at" => $attributes['created_at'],
                    "seq" => $attributes['seq'],
                    "demand_user_name" => $demand->name
                ];

                if($attributes['seq'] == 'p04' || $attributes['seq'] == 'm08'){
                    $jobFlow = $jobFlow[$attributes['seq']];
                    $data['deadline_dt'] = Carbon::createFromTimeString($attributes['seq_update_dt'])->addDay((int)$jobFlow['attention_condition'])->format('Y-m-d h:i:s');
                }

                if(in_array($attributes['seq'],['p07','p08','m11','m12'])){
                    $data["reason_cd"]       = isset($reasonCd[$attributes['reason_cd']])? $reasonCd[$attributes['reason_cd']]: '';
                    $data["reason_text"]    =  $attributes['reason_text'];
                }

                if($attributes['seq'] == 'm11'){
                    $reasonCd = DefaultService::getReasonCd();
                    $data['reason_cd']    = isset($reasonCd[$attributes['reason_cd']])? $reasonCd[$attributes['reason_cd']]: '' ;
                    $data['reason_text']               = $attributes['reason_text'];
                }

            }

            if(count($data) > 0){
                if (in_array($attributes['seq'],['m03','m04'])) {
                    // Log DB
                    $message =  Message::create(
                        [
                            'applicant_id'    => $applicant->id,
                            'from_id'         => Auth::id(),
                            'to_id'           => $applicant->demand_user_id,
                            'content'         => Json::encode($data),
                            'send_status'     => 1,
                        ]
                    );
                } else {
                    // Log DB
                    $message =  Message::create(
                        [
                            'applicant_id'    => $applicant->id,
                            'from_id'         => Auth::id(),
                            'to_id'           => $applicant->demand_user_id,
                            'content'         => Json::encode($data),
                        ]
                    );
                }
                return $message->toArray();
            }
            return $data;

        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * @param $data
     * @param int $messageId
     * @return bool
     * @throws \Throwable
     */
    public static function sendNotificationBySeq($data, $messageId = 0){
        try{
            //$job        = Jobs::getInfoById($data['jid']);
            $applicant  = $data['applicant'];
            $attributes = $applicant->getAttributes();
            $job        = $applicant->job;
            $demand     = $applicant->demandUser;
            if(!$job || !$demand)
                return false;
            $seq        = isset($data['seq'])? $data['seq']: $attributes['seq'];
            $jobFlow    = JobService::jobFlow(true);
            $jobFlow    = $jobFlow[$seq];
            if(!$jobFlow)
                return false;

            // Send email
            if($jobFlow['mail_to_supply_user'] == Applicant::SEND_MESSAGE){
                $titleEmail    = self::mailTitleBySeq($seq);
                if($titleEmail){
                    $title      = str_replace(['DEMAND_NAME'], [$demand->name], $titleEmail);
                    $body       = view('supply_side.applicant.mail_template.progress_status_'.$seq, compact('job','demand','data'))->render();
                    $email      = $job->jobOwner->login_id;
                    //$sendEmail = EmailService::sendMailHtml($email, $body, $title);
                    $sendEmail = EmailService::sendEmailBySes($email, $title, $body);
                }
            }

            // Push notification
            if($jobFlow['push_to_deman_user'] == Applicant::SEND_MESSAGE){
                $devices = $demand->getDevices;
                if($devices->count() > 0){
                    $devices = $devices->reduce(function ($carry, $item){
                        $carry[] = $item->registration_token;
                        return $carry;
                    },[]);
                    $notification    = self::notificationBySeq($seq);
                    if($notification){

                        $title      = $notification['title'];
                        $content    = $notification['content'];
                        $notificationType    = isset($notification['notification_type'])? $notification['notification_type']:'message_in_job_detail';
//                        $key = [
//                            'company_name','workplace_name','send_interview_info_num',
//                            'progress_status','send_first_day_info_num','send_interview_date_info_num'
//                        ];
//                        $val = [
//                            $job->company->company_name,$job->workplace_name,(int)$attributes['send_interview_info_num'],
//                            (int)$attributes['progress_status'],'#'.(int)$attributes['send_first_day_info_num'], '#'.(int)$attributes['send_interview_date_info_num']
//                        ];

                        $key = ['workplace_name'];
                        $val = [$job->workplace_name];

                        $pushData = [
                            'notification_type' => $notificationType,
                            'content' => [
                                'notification_type' => $notificationType,
                                'message_id' => $messageId,
                                'job_id' => $job->job_id,
                            ]
                        ];


                        if(count($key) > 0 ){
                            $title = str_replace($key, $val, $title);
                            $content = str_replace($key, $val, $content);
                        }

                        $content = nl2br($content);
                        $breaks = array("<br />","<br>","<br/>");
                        $content = str_ireplace($breaks, "\r\n", $content);
                        $badge = Message::countNumberOfUnread($demand->id);
                        $pushToDevice = NotificationService::pushToDevice($devices, $title, $content, $pushData, $badge);
                    }
                }

            }

            return true;
        }catch (\Exception $e){
            Log::error(__METHOD__ . ':' . $e->getMessage());
            return false;
        }

    }

    /**
     * @param $seq
     * @return mixed
     */
    public static function mailTitleBySeq($seq){
        $emails = [
            'm01' => '【ナナコネ】新着の応募が届いています',
            'm03' => '【ナナコネ】応募者から面接候補日の返信が届いています',
            'm04' => '【ナナコネ】応募者が面接候補日を選択できませんでした',
            'm06' => '【ナナコネ】応募者から面接候補日の再調整依頼が届いています',
            'm09' => '【ナナコネ】応募者から応募辞退の連絡が届いています',
            'm13' => 'm13 - DEMAND_NAME Send email to supply user',
            'p01' => '【ナナコネ】新着の応募が届いています',
            'p03' => '【ナナコネ】応募者から面接候補日の返信が届いています',
            'p04' => '【ナナコネ】応募者が面接候補日を選択できませんでした',
            'p06' => '【ナナコネ】応募者から面接候補日の再調整依頼が届いています',
            'p09' => '【ナナコネ】応募者から応募辞退の連絡が届いています',

        ];

        return (isset($emails[$seq]))? $emails[$seq]:null;
    }

    /**
     * @param $seq
     * @return mixed
     */
    public static function notificationBySeq($seq){
        $notifications = [
            'm02' => [
                'title'     => ' ',
                'content'   => '【面接候補日の調整】<br> workplace_name様から面接候補日が届きました。<br> 面接日を選択してください。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm05' => [
                'title'     => ' ',
                'content'   => '【面接のご案内】 <br> workplace_name様から面接の案内が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm07' => [
                'title'     => ' ',
                'content'   => '【内定通知】<br> workplace_name様から内定通知が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm08' => [
                'title'     => ' ',
                'content'   => '【選考中のご案内】<br> workplace_name様から選考中の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm09' => [
                'title'     => ' ',
                'content'   => '【初勤務日のご案内】<br> workplace_name様から初勤務日の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm10' => [
                'title'     => ' ',
                'content'   => '【採用通知】<br>おめでとうございます！<br> workplace_name様から採用通知が届きました。<br> お祝い金の申請をして3000円を受け取ってください！',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm11' => [
                'title'     => '',
                'content'   => '【内定取消通知】<br> workplace_name様から内定取消の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'm12' => [
                'title'     => ' ',
                'content'   => '【不採用通知】<br> workplace_name様から不採用の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p02' => [
                'title'     => ' ',
                'content'   => '【面接のご案内】<br> workplace_name様から面接の案内が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p03' => [
                'title'     => ' ',
                'content'   => '【内定通知】<br> workplace_name様から内定通知が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p04' => [
                'title'     => ' ',
                'content'   => '【選考中のご案内】<br> workplace_name様から選考中の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p05' => [
                'title'     => ' ',
                'content'   => '【初勤務日のご案内】<br> workplace_name様から初勤務日の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p06' => [
                'title'     => ' ',
                'content'   => '【採用通知】<br> おめでとうございます！<br> workplace_name様から採用通知が届きました。<br> お祝い金の申請をして3000円を受け取ってください！',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p07' => [
                'title'     => ' ',
                'content'   => '【内定取消通知】<br> workplace_name様から内定取消の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],
            'p08' => [
                'title'     => ' ',
                'content'   => '【不採用通知】<br> workplace_name様から不採用の連絡が届きました。',
                'notification_type' => Jobs::MESSAGE_SHOW_JOB
            ],

        ];

        return (isset($notifications[$seq]))? $notifications[$seq]:null;
    }

    /**
     * @param $id
     * @param null $template
     * @return string
     * @throws \Throwable
     */
    public static function applyRowContent($id, $template = null){
        $user       = Auth::user();
        $item       = self::getApplicantBỵId($id);
        $jobFlow        = JobService::jobFlow(true);
        $progressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
        $reasonCd       = DefaultService::getReasonCd();
        $notTr          = true;
        $template = (!isset($template)) ? 'supply_side.job.apply_row' : $template;

        $content = view($template, compact('reasonCd', 'user', 'item', 'jobFlow', 'progressStatus','notTr'))->render();
        return $content;
    }

    /**
     * @param $id
     */
    public static function findById($id){
        $applicant                = Applicant::find($id);
        if(!$applicant)
            return abort(404);

        return $applicant;
    }

    /**
     * @param $aid
     * @return mixed
     */
    public static function getApplicantBỵId($aid){
        $model = Applicant::select(['applicant.*','demand_user_info.name','demand_user_info.id AS demand_user_id','demand_user_info.tel','demand_user_info.mail']);
        $result = $model->join('demand_user_info', 'demand_user_info.id', '=', 'applicant.demand_user_id')->where('applicant.id', $aid)->whereNull('delete_at')->get()->first();
        return $result;
    }

}
