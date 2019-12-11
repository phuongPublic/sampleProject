<?php

namespace App\Http\Controllers\Admin;

use App\Model\Applicant;
use App\Model\ContentLogs;
use App\Model\DemandUserInfo;
use App\Services\DefaultService;
use App\Services\JobService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    const PAGINATE = 30;
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $user           = Auth::user();
        $filter         = $this->getFilterData();
        $sort           = $this->getSortData();
        $applicant      = Applicant::getList($sort, $filter);
        $jobFlow        = JobService::jobFlow(true);
        $progressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
        return view('admin.applicant.applicant_list', compact('sort', 'applicant', 'user', 'jobFlow', 'progressStatus', 'filter'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history(Request $request, $id) {
        $user           = DemandUserInfo::find($id);
        $filter         = $this->getFilterData();
        $sort           = $this->getSortData();
        $applicant      = Applicant::getListByDemand($id, ['sort' => $sort, 'filter' => $filter]);
        $jobFlow        = JobService::jobFlow(true);
        $progressStatus = DefaultService::getCodeMstByGroup('job_progress_status', true);
        return view('admin.applicant.applicant_list', compact('sort', 'applicant', 'user', 'jobFlow', 'progressStatus', 'filter'));
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
     * @param $content_id
     * @return mixed
     */
    public function getSequenceHistory($content_id) {
        $sequenceHistory = ContentLogs::getSequenceHistory($content_id);
        return $sequenceHistory;
    }
}
