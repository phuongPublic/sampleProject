<?php

namespace App\Http\Controllers\Admin;

use App\Model\OtpCodes;
use App\Model\SupplyUserInfo;
use App\Services\DefaultService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class OtpCodesController extends Controller
{

    /**
     * Otp codes list
     */
    public function index()
    {
        $sort           = $this->getSortData();
        //$otps         = OtpCodes::select()->paginate(5);
        $otps           = $this->getOtp($sort);
        $prefecture     = DefaultService::getPrefecture();
        return view('admin.otp.index', compact('otps','sort','prefecture'));
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
            $sort['code']               = $request->input('code', '');
            $sort['generation_num']     = $request->input('generation_num', '');
            $sort['expire_dt']          = $request->input('expire_dt', '');
            $sort['company_created']    = $request->input('company_created', '');
            $sort['company_name']       = $request->input('company_name', '');
            $sort['company_owner']      = $request->input('company_owner', '');
            $sort['detail_address']     = $request->input('detail_address', '');
            $sort['company_tel']        = $request->input('company_tel', '');
            $sort['status']             = $request->input('status', '');
            $sort['owner']              = $request->input('owner', '');


        }
        return $sort;
    }

    private function getOtp($sort){
        if(!$sort)
            $sort           = $this->getSortData();

        return OtpCodes::getList($sort);

    }

    /**
     * Reset Otp by id
     * @param $request, int $id
     * @return json
     */
    public function reset(Request $request,$id)
    {
        if(!$request->ajax())
            return abort(404);

        return $this->updateOtp($id);
    }

    /**
     * set owner Otp by id
     * @param $request, int $id
     * @return json
     */
    public function setOwner(Request $request, $id)
    {
        if(!$request->ajax())
            return abort(404);
        return $this->updateOtp($id, true);
    }

    /**
     * Update Otp
     * @param int $id, $isOwner
     * @return json
     */
    private function updateOtp($id, $isOwner = false)
    {
        $results = [
            'messages' => __('sypply.otp.update_error'),
            'results' => null,
            'code' => 400
        ];
        $otp = OtpCodes::find($id);
        if($otp){
            $code = null;
            if(!$isOwner){
                $code = DefaultService::makeOtpCode();
                $otp->code              = $code;
                $otp->status            = 0;
                $otp->generation_num    =   $otp->generation_num + 1;
                $otp->expire_dt         =   Carbon::now()->addDay(SupplyUserInfo::EXPIRE_DAYS);
            }

            if($isOwner)
                $otp->interaction_user_id = Auth::id();

            $otp->updated_at        = Carbon::now()->addDay();
            $otp->updated_id        = Auth::id();

            try{
                $save = $otp->save();
                if($save == true){
                    $results['code']    = 200;
                    $results['result']  = [
                        'id'        => $id,
                        'expire_dt' => date('Y/m/d', strtotime($otp->expire_from_dt)).' '.date('(Y/m/d)', strtotime($otp->expire_dt)),
                        'status'    => $otp->status,
                        'generation_num'    => $otp->generation_num
                    ];
                    if($otp->interactionUser)
                        $results['result']['owner'] = $otp->interactionUser->first_name.$otp->interactionUser->last_name;

                    if($code)
                        $results['result']['otp_code'] = $code;
                }
            }catch (\Exception $exception){
                Log::error(__METHOD__ . ':' . $exception->getMessage());
            }
        }

        return Json::encode($results);
    }
}
