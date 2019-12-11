<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    //route group: for LOGGED IN only
    $api->group(['middleware' => 'dingo_api_auth'], function ($api){
        $api->get('watch-list', 'App\Http\Controllers\Api\V1\DemandUserController@watchList');
        $api->get('trash-list', 'App\Http\Controllers\Api\V1\DemandUserController@trashList');
        $api->post('watch-list', 'App\Http\Controllers\Api\V1\DemandUserController@updateWatchList');
        $api->post('trash-list', 'App\Http\Controllers\Api\V1\DemandUserController@updateTrashList');
        $api->post('check-watch-list', 'App\Http\Controllers\Api\V1\DemandUserController@checkWatchList');
        $api->post('check-trash-list', 'App\Http\Controllers\Api\V1\DemandUserController@checkTrashList');
        $api->post('update-check-flag-trash-list', 'App\Http\Controllers\Api\V1\DemandUserController@updateCheckFlagForTrashList');
        $api->get('user_profile', 'App\Http\Controllers\Api\V1\AuthController@get_user_profile');
        $api->post('user_profile', 'App\Http\Controllers\Api\V1\AuthController@save_user_profile');
        $api->get('user_bank_info', 'App\Http\Controllers\Api\V1\DemandUserController@getUserBankInfo');
        $api->get('user/avatar/{image_file_name}', 'App\Http\Controllers\Api\V1\AuthController@get_user_avatar');
//        $api->get('banks/search', 'App\Http\Controllers\Api\V1\BankInfoController@bankInfo');
//        $api->get('banks/{bank_code}/branches', 'App\Http\Controllers\Api\V1\BankInfoController@bankBranch');
        $api->get('job/list', 'App\Http\Controllers\Api\V1\JobController@listAll');
        $api->get('job/detail/{id}', 'App\Http\Controllers\Api\V1\JobController@detail');
        $api->get('job/total_apply_status', 'App\Http\Controllers\Api\V1\JobController@totalApplyStatus');
        $api->get('job/apply', 'App\Http\Controllers\Api\V1\JobController@listApply');
        $api->post('job/apply', 'App\Http\Controllers\Api\V1\JobController@apply');
        $api->post('job/submit_celebration_money', 'App\Http\Controllers\Api\V1\JobController@submitCelebrationMoney');
        $api->get('banks', 'App\Http\Controllers\Api\V1\BankInfoController@bank');
        $api->get('messages/list', 'App\Http\Controllers\Api\V1\MessageController@index');
        $api->get('messages/detail', 'App\Http\Controllers\Api\V1\MessageController@detail');
        $api->get('messages/number_of_unread', 'App\Http\Controllers\Api\V1\MessageController@numberOfUnread');
        $api->post('user/verify-phone-number', 'App\Http\Controllers\Api\V1\AuthController@verifyPhoneNumber');
    });

    // route group: for GUEST only
    $api->group(['middleware' => 'api.common'], function ($api) {
        $api->post('register/email', 'App\Http\Controllers\Api\V1\AuthController@registerByEmail');
        $api->post('activate/{token}', 'App\Http\Controllers\Api\V1\AuthController@activateByToken');
        $api->post('register/facebook', 'App\Http\Controllers\Api\V1\AuthController@registerByFacebook');
        $api->get('data/master', 'App\Http\Controllers\Api\V1\DataController@master');
        $api->get('station/suggestion', 'App\Http\Controllers\Api\V1\DataController@stationSuggestion');
        $api->get('postal_code', 'App\Http\Controllers\Api\V1\DataController@postalCodeToAddress');
        $api->get('get_city_by_pref', 'App\Http\Controllers\Api\V1\DataController@getCityByPref');
        $api->get('get_city2_by_city1', 'App\Http\Controllers\Api\V1\DataController@getCity2ByCity1');
        $api->post('register_device', 'App\Http\Controllers\Api\V1\DataController@registerDevice');
    });
});

