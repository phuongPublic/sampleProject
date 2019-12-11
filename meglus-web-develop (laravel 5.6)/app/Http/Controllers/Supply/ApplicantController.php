<?php

namespace App\Http\Controllers\Supply;

use App\Model\Applicant;
use App\Model\Jobs;
use App\Services\ApplyService;
use App\Services\DefaultService;
use App\Services\JobService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Psy\Util\Json;

class ApplicantController extends Controller
{
    /**
     * @param Request $request
     * @param $encrypt
     * @return string|void
     * @throws \Throwable
     */
    public function update(Request $request, $encrypt){
        $decrypted = Crypt::decryptString($encrypt);
        $param = json_decode($decrypted,true);
        $id     = $param['id'];
        $jid    = $param['jid'];
        $seq    = $param['seq'];
        $old    = $param['seq_old'];
        $applicant = $this->getApplicant($id);

        if($applicant->job_id != $jid || $applicant->seq != $old )
            return;

        // Show popup
        if($request->method() == 'GET'){
            $param = array_merge($request->all(),$param);
            switch ($seq){
                case 'p03':
                    // Show popup 内定
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'p04':
                    // Show popup 選考中
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'p06':
                    // Show popup 採用
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'p07':
                    // Show popup 内定取消
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $acceptance = DefaultService::getCodeMstByGroup('cancel_acceptance_reason_cd', true);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus', 'acceptance'));
                    break;
                case 'p08':
                    // Show popup 不採用
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $acceptance = DefaultService::getCodeMstByGroup('cancel_employment_reason_cd', true);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job', 'demandUser', 'jobProgressStatus', 'acceptance'));
                    break;
                case 'm07':
                    // Show popup 内定
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'm08':
                    // Show popup 選考中
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'm10':
                    // Show popup 採用
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus'));
                    break;
                case 'm11':
                    // Show popup 内定取消
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $acceptance = DefaultService::getCodeMstByGroup('cancel_acceptance_reason_cd', true);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    $jobFlow    = JobService::jobFlow(true);
                    //$jobFlow    = $jobFlow[$applicant->seq];
                    $jobFlow    = $jobFlow[$seq];

                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job','jobFlow', 'demandUser', 'jobProgressStatus', 'acceptance'));
                    break;
                case 'm12':
                    // Show popup 不採用
                    $demandUser = $applicant->demandUser;
                    $job        = Jobs::getInfoById($applicant->job_id);
                    $acceptance = DefaultService::getCodeMstByGroup('cancel_employment_reason_cd', true);
                    $jobProgressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
                    return view('supply_side.applicant.modal.'.$seq, compact('param','encrypt','applicant','job', 'demandUser', 'jobProgressStatus', 'acceptance'));
                    break;
                default:
                    dd(array_merge($request->all(),$param));
                    break;
            }

        }elseif ($request->method() == 'POST'){
            // Update Data
            $results = [
                'messages' => [
                    'error-sys-are' => __('supply.common.system_error')
                ],
                'results' => null,
                'status' => 400
            ];

            switch ($seq){
                case 'p03':
                    // save 内定
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages' => __('supply.common.update_success'),
                            'results' => null,
                            'status' => 200
                        ];
                    }
                    break;
                case 'p04':
                    // save 選考中
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages' => __('supply.common.update_success'),
                            'results' => null,
                            'status' => 200
                        ];
                    }
                    break;
                case 'p06':
                    // save 採用
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages'      => __('supply.common.update_success'),
                            'results'       => null,
                            'status'        => 200
                        ];
                    }
                    break;
                case 'p07':
                    // save 内定取消
                    if($request->reason_cd == null || strlen($request->reason_cd) == 0){
                        $results['messages'] = ['reason_cd' => '選択してください'];
                    }else{
                        $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                        if($update === true){
                            Session::flash('Success',__('supply.common.update_success'));
                            $results = [
                                'messages' => __('supply.common.update_success'),
                                'results' => null,
                                'status' => 200
                            ];
                        }
                    }
                    break;
                case 'p08':
                    // save 不採用
                    if($request->reason_cd == null || strlen($request->reason_cd) == 0){
                        $results['messages'] = ['reason_cd' => '選択してください'];
                    }else{
                        $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                        if($update === true){
                            Session::flash('Success',__('supply.common.update_success'));
                            $results = [
                                'messages' => __('supply.common.update_success'),
                                'results' => null,
                                'status' => 200
                            ];
                        }
                    }
                    break;
                case 'm07':
                    // save 内定
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages' => __('supply.common.update_success'),
                            'results' => null,
                            'status' => 200
                        ];
                    }
                    break;
                case 'm08':
                    // save 選考中
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages' => __('supply.common.update_success'),
                            'results' => null,
                            'status' => 200
                        ];
                    }
                    break;
                case 'm10':
                    // save 採用
                    $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                    if($update === true){
                        Session::flash('Success',__('supply.common.update_success'));
                        $results = [
                            'messages' => __('supply.common.update_success'),
                            'results' => null,
                            'status' => 200
                        ];
                    }
                    break;
                case 'm11':
                    // save 内定取消
                    if($request->reason_cd == null || strlen($request->reason_cd) == 0){
                        $results['messages'] = ['reason_cd' => '選択してください'];
                    }else{
                        $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                        if($update === true){
                            Session::flash('Success',__('supply.common.update_success'));
                            $results = [
                                'messages' => __('supply.common.update_success'),
                                'results' => null,
                                'status' => 200
                            ];
                        }
                    }
                    break;
                case 'm12':
                    // save 不採用
                    if($request->reason_cd == null || strlen($request->reason_cd) == 0){
                        $results['messages'] = ['reason_cd' => '選択してください'];
                    }else{
                        $update = ApplyService::changeStatusApplicant(array_merge($request->all(),$param));
                        if($update === true){
                            Session::flash('Success',__('supply.common.update_success'));
                            $results = [
                                'messages' => __('supply.common.update_success'),
                                'results' => null,
                                'status' => 200
                            ];
                        }
                    }
                    break;
                default:
                    dd(array_merge($request->all(),$param));
                    break;

            }

            if($results['status'] == 200){
                $templateRow  = null;
                if(isset($param['current_route_name']) && $param['current_route_name'] == 'admin.applicant.index' )
                    $templateRow = 'admin.applicant.apply_row';
                $results['update_row']      = $param['id'];
                $results['content']         = ApplyService::applyRowContent($param['id'], $templateRow);
            }

            return Json::encode($results);
        }
        return;

    }

    /**
     * @param $id
     */
    private function getApplicant($id){
        $applicant                = Applicant::find($id);
        if(!$applicant)
            return abort(404);

        return $applicant;
    }
}
