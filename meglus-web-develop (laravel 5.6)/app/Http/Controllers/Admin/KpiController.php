<?php

namespace App\Http\Controllers\Admin;

use App\Model\Kpis;
use App\Services\DefaultService;
use App\Services\KpiService;
use App\Services\MakeKpiDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KpiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $filterTime = Carbon::parse($monthFilter . '/01');
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            // get data KPI
            $keys                   = $this->getDataKpiKeys();

            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, $keys);
            }
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);


            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.title_index');
            return view('admin.kpi.index',compact('monthFilter','data', 'title'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function rate(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = [];
            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.job_type');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sequence(Request $request){

        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = $this->getSequenceKeys();
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, $keys);
            }


            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.sequence');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function cumulativeSequence(Request $request){
        try{
            $monthFilter = $request->get('month_filter', date('Y/m'));
            $monthFilter = $monthFilter.'/01 00:00:00';
            $dateFormat = 'm月d日';
            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);

            $keys                   = $this->getCumulativeSequenceKeys();

            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, 'cumulative_sequence');
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.sequence');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
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

            $keys                   = [
                                    'jobs_N1',
                                    'jobs_N2',
                                    'jobs_N3',
                                    'jobs_N4',
                                    'jobs_N5'
                                ];
            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, 'job_japanese_level');
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.jlpt');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
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
                MakeKpiDataService::makeKpiData($from_date, null, 'job_important_thing_cd');
            }

            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.title_important');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
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

            $keys                   = ['workplace_stations'];

            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, $keys);
            }


            $data                 = array_merge($data, KpiService::getKpisByKeys($date['start'], $date['end'],$keys , $dateFormat));
            $title = __('supply.kpi.title_station');
            return view('admin.kpi.index',compact('monthFilter','title', 'data'));
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

            // insert
            $filterTime = Carbon::parse($monthFilter);
            $from_date = Carbon::now()->toDateString();
            $currentTime = Carbon::parse($from_date);
            if (($filterTime->year == $currentTime->year) && ($filterTime->month >= $currentTime->month)) {
                MakeKpiDataService::makeKpiData($from_date, null, ['jobs_per_job','average_salary_per_job']);
            }

            $date                   = KpiService::getStartEndTimeOfMonth($monthFilter);
            $days                   = KpiService::getDaysBetweenTwoDates($date['start'], $date['end'], $dateFormat);
            $data[]                 = array_merge(['label-input' => 'label'], $days);
            // get apply by phone job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'jobs_per_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'jobs_per_job_description_cd_',true, $dateFormat));
            // get apply by email job category
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'average_salary_per_job_category_cd_',false, $dateFormat));
            $data                 = array_merge($data, KpiService::getCategoryKpi($date['start'], $date['end'],'average_salary_per_job_description_cd_',true, $dateFormat));
            $title = __('supply.kpi.job_type');
            return view('admin.kpi.index',compact('monthFilter','data', 'title'));
        }catch (\Exception $e){
            session()->flash('Error',__('supply.common.system_error'));
            return redirect()->back();
        }
    }

    /**
     * @param $startTime
     * @param $endtime
     * @param string $dateFormat
     * @return array
     * @throws \Exception
     */
    private function getDays($startTime, $endtime, $dateFormat = 'Y/m/d'){
        $period = new \DatePeriod(
            new \DateTime($startTime),
            new \DateInterval('P1D'),
            new \DateTime($endtime)
        );
        $days = [];
        foreach ($period as $key => $value) {
            $days[] = $value->format($dateFormat);
        }
        if(count($days) > 0)
            $days[] = date($dateFormat, strtotime($endtime));
        return $days;
    }

    /**
     * @return array
     */
    private function getDataKpiKeys(){
        return [
            'account_register',
            'company_register',
            'account_register_job',
            'supply_account_cumulative',
            'company_account_cumulative',
            'new_jobs',
            'active_jobs',
            'stoped_jobs',
            'edited_jobs',
            'jobs_apply_by_phone',
            'jobs_apply_by_phone_and_email',
        ];
    }

    /**
     * @return array
     */
    private function getImportantKeys(){
        return [
            'job_important_thing_cd_1',
            'job_important_thing_cd_2',
            'job_important_thing_cd_3',
            'job_important_thing_cd_4',
            'job_important_thing_cd_5',
            'job_important_thing_cd_6',
            'job_important_thing_cd_7',
            'job_important_thing_cd_8',
            'job_important_thing_cd_9',
            'job_important_thing_cd_10',
            'job_important_thing_cd_11',
            'job_important_thing_cd_12',
            'job_important_thing_cd_13'
        ];
    }

    /**
     * @return array
     */
    private function getCumulativeSequenceKeys(){
        return [
            'cumulative_sequence_p01',
            'cumulative_sequence_p02',
            'cumulative_sequence_p03',
            'cumulative_sequence_p04',
            'cumulative_sequence_p05',
            'cumulative_sequence_p06',
            'cumulative_sequence_p07',
            'cumulative_sequence_p08',
            'cumulative_sequence_p09',
            'cumulative_sequence_m01',
            'cumulative_sequence_m02',
            'cumulative_sequence_m03',
            'cumulative_sequence_m04',
            'cumulative_sequence_m05',
            'cumulative_sequence_m06',
            'cumulative_sequence_m07',
            'cumulative_sequence_m08',
            'cumulative_sequence_m09',
            'cumulative_sequence_m10',
            'cumulative_sequence_m11',
            'cumulative_sequence_m12',
            'cumulative_sequence_m13'];
    }


    /**
     * @return array
     */
    private function getSequenceKeys(){
        return
            [
                'sequence_p01',
                'sequence_p02',
                'sequence_p03',
                'sequence_p04',
                'sequence_p05',
                'sequence_p06',
                'sequence_p07',
                'sequence_p08',
                'sequence_p09',
                'sequence_m01',
                'sequence_m02',
                'sequence_m03',
                'sequence_m04',
                'sequence_m05',
                'sequence_m06',
                'sequence_m07',
                'sequence_m08',
                'sequence_m09',
                'sequence_m10',
                'sequence_m11',
                'sequence_m12',
                'sequence_m13'
            ];
    }
}
