<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCategoryRequest;
use App\Model\CodeMst;
use App\Model\JobCategoryMst;
use Carbon\Carbon;
use http\QueryString;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Psy\Util\Json;

class SettingGroupController extends Controller
{
    //TODO
    const COUNTRY_LIST = ['jp', 'vn', 'en', 'cn'];
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($group)
    {
        $data = [];
        //TODO
        $countryList = self::COUNTRY_LIST;
        $lang = request('lang');
        $data['groupCurrent'] = $group;
        if (in_array($lang, $countryList)) {
            $data['lang'] = $lang;
            $data['infoGroup'] = CodeMst::getInfoGroup($group, $lang);
        } else {
            $data['lang'] = 'jp';
            $data['infoGroup'] = CodeMst::getInfoGroup($group, $lang = 'jp');
        }

        return view('admin.setting.setting_group', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeImg() {
        $countryList = self::COUNTRY_LIST;
        $groupCurrent  = Input::get('group_current');
        $lang  = Input::get('lang');
        $groupValue  = Input::get('group_value');

        if (Input::hasFile('img_path')) {
            $image = Input::file('img_path');
            try {
                $imageUrl = $this->uploadImage($image, 'img_path', 'code_mst');
                foreach ($countryList as $lg) {
                    if ($lg == 'jp')
                        $groupName  = $groupCurrent;
                    else
                        $groupName  = $groupCurrent . '_' . $lg;

                    CodeMst::where('group', '=', $groupName)->where('value', '=', $groupValue)
                        ->update(['img_path' => $imageUrl]);
                }

                // Clear cache
                Cache::forget('code_mst_important_thing');

                Session::flash('Success',__('supply.common.update_success'));
            } catch (\Exception $exception) {
                Session::flash('Error',__('supply.common.system_error'));
            }
        }

        if ($lang == 'jp')
            return redirect(route('admin.setting.group', ['group' => $groupCurrent]));
        else
            return redirect(route('admin.setting.group', ['group' => $groupCurrent]) . '?lang=' . $lang);
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

        $positionGroup = request('positionGroup');
        //TODO
        $countryList = self::COUNTRY_LIST;
        try {
            if (count($positionGroup) > 0) {
                foreach ($countryList as $lang) {
                    foreach ($positionGroup as $value) {
                        if ($lang == 'jp')
                            $group = $value['groupCurrent'];
                        else
                            $group = $value['groupCurrent'] . '_' . $lang;

                        CodeMst::where('group', '=', $group)->where('value', '=', $value['value'])
                            ->update(['seq' => $value['seq']]);

                        $results['status'] = 200;
                        $results['messages'] = __('supply.common.created_success');
                    }
                }
            }

            // Clear cache
            Cache::forget('code_mst_important_thing');
        } catch (\Exception $exception) {

        }

        return Json::encode($results);
    }

    public function create(JobCategoryRequest $request) {
        $name = $request->name;
        $lang = $request->lang;
        $groupCurrent = $request->group_current;

        try {
            $imageUrl = '';
            $groupValueNew = CodeMst::select()->where('group', '=', $groupCurrent)->max(DB::raw('CAST(`value` AS SIGNED )')) + 1;
            if (Input::hasFile('img_path')) {
                $image      = $request->file('img_path');
                $imageUrl = $this->uploadImage($image, 'img_path', 'code_mst');
            }
            foreach ($name as $key => $label) {
                $dataCodeMst = CodeMst::where('group', '=', $key)->where('value', '=', $groupValueNew)->first();
                if ($dataCodeMst) {
                    CodeMst::where('group', '=', $key)->where('value', '=', $groupValueNew)->delete();
                }
                CodeMst::insert([
                    'group' => $key,
                    'value' => $groupValueNew,
                    'label' => $label,
                    'seq' => 0,
                    'img_path' => $imageUrl,
                ]);
            }

            // Clear cache
            Cache::forget('code_mst_important_thing');

            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        if ($lang == 'jp')
            return redirect(route('admin.setting.group', ['group' => $groupCurrent]));
        else
            return redirect(route('admin.setting.group', ['group' => $groupCurrent]) . '?lang=' . $lang);
    }

    public function update(JobCategoryRequest $request) {
        $value = $request->value;
        $lang = $request->lang;
        $groupCurrent = $request->groupCurrent;
        if ($lang == 'jp')
            $groupName = $groupCurrent;
        else
            $groupName = $groupCurrent . '_' . $lang;
        try {
            CodeMst::where('group', '=', $groupName)->where('value', '=', $value)
                ->update(['label' => $request->name]);

            // Clear cache
            Cache::forget('code_mst_important_thing');

            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        return Json::encode([]);
    }

    public function delete() {
        $countryList = self::COUNTRY_LIST;
        $value = request('value');
        $results = [
            'messages' => __('supply.common.system_error'),
            'results' => null,
            'status' => 400
        ];

        try {
            foreach ($countryList as $lang) {
                if ($lang == 'jp')
                    $groupName = request('groupCurrent');
                else
                    $groupName = request('groupCurrent') . '_' . $lang;
                $codeMst = CodeMst::where('group', '=', $groupName)->where('value', '=', $value)->first();
                if ($codeMst) {
                    CodeMst::where('group', '=', $groupName)->where('value', '=', $value)->delete();
                    $results['status'] = 200;
                    Session::flash('Success',__('supply.common.update_success'));
                }
            }

            // Clear cache
            Cache::forget('code_mst_important_thing');
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        return Json::encode($results);
    }

    public function uploadImage($image, $nameInput, $childDirectory) {
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
}
