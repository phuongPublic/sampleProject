<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Model\SupplyUserInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $sort = $this->getSortData();
        $filter = $this->getFilterData();
        $users = SupplyUserInfo::getList($sort, $filter);
        return view('admin.user.index', compact('users', 'filter', 'sort'));
    }

    /**
     * @param UserPassword $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(UserRequest $request, $id){
        $user = $this->getUser($id);

        if($request->method() == 'POST'){
            $user->password = Hash::make($request->password);
            $user->save();
            Session::flash('Success',__('supply.common.update_success'));
            return redirect()->route('admin.user.index');
        }

        return view('admin.user.password', compact('user'));
    }

    /**
     * @param $id
     */
    public function block($id) {
        try {
            $user = $this->getUser($id);
            $user->status = SupplyUserInfo::BLOCKED_STATUS;
            $user->save();
            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception){
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * @param $id
     */
    public function unblock($id) {
        try {
            $user = $this->getUser($id);
            $user->status = SupplyUserInfo::ACTIVATED_STATUS;
            $user->save();
            Session::flash('Success',__('supply.common.update_success'));
        } catch (\Exception $exception) {
            Session::flash('Error',__('supply.common.system_error'));
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(UserRequest $request, $id) {
        $user = $this->getUser($id);

        if($request->method() == 'POST'){
            try {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->save();
                Session::flash('Success', __('supply.common.update_success'));
            } catch(\Exception $exception) {
                Session::flash('Error',__('supply.common.system_error'));
            }
            return redirect()->route('admin.user.index');
        }

        return view('admin.user.edit', compact('user'));
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
     * @return array|mixed
     */
    private function getUser($id){
        $item = SupplyUserInfo::find($id);
        if($item)
            return $item;
        return abort(404);
    }
}
