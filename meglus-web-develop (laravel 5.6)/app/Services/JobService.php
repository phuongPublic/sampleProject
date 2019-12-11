<?php
namespace App\Services;
use App\Model\CompanyInfo;
use App\Model\JobFlow;
use App\Model\Jobs;
use App\Model\JobsLogs;
use App\Model\JobWorkingTime;
use App\Model\JobWorkingTimeLogs;
use App\Model\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: Quan Lee
 * Date: 18/11/15
 * Time: 4:10 PM
 */
class JobService {


    const TYPE_INSERT   = 0;
    const TYPE_EDIT     = 1;
    const TYPE_STOP     = 2;
    const TYPE_REOPEN   = 3;

    /**
     * Create job
     * @param $request
     * @return boolean
     */
    public static function registerJob(Request $request)
    {
        DB::beginTransaction();
        try{
            $prefectures    = DefaultService::getPrefecture();
            $workplaceAddress = $request->workplace_building_name .','.$request->workplace_detail_address .','.$request->workplace_city2 .','. $request->workplace_city1 .','.$prefectures[$request->workplace_prefecture];
            $interviewAddress = $request->interview_building_name .','.$request->interview_detail_address .','.$request->interview_city2 .','. $request->interview_city1 .','.$prefectures[$request->interview_prefecture];

            // insert job
            $job = new Jobs($request->all());
            $workplaceAddress           = addressToLatLong($workplaceAddress);
            $job->workplace_lat         = ($workplaceAddress['lat'])? $workplaceAddress['lat'] : 0;
            $job->workplace_long        = ($workplaceAddress['long'])? $workplaceAddress['long'] : 0;

            $interviewAddress           = addressToLatLong($interviewAddress);
            $job->interview_lat         = ($interviewAddress['lat'])? $interviewAddress['lat'] : 0;
            $job->interview_long        = ($interviewAddress['long'])? $interviewAddress['long'] : 0;

            $job->created_id = isset(Auth::user()->id)?Auth::user()->id:null;
            $job->company_id = (Auth::user()->companyInfo && Auth::user()->companyInfo->company_id)?Auth::user()->companyInfo->company_id:null;
            $jobSaved = $job->save();

            if($jobSaved !== true){
                DB::rollBack();
                return false;
            }

            if ($request->get('workplace_nearest_station_cd')) {
                UtilService::calculateDistanceBetweenStations($request->get('workplace_nearest_station_cd'));
            }

            // make data insert to working time
            $workingtime = self::getWorkingTime($request);
            $workingtime = array_map(function($arr) use ($job){
                return self::addKey($arr,$job->job_id);
            }, $workingtime);

            $createRows = false;
            // insert working time
            if(count($workingtime) )
                $createRows = self::insertWorkingTimeByJob($workingtime);

            if($createRows !== true){
                DB::rollBack();
                return false;
            }

            // INSERT LOG : JOB LOG
            if( isset(Route::getCurrentRoute()->action['as']) &&
                (Route::getCurrentRoute()->action['as'] == 'supply.job.create' || Route::getCurrentRoute()->action['as'] == 'supply.job.copy')
            ){
                $insertLog = self::jobLogs($job, self::TYPE_INSERT);
                if($insertLog !== true){
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();
            return $job->job_id;
        }catch (\Exception $e){
            Log::error(__METHOD__ . ':' . $e->getMessage());
            DB::rollBack();
        }

        return false;

    }

    /**
     * log job
     * @param $job , $type
     * @return bool
     */
    public static function jobLogs($job, $type = null){
        // Log master : job_status_logs
        $statusOrigin = $job->getOriginal('status');
        $dataStatus = [
            'job_id'        => $job->job_id,
            'status_before' => $statusOrigin,
            'status_after'  => $type,
        ];
        $mstId = self::jobStatusLogs($dataStatus);
        if(!$mstId)
            return false;

        // insert + edit : insert log job, insert log working time
        if(in_array($type, [0,1])){
            // Log job : jobs_logs
            $data = $job->toArray();
            $data['job_status_log_id'] = $mstId;
            if(isset($data['job_id']))
                unset($data['job_id']);

            $created = self::jobLogsData($data);
            if(!$created)
                return false;

            // Log working time
            $workingtimeLog = JobWorkingTime::where('job_id',$job->job_id)->get()->toArray();
            $workingtimeLog = array_map(function($arr) use ($mstId){
                return self::addKeyLog($arr,$mstId);
            }, $workingtimeLog);

            if(count($workingtimeLog) > 0){
                $created = self::insertWorkingTimeLog($workingtimeLog);
                if(!$created)
                    return false;
            }
        }

        return true;
    }

    /**
     * Push notification job edit
     *
     * @param $job
     * @return bool
     */
    public static function jobUpdateNotification($job){
        try{
            if( $job->status == Jobs::BLOCKED_STATUS || $job->status == Jobs::STOP_STATUS ||  $job->getApplicant->count() == 0)
                return true;

            $applicants = $job->getApplicant;
            foreach ($applicants as $key => $item){
                if(isset($item->progress_status) && !in_array($item->progress_status,[5,6,7,8])){
                    $demand     = $item->demandUser;
                    $devices = $demand->getDevices;
                    if($devices->count() > 0){
                        $devices = $devices->reduce(function ($carry, $item){
                            $carry[] = $item->registration_token;
                            return $carry;
                        },[]);

                        $title  = '';
                        $body   = '応募中の求人の情報が更新されました。掲載記事を確認してください。';
                        // Log DB
                        $message =  Message::create(
                            [
                                'from_id'         => Auth::id(),
                                'to_id'    => $demand->id,
                                'applicant_id'    => $item->id,
                                'content'    => json_encode(['message' => $body]),
                            ]
                        );
                        // push data
                        $pushData = [
                            'notification_type' => Jobs::MESSAGE_SHOW_JOB,
                            'content' => [
                                'notification_type' => Jobs::MESSAGE_SHOW_JOB,
                                'message_id' => $message->id,
                                'job_id' => $job->job_id,
                            ]
                        ];
                        $badge = Message::countNumberOfUnread($demand->id);
                        $pushToDevice = NotificationService::pushToDevice($devices, $title, $body, $pushData, $badge);

                    }
                }
            }

            return true;
        }catch (\Exception $e){

        }
        return false;
    }

    /**
     * Insert job status log
     * @param array $data
     * @return int
     */
    public static function jobStatusLogs($data){
        return DB::table('job_status_logs')->insertGetId($data);
    }

    /**
     * Insert log data
     * @param array $data
     * @return mixed
     */
    public static function jobLogsData($data){
        return JobsLogs::create($data);
    }

    /**
     * Update job
     * @param $request
     * @return boolean
     */
    public static function updateJob(Request $request)
    {
        $job = Jobs::find($request->id);
        if(!$request->id || !$job)
            return false;
        DB::beginTransaction();
        try{
            $updateData = $request->all();
            $prefectures    = DefaultService::getPrefecture();

            $oldAddress = $job->workplace_building_name .','.$job->workplace_detail_address .','.$job->workplace_city2 .','. $job->workplace_city1 .','.$prefectures[$job->workplace_prefecture];
            $workplaceAddress = $request->workplace_building_name .','.$request->workplace_detail_address .','.$request->workplace_city2 .','. $request->workplace_city1 .','.$prefectures[$request->workplace_prefecture];
            if(str_replace(' ','', $workplaceAddress) != str_replace(' ','', $oldAddress)){
                $latLong = addressToLatLong($workplaceAddress);
                $updateData['workplace_lat'] = isset($latLong['lat'])? $latLong['lat'] :0 ;
                $updateData['workplace_long'] = isset($latLong['long'])? $latLong['long'] :0 ;
            }

            $oldInterviewAddress = $job->interview_building_name .','.$job->interview_detail_address .','.$job->interview_city2 .','. $job->interview_city1 .','.$prefectures[$job->interview_prefecture];
            $interviewAddress = $request->interview_building_name .','.$request->interview_detail_address .','.$request->interview_city2 .','. $request->interview_city1 .','.$prefectures[$request->interview_prefecture];
            if(str_replace(' ','', $interviewAddress) != str_replace(' ','', $oldInterviewAddress)){
                $latLong = addressToLatLong($interviewAddress);
                $updateData['interview_lat'] = isset($latLong['lat'])? $latLong['lat'] :0 ;
                $updateData['interview_long'] = isset($latLong['long'])? $latLong['long'] :0 ;
            }

            // update job
            $updateJob = $job->update($updateData);
            if($updateJob !== true){
                DB::rollBack();
                return false;
            }

            // update success push notification applicant JOB != block,stop, && applicant.status != 5,6,7,8
            $pushNofification = self::jobUpdateNotification($job);


            // make data insert to working time
            $workingtime = self::getWorkingTime($request);
            $workingtime = array_map(function($arr) use ($job){
                return self::addKey($arr,$job->job_id);
            }, $workingtime);

            // Delete working time
            self::deleteWorkingTimeByJobId($job->job_id);

            $createRows = false;
            // insert working time
            if(count($workingtime) >0 )
                $createRows = self::insertWorkingTimeByJob($workingtime);

            if($createRows !== true){
                DB::rollBack();
                return false;
            }

            // INSERT LOG : JOB LOG EDIT
            if(isset(Route::getCurrentRoute()->action['as']) && Route::getCurrentRoute()->action['as'] == 'supply.job.edit'){
                $insertLog = self::jobLogs($job, self::TYPE_EDIT);
                if($insertLog !== true){
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();
            return $job->job_id;
        }catch (\Exception $e){
            DB::rollBack();
        }

        return false;

    }


    /**
     * function add key to array
     * @param $arr, $id
     * @return array
     */
    public static function addKey($arr, $id){
        $arr['job_id'] = $id;
        return $arr;
    }


    /**
     * function add key to array
     * @param $arr, $id
     * @return array
     */
    public static function addKeyLog($arr, $id){
        $arr['job_status_log_id'] = $id;
        return $arr;
    }


    /**
     * Get working time
     * @param $jobId
     * @return boolean
     */
    public static function deleteWorkingTimeByJobId($jobId){
        return JobWorkingTime::where('job_id', $jobId)->delete();
    }


    /**
     * Get working time
     * @param $data
     * @return boolean
     */
    public static function insertWorkingTimeByJob($data){
        return JobWorkingTime::insert($data);
    }


    /**
     * Get working time
     * @param $data
     * @return boolean
     */
    public static function insertWorkingTimeLog($data){
        return JobWorkingTimeLogs::insert($data);
    }

    /**
     * Get working time
     * @param $request
     * @return array
     */
    public static function getWorkingTime(Request $request){

        // update time
        $job_day_1          = $request->job_time_day_1;
        $job_day_2          = $request->job_time_day_2;
        $job_day_3          = $request->job_time_day_3;

        $unit_time_start_1  = $request->unit_time_start_1;
        $unit_time_start_2  = $request->unit_time_start_2;
        $unit_time_start_3  = $request->unit_time_start_3;

        $unit_time_end_1    = $request->unit_time_end_1;
        $unit_time_end_2    = $request->unit_time_end_2;
        $unit_time_end_3    = $request->unit_time_end_3;
        $tmp = [];
        $uid = isset(Auth::user()->id)?Auth::user()->id:null;
        if($job_day_1 && $unit_time_start_1 && $unit_time_end_1){
            foreach ($job_day_1 as $key=> $item){
                $tmp[] = [
                    'time_option'   => 1,
                    'day'           => $item,
                    'start_time'    => date('2000-01-01 '.$unit_time_start_1.':00'),
                    'end_time'      => date('2000-01-01 '.$unit_time_end_1.':00'),
                    'created_id'    => $uid,
                    'updated_id'    => $uid
                ];
            }
        }

        if($job_day_2 && $unit_time_start_2 && $unit_time_end_2){
            foreach ($job_day_2 as $key=> $item){
                $tmp[] = [
                    'time_option'   => 2,
                    'day'           => $item,
                    'start_time'    => date('2000-01-01 '.$unit_time_start_2.':00'),
                    'end_time'      => date('2000-01-01 '.$unit_time_end_2.':00'),
                    'created_id'    => $uid,
                    'updated_id'    => $uid
                ];
            }
        }

        if($job_day_3 && $unit_time_start_3 && $unit_time_end_3){
            foreach ($job_day_3 as $key=> $item){
                $tmp[] = [
                    'time_option'   => 3,
                    'day'           => $item,
                    'start_time'    => date('2000-01-01 '.$unit_time_start_3.':00'),
                    'end_time'      => date('2000-01-01 '.$unit_time_end_3.':00'),
                    'created_id'    => $uid,
                    'updated_id'    => $uid
                ];
            }
        }
        return $tmp;
    }

    /**
     * function check access create job
     * @param $cid
     * @return bool
     */
    public static function accessJobBycompany($cid){
        $company = CompanyInfo::find($cid);
        if($company){
            if($company->status == Jobs::BLOCKED_STATUS){
                Session::flash('Error',__('validation.login.not_valid_account'));
                return false;
            }

            $maxJob = $company->max_job_num;
            $jobs = Jobs::getJobsBycompany($cid);
            if($maxJob <= $jobs->count()){
                Session::flash('Error',str_replace('％d', $maxJob, __('supply.job.max_job_num')));
                return false;
            }
        }
        return true;
    }

    /**
     * function get job flow
     * @param bool $getValue
     * @return mixed
     */
    public static function jobFlow($getValue = false){
        //Cache::flush('cache_job_flow'.(int)$getValue);
        $results = Cache::rememberForever('cache_job_flow'.(int)$getValue, function () use ($getValue) {
            $results = JobFlow::all();
            if($getValue === true){
                $results = $results->reduce(function ($arr , $item){
                    $arr[$item->seq] = $item->toArray();
                    return $arr;
                });
            }
            return $results;
        });
        return $results;
    }







}
