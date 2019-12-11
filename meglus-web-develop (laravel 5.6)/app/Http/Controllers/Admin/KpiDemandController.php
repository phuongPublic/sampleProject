<?php

namespace App\Http\Controllers\Admin;

use App\Services\KpiService;
use App\Services\MakeKpiDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KpiDemandController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            // get data KPI
            $keys                   = $this->getDataKpiKeys();
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, $keys);
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.demand.title_index');
            return view('admin.kpi.demand.index',compact('monthFilter','data', 'title'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function JobType(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                $keysJobType = [
                    'apply_by_phone_job',
                    'apply_by_email_job',
                    'acceptance_job',
                    'cancel_employment_job',
                    'cancel_acceptance_job',
                    'employment_job'
                ];
                MakeKpiDataService::makeKpiData($from_date, null, $keysJobType);
            }

            // get apply by phone job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'apply_by_phone_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'apply_by_phone_job_description_cd_',true, $dateFormat));
            // get apply by email job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'apply_by_email_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'apply_by_email_job_description_cd_',true, $dateFormat));
            // get acceptance job
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'acceptance_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'acceptance_job_description_cd_',true, $dateFormat));
            // get cancel employment job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'cancel_employment_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'cancel_employment_job_description_cd_',true, $dateFormat));
            // get cancel acceptance job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'cancel_acceptance_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'cancel_acceptance_job_description_cd_',true, $dateFormat));
            // get employment job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'employment_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'employment_job_description_cd_',true, $dateFormat));
            $title = __('supply.kpi.demand.job_type');
            return view('admin.kpi.demand.index',compact('monthFilter','data', 'title'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function Jlpt(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = ['N1','N2','N3','N4','N5'];
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, 'japanese_level');
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.demand.title_jlpt');
            return view('admin.kpi.demand.index',compact('monthFilter','title', 'data'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function Important(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = $this->getImportantKeys();
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, 'important_thing_cd');
            }


            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.demand.title_important');
            return view('admin.kpi.demand.index',compact('monthFilter','title', 'data'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function Station(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = ['home_nearest_station','school_nearest_station'];
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, $keys);
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.demand.title_station');
            return view('admin.kpi.demand.index',compact('monthFilter','title', 'data'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @return array
     */
    private function getImportantKeys(){
        return ['important_thing_cd_1',
            'important_thing_cd_2',
            'important_thing_cd_3',
            'important_thing_cd_4',
            'important_thing_cd_5',
            'important_thing_cd_6',
            'important_thing_cd_7',
            'important_thing_cd_8',
            'important_thing_cd_9',
            'important_thing_cd_10',
            'important_thing_cd_11',
            'important_thing_cd_12',
            'important_thing_cd_13'
        ];
    }

    /**
     * @return array
     */
    private function getDataKpiKeys(){
        return [
            'watching',
            'apply_by_phone',
            'apply_by_email',
            'acceptance',
            'cancel_employment',
            'cancel_acceptance',
            'employment',
            'celebration'
        ];
    }


}
