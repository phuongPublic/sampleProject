<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DemandRequest;
use App\Http\Requests\Admin\UserPassword;
use App\Model\DemandUserInfo;
use App\Model\DemandUserResidence;
use App\Model\DemandUserWorkDay;
use App\Model\Stations;
use App\Services\DefaultService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class DemandController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $country    = DefaultService::getCodeMstByGroup('country', true);
        $sort       = $this->getSortData();
        $filter     = $this->getFilterData();
        $prefectures    = DefaultService::getPrefecture();

        $demands    = DemandUserInfo::getList($sort, $filter);

        return view('admin.demand.index', compact('demands', 'prefectures', 'sort','country','filter'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id){
//        $demand = $this->getDemand($id);
//        $prefectures    = DefaultService::getPrefecture();
//        $country    = DefaultService::getCodeMstByGroup('country', true);
//        $workDaysCode = $demand->workDays;
//        $workDays = array();
//        foreach ($workDaysCode as $item){
//            array_push($workDays, $item['day']);
//        }

//        return view('admin.demand.view', compact('demand','prefectures', 'country','workDays'));

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
        //set address text
        $data->add_str = '〒'.$data->post_cd.' '.(($data->getPrefecture)?$data->getPrefecture->name:'').$data->city1.$data->city2.$data->detail_address;
        $data->avt_path = base_path() . env('USER_IMAGE_PATH', 'user_image') . $id . '/' . $data->profile_path;

//        return view('supply_side.auth.user_modal', compact('data'));
        return view('admin.demand.view', compact('data'));

    }

    /**
     * @param DemandRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function update(DemandRequest $request, $id){

        DB::beginTransaction();
        try{
            $demand         = $this->getDemand($id);
            if($request->method() == 'GET'){
                $country        = DefaultService::getCodeMstByGroup('country', true);
                $prefectures    = $this->getSelectBoxPrefectures($demand);

                $demand->residences = $demand->residences->reduce(function ($carry, $item){
                    $carry[$item->qualification] = $item->qualification;
                    return $carry;
                },[]);

                $demand->days = $demand->workDays->reduce(function ($carry, $item){
                    $carry[] = (int)$item->day;
                    return $carry;
                },[]);

                $resiStatus     = DefaultService::getCodeMstByGroup('residence_qualification', true);
                $japaneseLevel  = DefaultService::getCodeMstByGroup('japanese_level', true);
                $important      = DefaultService::getCodeMstByGroup('important_thing', true);
                $categories     = DefaultService::jobCategoryTree();

                return view('admin.demand.form', compact('demand','country','prefectures','resiStatus','japaneseLevel','important','categories'));

            }elseif($request->method() == 'POST'){
                $update = $request->all();
                if(isset($update['avatar']) && strlen($update['avatar'])>0){
                    $path       = base_path() . env('USER_IMAGE_PATH', 'user_image') . $demand->id;
                    $fileName   = date('Ymdhis').'_'.$demand->id.'.png';
                    $upload     = Image::make(file_get_contents($update['avatar']))->save($path.DIRECTORY_SEPARATOR.$fileName);
                    unset($update['avatar']);
                    $update['profile_path'] = $fileName;
                }

                // update residences
                $residences = $update['residences'];
                DemandUserResidence::inserts($id, $residences);

                // update work days
                $days       = $update['days'];
                DemandUserWorkDay::inserts($id, $days);

                $demand->fill($update);
                $demand->save();
                $results = [
                    'results' => null,
                    'status' => 200,
                    'redirect_url' => route('admin.demand.view',['id' => $demand->id])
                ];

                DB::commit();
                return $results;
            }

        }catch (\Exception $exception){
            if($request->method() == 'GET'){
                Session::flash('Error',__('supply.common.system_error'));
                return redirect()->back();
            }elseif($request->method() == 'POST'){
                DB::rollBack();
                $results = [
                    'messages' => __('supply.common.system_error'),
                    'results' => null,
                    'status' => 400
                ];
                return $results;
            }

        }

    }

    /**
     * @param UserPassword $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(UserPassword $request, $id){
        $demand = $this->getDemand($id);
        if($request->method() == 'POST'){
            dd($request->all());
        }
        return view('admin.demand.password', compact('demand'));
    }

    /**
     * Get Select box prefectures city.
     * @param Request $request
     * @return array
     */

    private function getSelectBoxPrefectures($request){
        $result = [];
        $result['prefectures']    = DefaultService::getPrefecture();

        if(isset($request->prefecture))
            $result['city1']    = DefaultService::getCtyByPrefecture($request->prefecture);

        if(isset($request->city1))
            $result['city2']    = DefaultService::getCty2ByCityName($request->city1);

        return $result;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function block($id){
        try{
            $demand = $this->getDemand($id);
            $demand->status = DemandUserInfo::BLOCKED_STATUS;
            $demand->save();
            Session::flash('Success',__('supply.common.update_success'));
        }catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unblock($id){
        try{
            $demand = $this->getDemand($id);
            $demand->status = DemandUserInfo::ACTIVATED_STATUS;
            $demand->save();
            Session::flash('Success',__('supply.common.update_success'));
        }catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blockApply($id){
        try{
            $demand = $this->getDemand($id);
            $demand->status = DemandUserInfo::BLOCKED_STATUS;
            $demand->save();
            Session::flash('Success',__('supply.common.update_success'));
        }catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unblockApply($id){
        try{
            $demand = $this->getDemand($id);
            $demand->status = DemandUserInfo::ACTIVATED_STATUS;
            $demand->save();
            Session::flash('Success',__('supply.common.update_success'));
        }catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImg($id){
        try{
            $demand = $this->getDemand($id);
            $demand->profile_path = null;
            $demand->save();
            Session::flash('Success',__('supply.common.update_success'));
        }catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->back();
    }

    /**
     * @return array|mixed
     */
    private function getSortData(){
        $request = request();

        $sort = [];
        if($request->sort)
            $sort = $request->sort;

        return $sort;
    }

    /**
     * @return array|mixed
     */
    private function getFilterData(){
        $filter = [];
        $request = request();
        if($request->filter)
            $filter = $request->filter;

        return $filter;
    }



    /**
     * check access demand
     * @param $id
     * @return bool
     */
    private function getDemand($id){
        $item = DemandUserInfo::find($id);
        if($item)
            return $item;
        return abort(404);
    }
}
