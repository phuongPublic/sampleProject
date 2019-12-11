<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Model\Bookmark;
use App\Model\DemandUserBankInfo;
use App\Model\Trash;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DemandUserController extends BaseController
{
    use Helpers;

    /**
     * API for get watch list jobs
     *
     * @param $request
     * @return mixed
     */
    public function watchList(Request $request) {
        $user = session('demand_user');

        $params = $request->all();
        $filter_sorts = [];
        if (isset($params['filter'])) {
            $filter_sorts = json_decode($params['filter']);
        }

        $response = $this->getDefaultResponse();
        $response['data']['bookmark'] = Bookmark::getBookmarkListByUserWithSort($user->id, $filter_sorts);

        return $this->response->array($response);
    }

    /**
     * API for add job to watch list
     * @return mixed
     */
    public function updateWatchList() {
        $user = session('demand_user');

        try {
            $job_ids = json_decode(Input::post('job_id', '[]'));

            foreach ($job_ids as $id) {
                Bookmark::updateOrCreate(
                    ['demand_user_id' => $user->id, 'job_id' => $id]
                );
            }

            //remove the job ids from trash
            Trash::where('demand_user_id', $user->id)->whereIn('job_id', $job_ids)->delete();

            $response = $this->getDefaultResponse();
        } catch (\Exception $exception) {
            throw new ValidationHttpException();
        }

        return $this->response->array($response);
    }

    /**
     * API for check job in watch list
     * @return mixed
     */
    public function checkWatchList() {
        $user = session('demand_user');

        try {
            Bookmark::where('demand_user_id', $user->id)->where('job_id', Input::post('job_id'))->update(['checked_flg' => 1]);;
            $response = $this->getDefaultResponse();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            throw new ValidationHttpException();
        }

        return $this->response->array($response);
    }

    /**
     * API for get trash list jobs
     *
     * @param $request
     * @return mixed
     */
    public function trashList(Request $request) {
        $user = session('demand_user');

        $params = $request->all();
        $filter_sorts = [];
        if (isset($params['filter'])) {
            $filter_sorts = json_decode($params['filter']);
        }

        $response = $this->getDefaultResponse();
        $response['data']['trash'] = Trash::getTrashListByUserWithSort($user->id, $filter_sorts);

        return $this->response->array($response);
    }

    /**
     * API for add job to trash list
     * @return mixed
     */
    public function updateTrashList() {
        $user = session('demand_user');

        try {
            $job_ids = json_decode(Input::post('job_id', '[]'));

            foreach ($job_ids as $id) {
                Trash::updateOrCreate(
                    ['demand_user_id' => $user->id, 'job_id' => $id]
                );
            }

            //remove the job ids from bookmark
            Bookmark::where('demand_user_id', $user->id)->whereIn('job_id', $job_ids)->delete();

            $response = $this->getDefaultResponse();
        } catch (\Exception $exception) {
            throw new ValidationHttpException();
        }

        return $this->response->array($response);
    }

    /**
     * update checked_flag = 1 for trash list
     *
     * @return mixed
     */
    public function updateCheckFlagForTrashList() {
        $user = session('demand_user');

        try {
            Trash::where('demand_user_id', $user->id)->update(['checked_flg' => '1']);
        } catch (\Exception $exception) {
            throw new ValidationHttpException();
        }

        $response = $this->getDefaultResponse();
        return $this->response->array($response);
    }

    /**
     * API for check job in trash list
     * @return mixed
     */
    public function checkTrashList() {
        $user = session('demand_user');

        try {
            Trash::where('demand_user_id', $user->id)->where('job_id', Input::post('job_id'))->update(['checked_flg' => 1]);

            $response = $this->getDefaultResponse();
        } catch (\Exception $exception) {
            throw new ValidationHttpException();
        }

        return $this->response->array($response);
    }

    /**
     * Get user's bank information
     *
     * @return mixed
     */
    public function getUserBankInfo() {
        $user = session('demand_user');
        $bank_info = DemandUserBankInfo::select(
            'bank_cd', 'bank_name', 'bank_branch_cd', 'bank_branch_name', 'bank_account_type', 'bank_account_name', 'bank_account_number'
        )
            ->orderBy('id', 'desc')
            ->where('demand_user_id', $user->id)->get();

        $response = $this->getDefaultResponse();
        $response['data'] = $bank_info;
        return $this->response->array($response);
    }

}
