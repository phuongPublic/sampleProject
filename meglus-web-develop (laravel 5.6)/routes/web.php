<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route for home page
Route::get('/','IndexController@index')->name('front_page');

// Start: Group for Supply pages
Route::namespace('Supply')->group(function () {
    /* Start: No need login routes */
    // Remove all cache
    Route::get('/cache','DefaultController@cacheFlush')->name('supply.cache.flush');

    // Logout
    Route::get('/logout', 'AuthController@logout')->name('supply_logout');

    // Language js
    Route::get('/generate-language', 'DefaultController@language')->name('assets.lang');
    Route::get('/terms-of-service', 'DefaultController@terms')->name('supply.page.terms');

    // Redirect to home page when user already login
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'AuthController@login')->name('supply_login');
        Route::post('/login', 'AuthController@submitLogin')->name('supply_submit_login');
        Route::get('/register', 'AuthController@register')->name('supply_register');
        Route::post('/register', 'AuthController@storeRegister')->name('supply_store_register');
        Route::match(['get', 'post'],'/reset-password', 'UserController@resetPassword')->name('supply.user.reset-password');
    });

    // Active user
    Route::get('/activate/{token}', 'AuthController@activate')->name('supply_activate');

    // Postcode,sations info
    Route::prefix('address')->group(function () {
        Route::post('/get','DefaultController@getAddress')->name('supply.address.get');
        Route::post('/prefecture','DefaultController@getPrefecture')->name('supply.address.prefecture');
        Route::post('/city1','DefaultController@getCity1')->name('supply.address.city1');
        Route::post('/city2','DefaultController@getCity2')->name('supply.address.city2');
        Route::post('/city','DefaultController@getCity')->name('supply.address.city');
        Route::post('/station/suggestion','DefaultController@suggestionStation')->name('supply.address.station.suggestion');
    });

    /* End: No need login routes */
    Route::match(['get', 'post'],'/password/{key?}', 'UserController@password')->name('supply.user.password');

    // Login required
    Route::middleware(['authenticated','second.authenticated'])->group(function () {
        Route::match(['get', 'post'],'/company', 'UserController@company')->name('company');
        Route::match(['get', 'post'],'/company-expire', 'UserController@companyExpire')->name('supply.company.expire');
        Route::get('/active', 'UserController@activeScreen')->name('supply.activeScreen');
        Route::get('/active-code', 'UserController@activeCode')->middleware(['onlyAjax'])->name('supply.activeCode');

        Route::get('/mypage', 'UserController@mypage')->name('mypage');
        Route::get('/avatar/{id}.png','DefaultController@avatar')->name('supply.user.avatar')->where('id', '[0-9]+');
        Route::post('/get-user-info', 'UserController@getUserInfo')->name('supply.userInfo')->middleware('onlyAjax')->where(['id'=> '[0-9]+','jid'=> '[0-9]+']);

        // Jobs
        Route::prefix('job')->group(function () {
            Route::get('/', 'JobController@index')->name('supply.job.index');
            Route::match(['get', 'post'], '/create', 'JobController@create')->name('supply.job.create');
            Route::get('/{id}', 'JobController@detail')->name('supply.job.detail')->where('id', '[0-9]+');
            Route::get('/preview/{id}', 'JobController@preview')->name('supply.job.preview')->where('id', '[0-9]+');
            Route::match(['get', 'post'], '/edit/{id}', 'JobController@edit')->name('supply.job.edit')->where('id', '[0-9]+');
            Route::match(['get', 'post'], '/copy/{id}', 'JobController@copy')->name('supply.job.copy')->where('id', '[0-9]+');
            Route::match(['get', 'post'], '/reopen/{id}', 'JobController@reopen')->name('supply.job.reopen')->where('id', '[0-9]+');
            Route::match(['get', 'post'], '/stop/{id}', 'JobController@stop')->name('supply.job.stop')->where('id', '[0-9]+');
            Route::post('/get-description', 'JobController@getCategoryDescription')->name('supply.job.getDescription');
            Route::post('/get-company-address', 'JobController@getCompanyAddress')->name('supply.job.company.address');
            Route::get('/apply/{id}', 'JobController@apply')->name('supply.job.apply')->where('id', '[0-9]+');
            Route::match(['get', 'post'], '/apply/{action}/{id}', 'JobController@applyPopup')->name('supply.job.applyPopup')->middleware('onlyAjax')->where('id', '[0-9]+');
            Route::get('result-confirm', 'JobController@resultConfirm')->name('supply.job.resultConfirm');

            Route::prefix('applicant')->group(function () {
                Route::match(['get', 'post'], '/update/{encrypt}', 'ApplicantController@update')->name('supply.job.applicant.update')->middleware('onlyAjax');
            });

        });
    });

});
// End: Group for Supply pages


//SAMPLE CODE
Route::get('/sample-send-mail', function (){
    // Send to 1 user
    $result = \App\Services\EmailService::sendBySes(
        'おもしろいダジャレを入力すると布団が吹っ飛ぶ装置を作った',
        'xxxx@gmail.com',
        'email.default_template',
        ['body' => 'があまりにもイメージとぴったり合ったため、名前を使わせていただきました。']
    );

    // // Send to 1 user & 1 cc
    $result = \App\Services\EmailService::sendBySes(
        'おもしろいダジャレを入力すると布団が吹っ飛ぶ装置を作った',
        'xxxx@gmail.com',
        'email.default_template',
        ['body' => 'があまりにもイメージとぴったり合ったため、名前を使わせていただきました。'],
        'xxxx@gmail.com' //cc email
    );

    // // Send to 1 user & 1 cc & 1 bcc
    $result = \App\Services\EmailService::sendBySes(
        'おもしろいダジャレを入力すると布団が吹っ飛ぶ装置を作った',
        'truongnv169.yt1@gmail.com',
        'email.default_template',
        ['body' => 'があまりにもイメージとぴったり合ったため、名前を使わせていただきました。'],
        'xxxx@gmail.com', //cc email
        'xxxx@gmail.com' //bcc email
    );


    // Send to multiple users
    $result = \App\Services\EmailService::sendBySes(
        'おもしろいダジャレを入力すると布団が吹っ飛ぶ装置を作った',
        ['xxxx@gmail.com', 'yyyy@gmail.com'],
        'email.default_template',
        ['body' => 'があまりにもイメージとぴったり合ったため、名前を使わせていただきました。']
    );
});
Route::get('/test-cronjob', function (){
    \Illuminate\Support\Facades\Artisan::call('celebration_money:run');
});
Route::get('/test-cronjob2', function (){
    \Illuminate\Support\Facades\Artisan::call('remind_set_employment:run');
});


// Admin router
require __DIR__.'/admin.php';
