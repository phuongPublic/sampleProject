<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 11/30/2018
 * Time: 5:01 PM
 */


namespace App\Helpers;

use App\Services\DefaultService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Psy\Util\Json;

class Supply {

    /**
     * @param $data
     * @param $attr
     * @return string
     */
    public static function makeDataAttr($data, $attr) {
        $str = ' data-sort ='.$attr.' ';
        if(isset($data[$attr]) && $data[$attr] != '' )
           $str = ' data-sort-icon='.$data[$attr].' data-sort ='.$attr.' data-sort-val ='.$data[$attr].'  data-sort-index ='.(array_search($attr,array_keys($data))+1).' ';
        return $str;
    }

    /**
     * @param $apply
     * @param $jobFlow
     * @param $progressStatus
     * @return string
     */
    public static function generateSelectableProgress($apply, $jobFlow, $progressStatus) {
        $val = explode(',', $jobFlow[$apply->seq]['selectable_progress_status']);
        $str = '';
        if(count($val) > 0){
            foreach ($val as $key => $item){
                $newJobFlow = isset($jobFlow[$item])? $jobFlow[$item]:null;
                if(isset($newJobFlow)){
                    $encryptString = [
                        'id'        => $apply->id,
                        'jid'       => $apply->job_id,
                        'seq'       => $item,
                        'status'        => $newJobFlow['progress_status'],
                        'progress_status'        => $newJobFlow['progress_status'],
                        'seq_old'       => $apply->seq,
                        'status_old'    => $apply->progress_status,
                        'current_route_name'    => Route::currentRouteName(),
                    ];
                    $encryptString = Json::encode($encryptString);
                    $str .= '<a href="javascript:void(0);" class="dropdown-item change-proccess-status" data-status="'.$item.'" data-url="'.Crypt::encryptString($encryptString).'"  >'.$progressStatus[$newJobFlow['progress_status']].'</a>';
                }
            }
        }

        if(strlen($str) > 0)
            $str = '    <div class="dropdown dropdown-apply">
                            <button class="btn dropdown-toggle btn btn-outline-secondary" type="button" id="dropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">選択</button>
                            <div class="dropdown-menu" id="action'.$apply->id.'" aria-labelledby="dropdownButton">
                            '.$str.'
                            </div>
                        </div>';
        return $str;
    }

    /**
     * @param $seq
     * @param $applicant
     * @return mixed|null
     */
    public static function generateAttentionText($seq, $applicant){
        if(strlen($seq['attention_text']) == 0)
            return null;
        $key = ['USER_NAME','DAYS'];
        $val = ['<span class="popup-name">'.$applicant->name.'</span>','<span class="popup-date">'.$seq['attention_condition'].'</span>'];
        $now = Carbon::now()->format('Y-m-d');
        $string = '';
        switch ($seq['seq']){
            case 'p01':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'p02':
                $conditionDate = Carbon::parse($applicant->interview_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'p03':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'p04':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];

            case 'p05':
                $conditionDate = Carbon::parse($applicant->first_day_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm01':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm02':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm03':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm04':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm05':
                $conditionDate = Carbon::parse($applicant->interview_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm06':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm07':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm08':
                $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;

            case 'm09':
                $conditionDate = Carbon::parse($applicant->first_day_dt)->format('Y-m-d');
                $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                if($days > (int)$seq['attention_condition'] )
                    $string = $seq['attention_text'];
                break;
        }

        return $str = self::__str_replace($key, $val, $string);
    }

    /**
     * @param $seq
     * @param $applicant
     * @param null $reasonCd
     * @return mixed
     */
    public static function displayMessage($seq, $applicant, $reasonCd = null){
        $str = $seq['display_message'];
        if(strlen($str) == 0)
            return $str;
        $key = $val = [];
        if($reasonCd == null)
            $reasonCd = DefaultService::getReasonCd();
        $now = Carbon::now()->format('Y-m-d');

        if($applicant){
            switch ($applicant->seq){
                case 'p01':
                    $key[] = 'USER_TEL';
                    $val = ['<span class="popup-tel bold">'.$applicant->tel.'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="popup-tel color-red bold">'.$applicant->tel.'</span>'];
                    break;

                case 'p02':
                    $key[] = 'INTERVIEW_DT';
                    $val = ['<span class="popup-tel bold">'.date('Y/m/d H:i', strtotime($applicant->interview_dt)).'</span>'];
                    $conditionDate = Carbon::parse($applicant->interview_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="popup-tel color-red bold">'.date('Y/m/d H:i', strtotime($applicant->interview_dt)).'</span>'];
                    break;

                case 'p04':
                    $key[] = 'SEQ_UPDATE_CONDITION';
                    $val = ['<span class="popup-tel bold">'.date('Y/m/d', strtotime($applicant->seq_update_dt."+".((int)$seq['attention_condition'])." day")).'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="popup-tel color-red  bold">'.date('Y/m/d H:i', strtotime($applicant->seq_update_dt)).'</span>'];
                    break;

                case 'p05':
                    $key[] = 'DAYS';
                    $key[] = 'FIRST_DAY_DT_CONDITION';
                    $key[] = 'FIRST_DAY_DT';
                    $val = [
                       (int)$seq['attention_condition'],
                        '<span class="popup-first-day-dt bold">'.date('Y/m/d', strtotime($applicant->first_day_dt."+".((int)$seq['attention_condition'])." day")).'</span>',
                        '<span class="popup-first-day-dt bold">'.date('Y/m/d', strtotime($applicant->first_day_dt)).'</span>',
                    ];
                    $conditionDate = Carbon::parse($applicant->first_day_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition']){
                        $val = [
                            (int)$seq['attention_condition'],
                            '<span class="popup-first-day-dt color-red bold">'.date('Y/m/d', strtotime($applicant->first_day_dt."+".((int)$seq['attention_condition'])." day")).'</span>',
                            '<span class="popup-first-day-dt color-red bold">'.date('Y/m/d', strtotime($applicant->first_day_dt)).'</span>',
                        ];
                    }
                    break;

                case 'p07':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].':'.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                case 'p08':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].':'.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                    break;
                case 'p09':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].':'.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                    break;
                case 'm02':
                    $key[] = 'DAYS';
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days_1 = Carbon::parse($conditionDate)->diffInDays($now,false);
                    $val = ['<span class="text_seq_update_dt bold">'.$days_1.'</span>'];

                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_seq_update_dt color-red bold">'.$days_1.'</span>'];
                    break;

                case 'm03':
                    $key[] = 'INTERVIEW_DATE_ADJUSTMENT_TEXT';
                    $val = ['<span class="text_interview_date_adjustment_text bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_interview_date_adjustment_text color-red bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    break;

                case 'm04':
                    $key[] = 'INTERVIEW_DATE_ADJUSTMENT_TEXT';
                    $val = ['<span class="text_interview_date_adjustment_text color-red  bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_interview_date_adjustment_text color-red bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    break;

                case 'm05':
                    $key[] = 'INTERVIEW_DT';
                    $val = ['<span class="text_interview_date_adjustment_text bold">'.date('Y/m/d H:i', strtotime($applicant->interview_dt)).'</span>'];
                    $conditionDate = Carbon::parse($applicant->interview_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_interview_date_adjustment_text color-red bold">'.date('Y/m/d H:i', strtotime($applicant->interview_dt)).'</span>'];
                    break;

                case 'm06':
                    $key[] = 'INTERVIEW_DATE_ADJUSTMENT_TEXT';
                    $val = ['<span class="text_interview_date_adjustment_text bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_interview_date_adjustment_text color-red bold">'.date('Y/m/d H:i', strtotime($applicant->interview_date_adjustment_text)).'</span>'];
                    break;

                case 'm08':
                    $key[] = 'SEQ_UPDATE_CONDITION';
                    $val = ['<span class="text_seq_update_dt bold">'.date('Y/m/d H:i', strtotime($applicant->seq_update_dt."+".((int)$seq['attention_condition'])." day")).'</span>'];
                    $conditionDate = Carbon::parse($applicant->seq_update_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition'])
                        $val = ['<span class="text_seq_update_dt color-red bold">'.date('Y/m/d H:i', strtotime($applicant->seq_update_dt."+".((int)$seq['attention_condition'])." day")).'</span>'];
                    break;

                case 'm09':
                    $key[] = 'DAYS';
                    $key[] = 'FIRST_DAY_DT_CONDITION';
                    $key[] = 'FIRST_DAY_DT';
                    $val = [
                        (int)$seq['attention_condition'],
                        '<span class="text_first-day-dt bold">'.date('Y/m/d', strtotime($applicant->first_day_dt."+".((int)$seq['attention_condition'])." day")).'</span>',
                        '<span class="text_first-day-dt bold">'.date('Y/m/d', strtotime($applicant->first_day_dt)).'</span>',
                    ];
                    $conditionDate = Carbon::parse($applicant->first_day_dt)->format('Y-m-d');
                    $days = Carbon::parse($conditionDate)->diffInDays($now,false);
                    if($days > (int)$seq['attention_condition']){
                        $val = [
                            (int)$seq['attention_condition'],
                            '<span class="text_first-day-dt color-red bold">'.date('Y/m/d', strtotime($applicant->first_day_dt."+".((int)$seq['attention_condition'])." day")).'</span>',
                            '<span class="text_first-day-dt color-red bold">'.date('Y/m/d', strtotime($applicant->first_day_dt)).'</span>',
                        ];
                    }
                    break;

                case 'm11':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].' : '.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                    break;
                case 'm12':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].' : '.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                    break;
                case 'm13':
                    $key[] = 'MESSAGES';
                    $val[] = '<span data-toggle="tooltip-removed" data-html="true" class="show-tooltip-removed" title="'.$reasonCd[$applicant->reason_cd].' : '.$applicant->reason_text.'">'.$reasonCd[$applicant->reason_cd].'</span>';
                    break;
                default:
                    break;

            }
        }

        if(count($key) > 0 && count($val) >0 )
            $str = self::__str_replace($key, $val, $str);
        return $str;
    }

    /**
     * @param $seq
     * @param $applicant
     * @return string
     */
    public static function displayButtonText($seq, $applicant){
        $str = $seq['display_button_text'];
        if(strlen($str) == 0)
            return $str;

        $sendInterviewInfoNum = ((int)$applicant->send_interview_info_num > 1 )? '#'.$applicant->send_interview_info_num:'';
        $sendFirstDayInfoNum = ((int)$applicant->send_first_day_info_num > 1 )? '#'.$applicant->send_first_day_info_num:'';
        $sendInterviewDateInfoNum = ((int)$applicant->send_interview_date_info_num > 1 )? '#'.$applicant->send_interview_date_info_num:'';
        $key = [
          'SEND_INTERVIEW_INFO_NUM',
          'SEND_FIRST_DAY_INFO_NUM',
          'SEND_INTERVIEW_DATE_INFO_NUM',
        ];
        $val = [
            $sendInterviewInfoNum,
            $sendFirstDayInfoNum,
            $sendInterviewDateInfoNum
        ];
        $str = self::__str_replace($key, $val, $str);
        return $str;
    }

    public static function __str_replace($key, $val, $str){
        return str_replace($key, $val, $str);
    }
}
