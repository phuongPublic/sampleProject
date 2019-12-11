<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCategoryRequest;
use App\Model\CodeMst;
use App\Model\JobCategoryMst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class JobCategoryController extends Controller
{
    //TODO
    const COUNTRY_LIST = ['jp', 'vn', 'en', 'cn'];
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        $data['parent_category']    = JobCategoryMst::get_parent_category();
        $data['child_category']     = JobCategoryMst::get_child_category()->toArray();

        $lang = request('lang');
        $countryList = self::COUNTRY_LIST;
        if (in_array($lang, $countryList) && $lang != 'jp') {
            $data['lang'] = $lang;
            $data['parent_category_multi_lang'] = JobCategoryMst::get_parent_category_multi_lang($lang);
            $data['child_category_multi_lang'] = JobCategoryMst::get_child_category_multi_lang($lang);
        }
        return view('admin.job.job_category', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeIcon() {
        $lang  = Input::get('lang');
        $jobCategoryId  = Input::get('category_id');
        if (Input::hasFile('icon_filepath')) {
            $image = Input::file('icon_filepath');
            try {
                $imageURL = $this->uploadIcon($image, 'icon_filepath', 'job_category');
                $jobCategory = JobCategoryMst::find($jobCategoryId);
                $jobCategory->icon_filepath = $imageURL;
                $jobCategory->save();

                // Clear cache
                Cache::forget('code_mst_job_category_cd');

                Session::flash('Success',__('supply.common.update_success'));
            } catch (\Exception $exception) {
                Session::flash('Error',__('supply.common.system_error'));
            }
        }

        if (!empty($lang))
            return redirect(route('admin.job.category') . '?lang=' . $lang);
        else
            return redirect(route('admin.job.category'));
    }

    public function uploadIcon($image, $nameInput, $childDirectory) {
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detectedType = exif_imagetype($_FILES[$nameInput]['tmp_name']);
        $extFile = '.jpg';

        if ($detectedType == 1)
            $extFile = '.gif';

        if ($detectedType == 3)
            $extFile = '.png';

        $ds = DIRECTORY_SEPARATOR;
        $fileName   = Carbon::now()->timestamp . $extFile;
        $directory  = $ds . 'img'. $ds . $childDirectory . $ds;
        $imageUrl   = $directory . $fileName;
        $im         = Image::make($image);
        if (in_array($detectedType, $allowedTypes)) {
            $im->save(base_path() . $ds . 'public' . $imageUrl);
            return $imageUrl;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function changePosition() {
        $results = [
            'messages' => __('supply.common.system_error'),
            'results' => null,
            'status' => 400
        ];

        $positionCategory = request('positionCategory');
        $countryList = self::COUNTRY_LIST;
        try {
            if (count($positionCategory) > 0) {
                foreach ($countryList as $lang) {
                    if ($lang == 'jp') {
                        foreach ($positionCategory as $value) {
                            $jobCategory = JobCategoryMst::find($value['id']);
                            $jobCategory->display_order = $value['display_order'];
                            $jobCategory->save();
                        }

                        $results['status'] = 200;
                        $results['messages'] = __('supply.common.created_success');
                    } else {
                        foreach ($positionCategory as $value) {
                            $group = 'job_category_cd_' . $lang;
                            CodeMst::where('group', '=', $group)->where('value', '=', $value['id'])
                                ->update(['seq' => $value['display_order']]);
                        }

                        $results['status'] = 200;
                        $results['messages'] = __('supply.common.created_success');
                    }
                }
            }

            // Clear cache
            Cache::forget('code_mst_job_category_cd');
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . ':' . $exception->getMessage());
        }

        return Json::encode($results);
    }

    public function create(JobCategoryRequest $request) {
        $name = $request->name;
        $lang = $request->lang;

        try {
            $image = $request->icon_filepath;
            $imageUrl = '';
            if (Input::hasFile('icon_filepath')) {
                $imageUrl = $this->uploadIcon($image, 'icon_filepath', 'job_category');
            }

            //Add job category JP
            $jobCategory = new JobCategoryMst();
            $jobCategory->category_cd = $request->category_cd;
            $jobCategory->display_order = 0;
            $jobCategory->name = $name['job_category_cd_jp'];
            $jobCategory->icon_filepath = $imageUrl;
            $jobCategory->created_id = auth()->user()->id;
            $jobCategory->save();

            $jobCategoryId = $jobCategory->id;
            foreach ($name as $key => $label) {
                if ($key != 'job_category_cd_jp') {
                    $jobCategoryCodeMst = CodeMst::where('group', '=', $key)->where('value', '=', $jobCategoryId)->first();
                    if ($jobCategoryCodeMst) {
                        $seqOld = $jobCategoryCodeMst->seq;
                        $deleteJobCategoryCodeMst = CodeMst::where('group', '=', $key)->where('value', '=', $jobCategoryId)->delete();
                        if ($deleteJobCategoryCodeMst) {
                            CodeMst::insert([
                                'group' => $key,
                                'value' => $jobCategoryId,
                                'label' => $label,
                                'seq' => $seqOld
                            ]);
                        }
                    } else {
                        CodeMst::insert([
                            'group' => $key,
                            'value' => $jobCategoryId,
                            'label' => $label,
                            'seq' => 0
                        ]);
                    }
                }
            }

            // Clear cache
            Cache::forget('code_mst_job_category_cd');

            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        if (!empty($lang))
            return redirect(route('admin.job.category') . '?lang=' . $lang);
        else
            return redirect(route('admin.job.category'));
    }

    public function update(JobCategoryRequest $request) {
        $id = $request->id;
        $name = $request->name;
        $lang = $request->lang;

        try {
            if (empty($lang)) {
                $jobCategory = JobCategoryMst::find($id);
                $jobCategory->name = $name;
                $jobCategory->updated_id = auth()->user()->id;
                $jobCategory->save();
            } else {
                $group = 'job_category_cd_' . $lang;
                CodeMst::where('group', '=', $group)->where('value', '=', $id)->update(['label' => $name]);
            }

            // Clear cache
            Cache::forget('code_mst_job_category_cd');

            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        return Json::encode([]);
    }

    public function delete() {
        $countryList = self::COUNTRY_LIST;
        $id = request('id');

        $dataChild = JobCategoryMst::where('category_cd', $id)->get();
        try {
            foreach ($countryList as $lang) {
                if ($lang == 'jp') {
                    $jobCategory = JobCategoryMst::find($id);
                    $jobCategory->delete();

                    if ($dataChild) {
                        foreach ($dataChild as $value) {
                            $jobCategoryChild = JobCategoryMst::find($value->id);
                            $jobCategoryChild->delete();
                        }
                    }
                } else {
                    $group = 'job_category_cd_' . $lang;
                    if ($dataChild) {
                        foreach ($dataChild as $value) {
                            CodeMst::where('group', '=', $group)->where('value', '=', $value->id)->delete();
                        }
                    }

                    $jobCategoryCodeMst = CodeMst::where('group', '=', $group)->where('value', '=', $id)->first();
                    if ($jobCategoryCodeMst) {
                        CodeMst::where('group', '=', $group)->where('value', '=', $id)->delete();
                    }
                }
            }

            // Clear cache
            Cache::forget('code_mst_job_category_cd');
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . ':' . $exception->getMessage());
        }

        return Json::encode([]);
    }
}
