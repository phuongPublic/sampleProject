<?php

namespace App\Http\Controllers\Admin;

use App\Model\CompanyInfo;
use App\Services\DefaultService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index() {
        $sort = $this->getSortData();
        $filter = $this->getFilterData();
        $companies = CompanyInfo::getList($sort, $filter);
        return view('admin.company.index', compact('companies', 'filter', 'sort'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function company(Request $request, $companyId)
    {
        //get list Prefecture
        $prefectures = DefaultService::getPrefecture();
        $viewData = [];
        //get list categories
        $categories = DefaultService::jobCategoryTree();
        //get data for show if created
        $data = CompanyInfo::find($companyId);
        //process action update or create conpany info
        if ($request->method() == 'POST') {
            $data = (object)$request->all();
            $validate = DefaultService::validate($request, 'CompanyInfo');
            $viewData['errors'] = $validate->errors();
            // save
            if(!$validate->fails()) {
                unset($request['_token']);
                unset($request['company_regist']);
                try {
                    CompanyInfo::where('company_id', $companyId)->update($request->all());
                    session()->flash('Success',trans('supply.company.update_success'));
                } catch (\Exception $exception) {
                    session()->flash('Error',trans('supply.common.update_fail'));
                }
            } else {
                session()->forget('Success');
            }
        }
        $cities1 = isset($data->prefecture) ? DefaultService::getCtyByPrefecture($data->prefecture) : [];
        $cities2 = isset($data->city1) ?  DefaultService::getCty2ByCityName($data->city1) : [];
        $viewData = array_merge($viewData, ['data' => $data, 'prefectures' => $prefectures, 'cities1' => $cities1, 'cities2' => $cities2, 'categories' => $categories, 'companyId' => $companyId]);

        return view('admin.company.edit', $viewData);
    }

    public function changeMaxJobNum() {
        try {
            $company = $this->getCompany(request('company_id'));
            if ($company) {
                $company->max_job_num = request('max_job_num');
                $company->save();
            }
            session()->flash('Success',trans('supply.company.update_success'));
        } catch (\Exception $e) {
            session()->flash('Error',trans('supply.common.update_fail'));
        }
        return redirect()->back();
    }

    /**
     * check access job
     * @param $id
     * @return bool
     */
    private function getCompany($id){
        $item = CompanyInfo::find($id);
        if($item)
            return $item;
        return abort(404);
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
}
