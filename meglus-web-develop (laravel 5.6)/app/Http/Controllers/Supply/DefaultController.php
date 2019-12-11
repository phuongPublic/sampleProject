<?php
namespace App\Http\Controllers\Supply;

use App\Model\DemandUserInfo;
use App\Services\DefaultService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\Response;
use Psy\Util\Json;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms(){
        return view('supply_side.page.terms');
    }

    /**
     * Function get address by post code
     * @param Request $request
     * @return Json
     */
    public function getAddress(Request $request){
        $result = [
            'message' => trans('validation.job.workplace_post_cd_length'),
            'results'  => null,
            'status'  => 400
        ];
        if($request->code && strlen($request->code) == 7)
            $result = DefaultService::getAddress($request->code);


        return Json::encode($result);
    }

    /**
     * Function get prefecture list
     * @return Json
     */
    public function getPrefecture(){

        return Json::encode([]);
    }

    /**
     * Function get city1 city2 by prefecture && city1 name
     * @param Request $request
     * @return Json
     */
    public function getCity(Request $request){
        $results = [
            'message' => null,
            'results' => null,
            'status' => 400
        ];
        return Json::encode($results);
    }

    /**
     * Function get city by prefecture id
     * @param Request $request
     * @return Json
     */
    public function getCity1(Request $request){
        $results = [
            'message' => null,
            'results' => null,
            'status' => 400
        ];

        if($request->has('id') && strlen($request->id) > 0){
            $results['results'] = DefaultService::getCtyByPrefecture($request->id);
            $results['status'] = 200;
        }
        return Json::encode($results);
    }

    /**
     * Function get city2 by city1
     * @param Request $request
     * @return Json
     */
    public function getCity2(Request $request){
        $results = [
            'message' => null,
            'results' => null,
            'status' => 400
        ];

        if($request->has('name') && strlen($request->name) > 0){
            $prefecture = $request->prefecture;
            $results['results'] = DefaultService::getCty2ByCityName($request->name, $prefecture);
            $results['status'] = 200;
        }

        return Json::encode($results);
    }

    /**
     * Function suggestion Station by Station name
     * @param Request $request
     * @return Json
     */
    public function suggestionStation(Request $request){
        $results = [
            'message' => null,
            'results' => null,
            'status' => 400
        ];

        if($request->has('name') && strlen($request->name) > 0){
            $results['results'] = DefaultService::suggestionStation($request->name);
            $results['status'] = 200;
        }
        return Json::encode($results);
    }

    /**
     * Function get language
     * @return String
     */
    public function language(){
        $lang       = config('app.locale');
        $files      = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];
        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }
        File::put(public_path().DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'lang.js', 'window.i18n = ' . json_encode($strings) . ';' );
        return;
        /*
        $strings = Cache::rememberForever('lang.js', function () {
            $lang       = config('app.locale');
            $files      = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];
            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }
            return $strings;
        });
        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
        */
    }

    public function cacheFlush(){
        Cache::flush();
        $this->language();
        return 'Cache::flush';
    }

    /**
     * Get user avatar. default: 200 x 200
     * @param $id
     * @return null
     */
    public function avatar($id) {

        // Get image path
        $base = base_path() . env('USER_IMAGE_PATH', '/data/demand_user/avatar/');

        // Exit when invalid id
        $user = DemandUserInfo::find($id);
        $pathNotAccess = $base . 'default/img-not-access.jpg';
        if(!$user){
            $path = $base . 'default/img-not-found.png';
        }else{
            // Exit when user have no permisson
            if(Auth::user()->is_admin != 1){
                $applied = DefaultService::checkUserAppliedThisJob($id, Auth::user()->id);
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
                if(
                    !in_array($applied->seq, $arrSeqNonShowInfo)
                    && !in_array($applied->seq, $arrSeqNonShowInfoA1)
                    && !in_array($applied->seq, $arrSeqNonShowInfoB)
                    && !in_array($applied->seq, $arrSeqNonShowInfoB1)
                ){

                    $origin     = request('o', null);
                    $width      = request('w',200);
                    $height     = request('h',200);
                    $image_resize = Image::make($pathNotAccess);
                    if ($origin == null) {
                        if (is_numeric($width) && is_numeric($height)) {
                            $image_resize->resize($width, $height);
                        } else {
                            $image_resize->resize($width, $height, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }
                    $re = new Response($image_resize);
                    return $re->make();
                }

            }

            if(!empty($user->profile_path)){
                $path = $base . $user->id . '/' . $user->profile_path;
                if(!file_exists($path))
                    $path = $base . 'default/avatar_default.png';
            }else {
                $path = $base . 'default/avatar_default.png';
            }
        }
        
        // Resize image
        $origin = request('o', null);
        $width = request('w',200);
        $height = request('h',200);
        $image_resize = Image::make($path);
        if ($origin == null) {
            if (is_numeric($width) && is_numeric($height)) {
                $image_resize->resize($width, $height);
            } else {
                $image_resize->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        $re = new Response($image_resize);
        return $re->make();
    }
}
