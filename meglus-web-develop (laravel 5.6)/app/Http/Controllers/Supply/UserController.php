<?php

namespace App\Http\Controllers\Supply;

use App\Http\Requests\Site\ChangePassword;
use App\Http\Requests\Site\ResetPassword;
use App\Model\Jobs;
use App\Model\Applicant;
use App\Model\Stations;
use App\Model\SupplyUserInfo;
use App\Services\DefaultService;
use App\Services\SupplyUserInfoService;
use App\Model\DemandUserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    const PAGINATE = 30;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('sample', ['sample' => 'index']);
    }

    public function company(Request $request)
    {
        //get list Prefecture
        $prefectures = DefaultService::getPrefecture();
        $viewData = [];
        //get list categories
        $categories = DefaultService::jobCategoryTree();
        //get data for show if created
        $companyId = null;
        $data = [];
        if (isset($this->user->companyInfo->company_id)) {
            $companyId = $this->user->companyInfo->company_id;
            $data = $this->user->companyInfo;
        }
        //process action update or create conpany info
        if ($request->method() == 'POST') {
            $data = (object)$request->all();
            $validate = DefaultService::validate($request, 'CompanyInfo');
            $viewData['errors'] = $validate->errors();
            // save
            if(!$validate->fails()){
                //from popup regist click
                if(isset($data->company_regist) && $data->company_regist == 1){
                    unset($request['_token']);
                    unset($request['company_regist']);
                    $result = SupplyUserInfoService::updateCompanyInfo($companyId, $request->all());
                    if ($result) {
                        session()->flash('Success',trans('supply.company.update_success'));
                        return redirect()->route('supply.job.create');
                    }else{
                        session()->flash('Error',trans('supply.common.update_fail'));
                    }
                }
                $data->show_modal = 1;
            }
        }
        $cities1 = isset($data->prefecture) ? DefaultService::getCtyByPrefecture($data->prefecture) : [];
        $cities2 = isset($data->city1) ?  DefaultService::getCty2ByCityName($data->city1) : [];
        $viewData = array_merge($viewData, ['data' => $data, 'prefectures' => $prefectures, 'cities1' => $cities1, 'cities2' => $cities2, 'categories' => $categories]);

        return view('supply_side.company.company', $viewData);
    }

    /**
     * Function user page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mypage(Request $request)
    {
        $user = Auth::user();
        if(!$user->companyInfo)
            return redirect()->route('company');

        $sort           = $this->getSortData();
        //$jobs           = Jobs::select()->where('created_id',$user->id)->paginate(2);
        $jobs           = $this->getJobbyUser($user, $sort);
        $statusCd       = DefaultService::getCodeMstByGroup('job_status', true);
        return view('supply_side.auth.mypage', compact('statusCd','user','jobs','sort'));
    }

    /**
     * @param ChangePassword $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function password(ChangePassword $request, $key = null){

        if ($request->method() == 'POST') {
            try{
                $logedin = false;
                if($key){
                    $user = SupplyUserInfoService::getUserByEncrypt($key);
                }else{
                    $user = Auth::user();
                    $logedin = true;
                }
                $user->change_pass_dt = null;
                $user->password = Hash::make($request->get('password'));
                $user->save();
                Session::flash('Success', __('supply.common.update_success'));
                if($logedin == true)
                    return redirect()->route('mypage');

                return redirect()->route('front_page');
            }catch (\Exception $e){
                Session::flash('Error', __('supply.common.system_error'));
                return redirect()->back();
            }

        }elseif ($request->method() == 'GET'){
            if($key){
                $user = SupplyUserInfoService::getUserByEncrypt($key);
                if(!$user)
                    return redirect()->route('mypage');

            }else{
                $user = Auth::user();
                if(!$user)
                    return redirect()->route('front_page');
            }
        }

        return view('supply_side.auth.password', compact('key'));
    }

    public function resetPassword(ResetPassword $request){
        if ($request->method() == 'POST') {
            try{
                $email = $request->get('email');
                $reset = SupplyUserInfoService::resetPassword($email);
                if($reset == true){
                    Session::flash('Success', __('supply.common.update_success'));
                    return redirect()->route('front_page');
                }else{
                    Session::flash('Error', __('supply.common.system_error'));
                    return redirect()->back();
                }

            }catch (\Exception $e){
                Session::flash('Error', __('supply.common.system_error'));
                return redirect()->back();
            }

        }
        return view('supply_side.auth.reset-password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function activeCode(Request $request)
    {
        $action = $request->action;
        $data = [
            'action' => $request->action,
            'val' => $request->val,
        ];

        $check = [];
        if(isset($action) && $action != ''){
            switch ($action){
                case 'active-code':
                    $check = SupplyUserInfoService::getOtpCodeByLoginUser();
                    break;
                case 'expire-code':
                    $check = SupplyUserInfoService::getOtpCodeByLoginUser();
                    break;
                case 'submit':
                    $check['updated'] = 'fail';
                    $check['generation_num'] = Auth::user()->company_generation_num;
                    $updated  = SupplyUserInfoService::otpActiveCode($request->val);
                    if($updated === true)
                        $check['updated'] = 'success';
                    break;
            }
        }

        $data = array_merge($data, $check);
        return view('supply_side.auth.active_code_modal', compact('data'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function companyExpire(Request $request){
        // Rediect to active OTP when remain day
        if(Auth::user()->company_expire_days > 0)
            return redirect()->route('supply.activeScreen');

        // Reset OTP by POST
        if($request->method() == 'POST' && $request->resetOtp = 'reset_code'){
            $reset = SupplyUserInfoService::userResetOtpCode();
            if($reset == true){
                Session::flash('Success', trans('supply.company.company_expire_success'));
                return redirect()->route('supply.activeScreen');
            }else{
                Session::flash('Error', trans('supply.common.update_error'));
            }
        }

        // Show page for user reset OTP
        $generationNum = Auth::user()->company_generation_num;
        return view('supply_side.auth.company_expire',compact('generationNum'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function activeScreen(Request $request){
        $days = Auth::user()->company_expire_days;
        if($days > 0)
            return view('supply_side.auth.active_screen', compact('days'));

        return redirect()->route('front_page');
    }

    function getUserInfo(Request $request){
        $id = $request->id;
        $job_id = $request->jid;
        $data = DemandUserInfo::getUserInfoById($id);
        $data->age = Carbon::parse($data->birth_day)->age;
        //set coutry name
        $country = DefaultService::getCodeMstByGroup('country', true);
        $data->country = !empty($data->nationality_cd) ? $country[$data->nationality_cd] : "";
        //set residence status
        $resiStatusCode = $data->getResidences($data->id)->toArray();
        $resiStatusArr = DefaultService::getCodeMstByGroup('residence_qualification', true);
        $data->residence_status = '';
        foreach ($resiStatusCode as $item){
            $data->residence_status .= !empty($data->residence_status) ? '、'.$resiStatusArr[$item['qualification']] : $resiStatusArr[$item['qualification']];
        }
        //set work exp
        $categories     = DefaultService::jobCategoryAll();
        $data->exp1 = isset($categories[$data->work_experience1_category_cd]) ? $categories[$data->work_experience1_category_cd] : '';
        $data->exp1 .= isset($categories[$data->work_experience1_discription_cd]) ? ' ('.$categories[$data->work_experience1_discription_cd].')' : '';

        $data->exp2 = isset($categories[$data->work_experience2_category_cd]) ? $categories[$data->work_experience2_category_cd]: '';
        $data->exp2 .= isset($categories[$data->work_experience2_discription_cd]) ? ' ('.$categories[$data->work_experience2_discription_cd].')' : '';

        $data->exp3 = isset($categories[$data->work_experience3_category_cd]) ? $categories[$data->work_experience3_category_cd]: '';
        $data->exp3 .= isset($categories[$data->work_experience3_discription_cd]) ? ' ('.$categories[$data->work_experience3_discription_cd].')' : '';
        //set important thing
        $important = DefaultService::getCodeMstByGroup('important_thing' , true);
        $data->important_1 = !empty($data->important1_cd) ?  $important[$data->important1_cd] : '';
        $data->important_2 = !empty($data->important2_cd) ?  $important[$data->important2_cd] : '';
        $data->important_3 = !empty($data->important3_cd) ?  $important[$data->important3_cd] : '';
        //set work days
        $workDaysCode = $data->getWorkDays($data->id)->toArray();
        $work_days = array();
        foreach ($workDaysCode as $item){
            array_push($work_days, $item['day']);
        }
        $data->work_days = $work_days;
        //set station nearest
        $data->home_nearest_station_name = !empty($data->home_nearest_station) ? Stations::getStationsById($data->home_nearest_station)->station_name : '';
        $data->school_nearest_station_name = !empty($data->home_nearest_station) ?  Stations::getStationsById($data->school_nearest_station)->station_name : '';
        $prefectureName = (($data->getPrefecture)?$data->getPrefecture->name:'');
        $data->not_show_working_days = 0;
        if(Auth::user()->is_admin != 11){
            //set show full info or no
            $applicant = Applicant::getApplicantByJobIdAndDemandId($id, $job_id);
            // A
            $arrSeqNonShowInfo = ['p01','p02','p04'];
            //B
            $arrSeqNonShowInfoB = ['p03','p05','p06'];
            //C
            $arrSeqNonShowInfoC = ['p07','p08','p09'];
            // M A
            $arrSeqNonShowInfoA1 = ['m01','m02','m03','m04','m05','m06','m08'];
            // M B
            $arrSeqNonShowInfoB1 = ['m07','m09','m10'];
            // M C
            $arrSeqNonShowInfoC1 = ['m11','m12','m13'];

            $data->work_start_time = date('H:i', strtotime($data->work_start_time));
            $data->work_end_time = date('H:i', strtotime($data->work_end_time));
            if(in_array($applicant->seq, $arrSeqNonShowInfo) || in_array($applicant->seq, $arrSeqNonShowInfoA1)){
                $data->detail_address = '*******';
                $data->post_cd = '***-***';
//                $data->home_nearest_station_name = '**********';
//                $data->school_nearest_station_name = '**********';
                $data->mail = '**********';
                if(
                    //$applicant->application_method !=0 &&
                    in_array($applicant->seq, $arrSeqNonShowInfoA1)){
                    $data->tel = '***_****_****';
                }
            }elseif (in_array($applicant->seq, $arrSeqNonShowInfoB) || in_array($applicant->seq, $arrSeqNonShowInfoB1)){
                $data->mail = '**********';
            }elseif (in_array($applicant->seq, $arrSeqNonShowInfoC) || in_array($applicant->seq, $arrSeqNonShowInfoC1)){
                $data->post_cd = '***-***';
                $data->mail = '**********';
                $data->detail_address = '**********';
                $prefectureName = '**********';
                $data->city1 = '**********';
                $data->city2 = '**********';
                $data->home_nearest_station_name = '**********';
                $data->school_nearest_station_name = '**********';
                $data->tel = '***_****_****';
                $data->residence_status = '**********';
                $data->japanese_level = '**********';
                $data->exp1 = '**********';
                $data->exp2 = '**********';
                $data->exp3 = '**********';
                $data->important_1 = '**********';
                $data->important_2 = '**********';
                $data->important_3 = '**********';
                $data->work_start_time = '**';
                $data->work_end_time = '**';

                $data->not_show_working_days = 1;

            }
        }

        //set address text
        $data->add_str = '郵便番号'.$data->post_cd.''.$prefectureName.$data->city1.$data->city2.$data->detail_address;
        $data->avt_path = base_path() . env('USER_IMAGE_PATH', 'user_image') . $id . '/' . $data->profile_path;

        return view('supply_side.auth.user_modal', compact('data'));
    }

    /**
     * @return array|mixed
     */
    private function getSortData(){
        $request = request();
        if($request->sort){
            $sort = $request->sort;
        }else {
            $sort = [];
            $sort['updated_at']         = $request->input('updated_at', '');
            $sort['workplace_name']     = $request->input('workplace_name', '');
            $sort['job_category_cd']    = $request->input('job_category_cd', '');
            $sort['job_discription_cd'] = $request->input('job_discription_cd', '');

            $sort['applicant']          = $request->input('applicant', '');
            $sort['bookmark']           = $request->input('bookmark', '');
            $sort['status']             = $request->input('status', '');
        }
        return $sort;
    }

    /**
     * @param $sort
     * @return mixed
     */
    private function getJobByUser($user, $sort){
        if(!$sort)
            $sort           = $this->getSortData();
        $model = Jobs::select()->where('company_id',$user->company_id);
        if(count($sort) > 0){
            foreach ($sort as $key => $item){
                if($key == 'applicant' && in_array($item,['ASC','DESC'])){
                    $model->withCount('getApplicant')->orderBy('get_applicant_count', $item);
                }elseif ($key == 'bookmark' && in_array($item,['ASC','DESC']) ){
                    $model->withCount('getBookmark')->orderBy('get_bookmark_count', $item);

                }else{
                    if(in_array($item,['ASC','DESC']))
                        $model->orderBy($key, $item);
                }
            }
        }

        return $model->paginate(self::PAGINATE);
    }



}
